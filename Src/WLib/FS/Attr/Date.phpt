<?
  Class T_FS_Attr_Date
  {
    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function ToUnixTime() { Return 0; }
    
    Function ToString() { Return GmDate('Y-M-d H:i:s', $this->ToUnixTime()); }
  //****************************************************************
  // Debug
  
    Function ToDebug() { Return $this->ToString().' '.$this->ToUnixTime(); }
    Function _Debug_Serialize(Array &$Res)
    {
      $Res=$this->ToDebug();
    }
  
  //****************************************************************
  }
?>