<?
  If(!IsSet($Factory))
  {
    for($F=__FILE__; $F;) if(@include($F=DirName($F)).'/Using.php') break;

    $Loader->GetLogger()->ScriptLog();
    
    $Factory=$Loader->Create_Object('/FS/Driver/Factory');
  }

//$FS=$Factory->Create('System');
