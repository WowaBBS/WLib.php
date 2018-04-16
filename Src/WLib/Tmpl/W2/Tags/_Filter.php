<?
  Class T_W2_Tag__Filter
  {
    Static $FuncFilter='';
 
    Static $InnerTags=[
      '#Data' => ['#Template','Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var', $Var[0]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      If(IsSet($Tags['#Data']))
      {
        $Builder->Out->Capture($this::$FuncFilter, True);
        $Tags['#Data'][0]->MakePHPInnerId($Builder, $Tags['#Data'][1]);
        $Builder->Out->End(True);
      }
      Else
        $Builder->Out->Evaluate($this::$FuncFilter.'('.$Builder->Vars_GetS($Tag->GetAttr('Var')).')');
    }
  }
?>