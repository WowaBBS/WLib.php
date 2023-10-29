<?
  Class T_W2_Tag_With
  {
    Static $InnerTags=[
      '#data' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Data' , $Var[1]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $vVar=$Builder->Var_Add_Tag('Var', $Tag);
  
      $Item=$Tag->GetAttr('Data');
      If($Item)
        $Builder->Add_Line($vVar.'=&'.$Builder->Vars_Get($Tag->GetAttr('Var')).';');
      Else
        $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($Tag->GetAttr('Var')).';');
      $Builder->Add_Line(' {');
      $T=$Builder->Tab;
      $Builder->Tab=$T.'  ';
      If($Item)
        $Builder->Vars_WithA([$Item=>'&'.$vVar]);
      Else
        $Builder->Vars_WithV($vVar);
      $Tags['#data'][0]->MakePHPInnerTo($Builder, $Tags['#data'][1]);
      $Builder->Vars_EndWith();
      $Builder->Tab=$T;
      $Builder->Add_Line(' }');
    }
  }
?>