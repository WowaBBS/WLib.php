<?
  $this->Load_Type('/BD/Expr/Func');
  
  Class T_BD_Expr_Op extends T_BD_Expr_Func
  {
     Static Function Eq  ($a, $b) { return $a==$b; }
     Static Function NEq ($a, $b) { return $a!=$b; }
     Static Function Now () { return GMDate('Y-m-d H:i:s'); }
  }
?>