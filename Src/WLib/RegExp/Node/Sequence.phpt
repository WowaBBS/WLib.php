<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Sequence Extends T_RegExp_Node_Base
  {
    Var $List=[];
    
    Function __Construct($List=[]) { $this->List=$List; }

    Function Make($Res)
    {
      ForEach($this->List As $Item)
        $Res[]=$Item;
    }
  }
  