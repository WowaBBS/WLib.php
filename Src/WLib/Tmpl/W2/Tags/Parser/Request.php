<?
  Class T_W2_Tag_Request
  {
    Static $InnerTags=[];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Path', $Var[0]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $A=$Tag->GetAttr('Path');
      $A=$Builder->ParsePath($A);
  
      $Builder->Out->Evaluate('Tmpl_Request('.$Builder->Vars().','.$A.')');
    }
  }
?>