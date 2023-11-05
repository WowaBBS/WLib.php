<?
  $this->Load_Type('/System/Registry/Keys'   ); 
  $this->Load_Type('/System/Registry/Values' ); 
  
  Class T_System_Registry_Key
  {
    Protected        $Driver ; //Driver An open registry driver.
    Protected String $Path=''; //Fully-qualified name of the key.
  
    Function __Construct($Driver, $Path)
    {
      $this->Driver = $Driver ;
      $this->Path   = $Path   ;
    }
  
    Function GetName()
    {
      If(($Pos=StrRPos($this->Path, '\\'))!==False)
        Return SubStr($this->Path, $Pos+1);
      
      Return $this->Path;
    }
  
    Function GetPath   () { Return $this->Path   ; }
    Function GetDriver () { Return $this->Driver ; }
    Function _SubPath($Name) { Return $this->Path===''? $Name:$this->Path.'\\'.$Name; }
  
    Function GetSubKey($Name)
    {
      If($this->Driver->IsKeyExists($SubKeyName=$this->_SubPath($Name)))
        Return New Static($this->Driver, $SubKeyName);
      Return Null;
    }
  
    Function GetParentKey()
    {
      $Res=DirName($this->Path);
      Return $Res==='.'? Null:New Static($this->Driver, $Res);
    }
    
    Function GetSubKeys () { Return New T_System_Registry_Keys   ($this); }
    Function GetValues  () { Return New T_System_Registry_Values ($this); }
    
    Function DeleteSubKey($Name) { Return $this->Driver->DeleteKey($this->_SubPath($Name)); }
    Function CreateSubKey($Name)
    {
      If($this->Driver->CreateKey($SubKeyName=$this->_SubPath($Name)))
        Return New Static($this->Driver, $SubKeyName);
    }
  
    Function EnumKey    () { Return $this->Driver->EnumKey    ($this->GetPath()); }
    Function EnumValues () { Return $this->Driver->EnumValues ($this->GetPath()); }
  
    Function ValueExists ($Name                    ) { Return $this->Driver->IsValueExists ($this->Path, $Name               ); }
    Function GetValue    ($Name         ,$Type=null) { Return $this->Driver->GetValue      ($this->Path, $Name         ,$Type); }
    Function SetValue    ($Name ,$Value ,$Type=null) { Return $this->Driver->SetValue      ($this->Path, $Name ,$Value ,$Type); }
    Function DeleteValue ($Name                    ) { Return $this->Driver->DeleteValue   ($this->Path, $Name               ); }
  
    Function GetValueType($Name) { Return $this->EnumValues()[$Name]?? Null; }
  }
