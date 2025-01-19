<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Back Extends T_RegExp_Node_Base_Base
  {
    Var $Id   =1;
    Var $Type =Null;
    
    Static $Types=[
      '\n'  =>['\\'   ,''   ,False ],//\n
      'P='  =>['(?P=' ,')'  ,True  ],//(?P=name)
      'kn'  =>['\k'   ,''   ,False ],//\kNum   ??
      'k<'  =>['\k<'  ,'>'  ,True  ],//\k<name>
      'k\'' =>['\k\'' ,'\'' ,True  ],//\k'name'
      'k{'  =>['\k{'  ,'}'  ,True  ],//\k{name}
      'gn'  =>['\g'   ,''   ,False ],//\gNum
      'g{'  =>['\g{'  ,'}'  ,True  ],//\g{name}
      'g<'  =>['\g<'  ,'>'  ,True  ],//\g<name>
      'g\'' =>['\g\'' ,'\'' ,True  ],//\g'name'
    ];
    
    Function __Construct($Id, $Type=Null) { $this->Id=$Id; $this->Type=$Type; }
    
    Static Function DetectType($Id)
    {
      If(Is_Integer ($Id)) Return '\n';
      If(Is_String  ($Id)) Return 'g{';
      Return Null;
    }
    
    Function Make($Res)
    {
      $Id   =$this->Id   ;
      $Type =$this->Type ;
      
      If(Is_Null($Type??=Self::DetectType($Id)))
        Return $Res->Error('Unknown Id');
      
      [$Begin, $End]=Self::$Types[$Type]?? Self::$Types[''];
      $Res[]=$Begin ;
      $Res[]=$this->Id;
      If($End) $Res[]=$End;
    }
    
    Static Function Test()
    {
      //TODO: [ab] \-1|\1|name preg_replace($pat, 'xx', 'aa ab ba bb')
    }
  }
  