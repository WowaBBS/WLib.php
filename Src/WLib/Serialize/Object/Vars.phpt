<?
  $this->Load_Type('/Serialize/Object/Map');
  
  class T_Serialize_Object_Vars
  {
    Var $Vars=[];
    Var $Factory=null; // TODO: Weak reference
    
    Function __Construct(C_Serialize_Object_Factory $Factory, $Vars=[])
    {
      $this->Factory =$Factory ;
      $this->Vars    =$Vars    ;
    }
    
    Function CopyToObj($Obj)
    {
      return $this->Factory->GetClassMap($Obj)->CopyToObj($this, $Obj);
    }
   
    Function _Pop($Name)
    {
      if(!IsSet($this->Vars[$Name]))
        return null;
      $Res=$this->Vars[$Name];
      UnSet($this->Vars[$Name]);
      return $Res;
    }
    
    Function PopVars($Name)
    {
      $R=$this->_Pop($Name);
      if(!Is_Array($R))
        return null;
      $Class=Get_Class($this);
      return new $Class($this->Factory, $R);
    }
    
    Function PopArrayVars($Name)
    {
      $R=$this->_Pop($Name);
      if(!Is_Array($R))
        return null;
      $Res=[];
      $Class=Get_Class($this);
      ForEach($R As $k=>$v)
        $Res[$k]=new $Class($this->Factory, $v);
      return $Res;
    }
    
    Function CheckUnused($Outer)
    {
      ForEach($this->Vars as $k=>$v)
        $this->Factory->Log('Error', 'Varible ', $k, ' was unused');
    }

    Function _Debug_Serialize(&$Res)
    {
    //Parent::_Debug_Info($Res);
      unset($Res['Factory' ]);
    }
  };
  
?>