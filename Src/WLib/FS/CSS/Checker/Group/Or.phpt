<?
  $this->Load_Type('/FS/CSS/Checker/Base');

  Class T_FS_CSS_Checker_Group_Or Extends T_FS_CSS_Checker_Base
  {
    Var $List=[];

    Function __Construct(Array $v) { $this->List=$v; }

    Function GetType() { Return 'Or'; }
    Function GetArg() { Return $this->List; }
  
    Function Check($Node)
    {
      ForEach($this->List As $Checker)
        If($Checker->Check($Node))
          Return True;
      Return False;
    }

    Function AddToMap($Map, $k, $v)
    {
      If(!False)
        Return $Map->Add_Manual($k, $v, $this);
      ForEach($this->List As $Checker)
        $Checker->AddToMap($Map, $k, $v);
    }
  }
