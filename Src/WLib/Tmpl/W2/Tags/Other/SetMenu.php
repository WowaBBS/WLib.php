<?
  Class T_W2_Tag_SetMenu // ???
  {
    Static $InnerTags=[
      'To'   => ['#Template', 'Default'],
      'From' => ['#Template'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('To'   , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('From' , $Var[1]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $To   =$Tag->GetAttr('To'   );
      $From =$Tag->GetAttr('From' );
  
      $vVar     =$Builder->Var_Add_Tag('Var'     ,$Tag);
      $vMenuMan =$Builder->Var_Add_Tag('MenuMan' ,$Tag);
  
      $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($From).';');
      $Builder->Add_Line($vMenuMan.'='.$Builder->Vars_Get('MenuMan').';');
      $Builder->Add_Line($vMenuMan."->SetMenu('".$To."', ".$vVar.');');
    }
  }
?>