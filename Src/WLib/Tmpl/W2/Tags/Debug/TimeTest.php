<?
  Class T_W2_Tag_TimeTest
  {
    Static $InnerTags=[
      'item' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Tag->SetAttr('Params',  $Tag->Params);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Params=$Tag->GetAttr('Params');
  
      $Builder->Add_Line("tsStart('".$Params."');");
      $Builder->Add_Line(' {');
      $T=$Builder->Tab;
      $Builder->Tab=$T.'  ';
      $Tags['item'][0]->MakePHPInnerTo($Builder, $Tags['item'][1]);
      $Builder->Tab=$T;
      $Builder->Add_Line(' }');
      $Builder->Add_Line("tsStop('".$Params."');");
    }
  }
?>