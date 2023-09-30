<?
 $this->Load_Type('/Type/Map/Multi');

 // Old name was T_Array_Hash_MKeyI and T_Array_MHashI

 Class T_Type_Map_MultiCi Extends T_Type_Map_Multi
 {
   Function _GetMapKey($v) { Return StrToLower($v); }
 }

?>