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

    Function TestSystem($Factory)
    {
      Include 'Example.Attr.php8';
    }
    
    Function TestLink($Factory)
    { //TODO:
    # Include 'Example.Link.php8';
    }
  }
?>
