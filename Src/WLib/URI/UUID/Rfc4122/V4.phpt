<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V4 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 4; }

    Static Function _Create(Factory $F, $Random): Self
    {
      Return Self::_Make($F->Random($Random, 16));
    }
  }
?>