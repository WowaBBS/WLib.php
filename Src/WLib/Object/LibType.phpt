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
  
  Static Function CreateDefaultTypes()
  {
    $CE=    Class_Exists(...); $CL=Get_Declared_Classes    (...);
    $IE=Interface_Exists(...); $IL=Get_Declared_Interfaces (...);
    $TE=    Trait_Exists(...); $TL=Get_Declared_Traits     (...);
    $EE=     Enum_Exists(...);
    Return Self::CreateTypes([
    //  Type       ,  Extension      ,  Ext    , Prefix ,NS,Chk ,Lst
      ['Lib'       ,'.Lib.php'       ,'.php'   ,''      ,0 ],
      ['Module'    ,'.Module.php'    ,'.phpm'  ,''      ,0 ],
      ['Class'     ,'.Class.php'     ,'.phpc'  ,'C'     ,1 ,$CE ,$CL ],
      ['Interface' ,'.Interface.php' ,'.phpi'  ,'I'     ,2 ,$IE ,$IL ],
      ['Enum'      ,'.Enum.php'      ,'.phpe'  ,'E'     ,3 ,$EE ,$CL ],
      ['Exception' ,'.Exception.php' ,'.phpe'  ,'E'     ,4 ,$CE ,$CL ],
      ['UnitTest'  ,'.Test.php'      ,'.phput' ,'Test'  ,5 ,$CE ,$CL ],
      ['Trait'     ,'.Trait.php'     ,'.phpt'  ,'Trait' ,6 ,$TE ,$TL ],
      ['Type'      ,'.Type.php'      ,'.phpt'  ,'T'     ,7 ,$CE ,$CL ],
      ['Struct'    ,'.Struct.php'    ,'.phpt'  ,'S'     ,8 ,$CE ,$CL ], //TODO: Type???
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
  )
  {
    $this->Type      =$Type      ;
    $this->Extension =$Extension ;
    $this->Ext       =$Ext       ;
    $this->Prefix    =$Prefix    ;
    $this->NS        =$NS        ;
    $this->Check     =$Check     ;
    $this->List      =$List      ;
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
}
