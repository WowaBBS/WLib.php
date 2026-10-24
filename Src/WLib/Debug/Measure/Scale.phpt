<? NameSpace WLib\Debug\Measure;
  $this->Load_Type('/Debug/Measure/Base');
  
  Class T_Scale Extends T_Base
  {
    Var $Scale;
    
    Function __Construct($Value, $Postfix)
    {
      Parent::__Construct($Value, $Postfix);
      $this->Scale   =$Value? 1/$Value:1;
    }

    Function ToDebug($v, Array &$Res)
    {
      If ($this->Scale !== 1)
        $v*=$this->Scale;
        
      Parent::ToDebug($v, $Res);
    }
  }
?>