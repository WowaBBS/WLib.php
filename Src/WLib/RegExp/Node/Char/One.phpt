<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_One Extends T_RegExp_Node_Base_Base
  {
    Var $Char ='';
    
    Function __Construct($Char=' ') { $this->Char=$Char; }

    Function Make($Res)
    {
      $Res[]=$Char;
    }
  }
  