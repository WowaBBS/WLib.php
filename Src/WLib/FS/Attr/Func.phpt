<?
  Class T_FS_Attr_Func
  {
    Var $Func=Null ;
    Var $Args=[]   ;
    Var $Deps=Null ;
    
    Function Set($Attr, $v, $IsNotGet)
    {
      $Args=$this->GetArgsClosure($Attr, $v, $IsNotGet);
      If(!Is_Array($Args)) $v=Null;
      $this->Func =$v    ;
      $this->Args =$Args ;
      $this->Deps =Null  ;
      Return (Bool)$v;
    }
    
    Function GetDeps($Attr) { Return $this->Deps??=$Attr->GetManager()->GetArgsAttrs($this->Args, $Attr->Name); }
    
    Function Call($Attr, $Map)
    {
      $Proc=$this->Func;
      If(!$Proc)
        Return $Attr->Log('Error', 'There is no closure in ', $Attr->Name)->Ret(Null);
      $Args=[];
      ForEach($this->Args As $Name=>$Info)
        $Args[]=$Map[$Name]?? Null;
      Return ($Proc)(...$Args);
    }
    
    Function GetArgsClosure($Attr, $Closure, $IsNotGet)
    {
      $Res=[];
      If(!$Closure) Return $Res;
      $Refl=New ReflectionFunction($Closure);
      $Parameters=$Refl->GetParameters();
      $Attr_Name=$Attr->Name;
      ForEach($Parameters As $Parameter)
      {
        $Arg_Name=$Parameter->GetName();
        If(IsSet($Res[$Arg_Name]))
          $Attr->Log('Error', 'Closure for ', $Attr_Name, ' uses ', $Arg_Name, 'several times')->File($Refl);
        
        If($Arg_Name===$Attr_Name && !$IsNotGet)
        {
          $Attr->Log('Error', 'Getter for ', $Attr_Name, ' uses the same agrument')->File($Refl);
          $Arg_Name='Unknown';
        }
        $Res[$Arg_Name]=True; // IsRerqured?
      }
      
      If($IsNotGet && !IsSet($Res[$Attr_Name]))
        $Attr->Log('Error', 'Setter for ', $Attr_Name, ' does\'n have ', $Attr_Name, ' argument')->File($Refl);
      
      Return $Res;
    }

    Function Deps_Invalidate()
    {
      $this->Deps=Null;
    }

    Function __Recursive($Attr, &$Vars, $Args, &$List=[])
    {
      ForEach($this->GetDeps($Attr) As $Name=>$Item)
      {
        If(!Array_Key_Exists($Name, $Vars))
          $Vars[$Name]=$Item->GetRecursive($Vars, Null);
        UnSet($List[$Name]); //Remove for to aviod duplicate calls for setters with several args like Touch
      }
    
      $Vars['Args']=$Args;
      Return $this->Call($Attr, $Vars);
    }

    Function Recursive($Attr, &$Vars, $Args, &$List=[])
    {
      ForEach($this->GetDeps($Attr) As $Name=>$Item)
      {
        If(!Array_Key_Exists($Name, $Vars))
          $Vars[$Name]=$Item->GetRecursive($Vars, Null);
        UnSet($List[$Name]); //Remove for to aviod duplicate calls for setters with several args like Touch
      }
    
      $Vars['Args']=$Args;
      Return $this->Call($Attr, $Vars);
    //Return $this->Get($Vars);
    }
  }
?>
