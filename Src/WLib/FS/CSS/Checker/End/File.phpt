<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_End_File Extends T_FS_CSS_Checker_Base
  {
    Var $Checker;
    
    Function __Construct($v) { $this->Checker=$v; }
  
    Function Check($Node) { Return True; }

    Function AddToMap($Map, $k, $v) { $this->Checker->AddToMap($Map->File, $k, $v); }
    Function GetType() { Return 'File'; }
    Function GetArg() { Return $this->Checker; }
  //Function IsEnd() { Return True; }
  }
