<?
  Class T_FS_CSS_Node
  {
    Var $Name ;
    Var $Ext  ;
    
    Function Set($Name)
    {
      $this->Name =$Name;
      $this->Ext  =PathInfo($Name, PATHINFO_EXTENSION);
      Return $this;
    }
  }
