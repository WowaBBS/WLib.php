<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Recursive Extends T_RegExp_Node_Base_Base
  {
    Var $Id   =0;
    Var $Type =Null;
    
    Static $Types=[
      'R'  =>['(?R'  ,')'  ,'None' ],//(?R)
      '?'  =>['(?'   ,')'  ,'Num'  ],//(?1)
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
      
      [$Begin, $End, $TypeId]=Self::$Types[$Type];
      $Res[]=$Begin ;
      If($TypeId!=='None')
        $Res[]=$this->Id;
      $Res[]=$End;
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
      Case 'None' : If($Id!==0          ) Return $Res->Error('Id should be Zero' ); Break;
      Case 'Num'  : If(!Is_Integer ($Id)) Return $Res->Error('Id should be Int'  ); Break;
      Case 'Str'  : If(!Is_String  ($Id)) Return $Res->Error('Id should be Str'  ); Break;
      Default     : Return $Res->Error('Unknown TypeId: ', $TypeId);
      }
      
      Return True;
    }
    

    
    Static Function Test()
    {
    }
  }
  