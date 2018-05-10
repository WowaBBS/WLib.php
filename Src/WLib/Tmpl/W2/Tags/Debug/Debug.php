<?
  Class T_W2_Tag_Debug
  {
    Static $InnerTags=[];

    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'   , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Limit' , $Var[1]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Var=$Tag->GetAttr('Var');
      If($Var)
        $Var=$Builder->Vars_Get($Var);
      Else
        $Var=$Builder->Out->Get_Debug();
      $Limit=$Tag->GetAttr('Limit');
      If($Limit)
        $Var.=', '.$Limit;
      $Builder->Add_Line('Debug('.$Var.');');
    }
  }
?>