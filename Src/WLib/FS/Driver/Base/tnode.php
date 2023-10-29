<?
 Unit('FS/Base/TNode');

 Uses('URI/Path/TBase');
 Uses('System/TObject');

 Class T_FS_Base_Node Extends T_Object
 {
   Var $Provider = False;
   Var $Path     = False;
   Var $MyVars = Array();

   Function _Init($Args)
   {
    parent::_Init($Args);
    $this->Path=&New TPath();
   }

   Function &_Clone()
   {
    $Res=&$this->Create_Object('FS/Base/Node');
    $Res->Provider=&$this->Provider;
    $Res->Path->Assign(&$this->Path);
    Return $Res;
   }

   Function ChDir($APath)
   {
    $LPath=&New TPath($APath);
    If($LPath->Path)
     {
      $LPath->Norm($this->Path);
      $this->Path->Assign($LPath);
     }
   }

   Function &Node($APath='')
   {
    If(!$APath)
      Return $this->Provider->Node($this->Path);
    $LPath=&New TPath($APath);
    //If($LPath->Path)
    //  $LPath->Norm($this->Path);
    $LPath->AddLeft($this->Path);
    $LPath->Norm();
    $Res=&$this->Provider->Node($LPath);
    Return $Res;
   }

   Function IsFile()        { Return $this->Provider->IsFile($this->Path);         }
   Function IsDir()         { Return $this->Provider->IsDir($this->Path);          }
   Function Exists()        { Return $this->Provider->Exists($this->Path);         }
   Function &Stream($AMode) { $Res=&$this->Provider->Stream($this->Path,$AMode); Return $Res; }
   Function Files($Mask=False,$Attr=3) { Return $this->Provider->Files($this->Path,$Mask,$Attr); }
   Function Nodes()         { Return $this->Provider->Nodes($this->Path);          }
   Function IncludePhp($U=Array(),$R=Array()) { Return $this->Provider->IncludePhp($this->Path,$U,$R); }
   Function &URL()            { Return $this->Provider->URL($this->Path);          }
   Function Vars()            { Return $this->Provider->Vars($this->Path);         }

   Function LoadFile()        { Return $this->Provider->LoadFile  ($this->Path);       }
   Function LoadText()        { Return $this->Provider->LoadText  ($this->Path);       }
   Function SaveFile($Data)   { Return $this->Provider->SaveFile  ($this->Path,$Data); }
   Function SaveText($Data)   { Return $this->Provider->SaveText  ($this->Path,$Data); }
   Function AppendFile($Data) { Return $this->Provider->AppendFile($this->Path,$Data); }
   Function AppendText($Data) { Return $this->Provider->AppendText($this->Path,$Data); }
 }

 EndUnit();
?>