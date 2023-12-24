<?
  $this->Load_Type('/FS/CSS/Checker/Match/RegExp');
  $Loader->Load_Lib('/FS/Utils'); //FileMask2RegExp

  Class T_FS_CSS_Checker_Match_Mask Extends T_FS_CSS_Checker_Match_RegExp
  {
    Var $Mask='';
  
    Function __Construct($v) { $this->Mask=$v; Parent::__Construct(FileMask2RegExp($v)); }
    Function GetType() { Return 'Mask'; }
    Function GetArg() { Return $this->Mask; }
  }
