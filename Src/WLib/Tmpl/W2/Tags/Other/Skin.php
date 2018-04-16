<?
  Class T_W2_Tag_Skin
  {
    Static $InnerTags=[
      'item' => ['#Template','Default'],
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
  
      $OldVars=$Builder->Vars();
      $NewVars=$Builder->Vars_New();
      $Builder->Add_Line($NewVars.'=Tmpl_Skin_Begin('.$OldVars.','."'".$Params."');");
      $Builder->Out->Capture(False);
      $Tags['item'][0]->MakePHPInnerId($Builder, $Tags['item'][1]);
      $Builder->Out->End(False);
      $Builder->Out->Evaluate('Tmpl_Skin_End('.$Builder->Vars().')');
      $Builder->Vars_End();
    }
  }
?>