<?
  $this->Load_Type('/FS/Attr/Date');
  $this->Load_Type('/FS/Attr/Date/Null'); Use T_FS_Attr_Date_Null As Nil;

  Class T_FS_Attr_Date_UnixTime Extends T_FS_Attr_Date
  {
    Public Int $Value=0;
    
    Function __Construct($v) { $this->Value=$v; }

    Static Function New($Value)
    {
      If(Is_Object($Value)) Return $Value;
      If(Is_Integer($Value)) Return New Static($Value);
      if($Value===Null) Return New Nil();
      Return New Error($Value);
    }
    
    Function ToUnixTime() { Return $this->Value; }
    
  //Function ToString() { Return GmDate('Y-m-d H:i:s', $this->Value); }
  //Function ToDebug() { Return $this->ToString().' '.$this->Value; }
  }
?>