<?
  Class T_W2_Tag_Skin
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
  
      $OldVars=$Info->Vars();
      $NewVars=$Info->Vars_New();
      $Info->Add_Line($NewVars.'=Tmpl_Skin_Begin('.$OldVars.','."'".$Params."');");
      $Info->Out->Capture(False);
      $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
      $Info->Out->End(False);
      $Info->Out->Evaluate('Tmpl_Skin_End('.$Info->Vars().')');
      $Info->Vars_End();
    }
  }
?>