<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V7 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 7; }

    Static Function _Create(Factory $F, $Rnd=Null, $Hns=Null): Self
    {
      $Hns??=$F->TimeStamp100ns();
      $Ms=IntDiv($Hns, 10_000);
      $SeqRn=UnPack('n', $F->Random($Rnd, 2))[1]%0x1000;

      [$OldMs, $OldSeq]=$F->_GetVar(Static::Class)?? [-1,0];
      
      If($OldSeq>=0 && $OldMs>$Ms)
        $OldSeq=$F->Log('Warning', 'Microtime is decreased: ', $OldMs, '=>',$Ms)->Ret(-1);
      
      $Diff=($Ms-$OldMs)<<12;
      If($OldSeq<0 || $Diff>$OldSeq)
        $Seq=$SeqRn;  
      Else
        $Seq=$OldSeq-$Diff+1;
      
      $F->_SetVar(Static::Class, [$Ms, $Seq]);
      
      $Ms+=$Seq>>12;
      
      $Res=SubStr(Pack('Jn', $Ms, $Seq), 2).$F->Random($Rnd, 8);
      Return Self::_Make($Res);
    }

    Function GetTime100ns(): ?Int
    {
      ['a'=>$a, 'b'=>$b]=UnPack('Na/nb', $this->ToBinary());
      Return ($a<<16 | $b)*10_000;
    }
  }
?>