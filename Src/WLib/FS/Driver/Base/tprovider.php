<?
 Unit('FS/Base/TProvider');

 Uses('FS/Base/TNode');
 Uses('System/TObject');

 Class T_FS_Base_Provider Extends T_Object
 {
 /*
   Function _Init($Args)
   {
    parent::_Init($Args);
   }
 */
   Function IsFile($Path)
   {
    Return False;
   }

   Function IsDir($Path)
   {
    Return False;
   }

   Function GetNode($Path)
   {
   }

   Function LoadFile($Path)
   {
    $f=&$this->Stream($Path,omReadOnly|omBinary);
    If(!$f)
      Return False;
    $Res=$f->ReadAll();
    $f->Close();
    Return $Res;
   }

   Function LoadText($Path)
   {
    $f=&$this->Stream($Path,omReadOnly|omText);
    If(!$f)
      Return False;
    $Res=$f->Get_Content();
    $f->Close();
    Return $Res;
   }

   Function SaveFile($Path,$Data)
   {
    $f=&$this->Stream($Path,omWriteOnly|omCreate|omClear|omBinary);
    If(!$f)
      Return False;
    $f->Write($Data);
    $f->Close();
   }

   Function SaveText($Path,$Data)
   {
    $f=&$this->Stream($Path,omWriteOnly|omCreate|omClear|omText);
    If(!$f)
      Return False;
    $f->Write($Data);
    $f->Close();
   }

   Function AppendFile($Path,$Data)
   {
    $f=&$this->Stream($Path,omWriteOnly|omCreate|omAppEnd|omBinary);
    If(!$f)
      Return False;
    $f->Write($Data);
    $f->Close();
   }

   Function AppendText($Path,$Data)
   {
    $f=&$this->Stream($Path,omWriteOnly|omCreate|omAppEnd|omText);
    If(!$f)
      Return False;
    $f->Write($Data);
    $f->Close();
   }

   Function IncludePhp($IncludePhp_Path,$UnPack_Vars=Array(),$Pack_Vars=Array())
   {
    Extract($UnPack_Vars);
    $Res=Eval('?>'.$this->LoadText($IncludePhp_Path).'<?');
    ForEach($Pack_Vars As $Pack_Var)
      $UnPack_Vars[$Pack_Var]=${$Pack_Var};
    Return $Res;
   }

   Function &URL($Path) { Return New TURL(); }
   Function Vars($Path) { Return Array(); }

   Function &Node($Path=False)
   {
    $Res=&New T_FS_Base_Node();
    If($Path)
      $Res->Path->Assign($Path);
    $Res->Provider=&$this;
    Return $Res;
   }

 }

 EndUnit();
?>