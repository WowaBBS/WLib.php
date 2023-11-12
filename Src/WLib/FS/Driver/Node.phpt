<?
  $Loader->Load_Type('/FS/Path');

  Class T_FS_Driver_Node
    Implements ArrayAccess
  {
    Var $Driver =False;
    Var $Path   =False;
    Var $Attrs  =[];

    Function __Construct($Driver, $Path, $Attrs=[])
    {
      $this->Driver =$Driver ;
      $this->Path   =T_FS_Path::Create($Path);
      $this->Attrs  =$Attrs  ;
    }

  //Function Clone() { Return New $this->Create_Object('/FS/Driver/Node', $this->Driver, $this->Path); }

  # Function ChDir($Path)
  # {
  #   $Path=T_FS_Path::Create($Path);
  #   If($Path->Path)
  #   {
  #     $Path->Norm($this->Path);
  #     $this->Path->Assign($Path);
  #   }
  # }

    Function Node($Path='')
    {
      If(!$Path)
        Return $this->Driver->Node($this->Path);
      $Path=T_FS_Path::Create($Path);
    //If($Path->Path)
    //  $Path->Norm($this->Path);
      $Path->AddLeft($this->Path);
      $Path->Norm();
      $Res=$this->Driver->Node($Path);
      Return $Res;
    }

    Function IsFile  (                     ) { Return $this->Get('IsFile' ); }
    Function IsDir   (                     ) { Return $this->Get('IsDir'  ); }
    Function IsLink  (                     ) { Return $this->Get('IsLink' ); }
    Function Exists  (                     ) { Return $this->Get('Exists' ); }
    Function Stream  ($Mode                ) { Return $this->Driver->Stream  ($this->Path, $Mode          ); }
    Function Files   ($Mask=False, $Attr=3 ) { Return $this->Driver->Files   ($this->Path, $Mask, $Attr   ); }
    Function Nodes   (                     ) { Return $this->Driver->Nodes   ($this->Path                 ); }
    Function Include ($UnPack=[], $Pack=[] ) { Return $this->Driver->Include ($this->Path, $UnPack, $Pack ); }
    Function URL     (                     ) { Return $this->Driver->URL     ($this->Path                 ); }
    Function Vars    (                     ) { Return $this->Driver->Vars    ($this->Path                 ); }

    Function Load    (       $Args=[]      ) { Return $this->Driver->Load    ($this->Path       , $Args   ); }
    Function Save    ($Data, $Args=[]      ) { Return $this->Driver->Save    ($this->Path, $Data, $Args   ); }

    Function MkDir  ($Recursive=True, $Mode=0777) { Return $this->Call('MkDir'  ,['Mode'=>$Mode, 'Recursive'=>$Recursive]); }
    
    Function UnLink (                ) { Return $this->Call('UnLink' ); }
    Function RmDir  ($Recursive=False) { Return $this->Call('RmDir'  ,['Recursive'=>$Recursive]); }
    Function Remove ($Recursive=False) { Return $this->Call('Remove' ,['Recursive'=>$Recursive]); }
    
    Function _Remove($Args)
    {
      If($this->IsFile())
        Return $this->UnLink();
      If(!$this->IsDir()) Return;
    //If(!$this->IsLink())
      Return $this->RmDir($Args['Recursive']?? Null);
    }

  //****************************************************************
  // Attributes
  
  // Usage:
  //   Get one attribute      : $Value=Get('Name')
  //   Get several attributes : ['N1'=>$v1, 'N2'=>$v2]=GetSet(['N1', 'N2'])
  //                            ['N1'=>$v1, 'N2'=>$v2]=Get(['N1', 'N2'])
  //   Set value attribute    : Set('Name', $Value);
  //                            GetSet(['Name'=>$Value]);
  //   Set values attributes  : GetSet(['N1'=>$v1, 'N2'=>$v2]);
    Function GetSet(Array $Key, Array $Args=[]) { Return $this->Driver->GetSet($this->Path, $Key, $Args, ['Node'=>$this]); }
    Function Get($Key, $Args=[])
    {
      If(Is_String($Key))
        Return $this->GetSet([$Key], [$Key=>$Args])[$Key]?? Null;
      Return $this->GetSet($Key ,$Args);
    }
    
    Function Set(String $Key, $Value=[], $Args=Null)
    {
    //If(Is_String($Key))
        Return $this->GetSet([$Key=>$Value], [$Key=>$Args??[]])[$Key]?? Null;
    //Return $this->GetSet($Key ,$Args?? $Value);
    }

    Function Call(String $Key, $Args=[])
    {
      Return $this->GetSet([$Key], [$Key=>$Args])[$Key]?? Null;
    }
    
    Function Supports($Key) { Return True; } //TODO: Check attribute exists

  //****************************************************************
  // ArrayAccess interface

    Public Function OffsetExists ($k    ):Bool  { return $this->Supports($k); }
    Public Function OffsetGet    ($k    ):Mixed { return $this->Get($k); }
    Public Function OffsetSet    ($k ,$v):Void  { $this->Set($k, $v); }
    Public Function OffsetUnset  ($k    ):Void  { $this->Log('Fatal', 'Unsupported'); }
    
  //****************************************************************
  // Debug

    Function _Debug_Serialize(Array &$Res)
    {
      UnSet($Res['Driver']); //TODO: Debug_Inline;
    }

  //****************************************************************
  }
?>