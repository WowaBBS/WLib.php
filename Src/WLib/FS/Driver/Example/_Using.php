<?
  If(!IsSet($Factory))
  {
    for($F=__FILE__; $F;) if(@include($F=DirName($F)).'/Using.php') break;

    $BackTrace=Debug_BackTrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
    $LogFile=$BackTrace[0]['file']?? __FILE__;
    $Ext  = PathInfo($LogFile, PATHINFO_EXTENSION);
    $LogFile=($l=StrLen($Ext))? SubStr($LogFile, 0, -$l):$LogFile;
    $Loader->GetLogger()->Add($LogFile.'log');
    
    $Factory=$Loader->Create_Object('/FS/Driver/Factory');
  }

//$FS=$Factory->Create('System');
