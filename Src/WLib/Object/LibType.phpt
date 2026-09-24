<?
NameSpace WLib\Object;

Class TLibType
{
  Var $Type      ;
  Var $Extension ;
  Var $Ext       ;
  Var $Prefix    ;
  Var $NS        ; 
  Var $Check     ;
  Var $List      ;
  Var $Aliace    =False;
  
  Static Function CreateDefaultTypes()
  {
    $CE=    Class_Exists(...); $CL=Get_Declared_Classes    (...);
    $IE=Interface_Exists(...); $IL=Get_Declared_Interfaces (...);
    $TE=    Trait_Exists(...); $TL=Get_Declared_Traits     (...);
    $EE=     Enum_Exists(...);
    Return Self::CreateTypes([
    //  Type       ,  Extension      ,  Ext    , Prefix ,NS,Chk ,Lst ,CA
      ['Lib'       ,'.Lib.php'       ,'.php'   ,''      ,0 ],
      ['Module'    ,'.Module.php'    ,'.phpm'  ,''      ,0 ],
      ['Class'     ,'.Class.php'     ,'.phpc'  ,'C'     ,1 ,$CE ,$CL ,1 ],
      ['Interface' ,'.Interface.php' ,'.phpi'  ,'I'     ,2 ,$IE ,$IL ,1 ],
      ['Enum'      ,'.Enum.php'      ,'.phpe'  ,'E'     ,3 ,$EE ,$CL ,1 ],
      ['Exception' ,'.Exception.php' ,'.phpe'  ,'E'     ,4 ,$CE ,$CL ,1 ],
      ['UnitTest'  ,'.Test.php'      ,'.phput' ,'Test'  ,5 ,$CE ,$CL ,1 ],
      ['Trait'     ,'.Trait.php'     ,'.phpt'  ,'Trait' ,6 ,$TE ,$TL ,1 ],
      ['Type'      ,'.Type.php'      ,'.phpt'  ,'T'     ,7 ,$CE ,$CL ,1 ],
      ['Struct'    ,'.Struct.php'    ,'.phpt'  ,'S'     ,8 ,$CE ,$CL ,1 ], //TODO: Type???
    ]);
  }
  
  Static Function CreateTypes($List)
  {
    $Res=[];
    ForEach($List As $Item)
      $Res[$Item[0]]=New Self(...$Item);
    Return $Res;
  }
  
  Function __Construct(
    String   $Type      ,
    String   $Extension ,
    String   $Ext       ,
    String   $Prefix    ,
             $NS        =0,
   ?Callable $Check     =Null,
   ?Callable $List      =Null,
   ?Bool     $Aliace    =Null,
  )
  {
    $this->Type      =$Type      ;
    $this->Extension =$Extension ;
    $this->Ext       =$Ext       ;
    $this->Prefix    =$Prefix    ;
    $this->NS        =$NS        ;
    $this->Check     =$Check     ;
    $this->List      =$List      ;
    $this->Aliace    =$Aliace    ??False;
  }
  
  Function GetListCount()
  {
    $f=$this->List;
    Return $f? Count($f()):0;
  }

  Function GetList()
  {
    $f=$this->List;
    Return $f? $f():[];
  }
  
  Function Aliace(String $Class, String $Alias, Bool $AutoLoad=True)
  {
    If(!$this->Aliace) Return False;
    Return Class_Alias($Class, $Alias, $AutoLoad);
  }
}
