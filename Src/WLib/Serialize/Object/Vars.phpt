<?
  $this->Load_Type('/Serialize/Object/Map');
  
  class T_Serialize_Object_Vars_Iterator extends ArrayIterator
  {
    Var $Factory ;
    Var $Class   ;
  
    Protected Function _ToVar($Res)
    {
      If(Is_Array($Res))
        return new $this->Class($this->Factory, $Res);
      return $Res;
    }
  
    public Function __construct(T_Serialize_Object_Vars $Vars, $Flags=0)
    {
      $this->Factory =$Vars->Factory;
      $this->Class   =Get_Class($Vars);
      Parent::__construct($Vars->Vars, $Flags);
    }
    
    //****************************************************************
    // ArrayIterator class

    public Function Current():Mixed
    {
      Return $this->_ToVar(Parent::Current());
    }
    
    public Function OffsetGet($index):Mixed
    {
      Return $this->_ToVar(Parent::OffsetGet($index));
    }
  //public append ( mixed $value )
  //public offsetSet ( mixed $index , mixed $newval ) : void
    //****************************************************************
  }
  
  class T_Serialize_Object_Vars implements ArrayAccess, Countable, IteratorAggregate
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
    
    Function _GetName($Name) { return $Name; }
    Function _SetName($Name) { return $Name; }
    
  //****************************************************************
    Function _Pop($Name) //Protected 
    {
      $Name=$this->_GetName($Name);
      if(!Array_Key_Exists($Name, $this->Vars)) //!IsSet($this->Vars[$Name]))
        return null;
      $Res=$this->Vars[$Name];
      UnSet($this->Vars[$Name]);
      return $Res;
    }
    
    Function _Get($Name) //Protected 
    {
      return $this->Vars[$this->_GetName($Name)]?? null;
    }
    
    Function Has($Name)
    {
      return Array_Key_Exists($this->_GetName($Name), $this->Vars); //IsSet($this->Vars[$this->_GetName($Name)]);
    }
    
    Function UnSet($Name)
    {
      UnSet($this->Vars[$this->_GetName($Name)]);
    }
    
    Function Set($Name, $v)
    {
      if(Is_Null($Name))
        $this->Add($v);
      else
        $this->Vars[$this->_SetName($Name)]=$v;
    }
    
    Function Add($v)
    {
      $this->Vars[]=$v;
    }
    
  //****************************************************************
    Protected Function _ToVar($Res)
    {
      If(Is_Array($Res))
      {
        $Class=Get_Class($this);
        return new $Class($this->Factory, $Res);
      }
      return $Res;
    }
  
    Function Get($Name)
    {
      Return $this->_ToVar($this->_Get($Name));
    }
    
    Function Pop($Name)
    {
      Return $this->_ToVar($this->_Pop($Name));
    }
    
  //****************************************************************
  
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
    
    Function CheckUnused($Outer, $Where)
    {
      ForEach($this->Vars as $k=>$v)
        $this->Factory->Log('Error', 'Field "', $k, '" was unused in ', $Where);
    }

  #/****************************************************************
  #/ Magic methods
  #
  # Function __Get   (String $k)     { return $this->Get   ($k);     }
  # Function __IsSet (String $k)     { return $this->Has   ($k);     }
  # Function __Set   (String $k, $v) {        $this->Set   ($k, $v); }
  # Function __UnSet (String $k)     {        $this->UnSet ($k);     }
 
  //****************************************************************
  // ArrayAccess interface

    Public Function OffsetExists ($k    ):Bool  { return $this->Has   ($k);     }
    Public Function OffsetGet    ($k    ):Mixed { return $this->Get   ($k);     }
    Public Function OffsetSet    ($k ,$v):Void  { if(Is_Null($k)) $this->Add($v); else $this->Set($k, $v); }
    Public Function OffsetUnset  ($k    ):Void  {        $this->UnSet ($k);     }
    
  //****************************************************************
  // Countable interface

    Public Function Count():int { return Count($this->Vars);     }
    
  //****************************************************************
  // IteratorAggregate interface
    
    public function getIterator():Traversable
    {
      return new T_Serialize_Object_Vars_Iterator($this);
    //return new ArrayIterator($this->Vars);
    }
    
  //****************************************************************
  // Debug 
    Function _Debug_Serialize(&$Res)
    {
    //Parent::_Debug_Info($Res);
      unset($Res['Factory' ]);
    }
    
  //****************************************************************
  };
  
?>