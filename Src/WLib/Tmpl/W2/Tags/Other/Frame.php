<?
  Class T_W2_Tag_Frame
  {
    Static $InnerTags=[
      'item' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Name' , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Op'   , $Var[1]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $Name=$Tag->GetAttr('Name' );
      $Op  =$Tag->GetAttr('Op'   );
  
      $vFrames =$Builder->Var_Add('Frames' ,$Id);
      $vFrame  =$Builder->Var_Add('Frame'  ,$Id);
  
      $Builder->Out->Capture();
      $Tags['item'][0]->MakePHPInnerId($Builder, $Tags['item'][1]);
    //Debug($Op);
  
      $Builder->Add_Line($vFrames."=&".$Builder->Vars_Get('Frame').';');
      $Builder->Add_Line($vFrame.'='.$vFrames."->GetFrame('".$Name."');");
      $OutData=$Builder->Out->Get();
      If($Op==='-1')
        $Builder->Add_Line($vFrame.'->AddLeft('.$OutData.');');
      If($Op==='0')
        $Builder->Add_Line($vFrame.'->Override('.$OutData.');');
      Else
        $Builder->Add_Line($vFrame.'->AddRight('.$OutData.');');
      $Builder->Out->End(False);
    }
  }
?>