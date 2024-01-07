<?
  Class T_FS_CSS_Node
  {
    Var $Name   ;
    Var $Ext    ;
    Var $IsFile =False;
    
    Function Set($Name, $IsFile=False)
    {
      $this->Name   =$Name   ;
      $this->Ext    =PathInfo($Name, PATHINFO_EXTENSION);
      $this->IsFile =$IsFile ;
      Return $this;
    }
    
    Static Function IteratePath($Path)
    {
      $Path=Explode('/', $Path);
      $Last=Count($Path)-1;
      $Node=New T_FS_CSS_Node();
      ForEach($Path As $i=>$Item)
        If($i!==$Last)
          Yield $Node->Set($Item);
        ElseIf($Item!=='')
          Yield $Node->Set($Item, True);
    }
    
    Function IsFile () { Return  $this->IsFile; }
    Function IsDir  () { Return !$this->IsFile; }
  }
