<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Str Extends T_RegExp_Node_Base_Base
  {
    Var $Str='';
 
    Function IsEmpty  () { Return $this->Str===''; }
    Function IsSolid  () { Return StrLen($this->Str)===1; }
    
    Function __Construct($Str)
    {
      $this->Str=$Str;
    }

    Function Make($Res)
    {
      $Res[]=$this->Str;
      //$Res->StrNode($this->Str);
    }

  //Function Validate($Res) { Return $Res->StrNode($this->Str); } //??
    Function Validate($Res) { Return True; } //??
    
    Function IsValid() { Return False; }
  }
  