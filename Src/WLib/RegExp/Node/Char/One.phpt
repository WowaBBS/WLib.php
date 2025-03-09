<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_One Extends T_RegExp_Node_Char_Base
  {
    Var $Char ='';
    
    Function IsSolid  () { Return True; }
    
    Function __Construct(Int|String $Char=' ') { $this->Char=$Char; }

    Function Make($Res)
    {
      $Res[]=$Res->Char($this->Char);
    }

    Function Validate($Res)
    {
      Return $Res->Char($this->Char);
    }
  }
  