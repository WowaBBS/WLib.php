<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_If Extends T_RegExp_Node_Base
  {
    Var $Condition ;
    Var $Then      ;
    Var $Else      ;
    
  //(?(condition)yes-pattern)
  //(?(condition)yes-pattern|no-pattern)
    
    Function __Construct($Condition, $Then, $Else=Null) { $this->Condition=$Condition; $this->Then=$Then, $this->Else=$Else}
    
    Function Make($Res)
    {
      $Res->Begin('(?(';
      $Res[]=$this->Condition;
      $Res->Next(')');
      $Res[]=$this->Then;
      If($Else=$this->Else)
      {
        $Res->Next('|');
        $Res[]=$Else;
      }
      $Res->End(')');
    }
  }
  