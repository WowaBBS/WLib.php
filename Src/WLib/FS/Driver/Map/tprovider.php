<?
 Unit('FS/Hash/TProvider');

 Uses('FS/Base/TProvider');
 Uses('MSystem');
 Uses('Stream/TFile');
 Uses('URI/URL/TBase');

 Class T_FS_Hash_Provider Extends T_FS_Base_Provider
 {
   Var $Hash  = Array();
 /*
   Var $BasePath ;
   Var $BaseURL  ;

   Function _Init($Args)
   {
    parent::_Init($Args);
    $this->BasePath = &New TPath();
    $this->BaseURL  = &New TURL();
   }
 */
   Function &RealVar($APath)
   {
    $RFalse=False;
    $Path=&New TPath($APath);
    $File='';
    $H=&$this->Hash;
    While(!$Path->IsNull()&&Is_Array($H))
     {
      $File=$Path->Get(0);
      If(!IsSet($H[$File]))
        Return $RFalse;
      $Path->Del(0);
      $H=&$H[$File];
     }
    If(!$Path->IsNull())
     {
      If(Is_String($H))
        Return $RFalse;
      If(Is_Object($H))
       {
        $H=&$H->Node($Path);
        Return $H;
       }
     }
    Return $H;
   }

   Function IsFile($Path)
   {
    $N=&$this->RealVar($Path);
    If($N===False)
      Return False;
    If(Is_String($N))
      Return True;
    If(Is_Object($N))
      Return $N->IsFile();
    Return False;
   }

   Function IsDir($Path)
   {
    $N=&$this->RealVar($Path);
    If($N===False)
      Return False;
    If(Is_Array($N))
      Return True;
    If(Is_Object($N))
      Return $N->IsDir();
    Return False;
   }

   Function Exists($Path)
   {
    $N=&$this->RealVar($Path);
    If($N===False)
      Return False;
    If(Is_Object($N))
      Return $N->Exists();
    Return True;
   }

   Function &Stream($Path,$AMode)
   {
    $N=&$this->RealVar($Path);
    If(Is_Object($N))
     {
      $Res=&$N->Stream($AMode);
      Return $Res;
     }
    Return False;
   }

   Function Files($Path,$Mask=False,$Attr=3)
   {
    $N=&$this->RealVar($Path);
    If($N===False)
      Return Array();
    If(Is_Array($N))
      Return Array_Keys($N);
    If(Is_Object($N))
      Return $N->Files();
    Return Array();
   }

   Function Nodes($Path)
   {
    $N=&$this->RealVar($Path);
    If($N===False)
      Return Array();
    If(Is_Array($N))
      Return Array();
    If(Is_Object($N))
      Return $N->Nodes();
    $Res=Array();
    $Res[]=&$this->Node($Path);
    Return $Res;
   }

   Function IncludePhp($Include_Path,$U=Array(),$P=Array())
   {
    FAbstract();
   }

   Function &URL($Path)
   {
    $N=&$this->RealVar($Path);
    If(Is_Object($N))
      Return $N->URL();
    Return '';
   }

   Function Vars($Path)
   {
    $N=&$this->RealVar($Path);
    $R=Array();
    If(Is_Object($N))
      $R=$N->Vars();
    Return $R;
   }
 }

 EndUnit();
?>