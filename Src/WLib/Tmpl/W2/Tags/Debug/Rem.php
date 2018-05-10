<?
  Class T_W2_Tag_Rem
  {
    Static $InnerTags=[
      '#data' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
     If(!$Tag->HasAttributes())
       Return;
     $Var=$Tag->Params;
     If(IsSet($Var))
       $Tag->SetAttr('Parse'  , $Var);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
     $Parse=$Tag->GetAttr('Parse');
     $T=$Builder->Tab;
     $Builder->Tab=$T.'// ';
     $Tags['#data'][0]->MakePHPInnerId($Builder, $Tags['#data'][1]);
     $Builder->Tab=$T;
    }
  }
?>