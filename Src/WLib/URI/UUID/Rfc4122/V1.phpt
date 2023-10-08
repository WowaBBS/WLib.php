<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V1 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 1; }

    Static Protected $TimeOffset;
    Static Function GetTimeOffset() { Return Self::$TimeOffset??=GmMkTime(0, 0, 0, 10, 15, 1582)*10_000_000; }
    
    Static Function _Create(Factory $F, Mac|String|Null $Mac=Null, $Rnd=Null, $Hns=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Hns-=Self::GetTimeOffset();
      $Res=Pack(
        'Nnn',
         $Hns &0xffffffff,
        ($Hns>>32)&0xffff,
        ($Hns>>48)&0x0fff,
      );
      Return Self::_Make($Res.$F->Random($Rnd, 2).$F->_Mac($Mac));
    }

    Function GetTime100ns(): ?Int
    {
      ['a'=>$a, 'b'=>$b, 'c'=>$c]=UnPack('Na/nb/nc', $this->ToBinary());
      Return (($c&0x0fff)<<48 | $b<<32 | $a)+Self::GetTimeOffset();
    }
  }
?>