<?
  $Loader->Begin_Type('/URI/Path/Dir/Abstr');
 
  $Loader->Using_Type('/FS/Path');
 
  Use \Deprecated As Deprecated;

  Class T_URI_Path_Dir_Abstr Extends T_FS_Path
  {
    Function __Construct()
    {
    }
 
    // »щет текущий файл по пут€м $APaths
    Function SearchFile($AFile, $APaths=[])
    {
      $AFile=T_FS_Path::Create($AFile);
      If($AFile->IsFile())
        ForEach($APaths As $k=>$APath)
        {
          $this->Assign($APath);
          $this->Add($AFile);
        //Debug([$this->ToString(), $this->IsFile()]);
          If($this->IsFile())
            Return [$k];
        }
      ElseIf($AFile->IsDir())
        ForEach($APaths As $k=>$APath)
        {
          $this->Assign($APath);
          $this->Add($AFile);
        //Debug([$this->ToString(), $this->IsFile()]);
          If($this->IsDir())
            Return [$k];
        }
    //$this->Clear();
      Return False;
    }
  }
  
  #[Deprecated("Use T_URI_Path_Dir_Abstr As TAbsDir;")]
  Class TAbsDir Extends T_URI_Path_Dir_Abstr {};
 
  $Loader->End_Type('/URI/Path/Dir/Abstr');
?>