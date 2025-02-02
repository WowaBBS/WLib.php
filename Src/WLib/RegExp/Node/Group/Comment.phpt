<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Comment Extends T_RegExp_Node_Base_Base
  {
    Var $Comment='';
    
    Function __Construct($Comment='') { $this->Comment=$Comment; }
    
    Function Make($Res)
    {
      $Res->Begin('(?#');
      $Res[]=$this->Comment;
      $Res->End(')');
    }
    
    Function Validate($Res)
    {
      Return True; //TODO: Check
    }
  }
  