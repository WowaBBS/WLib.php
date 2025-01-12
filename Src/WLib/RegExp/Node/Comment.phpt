<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Comment Extends T_RegExp_Node_Base
  {
    Var $Comment='';
    
    Function __Construct($Comment='') { $this->Comment=$Comment; }
    
    Function Make($Res)
    {
      $Res->Begin('(?#');
      $Res[]=$this->Comment;
      $Res->End(')');
    }
  }
  