<?
  Class T_W2_Tag_Let
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
  
      $Builder->Out->Capture();
      $Tags['item'][0]->MakePHPInnerId($Builder, $Tags['item'][1]);
      $vOut=$Builder->Out->Get();
      $Builder->Out->End(False);
      $Builder->Add_Line("  _put_var_(".$vOut.", '".$Params."'".', '.$Builder->Vars().');'."\n");
    }
  }
?>