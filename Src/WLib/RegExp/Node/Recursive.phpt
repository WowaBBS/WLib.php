<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Recursive Extends T_RegExp_Node_Base
  {
    Var $Id   =0;
    Var $Type =Null;
    
    Static $Types=[
      'R'  =>['(?R'  ,')'  ,'None' ],//(?R)
      '?'  =>['(?'   ,')'  ,'Int'  ],//(?1)
      '>'  =>['(?P>' ,')'  ,'Str'  ],//(?P>name)
      '&'  =>['(?&'  ,')'  ,'Str'  ],//(?&name)
    ];
    
    Function __Construct($Id=0, $Type=Null) { $this->Id=$Id; $this->Type=$Type; }
    
    Static Function DetectType($Id)
    {
      If($Id===0) Return 'R';
      If(Is_Integer ($Id)) Return '?' ;
      If(Is_String  ($Id)) Return True? '>':'&';
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
      $Res[]=$End;
    }
    
    Static Function Test()
    {
    }
  }
  