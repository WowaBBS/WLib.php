<?
  Class T_W2_Tag_Include
  {
    Static $InnerTags=[];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Path=$Info->ParsePath($Tag->GetAttr('Var'));
  
      $Info->Out->Evaluate('Parse('.$Path.',&'.$Info->Vars().')');
    }
  }
?>