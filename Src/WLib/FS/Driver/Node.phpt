<?
  $Loader->Load_Type('/FS/Path');
 
  Class T_FS_Driver_Node
  {
    Var $Driver = False;
    Var $Path   = False;
 
    Function __Construct($Driver, $Path)
    {
      $this->Driver=$Driver;
      $this->Path=T_FS_Path::Create($Path);
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
 
    Function IsFile  (                     ) { Return $this->Driver->IsFile  ($this->Path                 ); }
    Function IsDir   (                     ) { Return $this->Driver->IsDir   ($this->Path                 ); }
    Function Exists  (                     ) { Return $this->Driver->Exists  ($this->Path                 ); }
    Function Stream  ($Mode                ) { Return $this->Driver->Stream  ($this->Path, $Mode          ); }
    Function Files   ($Mask=False, $Attr=3 ) { Return $this->Driver->Files   ($this->Path, $Mask, $Attr   ); }
    Function Nodes   (                     ) { Return $this->Driver->Nodes   ($this->Path                 ); }
    Function Include ($UnPack=[], $Pack=[] ) { Return $this->Driver->Include ($this->Path, $UnPack, $Pack ); }
    Function URL     (                     ) { Return $this->Driver->URL     ($this->Path                 ); }
    Function Vars    (                     ) { Return $this->Driver->Vars    ($this->Path                 ); }
                                                                       
    Function Load    (       $Args=[]      ) { Return $this->Driver->Load    ($this->Path       , $Args   ); }
    Function Save    ($Data, $Args=[]      ) { Return $this->Driver->Save    ($this->Path, $Data, $Args   ); }
  }
?>