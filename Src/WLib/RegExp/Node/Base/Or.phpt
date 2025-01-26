<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Or Extends T_RegExp_Node_Base_Base
  {
    Var $List=[];
    
    Function __Construct($List=[]) { $this->List=$List; }

    Function Make($Res)
    {
      $z=False;
      ForEach($this->List As $Item)
      {
        If($z)
          $Res->Next('|');
        Else
          $z=True;
        $Res[]=$Item;
      }
    }

    Function Validate($Res)
    {
      ForEach($this->List As $Node)
        If(!$Res->NodeStr($Node))
          Return False;
      Return True;
    }
  }
  