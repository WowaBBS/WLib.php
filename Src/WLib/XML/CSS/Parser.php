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
    // ������ ����窨
    $Str1='(?:"(?:[^"\\\\]*|\\\\.)*")';
    // ������� ����窨
    $Str2="(?:'(?:[^'\\\\]*|\\\\.)*')";
    $Rem1="\\/\\*.*?\\*\\/";
    $RE='(?:(?:'.$Rem1.')|(?:'.$Str1.')|(?:'.$Str2.')|(?:'.$W.'+)|(?:'.$NW.')|('.$S.'))';
    If(Preg_Match_All('/'.$RE.'/sS', $Str, $Res))
      Return $Res;
    Else
      Return Array();
  }
?>