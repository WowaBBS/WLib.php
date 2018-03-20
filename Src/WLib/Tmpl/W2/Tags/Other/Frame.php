<?
  Class T_W2_Tag_Frame
  {
    Static $InnerTags=[
      'item' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Name' , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Op'   , $Var[1]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $Name=$Tag->GetAttr('Name' );
      $Op  =$Tag->GetAttr('Op'   );
  
      $vFrames =$Info->Var_Add('Frames' ,$Id);
      $vFrame  =$Info->Var_Add('Frame'  ,$Id);
  
      $Info->Out->Capture();
      $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
    //Debug($Op);
  
      $Info->Add_Line($vFrames."=&".$Info->Vars_Get('Frame').';');
      $Info->Add_Line($vFrame.'=&'.$vFrames."->GetFrame('".$Name."');");
      $OutData=$Info->Out->Get();
      If($Op==='-1')
        $Info->Add_Line($vFrame.'->AddLeft('.$OutData.');');
      If($Op==='0')
        $Info->Add_Line($vFrame.'->Override('.$OutData.');');
      Else
        $Info->Add_Line($vFrame.'->AddRight('.$OutData.');');
      $Info->Out->End(False);
    }
  }
?>