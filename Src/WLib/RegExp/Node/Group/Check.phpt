<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Check Extends T_RegExp_Node_Base_Base
  {
    Var $Node; //(?=Node) (?!Node) (?<=Node) (?<!Node)
    Var $Type; //! = <! <= 
    Static $Types=[
    //Name   ,Not   ,Back
      '!'  =>[True  ,False ],
      '='  =>[False ,False ],
      '<!' =>[True  ,True  ],
      '<=' =>[False ,True  ],
    ];
    
    Function __Construct($Node, $Type) { $this->Node=$Node; $this->Type=$Type; }
    
    Function Make($Res)
    {
      $Res->Begin('(?', $this->Type);
      $Res[]=$this->Node;
      $Res->End(')');
    }

    Function Validate($Res)
    {
      If(!$Res->NodeStr($this->Node)) Return False;
      $Info=Self::$Types[$this->Type]?? Null;
      If(!$Info)
        Return $Res->Error('Unknown Type: ', $this->Type);
      Return True;
    }
  }
  