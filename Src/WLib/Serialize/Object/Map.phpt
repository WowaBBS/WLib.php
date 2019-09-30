<?
  Class T_Serialize_Object_Map
  {
    Var $Map=[];
    Var $Serialize   =false;
    Var $Deserialize =false;
    
    Function __Construct($Class)
    {
    }
    
    Static Function ToVars($Var)
    {
      if(Is_Object ($Var)) return Static::ObjectToVars ($Var);
      if(Is_Array  ($Var)) return Static::ArrayToVars  ($Var);
      return $Var;
    }
    
    Static Function ArrayToVars($Arr)
    {
      $Res=[];
      ForEach($Arr As $k=>$v)
        $Res[$k]=Static::ToVars($v);
      return $Res;
    }
    
    Static Function ObjectToVars($Obj)
    {
      $Map=Static::Create($Obj);
      $Res=[];
      ForEach($Map->Map As [$Property, $Map2])
        $Res[$Property->getName()]=Static::ToVars($Property->GetValue($Obj));
      if($F=$Map->Serialize) $Res=$F->Invoke($Obj, $Res);
      return $Res;
    }
    
    Function CopyToObj($Vars, $Obj)
    {
      ForEach($this->Map As $Name=>[$Propery, $Map])
      {
        $v=$Propery->GetValue($Obj);
        if(Is_Object($v))
        {
          if(!$Map)
            $Map=Static::Create($v);
          $Vars=$this->PopVars($Name);
          $Map->CopyToObj($Vars, $v);
        }
        else
        {
          if($Map)
            $this->Logger->Log('Error', 'Field ', $Name, ' has map');
          $v=$Vars->_Pop($Name);
          if(!Is_Null($v))
            $Propery->SetValue($Obj, $v);
        }
      }
      if($F=$this->Deserialize) $F->Invoke($Obj, $Vars);
    //if(Method_Exists($Obj, 'Vars_Loader'))
      $Vars->CheckUnused($v);
    }
    
    Static Function Create($Obj)
    {
      Static $List=[];
      If(Is_Object($Obj))      
        $Class=Get_Class($Obj);
      Else
        $Class=$Obj;
      If(IsSet($List[$Class]))
        Return $List[$Class];
      $Res=new Self($Class);
      $List[$Class]=$Res;
    # if(Is_Object($Obj))
    #   $Res->UpdateObj($Obj);
      $Res->UpdateClass($Class);
      Return $Res;
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
      if($ParentClass=$Class->getParentClass())
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