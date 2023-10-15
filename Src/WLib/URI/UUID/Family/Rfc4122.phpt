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
      Static::_Fix($Res);
      Return New (Static::Class)($Res);
    }
    
    Static Function _Fix(&$Res)
    {
      $Version=Static::GetDesiredVersion();
      If($Version<0 || $Version>15)
        Throw New InvalidArgumentException('Unknown version '.$Version);

      $Res[6]=Chr(Ord($Res[6])&0x0F|($Version<<4));
      $Res[8]=Chr(Ord($Res[8])&0x3F|0x80);
    }

    Static Function _UnFix(&$Res)
    {
      $Res[6]=Chr(Ord($Res[6])&0x0F);
      $Res[8]=Chr(Ord($Res[8])&0x3F);
    }
  }
?>