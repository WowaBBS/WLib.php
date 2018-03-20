<?
  Class T_W2_Tag_Require
  {
    Static $InnerTags=[];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Path'  , $Var[0]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $A=$Tag->GetAttr('Path');
      $A=$Info->ParsePath($A);
  
      $Info->Out->Evaluate('Tmpl_Request(&'.$Info->Vars().','.$A.')');
    }
  }
?>