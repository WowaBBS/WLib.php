<?
 if(!IsSet($Loader))
 {
   If(!Class_Exists('C_Object_Loader'))
     Include_Once 'Object/Loader.phpc';
   
   $Loader=C_Object_Loader::Get();
 //$Loader=New C_Object_Loader();
 }
//$Loader->Loader_Init(__DIR__);
?>