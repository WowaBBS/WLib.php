<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Match_Ext Extends T_FS_CSS_Checker_Base
  {
    Var $Ext='';

    Function __Construct($v) { $this->Ext=Explode('.', $v)[1]; }

    Function Check($Node) { Return $Node->Ext===$this->Ext; }
    Function AddToMap($List, $k, $v) { $List->Add_Ext($k, $v, $this->Ext); }
    Function GetType() { Return 'Ext'; }
    Function GetArg() { Return '*.'.$this->Ext; }
  }
