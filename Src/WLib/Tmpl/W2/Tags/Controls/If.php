<?
  Class T_W2_Tag_If
  {
    Static $InnerTags=[
      'then' => ['#Template','Default'],
      'else' => ['#Template'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'   , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Value' , $Var[1]);
      If(IsSet($Var[2])) $Tag->SetAttr('Then'  , $Var[2]);
      If(IsSet($Var[3])) $Tag->SetAttr('Else'  , $Var[2]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $vVar =$Info->Var_Add('Var', $Id);
  
      $Info->Add_Line($vVar.'='.$Info->Vars_Get($Tag->GetAttr('Var')).';');
      If($Tag->Attributes->Has('Value'))
        $Info->Add_Line('If('.$vVar."=='".$Tag->GetAttr('Value')."')");
      Else
        $Info->Add_Line('If('.$vVar.')');
      If(IsSet($Tags['then']))
      {
        $Info->Add_Line(' {');
        $T=$Info->Tab;
        $Info->Tab=$T.'  ';
        $Tags['then'][0]->MakePHPInnerId($Info, $Tags['then'][1]);
        $Info->Tab=$T;
        $Info->Add_Line(' }');
      }
      If(IsSet($Tags['else']))
      {
        $Info->Add_Line('else');
        $Info->Add_Line(' {');
        $T=$Info->Tab;
        $Info->Tab=$T.'  ';
        $Tags['else'][0]->MakePHPInnerId($Info, $Tags['else'][1]);
        $Info->Tab=$T;
        $Info->Add_Line(' }');
      }
    }
  }
?>