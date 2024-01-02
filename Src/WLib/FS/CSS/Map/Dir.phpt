<?
  $this->Load_Type('/FS/CSS/Map/Base');
  $this->Load_Type('/FS/CSS/Map/File');

  Class T_FS_CSS_Map_Dir Extends T_FS_CSS_Map_Base
  {
    Var $File;
    
    Function __Construct()
    {
      $this->File=New T_FS_CSS_Map_File();
    }

    Function Clear()
    {
      Parent::Clear();
      $this->File->Clear();
    }

    Function CheckNode($Node) { Return $Node->IsFile()? $this->File->CheckNode($Node):Parent::CheckNode($Node); }

  }
?>