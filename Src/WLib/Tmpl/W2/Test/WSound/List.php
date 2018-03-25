<?
  require_once 'Effects.php';
  
  require_once 'Lib/Struct.php';
  
  function ToAL($S)
  {
    $S=Trim($S);
    $S=StrToUpper($S);
    $S=str_replace(' ', '_', $S);
    return $S;
  }
  
  function ToCpp($S)
  {
    $S=Trim($S);
    $S=str_replace(' ', '_', $S);
    return $S;
  }
  
  $CPP_Struct_Prefix ='';
  $CPP_Field_Prefix  ='';
  $AL_Effect_Prefix  ='AL_EFFECT_';
  $Structs_Vars=[
    'CPP_Struct_Prefix' => $CPP_Struct_Prefix ,
    'CPP_Field_Prefix'  => $CPP_Field_Prefix  ,
    'AL_Effect_Prefix'  => $AL_Effect_Prefix  ,
  ];
  
  Reformat_Structs($Effects, $Structs_Vars);
?>