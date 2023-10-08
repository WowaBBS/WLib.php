<?
  $this->Load_Type('/URI/UUID/Rfc4122/V1');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V6 Extends T_URI_UUID_Rfc4122_V1
  {
    Static Function GetDesiredVersion(): Int { Return 6; }

    Static Function _Create(Factory $F, Mac|String|Null $Mac=Null, $Rnd=Null, $Hns=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Hns-=Self::GetTimeOffset();
      $tl= $Hns      &0x0fff;
      $tm=($Hns>>12) &0xffff;
      $th=($Hns>>28) &0xffffffff; //28=12+16
      $Res= 
        Pack('Nnn', $th, $tm, $tl).
        $F->Random($Rnd, 2). // clock_seq
        $F->_Mac($Mac) // node
      ;
      Return Self::_Make($Res);
    }

    Function GetTime100ns(): ?Int
    {
      ['a'=>$a, 'b'=>$b, 'c'=>$c]=UnPack('Na/nb/nc', $this->ToBinary());
      Return ($a<<28 | $b<<12 | $c&0x0fff)+Self::GetTimeOffset();
    }
  }
?>