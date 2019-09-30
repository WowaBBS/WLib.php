<?
  $this->Load_Type('/BD/Expression/Base');
  
  Class T_BD_Expression_Op extends T_BD_Expression_Base
  {
     Static Function Eq($a, $b) { return $a==$b; }
     Static Function NEq($a, $b) { return $a!=$b; }
  }
?>