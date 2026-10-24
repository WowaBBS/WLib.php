<? NameSpace WLib\Debug\Measure;
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  $this->Load_Type('/Debug/Measure/Scale'   );
  $this->Load_Type('/Debug/Measure/Time'    );
  $this->Load_Type('/Debug/Measure/Postfix' );
  
  Class T_Rules
  {
    Var $List=[];
    
    Function Find($v)
    {
      $l = $this->List;
      $a = 0;
      $b = Count($l)-1;
      While($a<=$b)
      {
        $m=($a+$b)>>1;
        If($l[$m]->Value>=$v)
          $b=$m-1;
        Else
          $a=$m+1;
      }
      Return $l[$b>0? $b:$a];
    }
    
    Static Array $Exp=[
      'Big'   =>['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y', 'R', 'Q'],
      'Small' =>['m', 'u', 'n', 'p', 'f', 'a', 'a', 'y', 'r', 'q'],
      'DEC'   =>['da', 'h'],
      'dec'   =>['d', 'c'],
    //'Zero'  =>[''],
    ];

    Static Array $Run=[
      'Binary'    =>[
        ['Default', 'Old'],
        ['Case', 'Old' ,[['>Run', 'BinaryOld']]],
        ['Case', 'New' ,[['>Run', 'BinaryNew']]],
        ['Case', 'Dec' ,[['>Run', 'BinaryDec']]],
      ],
      'BinaryNew' =>[['Postfix<', 'i'], ['>Run', 'BinaryOld']],
      'BinaryOld' =>[['+Exp', 1024, 'Big']],
      'BinaryDec' =>[['+Exp', 1000, 'Big']],
      'Numeric'   =>[
        ['+Exp', 1000, 'Big'   ],
        ['+Exp', 1e-3, 'Small' ],
      ],
      'NumericDec'   =>[
        ['+Exp', 10   ,'DEC'],
        ['+Exp', 1e-1 ,'dec'],
        ['>Run', 'Numeric'],
      ],
      'Years'=>[
        ['Postfix<', 'yr'],
        ['+Scale', 3, 3], //Sience 3 year
        ['+Exp', 1000, 'Big'], //>1000 years
      ],
      'Time'=>[
        ['+Exp'  , 1e-3, 'Small'], // <1s
        ['Postfix=', ''],
        ['+Time',       60,     'i:s'],
        ['+Time',    60*60,   'H:i:s'],
        ['Scale*=', 365.2425*24*60*60],
        ['>Run', 'Years'], //>3 years
      ],
    ];
    
    Static Array $Types=[
      'SizeBytes'   =>[['Postfix<', 'B'   ], '+Zero', '+One', ['>Run', 'Binary']],
      'SizeBits'    =>[['Postfix<', 'b'   ], '+Zero', '+One', ['>Run', 'Binary']],
      'SpeedBytes'  =>[['Postfix<', 'Bps' ], '+Zero', '+One', ['>Run', 'Binary']],
      'SpeedBits'   =>[['Postfix<', 'bps' ], '+Zero', '+One', ['>Run', 'Binary']],
      'Time'        =>[['Postfix<', 's'   ], '+Zero', '+One', ['>Run', 'Time'  ]],
      
      'Default'     =>[],

    //'SizeLength'  =>['m'   ], // Astronomic sizes?
    //'SpeedLength' =>['m/s' ],
    ];
    
    Static Array $Cache=[];
    
    Static Function Get($Name) { Return Self::$Cache[$Name]??=Self::_Get($Name); }
    Static Function _Get($Name)
    {
      $Postfix ='';
      $Arg     ='';
      
      If($Steps=Self::$Types[$Name]?? Null)
        Return New Self($Steps, $Arg, $Postfix);
      
      [$Name, $Arg, $Postfix]=Self::Parse($Name);
      If(!Is_Null($Steps=Self::$Types[$Name]?? Null))
        Return New Self($Steps, $Arg, $Postfix);
        
      Self::Error('Unknown measure rules name')->Dump(['Name'=>$Name, 'Arg'=>$Arg, 'Add'=>$Postfix]);
      Return New Self([], $Arg, $Postfix);
    }
    
    Static Function Parse($Name)
    {
      $Name=Explode(';', $Name, 2);
      $Postfix=$Name[1]?? '';
      $Name=$Name[0];
      $Name=Explode(',', $Name, 2);
      $Arg=$Name[1]?? '';
      $Name=$Name[0];
      Return [$Name, $Arg, $Postfix];
    }
    
    Function __Construct(
       String|Array $Steps   , //='Numeric' ,
       String       $Arg     , //=''        ,
       String       $Postfix , //=''        ,
    )
    {
      $this->Base(0, $Postfix);
      $this->Base(1, $Postfix);
      $this->Run($Steps, New T_Postfix($Postfix), $Arg);
      USort($this->List, T_Base::Compare(...));
    }
    
    Function Run(
      String|Array $Steps   ,
      T_Postfix    $Postfix ,
      String       $Arg     ,
      Float        $Scale =1,
    )
    {
      If(Is_String($Steps))
        $Steps=Static::$Run[$Steps];
      ForEach($Steps As $Step)
      {
        If(Is_String($Step))
          $Step=[$Step];
        $Name=$Step[0];
        Switch($Name)
        {
        Case 'Nop'      : Break;
        Case 'Default'  : If($Arg==='') $Arg=$Step[1]; Break;
        Case 'Case'     : If($Arg===$Step[1]) $this->Run($Step[2], Clone $Postfix, $Arg, $Scale); Break;
        
        Case 'Postfix=' : $Postfix->SetFirst ($Step[1]); Break;
        Case 'Postfix<' : $Postfix->UnShift  ($Step[1]); Break;
        
        Case 'Scale='   : $Scale   =$Step[1]; Break;
        Case 'Scale*='  : $Scale  *=$Step[1]; Break;
        Case 'Scale/='  : $Scale  /=$Step[1]; Break;
        
        Case '>Run'     : $this->Run   ($Step[1]?? '', Clone $Postfix, $Arg, $Scale); Break;
        Case '+Zero'    : $this->Base  (     0          ,$Postfix); Break;
        Case '+One'     : $this->Base  ($Scale          ,$Postfix); Break;
        Case '+Scale'   : $this->Scale ($Scale*$Step[1] ,$Postfix, $Step[2]?? Null); Break;
        Case '+Time'    : $this->Time  ($Scale*$Step[1] ,$Postfix, $Step[2]); Break;
        Case '+Exp'     : $this->Exp   ($Step[1], Self::$Exp[$Step[2]], $Postfix, $Scale); Break;
        Default: $this->Error('Unknown step name ', $Name);
        }
      }
    }
    
    Function Add(T_Base $Rule) { $this->List[$Rule->Key]=$Rule; }
    
    Function Base  (Float $Value, String $Postfix                     ) { $this->Add(New T_Base  ($Value, $Postfix          )); }
    Function Scale (Float $Value, String $Postfix, ?Float $Scale=Null ) { $this->Add(New T_Scale ($Value, $Postfix, $Scale  )); }
    Function Time  (Float $Value, String $Postfix, String $Format     ) { $this->Add(New T_Time  ($Value, $Postfix, $Format )); }
    
    Function Exp(Float $Exp, Array $List, String $Postfix, Float $Scale=1)
    {
      ForEach($List As $ExpPostfix)
        $this->Scale($Scale*=$Exp, $ExpPostfix.$Postfix);
    }
    
    Static Function Error(...$Args) { Return Logger::Error(...$Args); }
  };
?>