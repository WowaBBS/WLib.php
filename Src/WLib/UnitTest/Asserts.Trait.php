<?
  Trait Trait_UnitTest_Asserts
  {
    Function Assert($Assertion, $Message='')
    {
      If($Assertion) Return False;
      $this->Test_SetFailed();
      $this->Log('Error', 'Assert failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertTrue($Assertion, $Message='')
    {
      If($Assertion===True) Return False;
      $this->Test_SetFailed();
      $this->Log('Error', 'AssertTrue failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertFalse($Assertion, $Message='')
    {
      If($Assertion===False) Return False;
      $this->Test_SetFailed();
      $this->Log('Error', 'AssertFalse failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertNull($Value, $Message='')
    {
      If(Is_Null($Value)) Return False;
      $this->Test_SetFailed();
      $this->Log('Error', 'AssertNull failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertEquals($Expected, $Actual, $Message='')
    {
      If($Expected==$Actual) Return False; //<Fast check
      $this->Test_SetFailed();
      $Debug=[
        'Expected' =>$Expected ,
        'Actual'   =>$Actual   ,
      ];
      Return $this->Log('Error', 'AssertEquals failed: Expected and Actual are different ', $Message)
        ->BackTrace()->Debug($Debug)->Ret(True);
    }
    
    Function AssertEqualsWithDelta(Float $Expected, Float $Actual, Float $Delta, $Message='')
    {
      $Diff=Abs($Expected-$Actual);
      If($Diff<=$Delta) Return False;
      $this->Test_SetFailed();
      $Debug=[
        'Expected' =>$Expected ,
        'Actual'   =>$Actual   ,
        'Diff'     =>$Diff     ,
        'Delta'    =>$Delta    ,
      ];
      Return $this->Log('Error', 'AssertEqualsWithDelta failed: Expected and Actual have diff More than Delta ', $Message)
        ->BackTrace()->Debug($Debug)->Ret(True);
    }
    
    Function AssertSame($Expected, $Actual, $Message='')
    {
      $Res=$this->IsIdentical($Expected, $Actual);
      If($Res[0]) Return False;
      $this->Test_SetFailed();
      $z=Is_Null($Res[0]);
      $Debug=[
        'Expected' =>$Expected ,
        'Actual'   =>$Actual   ,
      ]+($Res['Debug']?? []);
      If($Res[1]==='Type')
        Return $this->Log($z? 'Warning':'Error', 'AssertSome failed: Expected and Actual values have different types ', $Message)
          ->BackTrace()->Debug($Debug)->Ret(True);
      Return $this->Log($z? 'Warning':'Error', 'AssertSome failed: Expected and Actual are different ', $Message)
        ->BackTrace()->Debug($Debug)->Ret(True);
    }
    
    Function AssertNotSame($Expected, $Actual, $Message='')
    {
      $Res=$this->IsIdentical($Expected, $Actual);
      If(!$Res[0]) Return False;
      $this->Test_SetFailed();
      $Debug=[
        'Expected' =>$Expected ,
        'Actual'   =>$Actual   ,
      ]+($Res['Debug']?? []);
    
      Return $this->Log('Error', 'AssertNotSome failed: Expected and Actual values are some ', $Message)
        ->BackTrace()->Debug($Debug)->Ret(True);
    }

    Function IsIdentical($a, $b)
    {
      If($a===$b) Return [True, 'Sharp'];
      $z=$a==$b;
      If(GetType($a)!==GetType($b))
        Return [$z? Null:False, 'Type', 'Msg'=>['values have different types']];
      If(Is_Float($a) && !$z && (String)$a===(String)$b)
      {
        If(Is_Infinite ($a) && Is_Infinite ($b)) Return [True, 'Float/Inf'];
        If(Is_Nan      ($a) && Is_Nan      ($b)) Return [True, 'Float/Nan'];
        $Debug=[
          'Bin' =>[Bin2Hex(Pack('d', $a)),
                   Bin2Hex(Pack('d', $b))],
          'Fmt' =>[Number_Format($a ,20, '.', ''),
                   Number_Format($b ,20, '.', '')],
        ];
        Return [False, 'Float/StrEquals', 'Debug'=>$Debug];
      }
      Return [$z? Null:False];
    }

  }
?>