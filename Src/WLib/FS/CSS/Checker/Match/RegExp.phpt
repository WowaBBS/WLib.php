<?
  $this->Load_Type('/FS/CSS/Checker/Match/Manual');

  Class T_FS_CSS_Checker_Match_RegExp Extends T_FS_CSS_Checker_Match_Manual
  {
    Var $RegExp='';
    
    Function __Construct($v) { $this->RegExp=$v; }
    
    Function Check($Node) { Return Preg_Match($this->RegExp, $Node->Name); }
    
    Function GetType() { Return 'RegExp'; }
    Function GetArg() { Return $this->RegExp; }
  }
