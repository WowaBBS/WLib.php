<?
  Class T_W2_Tag_ParseFile
  {
    Static $InnerTags=[];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var',  $Var[0]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Path=$Tag->GetAttr('Var');
      $Path=$Builder->ParsePath($Path);
  
      $Builder->Out->Evaluate('Parse('.$Path.', '.$Builder->Vars().')');
    }
  }
?>