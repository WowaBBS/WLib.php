<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Group_And Extends T_FS_CSS_Checker_Base
  {
    Var $List=[];

    Function __Construct(Array $v) { $this->List=$v; }
  
    Function Check($Node)
    {
      ForEach($this->List As $Checker)
        If(!$Checker->Check($Node))
          Return False;
      Return True;
    }
  //Function AddTo($List, $k, $v) { $List->Add_Any($k, $v); }
  }
