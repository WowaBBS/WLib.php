<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Char_One Extends T_RegExp_Node_Base
  {
    Var $Char ='';
    
    Function __Construct($Char=' ') { $this->Char=$Char; }

    Function Make($Res)
    {
      $Res[]=$Char;
    }
  }
  