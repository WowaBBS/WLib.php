<?
  $this->Load_Type('/URI/UUID/UUID');
  $this->Load_Enum('/URI/UUID/Family');
  
  Use E_URI_UUID_Family As Family;
  
  Class T_URI_UUID_Family_Unknown Extends T_URI_UUID_UUID
  {
    Private $Unknown;

    Function __Construct(String $v) { $this->Unknown=$v; }

    Function GetFamily(): Family { Return Family::Unknown; }
    Function IsNil(): Bool { Return True; }
    Function _ToBinary(): String { Return E_URI_UUID_Family::_Nil; }
  }
?>