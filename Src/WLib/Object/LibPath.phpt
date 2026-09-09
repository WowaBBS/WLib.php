<?
NameSpace WLib\Object;

Class TLibPath
{
  Var $Name   ;
  Var $Path   ;
  Var $Prefix ; //Prefix of NameSpace
  Var $Found  ; //Last found file
  
  Function __Construct(
    String   $Name   ,
    String   $Path   ,
   ?String   $Prefix =Null,
  )
  {
    If(($Real=RealPath($Path))!=='')
      $Path=$Real;
  
    $Path=StrTr($Path, '\\', '/');
    
    // Remove slash at the end
    If($Path!=='' && $Path[StrLen($Path)-1]==='/')
      $Path=SubStr($Path, 0, -1);
    
  //if(SubStr($Path, -1)!='/')
  //  $Path.='/';

    $this->Name   =$Name   ;
    $this->Path   =$Path   ;
    $this->Prefix =$Prefix ??$Name.'\\';
  }

  Static Function GetDefaultList() { Static $Res=['Default'=>New Self('Default', './Lib/', '')]; Return $Res; }
  
  Function Check($Loader, $Path)
  {
    $Path=$this->Path.$Path;
    If(!Is_File($Path))
      Return Null;
    $Res=StrTr(RealPath($Path), '\\', '/');
    if($Res!==$Path)
      $Loader->Log('Error', ' _Find_Lib:',"\n",
        '  Excepted path ', $Res ,"\n",
        '  Actual   path ', $Path
      );
    $this->Found=$Res;
    Return $Res;
  }
  
}
