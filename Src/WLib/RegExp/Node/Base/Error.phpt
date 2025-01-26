<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Error Extends T_RegExp_Node_Base_Base
  {
    Var $Name     ;
    Var $Node     ;
    Var $Error ='';
 
    Function __Construct($Name, $Node, $Error)
    {
      $this->Name  =$Name  ;
      $this->Node  =$Node  ;
      $this->Error =$Error ;
    }

    Function Make($Res)
    {
      $Res->Begin ('(', $this->Name, ':');
      $Res[]=$Error;
      $Res->End   (')');
    }

    Function Validate($Res)
    {
      Return True;
    }
    
    Function IsValid() { Return False; }
  }
  