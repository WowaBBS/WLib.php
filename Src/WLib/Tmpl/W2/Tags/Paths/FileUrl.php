<?
  Class T_W2_Tag_FileUrl
  {
    Static $InnerTags=[];
 
    Function SetAttr(&$Tag)
    {
      If($Tag->Attributes->Attr)
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->Attributes->SetAttr('Var'  ,$Var[0]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $ID=$Tag->ID;
  
      $Path=$Tag->Attributes->GetAttr('Var'  );
      $Path=$Builder->ParsePath($Path);
  
      $Builder->Out->Evaluate('Get_FileUrl('.$Path.',&'.$Builder->Vars().')');
    }
  }
?>