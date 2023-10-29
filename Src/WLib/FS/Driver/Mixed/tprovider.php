<?
 Unit('FS/Mixed/TProvider');

 Class T_FS_Mixed_Provider Extends T_FS_Base_Provider
 {
   Var $ListNodes=Array();
 /*
   Function _Init($Args)
   {
    parent::_Init($Args);
   }
 */
   Function IsFile($Path)
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->IsFile())
        Return True;
     }
    Return False;
   }

   Function IsDir($Path)
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->IsDir())
        Return True;
     }
    Return False;
   }

   Function Exists($Path)
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->Exsist())
        Return True;
     }
    Return False;
   }

   Function &Stream($Path,$AMode)
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->IsFile())
       {
        $Res=&$v->Stream($AMode);
        Return $Res;
       }
     }
    Return False;
   }

   Function Files($Path,$Mask=False,$Attr=3)
   {
    $Res=Array();
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      $R=$v->Files($Mask,$Attr);
      ForEach($R As $F)
        $Res[$F]=$F;
     }
    Return Array_Values($Res);
   }

   Function Nodes($Path)
   {
    $Pth=&New TPath($Path);
    If($Pth->IsRoot())
      $Pth->Del(0);
    //Debug($Pth);
    $Res=Array();
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      $R=$v->Nodes();
      ForEach($R As $k=>$F)
        $Res[]=&$R[$k];
     }
    Return $Res;
   }

   Function IncludePhp($Path,$UnPack_Vars=Array(),$Pack_Vars=Array())
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->IsFile())
        Return $v->IncludePhp($UnPack_Vars,$Pack_Vars);
     }
    Return False;
   }

   Function &URL($Path)
   {
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      If($v->Exists())
        Return $v->URL($Path);
     }
    Return New TURL();
   }

   Function Vars($Path)
   {
    $Res=Array();
    ForEach($this->ListNodes As $k=>$v)
     {
      $v=&$this->ListNodes[$k]->Node($Path);
      $R=$v->Vars();
      If($R)
        ForEach($R As $k->$v)
          If(!IsSet($Res[$k]))
            $Res[$k]=&$R[$k];
     }
    Return $Res;
   }
 }

 EndUnit();
?>