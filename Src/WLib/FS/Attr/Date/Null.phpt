<?
  $this->Load_Type('/FS/Attr/Date');

  Class T_FS_Attr_Date_Null Extends T_FS_Attr_Date
  {
    Function ToUnixTime() { Return Null; }
    
  //Function ToString() { Return GmDate('Y-M-d H:i:s', $this->Value); }
  //Function ToDebug() { Return $this->ToString().' '.$this->Value; }
  }
?>