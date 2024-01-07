<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  // Which name is better: Recursive, ForEach, remove or another?
  Class T_FS_CSS_Checker_End_Dir Extends T_FS_CSS_Checker_Base
  {
    Function Check($Node) { Return True; }

  //Function AddToMap($Map, $k, $v) {} //? $Map->Add_Manual($k, $v, $this); }
    Function AddToMap($Map, $k, $v) { $Map->Add_Any($k, $v); }
    Function GetType() { Return 'Dir'; }
    Function GetArg() { Return Null; }
    Function IsEnd() { Return True; }
    Function IsRec() { Return True; }
  }
