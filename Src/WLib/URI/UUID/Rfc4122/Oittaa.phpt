<?
  $this->Load_Type('/URI/UUID/Rfc4122/V8');
  
  Use C_URI_UUID_Factory As Factory ;

  // This format was token from:
  // https://github.com/oittaa/uuid-php/blob/master/src/UUID.php  
  Class T_URI_UUID_Rfc4122_Oittaa Extends T_URI_UUID_Rfc4122_V8
  {
    Static Function _Create(Factory $F, $Hns=Null, $Rnd=Null): Self
    {
      $t=$F->_Time($Hns, 10_000, 48, 14, 0);
      $F->_Seq($t, 'Zero', 0, Self::Class);

      $Res=SubStr(Pack('Jn', $t>>14, $t>>2), 2).$F->Random($Rnd, 8);
      $Res[8]=Chr(Ord($Res[8])&0xF | $t<<4);
      
      Return Self::_Make($Res);
    }
    
    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$a, 'b'=>$b, 'c'=>$c, 'd'=>$d]=UnPack('Na/nb/nc/Cd', $Bin);
      $Time=$a<<30 | $b<<14 | $c<<2 | $d>>4;
      Return [
        'Class'  =>'Oittaa',
        'Time'   =>Factory::_RestoreTime($Time, 10_000, 48, 14, 0),
        'Random' =>SubStr($Bin, 8),
      ];
    }
  }
?>