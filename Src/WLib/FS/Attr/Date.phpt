<?
  Class T_FS_Attr_Date
    Implements Stringable 
  {
  //Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function ToUnixTime() { Return 0; }
    Function FracNanoSecond() { Return 0; }
    
    Function ToString() { $v=$this->ToUnixTime(); Return Is_Integer($v)? GmDate('Y-m-d H:i:s', $v):'0000-00-00 00:00:00'; }
    Function __ToString() { Return $this->ToString(); }
    
    Function Max(...$Args)
    {
      $Res=$this;
      ForEach($Args As $Arg)
        If($Res->LessThen($Arg))
          $Res=$Arg;
      Return $Res;
    }
    
    Function Compare($v)
    {
      Return $this->ToUnixTime()<=>$v->ToUnixTime()?: $this->FracNanoSecond()<=>$v->FracNanoSecond();
    }
    
    Function LessThen($v) { Return $this->Compare($v)<0; }
    Function MoreThen($v) { Return $this->Compare($v)>0; }
    
  //****************************************************************
  // Debug
  
    Function ToDebug() { Return $this->ToString().' '.$this->ToUnixTime(); }
    Function _Debug_Serialize(Array &$Res)
    {
      $Res=$this->ToDebug();
    }
  
  //****************************************************************
  }
?>