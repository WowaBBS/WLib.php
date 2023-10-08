<?
  $this->Load_Type('/URI/UUID/UUID');
  
  Class T_URI_UUID_Binary Extends T_URI_UUID_UUID
  {
    Private $Value;

    Function __Construct(String $v) { $this->Value=$v; $this->Validate(); }
    
    Function _ToBinary(): String { Return $this->Value; }
  }
?>