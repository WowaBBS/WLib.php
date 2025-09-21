<?
  $this->Load_Type('/RegExp/Node/Base/List');
  
  Class T_RegExp_Node_Base_Sequence Extends T_RegExp_Node_Base_List
  {
    Function Make($Res)
    {
      ForEach($this->List As $Item)
        $Res[]=$Item;
    }
    
    Function Optimize_Object($Optimizer, $Item)
    {
      $Item=Parent::Optimize_Object($Optimizer, $Item);
      Return $Item?->IsEmpty()? Null:$Item;
    }
  }
  