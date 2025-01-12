<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Char_Class Extends T_RegExp_Node_Base
  {
    Var $Name ='\w';
    
    Function __Construct($Name='\w') { $this->Name=$Name; }

    Function Make($Res)
    {
      $Res[]=$this->Name;
    }
  }
  