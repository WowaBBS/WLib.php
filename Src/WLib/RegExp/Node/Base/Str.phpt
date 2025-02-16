<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Str Extends T_RegExp_Node_Base_Base
  {
    Var $Str='';
 
    Function __Construct($Str)
    {
      $this->Str=$Str;
    }

    Function Make($Res)
    {
      $Res->StrNode($this->Str);
    }

    Function Validate($Res) { Return $Res->StrNode($this->Str); } //??
    
    Function IsValid() { Return False; }
  }
  