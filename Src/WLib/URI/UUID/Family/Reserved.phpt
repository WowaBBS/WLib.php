<?
  $this->Load_Enum('/URI/UUID/Family');
  $this->Load_Type('/URI/UUID/Binary');
  
  Use E_URI_UUID_Family As Family;

  Class T_URI_UUID_Family_Reserved Extends T_URI_UUID_Binary
  {
    Function GetFamily(): Family { Return Family::Reserved; }
  }
?>