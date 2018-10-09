<?
  $Loader->Parent_Class('/Object');
  $Loader->Load_Lib('/FS/My');
  $Loader->Load_Lib('/FS/Utils');

  class T_FS_Search_Item
  {
    Var $Name     ='';
    Var $FullPath ='';
    Var $LocPath  ='';
    Var $IsDir    =false;
    Var $IsFile   =false;
    Var $Parent   =null;
    
    Var $Public   =true  ;
    Var $SubDir   =false ;
    Var $AddRes   =null  ;
    Var $Abort    =false ;
    
    Function SetPublic ($v=true) { $this->Public =$v ?? $this->Public; }
    Function SetSubDir ($v=true) { $this->SubDir =$v; }
    Function Abort     ($v=true) { $this->Abort  =$v; }
    Function SetAddRes ($v=true) { $this->AddRes =$v; }

    Function IsPublic () { return $this->Public  ; }
    Function IsSubDir () { return $this->SubDir  ; }
    Function IsAbort  () { return $this->Abort   ; }
    Function IsAddRes () { return $this->AddRes ?? $this->Public; }
    
    Function __Construct($Name, $FullPath, $LocPath, $IsDir, $IsFile, $Parent)
    {
      $this->Name     = $Name     ;
      $this->FullPath = $FullPath ;
      $this->LocPath  = $LocPath  ;
      $this->IsDir    = $IsDir    ;
      $this->IsFile   = $IsFile   ;
      $this->SubDir   = $IsDir    ;
      $this->Parent   = $Parent   ;
      $this->Public   = $Parent? $Parent->Public:true;
    }
    
    Function GetNick  () { return FileName_GetFileNick ($this->GetName()); }
    Function GetExt   () { return GetFileNameExt       ($this->GetName()); }
    Function GetName  () { return $this->Name     ; }
    Function GetLocalPath () { return $this->LocPath  ; }
    Function GetFullPath  () { return $this->FullPath ; }
    
    Function IsDir  () { return $this->IsDir  ; }
    Function IsFile () { return $this->IsFile ; }
    
    Static Function First($FullPath, $LocPath)
    {
      return New T_FS_Search_Item('', $FullPath, $LocPath, true, false, null);
    }

    Static Function Child($Parent, $Name)
    {
      $FullPath =$Parent->FullPath .'/'.$Name;
      $LocPath  =$Parent->LocPath  .'/'.$Name;
      
      // TODO: Custom FS
      $IsDir  =Is_Dir  ($FullPath);
      $IsFile =Is_File ($FullPath);
      
      return New T_FS_Search_Item($Name, $FullPath, $LocPath, $IsDir, $IsFile, $Parent);
    }
  };
?>