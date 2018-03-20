<?
  Class T_W2_Tag_SetMenu // ???
  {
    Static $InnerTags=[
      'To'   => ['#Template','Default'],
      'From' => ['#Template'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('To'   , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('From' , $Var[1]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
      $To   =$Tag->GetAttr('To'   );
      $From =$Tag->GetAttr('From' );
  
      $vVar     =$Info->Var_Add('Var'     ,$Id);
      $vMenuMan =$Info->Var_Add('MenuMan' ,$Id);
  
      $Info->Add_Line($vVar.'='.$Info->Vars_Get($From).';');
      $Info->Add_Line($vMenuMan.'=&'.$Info->Vars_Get('MenuMan').';');
      $Info->Add_Line($vMenuMan."->SetMenu('".$To."',".$vVar.');');
    }
  }
?>