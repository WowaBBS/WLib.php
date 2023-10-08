<?
  $this->Load_Type('/URI/UUID/Rfc4122/V8');
  
  Use C_URI_UUID_Factory As Factory ;

  // This format was token from:
  // https://github.com/oittaa/uuid-php/blob/master/src/UUID.php  
  Class T_URI_UUID_Rfc4122_Oittaa Extends T_URI_UUID_Rfc4122_V8
  {
  //Static Function GetDesiredVersion(): Int { Return 8; }

    Static Function _Create(Factory $F, $Rnd=Null, $Hns=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Ms=IntDiv($Hns, 10_000);
      If($Ms>=1<<48) Throw New \TypeError('TimeStamp is too big '  .$Hns);
      If($Hns<0    ) Throw New \TypeError('TimeStamp is too small '.$Hns);

      $SubSec  = IntDiv(($Hns%10_000)<<14, 10_000);
      $SubSecA = $SubSec>>2;     //12 bit
      $SubSecB = $SubSec & 0x03; // 2 bit

      $Res=SubStr(Pack('Jn', $Ms, $SubSecA), 2).$F->Random($Rnd, 8);
      $Res[8]=$Res[8]&"\x0f" | Chr($SubSecB<<4);
      
      Return Self::_Make($Res);
    }

    Function GetTime100ns(): ?Int
    {
      ['a'=>$a, 'b'=>$b, 'c'=>$c, 'd'=>$d]=UnPack('Na/nb/nc/Cd', $this->ToBinary());
      $Ms     =$a<<16 | $b;
      $SubSec =(($c&0x0fff)<<2)+(($d>>4)&0x03)+1;
      $Res=$Ms*10_000+(($SubSec*10_000)>>14);
      Return $Res;
    }
  }
?>