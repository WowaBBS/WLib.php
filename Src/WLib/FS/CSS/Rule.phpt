<?
  $this->Load_Type('/FS/CSS/Checker/Item');
  $this->Load_Type('/FS/CSS/Map/File' );
  $this->Load_Type('/FS/CSS/Map/Dir'  );

  Class T_FS_CSS_Rule
  {
    Var $Checkers =[];
    Var $Vars     =[];
    
    Function __Construct($Checkers, $Vars)
    {
      $this->Checkers =$Checkers ;
      $this->Vars     =$Vars     ;
    }
    
    Function CheckPath(String $Path)
    {
      $Map=New T_FS_CSS_Map_Dir();
      $Path=Explode('/', $Path);
      $Last=Count($Path)-1;

      $Ok=False;
      $Event=Function() Use(&$Ok) { $Ok=True; };
      
      $Item=New T_FS_CSS_Checker_Item($this->Checkers, $Event);
      
      $Items=[$Item];
      ForEach($Items As $Item)
        $Item->AddToMap($Map);
        
      $Node=New T_FS_CSS_Node();
      
      ForEach($Path As $i=>$PathItem)
      {
        $IsFile=$i===$Last;
        If($IsFile && $PathItem==='') Break;
        $Ok=False;
        $Node->Set($PathItem, $IsFile);
        $Items=$Map->CheckNode($Node);
      # $this->Log('Debug', 'Process ', $Node->IsFile()? 'file  ':'' , $Node->Name, ' in ', $Map->ToDebugCheckers(), ' checks: ', Count($Items));
        $Map->Clear();
        ForEach($Items As $Item)
          $Item->Process($Map, $Node);
      }
      
      Return $Ok;
    }
  
    Function Log(...$Args) { Return $GLOBALS['Loader']->Log(...$Args); }
  }
?>