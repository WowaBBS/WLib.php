<?
  $this->Load_Class('/UnitTest/Case');
  
  Class Test_FS_Driver_Driver Extends C_UnitTest_Case
  {
    Var $Factory;
  
    Function _Init($Args)
    {
      $this->Factory=$this->Create_Object('/FS/Driver/Factory');
      Parent::_Init($Args);
      $this->Test_Register_Argument_Name_Value('Factory', $this->GetFactory());
    }
    
    Function GetFactory() { Return $this->Factory; }
    
    Function TestCanGenerateValid($Factory)
    {
      $Factory->Create('Base'   );
      $Factory->Create('Map'    );
      $Factory->Create('Mixed'  );
      $Factory->Create('Null'   );
      $Factory->Create('Router' );
      $Factory->Create('System' );
    }

    Function TestAttr    ($Loader, $Factory) { Include 'Example/Attr.php8'    ; }
    Function TestList    ($Loader, $Factory) { Include 'Example/List.php8'    ; }
  # Function TestLink    ($Loader, $Factory) { Include 'Example/Link.php8'    ; }
    Function TestDisk    ($Loader, $Factory) { Include 'Example/Disk.php8'    ; }
    Function TestTest    ($Loader, $Factory) { Include 'Example/Test.php8'    ; }
    Function TestUnknown ($Loader, $Factory) { Include 'Example/Unknown.php8' ; }
  }
?>