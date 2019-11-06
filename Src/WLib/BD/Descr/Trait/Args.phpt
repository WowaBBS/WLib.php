<?
  Trait T_BD_Descr_Trait_Args
  {
    Static Function Args_PopOrGet(Array &$Vars, $Name, $Def=null)
    {
      if(IsSet($Vars[$Name]))
      {
        $Res=$Vars[$Name];
        UnSet($Vars[$Name]);
        return $Res;
      }
      if(IsSet($Vars[0]))
        return Array_Shift($Vars);
      return $Def;
    }

    Static Function Args_Get(Array &$Vars, $Name, $Def=null)
    {
      if(IsSet($Vars[$Name]))
      {
        $Res=$Vars[$Name];
        UnSet($Vars[$Name]);
        return $Res;
      }
      return $Def;
    }
  }
?>