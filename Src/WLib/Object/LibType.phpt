<?
NameSpace Object;

Class TLibType
{
  Var $Type      ;
  Var $Extension ;
  Var $Prefix    ;
  Var $NS        ; 
  Var $Ext       ;
  Var $Check     ;
  Var $List      ;
  
  Static Function CreateDefaultTypes()
  {
    Return Self::CreateTypes([
    //  Type       ,  Extension      , Prefix , NS         ,  Ext    , Check                , List
      ['Class'     ,'.Class.php'     ,'C'     ,'Class'     ,'.phpc'  ,     Class_Exists(...), Get_Declared_Classes    (...)],
      ['Interface' ,'.Interface.php' ,'I'     ,'Interface' ,'.phpi'  , Interface_Exists(...), Get_Declared_Interfaces (...)],
      ['Enum'      ,'.Enum.php'      ,'E'     ,'Enum'      ,'.phpe'  ,      Enum_Exists(...), Get_Declared_Classes    (...)],
      ['Exception' ,'.Exception.php' ,'E'     ,'Exception' ,'.phpe'  ,     Class_Exists(...), Get_Declared_Classes    (...)],
      ['UnitTest'  ,'.Test.php'      ,'Test'  ,'UnitTest'  ,'.phput' ,     Class_Exists(...), Get_Declared_Classes    (...)],
      ['Lib'       ,'.Lib.php'       ,''      ,'Lib'       ,'.php'   ,                  Null,                          Null],
      ['Module'    ,'.Module.php'    ,''      ,'Lib'       ,'.phpm'  ,                  Null,                          Null],
      ['Trait'     ,'.Trait.php'     ,'Trait' ,'Trait'     ,'.phpt'  ,     Trait_Exists(...), Get_Declared_Traits     (...)],
      ['Type'      ,'.Type.php'      ,'T'     ,'Type'      ,'.phpt'  ,     Class_Exists(...), Get_Declared_Classes    (...)],
      ['Struct'    ,'.Struct.php'    ,'S'     ,'Struct'    ,'.phpt'  ,     Class_Exists(...), Get_Declared_Classes    (...)], //TODO: Type???
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
    String   $Prefix    ,
    String   $NS        ,
    String   $Ext       ,
   ?Callable $Check     ,
   ?Callable $List      ,
  )
  {
    $this->Type      =$Type      ;
    $this->Extension =$Extension ;
    $this->Prefix    =$Prefix    ;
    $this->NS        =$NS        ;
    $this->Ext       =$Ext       ;
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
