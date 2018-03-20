<?
  Class T_W2_Tag_TimeTest
  {
    Static $InnerTags=[
      'item' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Tag->SetAttr('Params',  $Tag->Params);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Params=$Tag->GetAttr('Params');
  
      $Info->Add_Line("tsStart('".$Params."');");
      $Info->Add_Line(' {');
      $T=$Info->Tab;
      $Info->Tab=$T.'  ';
      $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
      $Info->Tab=$T;
      $Info->Add_Line(' }');
      $Info->Add_Line("tsStop('".$Params."');");
    }
  }
?>