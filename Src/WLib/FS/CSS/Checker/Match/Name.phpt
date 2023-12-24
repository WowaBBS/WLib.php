<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Match_Name Extends T_FS_CSS_Checker_Base
  {
    Var $Name='';

    Function __Construct($v) { $this->Name=$v; }
    
    Function AddTo($List, $k, $v) { $List->Add_Name($k, $v, $this->Name); }
    Function Check($Node) { return $Node->Name===$this->Name; }
    Function GetType() { Return 'Name'; }
    Function GetArg() { Return $this->Name; }
  }
