<?
  $this->Load_Class('/URI/UUID/Test/Base');
  
  Use T_URI_UUID_UUID As UUID;
  
  // Taken from
  // https://github.com/oittaa/uuid-php/blob/master/tests/UuidTest.php
  
  Class Test_URI_UUID_Test_Oittaa Extends C_URI_UUID_Test_Base
  {
    Function Test()
    {
      $this->TestCanGenerateValid();
      $this->TestCannotBeCreatedFromInvalidNamespace();
      $this->TestCanValidate();
      $this->TestCanGetVersion();
      $this->TestCanCompare();
      $this->TestToString();
      $this->TestCanUseAliases();
      $this->TestKnownGetTime();
      $this->TestGetTimeValid();
      $this->TestGetTimeNull();
      $this->TestGetTimeNearEpoch();
      $this->TestGetTimeNegativeNearEpoch();
      $this->TestGetTimeZero();
      $this->TestGetTimeMax();
    }
    
    Function TestCanGenerateValid()
    {
      $f=$this->GetFactory();

      $this->AssertSame('11a38b9a-b3da-360f-9353-a5a725514269', $f->v3('Dns', 'php.net')->ToString()); // Version3()
      $this->TestUnique(4, $f->v4(...), False); //Version4()
      $this->AssertSame('c4a760a8-dbcf-5254-a0d9-6a4474bd1b62', $f->v5('Dns', 'php.net')->ToString()); //Version5()
      $this->TestUnique(6, $f->v6(...), True); //Version6() 
      $this->TestUnique(7, $f->v7(...), True); //Version7() 
      $this->TestUnique(8, $f->Oittaa(...), True); //Version8() 
    }
    
    Function TestCannotBeCreatedFromInvalidNamespace()
    {
      $f=$this->GetFactory();

    //$this->ExpectException(\InvalidArgumentException::class);
    //TODO: $f->v5('invalid', 'php.net');
    }
    
    Function TestCanValidate()
    {
      $f=$this->GetFactory();

      $this->Assert( $f->Verify('11a38b9a-b3da-360f-9353-a5a725514269'   ));
      $this->Assert(!$f->Verify('11a38b9a-b3da-360f-9353-a5a72551426'    ));
      $this->Assert(!$f->Verify('11a38b9a-b3da-360f-9353-a5a7255142690'  ));
      $this->Assert( $f->Verify('urn:uuid:c4a760a8-dbcf-5254-a0d9-6a4474bd1b62'));
      $this->Assert( $f->Verify('{C4A760A8-DBCF-5254-A0D9-6A4474BD1B62}' ));
      $this->Assert(!$f->Verify('{C4A760A8-DBCF-5254-A0D9-6A4474BD1B62'  ));
      $this->Assert(!$f->Verify('C4A760A8-DBCF-5254-A0D9-6A4474BD1B62}'  ));
      
      $this->Assert( $f->Parse('urn:uuid:c4a760a8-dbcf-5254-a0d9-6a4474bd1b62')->Equals(
                     $f->Parse('{C4A760A8-DBCF-5254-A0D9-6A4474BD1B62}')));
      $this->Assert(!$f->Parse('c4a760a8-dbcf-5254-a0d9-6a4474bd1b62')->Equals(
                     $f->Parse('2140a926-4a47-465c-b622-4571ad9bb378')));
    }
    
    Function TestCanGetVersion()
    {
      $f=$this->GetFactory();

      $this->AssertSame(1, $f->v1     (                )->GetVersion());
      $this->AssertSame(3, $f->v3     ('Dns', 'php.net')->GetVersion());
      $this->AssertSame(4, $f->v4     (                )->GetVersion());
      $this->AssertSame(5, $f->v5     ('Dns', 'php.net')->GetVersion());
      $this->AssertSame(6, $f->v6     (                )->GetVersion());
      $this->AssertSame(7, $f->v7     (                )->GetVersion());
      $this->AssertSame(8, $f->v8     (                )->GetVersion());
      $this->AssertSame(8, $f->Oittaa (                )->GetVersion());
    }
    
    Function TestCanCompare()
    {
      $f=$this->GetFactory();
      
      //assertSame(0, 
      $this->Assert( $f->Parse('c4a760a8-dbcf-5254-a0d9-6a4474bd1b62')->Equals(
                     $f->Parse('C4A760A8-DBCF-5254-A0D9-6A4474BD1B62')));
     
      //assertGreaterThan(0, 
      $this->Assert( $f->Parse('c4a760a8-dbcf-5254-a0d9-6a4474bd1b63')->Greater(
                     $f->Parse('c4a760a8-dbcf-5254-a0d9-6a4474bd1b62')));
    }
    
    Function TestToString()
    {
      $f=$this->GetFactory();
      
      $this->Assert(      'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62'===
               $f->Parse('{C4A760A8-DBCF-5254-A0D9-6A4474BD1B62}')->ToString());
    }

    Function TestCanUseAliases()
    {
      $f=$this->GetFactory();

      $this->AssertSame('11a38b9a-b3da-360f-9353-a5a725514269', $f->v3('Dns', 'php.net')->ToString());
      $this->AssertSame('c4a760a8-dbcf-5254-a0d9-6a4474bd1b62', $f->v5('Dns', 'php.net')->ToString());
    }
    
    Function TestKnownGetTime()
    {
      $f=$this->GetFactory();

      $this->AssertSame(1645557742.0000000 ,$f->Parse('C232AB00-9414-11EC-B3C8-9E6BDECED846')->GetTime());
      $this->AssertSame(1645557742.0000000 ,$f->Parse('1EC9414C-232A-6B00-B3C8-9E6BDECED846')->GetTime());
      $this->AssertSame(1645557742.0000000 ,$f->Parse('017F22E2-79B0-7CC3-98C4-DC0C0C07398F')->GetTime());
      $this->AssertSame(1645557742.0007976 ,$f->Parse('017F22E2-79B0-8CC3-98C4-DC0C0C07398F', 'Oittaa')->GetTime());

      $this->AssertSame(16455577420000000 ,$f->Parse('C232AB00-9414-11EC-B3C8-9E6BDECED846')->GetTime100ns());
      $this->AssertSame(16455577420000000 ,$f->Parse('1EC9414C-232A-6B00-B3C8-9E6BDECED846')->GetTime100ns());
      $this->AssertSame(16455577420000000 ,$f->Parse('017F22E2-79B0-7CC3-98C4-DC0C0C07398F')->GetTime100ns());
      $this->AssertSame(16455577420007977 ,$f->Parse('017F22E2-79B0-8CC3-98C4-DC0C0C07398F', 'Oittaa')->GetTime100ns());
    }
    
    Function TestGetTimeValid()
    {
      $f=$this->GetFactory();

      For($i=1; $i<=10; $i++)
      {                                                      
        $this->AssertEqualsWithDelta(MicroTime(True), $f->v1     ()->GetTime(), 0.001);
        $this->AssertEqualsWithDelta(MicroTime(True), $f->v6     ()->GetTime(), 0.001);
        $this->AssertEqualsWithDelta(MicroTime(True), $f->v7     ()->GetTime(), 0.01 );
        $this->AssertEqualsWithDelta(MicroTime(True), $f->Oittaa ()->GetTime(), 0.001);
        USleep(100000);
      }
    }
    
    Function TestGetTimeNull()
    {
      $f=$this->GetFactory();

      $this->AssertNull($f->v4()->getTime());
    }
    
    Function TestGetTimeNearEpoch()
    {
      $f=$this->GetFactory();

      $this->AssertSame( 0.0000001 ,$f->Parse('13814001-1dd2-11b2-b6fa-54fb559c5fcd')->GetTime());
      $this->AssertSame( 0.0000001 ,$f->Parse('1b21dd21-3814-6001-b6fa-54fb559c5fcd')->GetTime());
    }
    
    Function TestGetTimeNegativeNearEpoch()
    {
      $f=$this->GetFactory();

      $this->AssertSame(-0.0000001 ,$f->Parse('1b21dd21-3813-6fff-b678-1556dde9b80e')->GetTime());
    }
    
    Function TestGetTimeZero()
    {
      $f=$this->GetFactory();

      $this->AssertSame(-12219292800.0000000 ,$f->Parse('00000000-0000-1000-8000-000000000000')->GetTime());
      $this->AssertSame(-12219292800.0000000 ,$f->Parse('00000000-0000-6000-8000-000000000000')->GetTime());
      $this->AssertSame(0.0000000            ,$f->Parse('00000000-0000-7000-8000-000000000000')->GetTime());
      $this->AssertSame(0.0000000            ,$f->Parse('00000000-0000-8000-8000-000000000000', 'Oittaa')->GetTime());
    }
    
    Function TestGetTimeMax()
    {
      $f=$this->GetFactory();

      $this->AssertSame(103072857660.6846975, $f->Parse('ffffffff-ffff-1fff-bfff-ffffffffffff')->GetTime());
      $this->AssertSame(103072857660.6846975, $f->Parse('ffffffff-ffff-6fff-bfff-ffffffffffff')->GetTime());
      $this->AssertSame(281474976710.6549760, $f->Parse('ffffffff-ffff-7fff-bfff-ffffffffffff')->GetTime());
      $this->AssertSame(281474976710.6560000, $f->Parse('ffffffff-ffff-8fff-bfff-ffffffffffff', 'Oittaa')->GetTime());
  
      $this->AssertSame(1030728576606846975, $f->Parse('ffffffff-ffff-1fff-bfff-ffffffffffff')->GetTime100ns());
      $this->AssertSame(1030728576606846975, $f->Parse('ffffffff-ffff-6fff-bfff-ffffffffffff')->GetTime100ns());
      $this->AssertSame(2814749767106550000, $f->Parse('ffffffff-ffff-7fff-bfff-ffffffffffff')->GetTime100ns());
      $this->AssertSame(2814749767106560000, $f->Parse('ffffffff-ffff-8fff-bfff-ffffffffffff', 'Oittaa')->GetTime100ns());
    }
  }
?>
