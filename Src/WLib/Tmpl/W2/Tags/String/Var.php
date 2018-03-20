<?
  Class T_W2_Tag_Var
  {
    Static $InnerTags=[];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var', $Var[0]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Info->Out->Evaluate($Info->Vars_GetS($Tag->GetAttr('Var')));
    }
  }
?>