<?
  $this->Load_Type('/URI/UUID/UUID');
  
  Use E_URI_UUID_Family As Family;
  
  Class T_URI_UUID_Family_Max Extends T_URI_UUID_UUID
  {
    Function GetFamily(): Family { Return Family::Max; }
    Function _ToBinary(): String { Return E_URI_UUID_Family::_Max; }
  }
?>