<?
  $this->Load_Type('/FS/Attr/Date');

  Class T_FS_Attr_Date_UnixTime Extends T_FS_Attr_Date
  {
    Public Int $Value=0;
    
    Function __Construct($v) { $this->Value=$v; }

    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function ToUnixTime() { Return $this->Value; }
    
    Function ToString() { Return GmDate('Y-M-d H:i:s', $this->Value); }
    Function ToDebug() { Return $this->ToString().' '.$this->Value; }
  }
?>