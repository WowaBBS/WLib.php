<?
  Class T_W2_Tag__Def
  {
    Static $InnerTags=[
      '#data' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=$Tag->Params;
      If(IsSet($Var)) $Tag->SetAttr('Params', $Var);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Builder->Add_Line('// ('.$Tag->tagName.')');
      If(IsSet($Tags['#data']))
      {
        $Builder->Add_Line(' {');
        $T=$Builder->Tab;
        $Builder->Tab=$T.'  ';
        $Tags['#data'][0]->MakePHPInnerTo($Builder, $Tags['#data'][1]);
        $Builder->Tab=$T;
        $Builder->Add_Line(' }');
        $Builder->Add_Line('// (/'.$Tag->tagName.')');
      }
      Else
      {
        If(Function_Exists('_cmd_'.$Tag->tagName.'_')) //TODO: Factory?
        {
          $vRes=$Builder->Var_Add_Tag('Res', $Tag);
          $Builder->Add_Line($vRes."=''; _cmd_".$Tag->tagName.'_('.
            "'".$Tag->GetAttr('Params')."'".', '.$vRes.', '.$Builder->Vars().');');
          $Builder->Out->Evaluate($vRes);
        }
        Else
          $Builder->Out->Text($Tag->AsText);
      }
    }
  }
?>