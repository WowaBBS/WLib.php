<?
  Class T_W2_Tag_Rnd
  {
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[1]))
      {
        $Tag->SetAttr('min' , $Var[0]);
        $Tag->SetAttr('max' , $Var[1]);
      }
      Else
      {
        $Tag->SetAttr('min' ,      0 );
        $Tag->SetAttr('max' , $Var[0]);
      }
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Min=$Tag->GetAttr('min');
      If($Min===False)
        $Min=0;
      $Max=$Tag->GetAttr('max');
      If($Max===False)
        $Info->Out->Evaluate('Mt_Rand()');
      Else
        $Info->Out->Evaluate('Mt_Rand('.$Min.','.$Max.')');
    }
  }
?>