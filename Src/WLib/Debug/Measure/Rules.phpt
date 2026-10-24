<? NameSpace WLib\Debug\Measure;
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  $this->Load_Type('/Debug/Measure/Rule');
  
  Class T_Rules
  {
    Var $List=[];
    Var $Type_Num='Num';
    
    Function Find($v)
    {
      $l = $this->List;
      $a = 0;
      $b = Count($l)-1;
      While($a<=$b)
      {
        $m=($a+$b)>>1;
      //Logger::Debug('Compare: ', ['m'=>$m, 'l'=>$l[$m]->Value, 'r'=>$v]);
        If($l[$m]->Value>=$v)
          $b=$m-1;
        Else
          $a=$m+1;
      //Logger::Debug('Choose', ['a'=>$a, 'b'=>$b]);
      }
    //Logger::Debug('Final: ', ['a'=>$a, 'b'=>$b]);
      Return $l[$b>0? $b:$a];
    }
    
    Static Array $Prefixes=[
      'Big'   =>['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y', 'R', 'Q'],
      'Small' =>['m', 'u', 'n', 'p', 'f', 'a', 'a', 'y', 'r', 'q'],
      'DEC'   =>['da', 'h'],
      'dec'   =>['d', 'c'],
    //'Zero'  =>[''],
    ];
    
    Static Array $Steps=[
      'Binary'    =>[
        ['Default', 'Old'],
        ['Case', 'Old' ,[['Steps', 'BinaryOld']]],
        ['Case', 'New' ,[['Steps', 'BinaryNew']]],
        ['Case', 'Dec' ,[['Steps', 'BinaryDec']]],
      ],
      'BinaryNew' =>[['Postfix', 'i'], ['Steps', 'BinaryOld']],
      'BinaryOld' =>[['Exp', 1024, 'Big']],
      'BinaryDec' =>[['Exp', 1000, 'Big']],
      'Numeric'   =>[
        ['Exp', 1000, 'Big'   ],
        ['Exp', 1e-3, 'Small' ],
      //'Zero',
      ],
      'NumericDec'   =>[
        ['Exp', 10   ,'DEC'],
        ['Exp', 1e-1 ,'dec'],
        ['Steps', 'Numeric'],
      ],
    ];
    
    Static Array $Types=[
      'SizeBytes'   =>[['Postfix', 'B'   ], ['Steps', 'Binary']],
      'SizeBits'    =>[['Postfix', 'b'   ], ['Steps', 'Binary']],
      'SpeedBytes'  =>[['Postfix', 'Bps' ], ['Steps', 'Binary']],
      'SpeedBits'   =>[['Postfix', 'bps' ], ['Steps', 'Binary']],
      
      'Default'     =>[],

    //'SizeLength'  =>['m'   ], // Astronomic sizes?
    //'SpeedLength' =>['m/s' ],
    ];
    
    Static Array $Cache=[];
    
    Static Function Get($Name) { Return Self::$Cache[$Name]??=Self::_Get($Name); }
    Static Function _Get($Name)
    {
      If($Steps=Self::$Types[$Name]?? Null)
        Return New Self('', $Steps, '');
      $Name=Explode(';', $Name, 2);
      $AddPostfix=$Name[1]?? '';
      $Name=$Name[0];
      $Name=Explode(',', $Name, 2);
      $Arg=$Name[1]?? '';
      $Name=$Name[0];
      If($Steps=Self::$Types[$Name]?? Null)
        Return New Self($AddPostfix, $Steps, $Arg);
      Self::Error('Unknown measure rules name')->Dump(['Name'=>$Name, 'Arg'=>$Arg, 'Add'=>$AddPostfix]);
      Return New Self($AddPostfix, [], $Arg);
    }
    
    Function __Construct(
       String       $AddPostfix , //=''        ,
       String|Array $Steps      , //='Numeric' ,
       String       $Arg        , //=''        ,
    )
    {
      $this->Run($Steps, $AddPostfix, $Arg);
    //If(!$this->List)
      $this->AddItem(0, $AddPostfix);
      $this->AddItem(1, $AddPostfix);
      USort($this->List, T_Rule::Compare(...));
    //Logger::Dump($this);
    }
    
    Function Run(
      String|Array $Steps      ,
      String       $AddPostfix ,
      String       $Arg        ,
    )
    {
      If(Is_String($Steps))
        $Steps=Static::$Steps[$Steps];
      ForEach($Steps As $Step)
      {
        If(Is_String($Step))
          $Step=[$Step];
        $Name=$Step[0];
        Switch($Name)
        {
        Case 'Nop'     : Break;
        Case 'Default' : If($Arg==='') $Arg=$Step[1]; Break;
        Case 'Case'    : If($Arg===$Step[1]) $this->Run($Step[2], $AddPostfix, $Arg); Break;
        Case 'Postfix' : $AddPostfix=$Step[1].$AddPostfix; Break;
        Case 'Steps'   : $this->Run($Step[1]?? '', $AddPostfix, $Arg); Break;
      //Case 'Zero'    : $this->AddItem(0, $Step[1]?? $AddPostfix); Break;
      //Case 'One'     : $this->AddItem(1, $Step[1]?? $AddPostfix); Break;
        Case 'Exp'     : $this->AddExp($Step[1], Self::$Prefixes[$Step[2]], $AddPostfix); Break;
        Default: $this->Error('Unknown step name ', $Name);
        }
      }
    }
    
    Function AddItem(Float $Value, String $Postfix)
    {
      $Key=Pack('d', $Value);
      $this->List[$Key]=New T_Rule($Value, $Postfix);
    }
    
    Function AddExp(Float $Exp, Array $List, String $AddPostfix)
    {
      $Shift=1;
      ForEach($List As $Postfix)
        $this->AddItem($Shift*=$Exp, $Postfix.$AddPostfix);
    }
    
    Static Function Error(...$Args) { Return Logger::Error(...$Args); }
  };
?>