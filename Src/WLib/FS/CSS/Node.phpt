<?
  Class T_FS_CSS_Node
  {
    Var $Name   ;
    Var $Ext    ;
    Var $IsFile =False;
    
    Function Set($Name, $IsFile=False)
    {
      $this->Name   =$Name   ;
      $this->Ext    =PathInfo($Name, PATHINFO_EXTENSION);
      $this->IsFile =$IsFile ;
      Return $this;
    }
    
    Function IsFile() { Return $this->IsFile; }
  }
