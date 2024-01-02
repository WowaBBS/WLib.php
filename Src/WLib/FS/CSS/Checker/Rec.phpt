<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  // Which name is better: Recursive, ForEach or another?
  
  Class T_FS_CSS_Checker_Rec Extends T_FS_CSS_Checker_Base
  {
    Function Check($Node) { Return True; }

    Function AddToMap($Map, $k, $v) { $Map->Add_Any($k, $v); }
  //Function AddToMap($Map, $k, $v) {} //? $Map->Add_Manual($k, $v, $this); }
    Function GetType() { Return 'Rec'; }
    Function GetArg() { Return Null; }
    Function GetCheckArg() { Return '**'; }
    Function IsRec() { Return True; }
  }
