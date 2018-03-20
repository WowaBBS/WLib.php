<?
  Class T_W2_Tag__Def
  {
    Static $InnerTags=[
      '#data' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=$Tag->Params;
      If(IsSet($Var)) $Tag->SetAttr('Params', $Var);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
      $Info->Add_Line('// ('.$Tag->tagName.')');
      If(IsSet($Tags['#data']))
      {
        $Info->Add_Line(' {');
        $T=$Info->Tab;
        $Info->Tab=$T.'  ';
        $Tags['#data'][0]->MakePHPInnerId($Info, $Tags['#data'][1]);
        $Info->Tab=$T;
        $Info->Add_Line(' }');
        $Info->Add_Line('// (/'.$Tag->tagName.')');
      }
      Else
      {
        If(Function_Exists('_cmd_'.$Tag->tagName.'_'))
        {
          $vRes=$Info->Var_Add('Res', $Id);
          $Info->Add_Line($vRes."=''; _cmd_".$Tag->tagName.'_('.
            "'".$Tag->GetAttr('Params')."'".','.$vRes.',&'.$Info->Vars().');');
          $Info->Out->Evaluate($vRes);
        }
        Else
          $Info->Out->Text($Tag->AsText);
      }
    }
  }
?>