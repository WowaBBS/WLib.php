<?
  Class T_W2_Tag_ModeUrl
  {
    Static $InnerTags=[];
 
    Function SetAttr($Tag)
    {
      If($Tag->Attributes->Attr)
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->Attributes->SetAttr('Var' ,$Var[0]);
      If(IsSet($Var[1])) $Tag->Attributes->SetAttr('Get' ,$Var[1]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $ID=$Tag->ID;
  
      $Path=$Tag->Attributes->GetAttr('Var'  );
      $Path=$Builder->ParsePath($Path);
  
      $Get=$Tag->Attributes->GetAttr('Get'  ,1)? 'True':'False';
  
      $vVar =$Builder->Var_Add('SelfMode', $ID);
  
      $Builder->Add_Line($vVar.'='.$Builder->Vars_Get('SelfMode').';');
      $Builder->Out->Evaluate($vVar.'->URL('.$Path.', '.$Get.')');
    }
  }
?>