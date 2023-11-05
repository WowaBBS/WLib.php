<?
  Class T_FS_Attr_Date
  {
    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function ToUnixTime() { Return 0; }
    
    Function ToString() { Return GmDate('Y-M-d H:i:s', $this->ToUnixTime()); }
    Function ToDebug() { Return $this->ToString().' '.$this->ToUnixTime(); }
  }
?>