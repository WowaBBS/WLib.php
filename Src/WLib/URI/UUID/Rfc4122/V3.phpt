<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V3 Extends T_URI_UUID_Family_Rfc4122
  {
    Static Function GetDesiredVersion(): Int { Return 3; }

    Static Function _Create(Factory $F, $NameSpace, String $Name): Self
    {
      Return Self::_Make(Md5($F->_NS($NameSpace).$Name, True));
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      Return ['Class'=>'V3', 'Hash'=>$Bin];
    }
  }
?>