<?
  Require_Once "My.php";

  Function Path_Simplify($v)
  {
    $v=StrTr($v, '\\', '/');
    $v=Trim($v);
    $v=Trim($v, '"');
    $v=RTrim($v, '/');
    return $v;
  };
  
  Function Path_Key($v)
  {
    $v=Path_Simplify($v);
    $v=StrToLower($v); // Windows only
    return $v;
  };
  
  // FileName functions
  function FileName_Normalize($Res)
  {
    return Path_Simplify($Res);
  }
  
  function FileName_GetFileNick($FileName)
  {
    $Pos = StrRPos($FileName, '.');
    if($Pos===False)
      return $FileName;
    return SubStr($FileName, 0, $Pos-1);
  }
  
  // FilePath functions
  function FilePath_GetFileName($FilePath)
  {
    $Pos = StrRPos($FilePath, '/');
    if($Pos===False)
      return $FinePath;
    return SubStr($FilePath, $Pos+1);
  }
 
  function FilePath_GetFileNick($FilePath)
  {
    $Pos1 = StrRPos($FilePath, '/');
    $Pos2 = StrRPos($FilePath, '.'); // TODO: to $Pos1
    if($Pos2===false)
      $Pos2=StrLen($FilePath);
    if($Pos1===false)
      $Pos1=0;
    else
      $Pos1++;
    return SubStr($FilePath, $Pos1, $Pos2-$Pos1);
  }
  
  Function FilePath_GetPathNick($FilePath)
  {
    $i=StrRPos($FilePath, '.');
    $j=StrRPos($FilePath, '/');
    if($i!==false && ($j===false || $j<$i))
      $FilePath=SubStr($FilePath, 0, $i);
    return $FilePath;
  }
 
  // Other Functions 
  function GetFileNameExt($FileName)
  {
    $Pos = StrRPos($FileName, '.');
    if($Pos===false)
      return '';
    return SubStr($FileName, $Pos+1);
  }
 
  function GetFilePathExt($FileName)
  {
    $Pos = StrRPos($FileName, '.');
    if($Pos===False)
      return '';
    $Pos2 = StrPos($FileName, '/', $Pos+1);
    if($Pos2!==False)
      return '';
    return SubStr($FileName, $Pos+1);
  }
 
  function GetDirPath($FileName)
  {
    $Pos = StrRPos($FileName, '/');
    if($Pos===False)
      return '';
    return SubStr($FileName, 0, $Pos);
  }
 
  function GetDir($FileName)
  {
  //$Pos = StrRPos($FileName, '/', StrLen($FileName)-2);
    if(StrLen($FileName)<2)
      return '';
    $Pos = StrRPos($FileName, '/', -2);
    if($Pos===False)
      return '';
    return SubStr($FileName, 0, $Pos+1);
  }
 
  Function CreatePath($Path, $Attr=0700)
  {
  //Echo 'CP ', $Path, "\n";
    If($Path==='' || $Path==='/')
      Return True;
    If(FS_Is_Dir($Path))
      Return True;
    If(FS_File_Exists($Path))
      Return False;
    If(!CreatePath(GetDirPath($Path), $Attr))
      Return False;
    @FS_MkDir($Path, $Attr);
    Return FS_Is_Dir($Path);
  }
?>