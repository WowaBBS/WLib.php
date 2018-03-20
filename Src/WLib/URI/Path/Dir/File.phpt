<?
  $Loader->Begin_Type('/URI/Path/Dir/File');
 
  $Loader->Using_Type('/URI/Path/Dir/Abstr');
 
  Class TFileDir Extends TAbsDir
  {
    Function __construct($Path='')
    {
      $this->Assign($Path);
    }
 
    Static Function Create($Path=''):TFileDir
    {
      Return New TFileDir($Path);
    }
 
    Function IsFile()
    {
      Return Is_File($this->Make());
    }
 
    Function IsDir()
    {
      Return Is_Dir($this->Make());
    }
 
    Function CreatePath($APath=False, $Attr=06775)
    {
      If($APath!==False)
        TPath::Assign($APath);
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
 
  $Loader->End_Type('/URI/Path/Dir/File');
?>