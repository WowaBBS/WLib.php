<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V7 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 7; }

    Static Function _Create(Factory $F, $Hns=Null, $Seq=Null, $Rnd=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Ms=IntDiv($Hns, 10_000);
      $Seq=$F->_Seq($Ms, $Seq, 12, Self::Class);
      $Res=SubStr(Pack('Jn', $Ms, $Seq), 2).$F->Random($Rnd, 8);
      Return Self::_Make($Res);
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$a, 'b'=>$b, 'c'=>$Seq]=UnPack('Na/nb/nc', $Bin);
      Return [
        'Class'  =>'V7',
        'Time'   =>($a<<16 | $b)*10_000,
        'Seq'    =>$Seq,
        'Random' =>SubStr($Bin, 8),
      ];
    }
  }
?>