<?
  $Loader->Begin_Type('/URI/Path/Dir/File');
  $Loader->Using_Type('/URI/Path/Dir/Abstr');
  
  Use \Deprecated As Deprecated;

  Class T_URI_Path_Dir_File Extends T_URI_Path_Dir_Abstr
  {
    Function __construct($Path='')
    {
      $this->Assign($Path);
    }
 
    Static Function Create($Path=''):Static
    {
      Return New Static($Path);
    }
 
    Function IsFile()
    {
      Return Is_File($this->ToString());
    }
 
    Function IsDir()
    {
      Return Is_Dir($this->ToString());
    }
 
    Function CreatePath($APath=False, $Attr=06775)
    {
      If($APath!==False)
        $this->Assign($APath);
      If($this->IsDir($Path))
        Return True;
      $Pth='';
      ForEach($this->Path As $v)
      {
        $Pth.=$v;
        If(!IsDir($Pth))
          @MkDir($Pth, $Attr);
        $Pth.='/';
      }
      Return IsDir($Pth);
    }
  }
 
  //Doesn't work in PHP8.4 #[Deprecated("Use T_URI_Path_Dir_File As TFileDir;")]
  Class TFileDir Extends T_URI_Path_Dir_File {};
 
  $Loader->End_Type('/URI/Path/Dir/File');
?>