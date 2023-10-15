<?
  $this->Load_Type('/URI/UUID/Rfc4122/V1');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V6 Extends T_URI_UUID_Rfc4122_V1
  {
    Static Function GetDesiredVersion(): Int { Return 6; }

    Static Function _Create(Factory $F, $Hns=Null, $Seq=Null, Mac|String|Null $Mac=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Hns-=Self::GetTimeOffset();
      $Seq=$F->_Seq($Hns, $Seq, 14, Self::Class);
      $Res= 
        Pack('Nnnn', $Hns>>28, $Hns>>12, $Hns, $Seq).
        $F->_Mac($Mac) // node
      ;
      Return Self::_Make($Res);
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$a, 'b'=>$b, 'c'=>$c, 'd'=>$Seq]=UnPack('Na/nb/nc/nd', $Bin);
      Return [
        'Class' =>'V6',
        'Time'  =>($a<<28 | $b<<12 | $c)+Self::GetTimeOffset(),
        'Seq'   =>$Seq,
        'Mac'   =>SubStr($Bin, 10),
      ];
    }
  }
?>