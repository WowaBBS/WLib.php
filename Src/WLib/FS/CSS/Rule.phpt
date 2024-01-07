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

      $Ok=False;
      $Event=Function() Use(&$Ok) { $Ok=True; };
      
      $Item=New T_FS_CSS_Checker_Item();
      $Item->CreateSub($this->Checkers, $Event);
      $Item->AddToMapSub($Map);
      
      ForEach(T_FS_CSS_Node::IteratePath($Path) As $Node)
      {
        $Ok=False;
        $Map->InlineProcessNode($Node);
      }
      
      Return $Ok;
    }
  
    Function Log(...$Args) { Return $GLOBALS['Loader']->Log(...$Args); }
  }
?>