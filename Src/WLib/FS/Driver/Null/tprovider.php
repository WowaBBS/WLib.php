<?
 Unit('FS/Null/TProvider');

 Uses('FS/Base/TProvider');
 Uses('MSystem');
 Uses('URI/URL/TBase');
 Uses('Stream/TNull');

 Class T_FS_Null_Provider Extends T_FS_Base_Provider
 {
 /*
   Function _Init($Args)
   {
    parent::_Init($Args);
   }
 */
   Function IsFile($Path)
   {
    Return False;
   }

   Function IsDir($Path)
   {
    Return False;
   }

   Function Exists($Path)
   {
    Return False;
   }

   Function &Stream($Path,$AMode)
   {
    Global $Stream_Null;
    Return $Stream_Null;
   }

   Function Files($Path,$Mask=False,$Attr=3)
   {
    Return Array();
   }

   Function Nodes($Path)
   {
    Return Array();
   }

   Function IncludePhp($IncludePhp_Path,$UnPack_Vars=Array(),$Pack_Vars=Array())
   {
   }

   Function &URL($Path)
   {
    Return '';
   }
 }

 $GLOBALS['FS_Null_Provider']=&New T_FS_Null_Provider();
 $GLOBALS['FS_Null_Node']=&$GLOBALS['FS_Null_Provider']->Node();

 EndUnit();
?>