<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_If Extends T_RegExp_Node_Base_Base
  {
    Var $Condition ;
    Var $Then      ;
    Var $Else      ;
    
  //(?(condition)yes-pattern)
  //(?(condition)yes-pattern|no-pattern)
    
    Function __Construct($Condition, $Then, $Else=Null) { $this->Condition=$Condition; $this->Then=$Then; $this->Else=$Else; }
    
    Function Init($Res)
    {
      Parent::Init($Res);
      
      $this->Condition =$Res->Node($this->Condition );
      $this->Then      =$Res->Node($this->Then      );
      $this->Else      =$Res->Node($this->Else      );
    }
    
    Function Make($Res)
    {
      $Res->Begin('(?(');
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
    
    Function Validate($Res)
    {
      If(!$Res->NodeStr($this->Condition )) Return False;
      If(!$Res->NodeStr($this->Then      )) Return False;
      If($this->Else!==Null && !$Res->NodeStr($this->Else      )) Return False;
      Return True;
    }
  }
  