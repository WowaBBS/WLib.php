<? NameSpace WLib\Debug\Measure;
  
  Class T_Base
  {
    Var $Value   ;
    Var $Postfix ;
    Var $Type_Num='Num';
    
    Function __Construct($Value, $Postfix)
    {
      $this->Value   =$Value   ;
      $this->Postfix =$Postfix ;
    }
    
    Function ToDebug($v, Array &$Res)
    {
      $f=FMod($v, 1);
      If($v<1   ) $Precision=Null; Else
      If($f<0.01) $Precision=0; Else
      If($f<0.1 ) $Precision=1; Else
      If($v> 100) $Precision=0; Else
      If($v>  10) $Precision=1; Else
      If($v>   1) $Precision=2; Else
                  $Precision=Null;
      
      If(Is_Null($Precision))
        $Res[]=$v;
      Else
      {
        $s=Number_Format($v, $Precision);
        If($v>=1000)
          $s=StrTr($s, ',', '`');
        $Res[]=DebugItem($s, $this->Type_Num);
      }
      
      If(($Postfix=$this->Postfix)!=='')
        $Res[]=$Postfix;
    }
    
    Static Function Compare($a, $b)
    {
      Return $a->Value <=> $b->Value;
    }
  }
?>