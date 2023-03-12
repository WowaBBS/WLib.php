<?
  Class T_Object_WeakProxy
  {
    Var $WeakProxy_Object=null;
    
    Function WeakProxy_Get() { Return $this->WeakProxy_Object->Get(); }
    Function WeakProxy_Set($v) { $this->WeakProxy_Object=WeakReference::Create($v); }
  
           Function __Construct  ($Object) { $this->WeakProxy_Set($Object); }
           Function __Call       ($Name, $Args)  { Return       $this->WeakProxy_Get()->$Name(...$Args); }
    Static Function __CallStatic ($Name, $Args)  { Return       $this->WeakProxy_Get()::$Name(...$Args); }
           Function __Get        (String $k)     { Return       $this->WeakProxy_Get()->$k   ; }
           Function __IsSet      (String $k)     { Return IsSet($this->WeakProxy_Get()->$k  ); }
           Function __Set        (String $k, $v) {              $this->WeakProxy_Get()->$k=$v; }
           Function __UnSet      (String $k)     {        UnSet($this->WeakProxy_Get()->$k  ); }
           Function __Invoke     (...$Args)      { Return       $this->WeakProxy_Get()(...$Args); }
  }
?>