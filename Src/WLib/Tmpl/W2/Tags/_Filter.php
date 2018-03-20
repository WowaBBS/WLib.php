<?
  Class T_W2_Tag__Filter
  {
    Static $FuncFilter='';
 
    Static $InnerTags=[
      '#Data' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var', $Var[0]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      If(IsSet($Tags['#Data']))
      {
        $Info->Out->Capture($this::$FuncFilter, True);
        $Tags['#Data'][0]->MakePHPInnerId($Info, $Tags['#Data'][1]);
        $Info->Out->End(True);
      }
      Else
        $Info->Out->Evaluate($this::$FuncFilter.'('.$Info->Vars_GetS($Tag->GetAttr('Var')).')');
    }
  }
?>