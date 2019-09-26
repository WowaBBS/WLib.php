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
        $Var[StrToLower($k)]=$v;
      $this->Var=$Var;
    }
    
    Function CopyTo($Obj)
    {
      $Map=T_Serialize_Object_Map::Create($Obj);
      ForEach($Map->Map As $Name=>$Propery)
      {
        $v=$Propery->GetValue($Obj);
        if(Is_Object($v))
        {
          $Vars=$this->GetVars($Name);
          $Vars->CopyTo($v);
        }
        else
        {
          $v=$this->_Get($Name);
          if(!Is_Null($v))
            $Propery->SetValue($Obj, $v);
        }
      }
    //if(Method_Exists($Obj, 'Vars_Loader'))
      $this->CheckUnused($v);
    }
    
  # Static Function Create($Class, $Vars)
  # {
  # }
    
    Function _Get($Name)
    {
      $Name=StrToLower($Name);
      if(!IsSet($this->Var[$Name]))
        return null;
      $Res=$this->Var[$Name];
      UnSet($this->Var[$Name]);
      return $Res;
    }
    
    Function GetVars($Name)
    {
      $R=$this->_Get($Name);
      if(!Is_Array($R))
        return null;
      return new Self($this->Logger, $R);
    }
    
    Function GetArrayVars($Name)
    {
      $R=$this->_Get($Name);
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