<?
  $this->Load_Class('/UnitTest/Case');
  $this->Load_Type('/FS/Attr/Mode');
  
  Use T_FS_Attr_Mode As Mode;
  
  Class Test_FS_Attr_Modes Extends C_UnitTest_Case
  {
    Function TestCanGenerateValid()
    {
      $this->Log('Debug', Mode::New(0100644)->ToDebug());
      $this->Log('Debug', Mode::New(0040755)->ToDebug());
    }
  }
?>