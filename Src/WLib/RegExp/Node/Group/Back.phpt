<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Back Extends T_RegExp_Node_Base_Base
  {
    Var $Id   =1;
    Var $Type =Null;
    
    Static $Types=[
      '\n'  =>['\\'   ,''   ,'None' ],//\n
      'P='  =>['(?P=' ,')'  ,'Str'  ],//(?P=name)
      'kn'  =>['\k'   ,''   ,'Num'  ],//\kNum   ??
      'k<'  =>['\k<'  ,'>'  ,'Str'  ],//\k<name>
      'k\'' =>['\k\'' ,'\'' ,'Str'  ],//\k'name'
      'k{'  =>['\k{'  ,'}'  ,'Str'  ],//\k{name}
      'gn'  =>['\g'   ,''   ,'Num'  ],//\gNum
      'g{'  =>['\g{'  ,'}'  ,'Str'  ],//\g{name}
      'g<'  =>['\g<'  ,'>'  ,'Str'  ],//\g<name>
      'g\'' =>['\g\'' ,'\'' ,'Str'  ],//\g'name'
    ];
    
    Function __Construct($Id, $Type=Null) { $this->Id=$Id; $this->Type=$Type; }
    
    Static Function DetectType($Id)
    {
      If(Is_Integer ($Id)) Return '\n';
      If(Is_String  ($Id)) Return 'g{';
      Return Null;
    }
    
    Function Init($Res)
    {
      Parent::Init($Res);
    
      If(Is_Null($this->Type??=Self::DetectType($this->Id)))
        Return $Res->Error('Unknown Id');
    }
    
    Function Make($Res)
    {
      $Id   =$this->Id   ;
      $Type =$this->Type ;
      
      $Info=Self::$Types[$Type]?? Null;
      if(!$Info) return False;
      
      [$Begin, $End, $TypeId]=$Info;
      If($TypeId!=='None')
        $Res[]=$Begin ;
      $Res[]=$this->Id;
      If($End) $Res[]=$End;
    }

    Function Validate($Res)
    {
      $Id   =$this->Id   ;
      $Type =$this->Type ;
      
      $Info=Self::$Types[$Type]?? Null;
      If(!$Info)
        Return $Res->Error('Unknown Type: ', $Type);
      
      Switch($TypeId=$Info[2])
      {
      Case 'None' : If(!Is_Null    ($Id)) Return $Res->Error('Id should be Null' ); Break;
      Case 'Num'  : If(!Is_Integer ($Id)) Return $Res->Error('Id should be Int'  ); Break;
      Case 'Str'  : If(!Is_String  ($Id)) Return $Res->Error('Id should be Str'  ); Break;
      Default     : Return $Res->Error('Unknown TypeId: ', $TypeId);
      }
      
      Return True;
    }
    
    Static Function Test()
    {
      //TODO: [ab] \-1|\1|name preg_replace($pat, 'xx', 'aa ab ba bb')
    }
  }
