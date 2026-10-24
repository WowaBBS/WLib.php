<? NameSpace WLib\Debug\Measure;

  $Loader->Load_Type('/Debug/Custom/Item'); Use Function \WLib\Debug\Custom\DebugItem;
  
  Class T_Base
  {
    Var $Key     ;
    Var $Value   ;
    Var $Postfix ;
    Var $Type_Num     ='Num'   ;
    Var $Type_Postfix ='Class' ;
    
    Function __Construct($Value, $Postfix)
    {
      $this->Key     =Pack('d', $Value);
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
        $s=Number_Format($v, $Precision, '.', '`');
        $Res[]=DebugItem($s, $this->Type_Num);
      }
      
      If(($Postfix=$this->Postfix)!=='')
        $Res[]=DebugItem($Postfix, $this->Type_Postfix);
    }
    
    Static Function Compare($a, $b)
    {
      Return $a->Value <=> $b->Value;
    }
  }
?>