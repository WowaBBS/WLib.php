<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V8 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 8; }

    Static Function _Create(Factory $F, $Res): Self
    {
      $Res??=$F->Random($Res, 16);
      If(StrLen($Res)!==16)
        Throw New Exception('The argument must be a binary string of exactly 16 octets.');

      Return Self::_Make($Res);
    }
  }
?>