<?
  $this->Load_Class('/UnitTest/Case');
  
  Class Test_FS_Driver_Driver Extends C_UnitTest_Case
  {
    Function TestCanGenerateValid()
    {
      $Factory=$this->Create_Object('/FS/Driver/Factory');
      $Factory->Create('Base'   );
      $Factory->Create('Map'    );
      $Factory->Create('Mixed'  );
      $Factory->Create('Null'   );
      $Factory->Create('Router' );
      $Factory->Create('System' );
    }
  }
?>