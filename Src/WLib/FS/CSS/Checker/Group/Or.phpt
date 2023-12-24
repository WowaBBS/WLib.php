<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Group_Or Extends T_FS_CSS_Checker_Base
  {
    Var $List=[];

    Function __Construct(Array $v) { $this->List=$v; }
  
    Function Check($Node)
    {
      ForEach($this->List As $Checker)
        If($Checker->Check($Node))
          Return True;
      Return False;
    }
  //Function AddTo($List, $k, $v) { $List->Add_Any($k, $v); }
  }
