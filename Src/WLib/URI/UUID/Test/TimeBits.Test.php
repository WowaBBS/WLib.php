<?
  $this->Load_Class('/URI/UUID/Test/Base');
  
  Use T_URI_UUID_UUID As UUID;
  
  Class Test_URI_UUID_Test_TimeBits Extends C_URI_UUID_Test_Base
  {
    Function Test()
    {
      $f=$this->GetFactory();

      $this->Assert(($c=$f->Oittaa($v=0)->GetTime100ns())===$v, $v.'!='.$c);
    # for($i=-1; $i<62; $i++)
    #   $this->Log('Debug', $i, ': ', ($v=$f->Oittaa($i>=0? 1<<$i:0, "\0\0\0\0\0\0\0\0"))->ToString(), ' ', $v->GetTime100ns());
    //Assert(($c=$f->Example($v=1)->GetTime100ns())===$v, $v.'!='.$c);
      for($i=0; $i<62; $i++)
        $this->Assert(($c=$f->Oittaa($v=1<<$i)->GetTime100ns())===$v, $v.'!='.$c);
    }
  }
?>