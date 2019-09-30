<?
  $this->Load_Type('/Serialize/Object/Map');
  $this->Load_Type('/Serialize/Object/Vars');
  
  class T_Serialize_Object_VarsCI extends T_Serialize_Object_Vars
  {
    Var $Map=[];
    
    Function __Construct($Logger, $Vars=[])
    {
      Parent::__Construct($Logger, $Vars);
      $Map=[];
      ForEach($Vars As $k=>$v)
        $Map[StrToLower($k)]=$k;
      $this->Map=$Map;
    }
    
    Function _Pop($Name)
    {
      $Name=StrToLower($Name);
      $Name=$this->Map[$Name];
      $Res=Parent::_Pop($Name);
      return $Res;
    }
  };
  
?>