<?
  Class T_Serialize_Object_Map
  {
    Var $Map=[];
    Var $Serialize   =false;
    Var $Deserialize =false;
    Var $Factory     =null; // TODO: Weak reference
    
    Function __Construct(C_Serialize_Object_Factory $Factory, $Class)
    {
      $this->Factory=$Factory;
    }
    
    Function CopyToObj(T_Serialize_Object_Vars $Vars, $Obj)
    {
      $Factory=$this->Factory;
      if($F=$this->Deserialize)
        if($F->Invoke($Obj, $Vars)===False)
          return false;
      ForEach($this->Map As $Name=>[$Propery, $Map])
      {
        $v=$Propery->GetValue($Obj);
        if(Is_Object($v))
        {
          if(!$Map)
            $Map=$Factory->GetClassMap($v);
          $ObjectVars=$Vars->PopVars($Name);
          if($ObjectVars)
            $Map->CopyToObj($ObjectVars, $v);
        # else
        #   $this->Factory->Log('Error', 'Serialize/Object/Map::CopyToObj property ', $Name, ' not found')->Debug($Vars);
        }
        else
        {
          if($Map)
            $Factory->Log('Error', 'Field ', $Name, ' has map');
          $v=$Vars->_Pop($Name);
          if(!Is_Null($v))
            $Propery->SetValue($Obj, $v);
        }
      }
      $Vars->CheckUnused($v);
      return true;
    }
    
    Function UpdateClass($Class)
    {
      if($this->Map)
        return;
      if(Is_String($Class))
        $Class=new ReflectionClass($Class);
      static $ClassExclude=['C_Object_Base'=>False];
      $ClassName=$Class->GetName();
      if(IsSet($ClassExclude[$ClassName]))
        return;
      if($ParentClass=$Class->GetParentClass())
        $this->UpdateClass($ParentClass);
      $Map=$this->Map;
      $Properties =$Class->getProperties(
        ReflectionProperty::IS_PUBLIC    |
        ReflectionProperty::IS_PROTECTED |
        ReflectionProperty::IS_PRIVATE
      );
      ForEach($Properties As $Property)
      {
        $Name=$Property->getName();
        $DClass=$Property->getDeclaringClass()->getName();
        if($DClass!=$ClassName)
          Break;
      //echo $DClass, ':',$Name, "\n";
        $Property->setAccessible(true);
        $Map[$Name]=[$Property, False];
      }
      $this->Map=$Map;
      if(Method_Exists($ClassName, 'Serialize_Object_Vars'))
        [$ClassName, 'Serialize_Object_Vars']($this);
      if($Class->HasMethod('Serialize_Object'))
        $this->Serialize=$Class->GetMethod('Serialize_Object');
      if($Class->HasMethod('Deserialize_Object'))
        $this->Deserialize=$Class->GetMethod('Deserialize_Object');
    }
    
    Function RemoveField(String $Name)
    {
      UnSet($this->Map[$Name]);
    }
  };
  
?>