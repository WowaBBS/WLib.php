<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Abstract Class T_FS_CSS_Checker_Match_Manual Extends T_FS_CSS_Checker_Base
  {
    Function AddTo($List, $k, $v) { $List->Add_Manual($k, $v, $this); }
  }
