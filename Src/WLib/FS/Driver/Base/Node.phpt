<?
  $Loader->Load_Type('/FS/Path');
 
  Class T_FS_Driver_Base_Node
  {
    Var $Provider = False;
    Var $Path     = False;
    Var $MyVars   = []   ;
 
    Function __Construct($Provider, $Path)
    {
      $this->Provider=$Provider;
      $this->Path=T_FS_Path::Create($Path);
    }
 
  //Function Clone() { Return New $this->Create_Object('/FS/Base/Node', $this->Provider, $this->Path); }
 
    Function ChDir($APath)
    {
      $LPath=New T_FS_Path($APath);
      If($LPath->Path)
      {
        $LPath->Norm($this->Path);
        $this->Path->Assign($LPath);
      }
    }
 
    Function Node($APath='')
    {
      If(!$APath)
        Return $this->Provider->Node($this->Path);
      $LPath=New T_FS_Path($APath);
    //If($LPath->Path)
    //  $LPath->Norm($this->Path);
      $LPath->AddLeft($this->Path);
      $LPath->Norm();
      $Res=$this->Provider->Node($LPath);
      Return $Res;
    }
 
    Function IsFile()        { Return $this->Provider->IsFile($this->Path);         }
    Function IsDir()         { Return $this->Provider->IsDir($this->Path);          }
    Function Exists()        { Return $this->Provider->Exists($this->Path);         }
    Function Stream($AMode)  { Return $this->Provider->Stream($this->Path,$AMode);  }
    Function Files($Mask=False,$Attr=3) { Return $this->Provider->Files($this->Path,$Mask,$Attr); }
    Function Nodes()         { Return $this->Provider->Nodes($this->Path);          }
    Function IncludePhp($U=[],$R=[]) { Return $this->Provider->IncludePhp($this->Path,$U,$R); }
    Function URL()             { Return $this->Provider->URL($this->Path);          }
    Function Vars()            { Return $this->Provider->Vars($this->Path);         }
 
    Function LoadFile()        { Return $this->Provider->LoadFile  ($this->Path);       }
    Function LoadText()        { Return $this->Provider->LoadText  ($this->Path);       }
    Function SaveFile($Data)   { Return $this->Provider->SaveFile  ($this->Path,$Data); }
    Function SaveText($Data)   { Return $this->Provider->SaveText  ($this->Path,$Data); }
    Function AppendFile($Data) { Return $this->Provider->AppendFile($this->Path,$Data); }
    Function AppendText($Data) { Return $this->Provider->AppendText($this->Path,$Data); }
  }
?>