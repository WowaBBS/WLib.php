<?
  Class T_W2_Tag_With
  {
    Static $InnerTags=[
      '#data' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Data' , $Var[1]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $vVar=$Info->Var_Add('Var', $Id);
  
      $Item=$Tag->GetAttr('Data');
      If($Item)
        $Info->Add_Line($vVar.'=&'.$Info->Vars_Get($Tag->GetAttr('Var')).';');
      Else
        $Info->Add_Line($vVar.'='.$Info->Vars_Get($Tag->GetAttr('Var')).';');
      $Info->Add_Line(' {');
      $T=$Info->Tab;
      $Info->Tab=$T.'  ';
      If($Item)
        $Info->Vars_WithA([$Item=>'&'.$vVar]);
      Else
        $Info->Vars_WithV($vVar);
      $Tags['#data'][0]->MakePHPInnerId($Info, $Tags['#data'][1]);
      $Info->Vars_EndWith();
      $Info->Tab=$T;
      $Info->Add_Line(' }');
    }
  }
?>