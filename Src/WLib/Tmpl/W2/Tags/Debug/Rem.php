<?
  Class T_W2_Tag_Rem
  {
    Static $InnerTags=[
      '#data' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
     If(!$Tag->HasAttributes())
       Return;
     $Var=$Tag->Params;
     If(IsSet($Var))
       $Tag->SetAttr('Parse'  , $Var);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
     $Parse=$Tag->GetAttr('Parse');
     $T=$Info->Tab;
     $Info->Tab=$T.'// ';
     $Tags['#data'][0]->MakePHPInnerId($Info, $Tags['#data'][1]);
     $Info->Tab=$T;
    }
  }
?>