<?
  $this->Load_Type('/Serialize/Object/Map');
  
  class T_Serialize_Object_Vars
  {
    Var $Var=[];
    Var $Logger;
    
    Function __Construct($Logger, $Vars=[])
    {
      $this->Logger=$Logger;
      $Var=[];
      ForEach($Vars As $k=>$v)
        $Var[$k]=$v;
      $this->Var=$Var;
    }
    
  # Static Function Create($Class, $Vars)
  # {
  # }
    
    Function _Pop($Name)
    {
      if(!IsSet($this->Var[$Name]))
        return null;
      $Res=$this->Var[$Name];
      UnSet($this->Var[$Name]);
      return $Res;
    }
    
    Function PopVars($Name)
    {
      $R=$this->_Pop($Name);
      if(!Is_Array($R))
        return null;
      return new Self($this->Logger, $R);
    }
    
    Function PopArrayVars($Name)
    {
      $R=$this->_Pop($Name);
      if(!Is_Array($R))
        return null;
      $Res=[];
      ForEach($R As $k=>$v)
        $Res[$k]=new Self($this->Logger, $v);
      return $Res;
    }
    
    Function CheckUnused($Outer)
    {
      ForEach($this->Var as $k=>$v)
        $this->Logger->Log('Error', 'Varible ', $k, ' was unused');
    }
  };
  
?>