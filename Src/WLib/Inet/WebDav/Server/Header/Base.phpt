<?
  Class T_Inet_WebDav_Server_Header_Base
  {
    Var $Name='';
    Var $Headers;
    
    Function __Construct($Headers, $Name=Null)
    {
      $this->Headers = $Headers;
      if($Name) $this->Name=$Name;
    }
  }
?>