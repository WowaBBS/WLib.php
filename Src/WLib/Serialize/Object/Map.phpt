<?
  Class T_Serialize_Object_Map
  {
    Var $Map=[];
    
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
      ForEach($Map->Map As $Property)
        $Res[$Property->getName()]=Static::ToVars($Property->GetValue($Obj));
      return $Res;
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
        $Map[StrToLower($Name)]=$Property;
      }
      $this->Map=$Map;
    }
    
    // Deprecated
    Function UpdateObj($Obj)
    {
      if($this->Map)
        return;
      $Map=[];
    //ForEach(Get_Object_Vars($Obj) As $k=>&$v)
      ForEach((Array)$Obj As $k=>&$v)
      {
        $Field=$k[0]==="\0"? Explode("\0", $k)[2]:$k;
        $Map[StrToLower[$Field]]=$k;
      //echo $Field, '->', $k, "\n";
      }
      $this->Map=$Map;
    }
    
    Function _Get($Name)
    {
      $Name=StrToLower($Name);
      if(!IsSet($this->Var[$Name]))
        return null;
      $Res=$this->Var[$Name];
      UnSet($this->Var[$Name]);
      return $Res;
    }
    
    Function GetArray($Name, $Class)
    {
    }
  };
  
?>