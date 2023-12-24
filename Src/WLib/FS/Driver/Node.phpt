<?
  $Loader->Load_Type('/FS/Path');

  Class T_FS_Driver_Node
    Implements ArrayAccess, IteratorAggregate 
  {
    Var $Driver =False;
    Var $Path   =False;

    Function __Construct($Driver, $Path)
    {
      $this->Driver =$Driver ;
      $this->Path   =T_FS_Path::Create($Path);
    }
    
    Function Sub($Path)
    {
      $Path=T_FS_Path::Create($Path);
      $Path->Norm($this->Path);
      Return $this->Driver->Node($Path);
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

    Function Is_File (                     ) { Return $this->Get('Is_File' ); }
    Function Is_Dir  (                     ) { Return $this->Get('Is_Dir'  ); }
    Function Is_Link (                     ) { Return $this->Get('Is_Link' ); }
    Function Exists  (                     ) { Return $this->Get('Exists'  ); }
    Function Stream  ($Mode, $Args=[]      ) { Return $this->Call('Stream'  ,$Args+['Mode'=>$Mode]); }
    Function Files   ($Mask=False, $Attr=3 ) { Return $this->Call('Files'   ,['Mask'=>$Mask     ,'Attr'=>$Attr ]); }
    Function Nodes   (                     ) { Return $this->Call('Nodes'   ,[                                 ]); }
    Function Include ($UnPack=[], $Pack=[] ) { Return $this->Call('Include' ,['UnPack'=>$UnPack ,'Pack'=>$Pack ]); }
    Function URL     (                     ) { Return $this->Driver->URL     ($this->Path                 ); }
    Function Vars    (                     ) { Return $this->Driver->Vars    ($this->Path                 ); }

    Function Load    (       $Args=[]      ) { Return $this->Driver->Load    ($this->Path       , $Args   ); }
    Function Save    ($Data, $Args=[]      ) { Return $this->Driver->Save    ($this->Path, $Data, $Args   ); }

    Function MkDir  ($Recursive=True, $Mode=0777) { Return $this->Call('MkDir'  ,['Mode'=>$Mode, 'Recursive'=>$Recursive]); }
    Function CopyTo ($To, $Args=[]) { Return $this->Call('Copy', [...$Args, 'To'=>$To]); }
    Function MoveTo ($To, $Args=[]) { Return $this->Call('Copy', [...$Args, 'To'=>$To, 'Remove'=>True]); }
    
    Function UnLink (                  $Args=[]) { Return $this->Call('UnLink' ,$Args); }
    Function RmDir  ($Recursive=False, $Args=[]) { Return $this->Call('RmDir'  ,[...$Args, 'Recursive'=>$Recursive]); }
    Function Remove ($Recursive=False, $Args=[]) { Return $this->Call('Remove' ,[...$Args, 'Recursive'=>$Recursive]); }
    
    Function ForEach($Func, ...$Args)
    {
      ForEach($this As $Node)
        $Func($Node, ...$Args);
    }

    Function ForEachRes($Res, $Func, ...$Args)
    {
      ForEach($this As $Node)
        $Res=$Func($Res, $Node, ...$Args);
      Return $Res;
    }

    Function getIterator(): Traversable { Return $this['List']; }
    
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