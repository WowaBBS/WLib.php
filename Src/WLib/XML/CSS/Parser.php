<?
//Unit('XML/CSS/MBase');

//Uses('XML/CSS/TStyle');
//Uses('XML/CSS/TFile' );

  Function ParseStyle($Str)
  {
    $Cs=Preg_Quote(';:(){}.>#,*', '/');
    $NW='['.$Cs.']';
    $W='[^\\s'.$Cs.']';
    $S='\\s+';
    // Двойные ковычки
    $Str1='(?:"(?:[^"\\\\]*|\\\\.)*")';
    // Одинарные ковычки
    $Str2="(?:'(?:[^'\\\\]*|\\\\.)*')";
    $Rem1="\\/\\*.*?\\*\\/";
    $RE='(?:(?:'.$Rem1.')|(?:'.$Str1.')|(?:'.$Str2.')|(?:'.$W.'+)|(?:'.$NW.')|('.$S.'))';
    If(Preg_Match_All('/'.$RE.'/sS', $Str, $Res))
      Return $Res;
    Else
      Return Array();
  }
?>