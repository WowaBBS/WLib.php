<?
 class T_FS_Param
 {
   Var $List =[];
   Var $Def  =null;
   
   Function Append($AList)
   {
     $List=&$this->List;
     ForEach($AList as $k=>$v)
       $List[StrToLower($k)]=$v;
   }

   Function Get($Path)
   {
     $Path=StrToLower($Path);
     $Paths=[];
     $Res=$this->_Get($Paths, $Path);
     ForEach($Paths as $Dir) // Add to cache
       $List[$Dir]=$Res;
     return $Res;
   }
   
   Function _Get(&$Paths, $Path)
   {
     $List=&$this->List;
     if(IsSet($List[$Path])) return $List[$Path];
       
     $Dir=GetDir($Path);
   //echo '!!!', $Dir, '-', $Path, "\n";
     if(IsSet($List[$Dir.'*'])) return $List[$Dir.'*'];
     if(IsSet($List[$Dir    ])) return $List[$Dir    ];
     $Paths[]=$Dir;
     while(true)
     {
       $Dir=GetDir($Dir);
       if($Dir==='')
         break;
       if(IsSet($List[$Dir.'*/'])) return $List[$Dir.'*/'];
       if(IsSet($List[$Dir     ])) return $List[$Dir     ];
       $Paths[]=$Dir;
     }
     return $this->Def;
   }
 }

?>