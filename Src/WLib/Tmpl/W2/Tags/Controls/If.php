<?
  Class T_W2_Tag_If
  {
    Static $InnerTags=[
      'then' => ['#Template', 'Default'],
      'else' => ['#Template'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'   , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Value' , $Var[1]);
      If(IsSet($Var[2])) $Tag->SetAttr('Then'  , $Var[2]);
      If(IsSet($Var[3])) $Tag->SetAttr('Else'  , $Var[3]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $vVar =$Builder->Var_Add_Tag('Var', $Tag);
  
      $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($Tag->GetAttr('Var')).';');
      If($Tag->Attributes->Has('Value'))
        $Builder->Add_Line('If('.$vVar."=='".$Tag->GetAttr('Value')."')");
      Else
        $Builder->Add_Line('If('.$vVar.')');
      If(IsSet($Tags['then']))
      {
        $Builder->Add_Line(' {');
        $T=$Builder->Tab;
        $Builder->Tab=$T.'  ';
        $Tags['then'][0]->MakePHPInnerId($Builder, $Tags['then'][1]);
        $Builder->Tab=$T;
        $Builder->Add_Line(' }');
      }
      If(IsSet($Tags['else']))
      {
        $Builder->Add_Line('else');
        $Builder->Add_Line(' {');
        $T=$Builder->Tab;
        $Builder->Tab=$T.'  ';
        $Tags['else'][0]->MakePHPInnerId($Builder, $Tags['else'][1]);
        $Builder->Tab=$T;
        $Builder->Add_Line(' }');
      }
    }
  }
?>