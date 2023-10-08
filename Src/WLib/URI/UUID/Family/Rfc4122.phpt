<?
  $this->Load_Type('/URI/UUID/Binary');
  $this->Load_Enum('/URI/UUID/Family');
  
  Use E_URI_UUID_Family As Family;

  Class T_URI_UUID_Family_Rfc4122 Extends T_URI_UUID_Binary
  {
    Function GetFamily(): Family { Return Family::Rfc4122; }
    
    Static Function _Make(?String $Res=Null): Self
    {
      If(StrLen($Res)!==16)
        Throw New InvalidArgumentException('Expected exactly 16 bytes, but got '.StrLen($Input));
      $Version=Static::GetDesiredVersion();
      If($Version<0 || $Version>15)
        Throw New InvalidArgumentException('Unknown version '.$Version);

      $Res[6]=Chr(Ord($Res[6])&0b00001111|(($Version&0xF)<<4));
      $Res[8]=Chr(Ord($Res[8])&0b00111111|0b10000000);
      Return New (Static::Class)($Res);
    }
    
  }
?>