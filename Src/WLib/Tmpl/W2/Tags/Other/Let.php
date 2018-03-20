<?
  Class T_W2_Tag_Let
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
  
      $Info->Out->Capture();
      $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
      $vOut=$Info->Out->Get();
      $Info->Out->End(False);
      $Info->Add_Line("  _put_var_(".$vOut.",'".$Params."'".','.$Info->Vars().');'."\n");
    }
  }
?>