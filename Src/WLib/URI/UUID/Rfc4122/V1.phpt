<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V1 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 1; }

    Static Protected $TimeOffset;
    Static Function GetTimeOffset() { Return Self::$TimeOffset??=GmMkTime(0, 0, 0, 10, 15, 1582)*10_000_000; }
    
    Static Function _Create(Factory $F, $Hns=Null, $Seq=Null, Mac|String|Null $Mac=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Hns-=Self::GetTimeOffset();
      $Seq=$F->_Seq($Hns, $Seq, 14, Self::Class);
      $Res=Pack('Nnnn', $Hns, $Hns>>32, $Hns>>48, $Seq);
      Return Self::_Make($Res.$F->_Mac($Mac));
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$a, 'b'=>$b, 'c'=>$c, 'd'=>$Seq]=UnPack('Na/nb/nc/nd', $Bin);
      Return [
        'Class' =>'V1',
        'Time'  =>($c<<48 | $b<<32 | $a)+Self::GetTimeOffset(),
        'Seq'   =>$Seq,
        'Mac'   =>SubStr($Bin, 10),
      ];
    }
  }
?>