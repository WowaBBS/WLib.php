<?
  $Loader->Begin_Type('/URI/Path/Dir/Abstr');
 
  $Loader->Using_Type('/FS/Path');
 
  Class TAbsDir Extends TPath
  {
    Function __Construct()
    {
    }
 
    // »щет текущий файл по пут€м $APaths
    Function SearchFile($AFile, $APaths=[])
    {
     $AFile=TPath::Create($AFile);
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
 
  $Loader->End_Type('/URI/Path/Dir/Abstr');
?>