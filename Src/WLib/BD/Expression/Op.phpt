<?
  $this->Load_Type('/BD/Expression/Func');
  
  Class T_BD_Expression_Op extends T_BD_Expression_Func
  {
     Static Function Eq  ($a, $b) { return $a==$b; }
     Static Function NEq ($a, $b) { return $a!=$b; }
  }
?>