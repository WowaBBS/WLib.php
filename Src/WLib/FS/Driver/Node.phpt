<?
  $Loader->Load_Type('/FS/Path');

  Class T_FS_Driver_Node
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

    Function ChDir($Path)
    {
      $Path=T_FS_Path::Create($Path);
      If($Path->Path)
      {
        $Path->Norm($this->Path);
        $this->Path->Assign($Path);
      }
    }

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

  //****************************************************************
  // Attributes
  
  // Usage:
  //   Get one attribute      : $Value=Attr('Name')
  //   Get several attributes : [$v1, $v2]=Attr(['N1', 'N2'])
  //   Set value attribute    : Attr('Name', $Value);
  //   Set values attributes  : Attr(['N1'=>$v1, 'N2'=>$v2]);
  # Function Attr($Get, $Set=Null) { Return $this->Driver->Attr($this->Path, $Get, $Set); }
  # Function GetAttrs(Array $List   ) { Return $this->Driver->GetAttrs($this->Path, $List   ); }
  # Function SetAttrs(Array $Values ) { Return $this->Driver->SetAttrs($this->Path, $Values ); }
    Function GetSet(Array $Key, Array $Args=[]) { Return $this->Driver->GetSet($this->Path, $Key, $Args); }
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

  //****************************************************************
  // Debug

    Function _Debug_Serialize(Array &$Res)
    {
      UnSet($Res['Driver']); //TODO: Debug_Inline;
    }
  
  //****************************************************************
  }
?>