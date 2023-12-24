<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  // Which name is better: Recursive, ForEach or another?
  
  Class T_FS_CSS_Checker_Rec Extends T_FS_CSS_Checker_Base
  {
    Function Check($Node) { Return True; }

    Function AddTo($List, $k, $v) {} //? $List->Add_Manual($k, $v, $this); }
    Function GetType() { Return 'Rec'; }
    Function GetArg() { Return '**'; } //Null; }
  }
