<?
 Unit('FS/Router/TNode');

 Class T_FS_Router_Node Extends T_FS_Base_Node
 {
   Var $Base = False;
   Var $MyVars = Array();

/*
   Function _Init($Args)
   {
    parent::_Init($Args);
   }

   Function &_Clone()
   {
    $Res=&$this->Create_Object('FS/Router/Node');
    $Res->Provider=&$this->Provider;
    $Res->Path->Assign(&$this->Path);
    $Res->Base=&$this->Base;
    $Res->MyVar=&$this->MyVar;
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
*/
//   //Function &Node()         { Return $this->Base->Node();           }
//   Function IsFile()        { Return $this->Base->IsFile();         }
//   Function IsDir()         { Return $this->Base->IsDir();          }
//   Function Exists()        { Return $this->Base->Exists();         }
//   Function &Stream($AMode) { Return $this->Base->Stream($AMode);   }
//   Function Files($Mask=False,$Attr=3) { Return $this->Base->Files($Mask,$Attr); }
//   Function Nodes()         { Return $this->Base->Nodes();          }
//   Function IncludePhp($U=Array(),$R=Array()) { Return $this->Base->IncludePhp($U,$R); }
//   Function LoadFile()        { Return $this->Base->LoadFile  ();       }
//   Function LoadText()        { Return $this->Base->LoadText  ();       }
//   Function SaveFile($Data)   { Return $this->Base->SaveFile  ($Data); }
//   Function SaveText($Data)   { Return $this->Base->SaveText  ($Data); }
//   Function AppendFile($Data) { Return $this->Base->AppendFile($Data); }
//   Function AppendText($Data) { Return $this->Base->AppendText($Data); }
//   Function &URL()            { Return $this->Base->URL();          }
//   Function Vars()            { Return $this->MyVars;               }
 }

 EndUnit();
?>