<? NameSpace WLib\Debug\Measure;

  $Loader->Load_Type('/Debug/Custom/Item'); Use Function \WLib\Debug\Custom\DebugItem;
  
  Class T_Postfix
  {
    Var $List  = [];
    Var $Cache = Null;
    
    Function __Construct(String $Value) { $this->List=[$Value]; }
    
    Function ToString() { Return $this->Cache??=Join($this->List); }
    Function __ToString() { Return $this->ToString(); }
    
    Function SetFirst ($v) {              $this->List[0]=$v; $this->InValidate(); }
    Function UnShift  ($v) { Array_UnShift($this->List, $v); $this->InValidate(); }
    
    Function InValidate() { $this->Cache=Null; }
    
    Function __clone() {}    
  }
?>