<?
  for($F=__FILE__; $F;) if(@include($F=DirName($F)).'/Using.php') break;
  $Loader->GetLogger()->ScriptLog();
  $Loader->Load_Type('/Debug/Depth'); Use Function WLib\Debug\Depth;
  
  $Data=[];
  For($i=0; $i<8; $i++)
    $Data=['l'.$i=>$Data];
  
  $Loader->Log('Log', $Data);
  $Loader->Log('Log', Depth(100), $Data);
  $Loader->Log('Log', $Data);
  
  $Loader->Done();
