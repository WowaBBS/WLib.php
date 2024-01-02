<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Unknown Extends T_FS_CSS_Checker_Base
  {
    Var $Arg;

    Function __Construct($v) { $this->Arg=$v; }
  
    Function AddToMap($Map, $k, $v) {}
    Function Check($Node) { return false; }

    Function GetType() { Return 'Unknown'; }
    Function GetArg() { Return $this->Arg; }
  }
