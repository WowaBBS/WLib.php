<?
  Trait Trait_UnitTest_Asserts
  {
    Function Assert($Assertion, $Message='')
    {
      If($Assertion) Return False;
      $this->Log('Error', 'Assert failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertNull($Value, $Message='')
    {
      If(Is_Null($Value)) Return False;
      $this->Log('Error', 'AssertNull failed ', $Message)->BackTrace();
      Return True;
    }
    
    Function AssertEquals($Expected, $Actual, $Message='')
    {
      If($Expected==$Actual) Return False; //<Fast check
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
      If($Expected===$Actual) Return False;
      $z=$Expected==$Actual;
      $Debug=[
        'Expected' =>$Expected ,
        'Actual'   =>$Actual   ,
      ];
      If(GetType($Expected)!==GetType($Actual))
        Return $this->Log($z? 'Warning':'Error', 'AssertSome failed: Expected and Actual values have different types ', $Message)
          ->BackTrace()->Debug($Debug)->Ret(True);
      If(Is_Float($Expected) && !$z)
      {
        $z=(String)$Expected===(String)$Actual;
        if($z)
        {
          If(Is_Infinite ($Expected) && Is_Infinite ($Actual)) Return False;
          If(Is_Nan      ($Expected) && Is_Nan      ($Actual)) Return False;
          $Debug+=[
            'ExpectedBin' =>Bin2Hex(Pack('d', $Expected )),
            'ActualBin'   =>Bin2Hex(Pack('d', $Actual   )),
            'ExpectedFmt' =>Number_Format($Expected ,20, '.', ''),
            'ActualFmt'   =>Number_Format($Actual   ,20, '.', ''),
          ];
        }
      }
      Return $this->Log($z? 'Warning':'Error', 'AssertSome failed: Expected and Actual are different ', $Message)
        ->BackTrace()->Debug($Debug)->Ret(True);
    }
  }
?>