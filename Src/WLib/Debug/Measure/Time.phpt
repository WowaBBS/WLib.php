<? NameSpace WLib\Debug\Measure;

  $Loader->Load_Type('/Debug/Custom/Item' ); Use Function \WLib\Debug\Custom\DebugItem;
  $Loader->Load_Type('/Debug/Measure/Base');
  
  Class T_Time Extends T_Base
  {
    Var $Format ;
    
    Function __Construct($Value, $Format)
    {
      Parent::__Construct($Value, ' ');
      $this->Format =$Format;
    }

    Function ToDebug($v, Array &$Res)
    {
      $v=(Int)$v;
      
      $PerDay = 24*60*60;
      $Days = IntDiv($v, $PerDay);
      $v %= $PerDay;
      
      If($Days)
        Parent::ToDebug($Days, $Res);
      
      $s=Date($this->Format, (Int)$v);
      
      $Res[]=DebugItem($s, $this->Type_Num); //TODO: Split
    }
  }
?>