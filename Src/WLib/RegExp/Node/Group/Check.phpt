<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Check Extends T_RegExp_Node_Base_Base
  {
    Var $Node; //(?=Node) (?!Node) (?<=Node) (?<!Node)
    Var $Type; //! = <! <= 
    
    Function __Construct($Node, $Type) { $this->Node=$Node; $this->Type=$Type; }
    
    Function Make($Res)
    {
      $Res->Begin('(?', $this->Type);
      $Res[]=$this->Node;
      $Res->End(')');
    }
  }
  