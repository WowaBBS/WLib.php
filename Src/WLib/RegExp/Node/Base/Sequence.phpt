<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Sequence Extends T_RegExp_Node_Base_Base
  {
    Var $List=[];
    
    Function __Construct($List=[]) { $this->List=$List; }

    Function Make($Res)
    {
      ForEach($this->List As $Item)
        $Res[]=$Item;
    }

    Function Validate($Res)
    {
      ForEach($this->List As $Node)
        If(!$Res->NodeStr($Node))
          Return False;
      Return True;
    }
  }
  