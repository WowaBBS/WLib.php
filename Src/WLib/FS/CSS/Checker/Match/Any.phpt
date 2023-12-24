<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Match_Any Extends T_FS_CSS_Checker_Base
  {
    Function Check($Node) { return true; }
    Function AddTo($List, $k, $v) { $List->Add_Any($k, $v); }
    Function GetType() { Return 'Any'; }
    Function GetArg() { Return '*'; } //Null; }
  }
