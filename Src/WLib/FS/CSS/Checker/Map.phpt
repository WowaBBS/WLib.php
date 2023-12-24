<?
  $Loader->Load_Lib('/FS/Utils'); //FileMask2RegExp

  Class T_FS_CSS_Checker_Map
  {
    Var $Names   =[];
    Var $Exts    =[];
    Var $Manual  =[];
    Var $Default =[];
    
    Function CollectRules(&$Res, $Node)
    {
    //$this->Log('Debug', $Name, ', ',  $Ext);
      ForEach($this->Default                   As $R) $Res[]=$R;
      ForEach($this->Names [$Node->Name ]?? [] As $R) $Res[]=$R;
      ForEach($this->Exts  [$Node->Ext  ]?? [] As $R) $Res[]=$R;
      ForEach($this->Manual As [$Checker, $R]) If($Checker->Check($Node)) $Res[]=$R;
    }

    Function GetRules($Node) { $Res=[]; $this->CollectRules($Res, $Node); Return $Res; }
    
    Function SetCheckers($Checkers, $k=Null)
    {
      ForEach($Checkers As [$Checker, $v])
        $Checker->AddTo($this, $k, $v);
    }
    
    Static Function _Add   (&$List, $k, $v     ) { If(Is_Null($k)) $List     []=$v; Else $List     [$k]=$v; }
    Static Function _AddId (&$List, $k, $v, $Id) { If(Is_Null($k)) $List[$Id][]=$v; Else $List[$Id][$k]=$v; }
    Function Add_Any    ($k, $v          ) { Static::_Add   ($this->Default ,$k, $v         ); }
    Function Add_Name   ($k, $v, $Name   ) { Static::_AddId ($this->Names   ,$k, $v, $Name  ); }
    Function Add_Ext    ($k, $v, $Ext    ) { Static::_AddId ($this->Exts    ,$k, $v, $Ext   ); }
    Function Add_Manual ($k, $v, $Checker) { Static::_Add   ($this->Manual  ,$k, [$Checker, $v]); }
    
    Function Log(...$Args)
    {
      Return $GLOBALS['Loader']->Log(...$Args);
    }
  }
?>