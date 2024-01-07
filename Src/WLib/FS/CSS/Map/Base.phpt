<?
  Class T_FS_CSS_Map_Base
  {
    Var $Names   =[];
    Var $Exts    =[];
    Var $Manual  =[];
    Var $Default =[];
    
    Function CollectRules(&$Res, $Node)
    {
    //$this->Log('Debug', $Name, ', ',  $Ext); //TODO: Key
      ForEach($this->Default                   As $R) $Res[]=$R;
      ForEach($this->Names [$Node->Name ]?? [] As $R) $Res[]=$R;
      ForEach($this->Exts  [$Node->Ext  ]?? [] As $R) $Res[]=$R;
      ForEach($this->Manual As[$Checker, $R]) If($Checker->Check($Node)) $Res[]=$R;
    }
    
    Function Clear()
    {
      $this->Names   =[];
      $this->Exts    =[];
      $this->Manual  =[];
      $this->Default =[];
    }

    Function CheckNode($Node) { $Res=[]; $this->CollectRules($Res, $Node); Return $Res; }
    
    Function InlineProcessNode($Node)
    {
      $Items=$this->CheckNode($Node);
    //$this->Log('Debug', 'Process ', $Node->IsFile()? 'file  ':'' , $Node->Name, ' in ', $this->ToDebugCheckers(), ' checks: ', Count($Items));
      $this->Clear();
      ForEach($Items As $Item)
        $Item->Process($this, $Node);
      Return $this;
    }
    
    Function AddCheckers($Checkers, $k=Null)
    {
      ForEach($Checkers As [$Checker, $v])
        $Checker->AddToMap($this, $k, $v);
    }
    
    Function AddItem($Item)
    {
      $this->AddCheckers([[$Item->Checker, $Item]], Spl_Object_ID($Item));
    }
    
    Static Function _Add   (&$List, $k, $v     ) { If(Is_Null($k)) $List     []=$v; Else $List     [$k]=$v; }
    Static Function _AddId (&$List, $k, $v, $Id) { If(Is_Null($k)) $List[$Id][]=$v; Else $List[$Id][$k]=$v; }
    Function Add_Any    ($k, $v          ) { Static::_Add   ($this->Default ,$k, $v         ); }
    Function Add_Name   ($k, $v, $Name   ) { Static::_AddId ($this->Names   ,$k, $v, $Name  ); }
    Function Add_Ext    ($k, $v, $Ext    ) { Static::_AddId ($this->Exts    ,$k, $v, $Ext   ); }
    Function Add_Manual ($k, $v, $Checker) { Static::_Add   ($this->Manual  ,$k, [$Checker, $v]); }
    
    Function Log(...$Args) { Return $GLOBALS['Loader']->Log(...$Args); }
    
    Function ToDebugCheckers()
    {
      $Res=[];
      If($this->Default) $Res[]='Any';
      ForEach($this->Names As $Name =>$R) $Res[]='Name:' .$Name ;
      ForEach($this->Exts  As $Ext  =>$R) $Res[]='Ext:'  .$Ext  ;
      ForEach($this->Manual As[$Checker, $R]) $Res[]=$Checker->ToDebug();
      Return Implode(',', $Res);
    }
  }
?>