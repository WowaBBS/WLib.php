<?
 class T_FS_Config
 {
   Var $List =[];
   Var $Def  =[];

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
     if(IsSet($List[$Path])) return $Required[$Path];
       
     $Dir=GetParentDir($Path);
   //echo '!!!', $Dir, '-', $Path, "\n";
     if(IsSet($List[$Dir.'*'])) return $List[$Dir.'*'];
     if(IsSet($List[$Dir    ])) return $List[$Dir    ];
     $Paths[]=$Dir;
     while(true)
     {
       $Dir=GetParentDir($Dir);
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