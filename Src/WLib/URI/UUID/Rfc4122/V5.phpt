<?
  $this->Load_Type('/URI/UUID/Rfc4122/V3');
  
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_Rfc4122_V5 Extends T_URI_UUID_Rfc4122_V3
  {
    Static Function GetDesiredVersion(): Int { Return 5; }

    Static Function _Create(Factory $F, $NameSpace, String $Name): Self
    {
      Return Self::_Make(SubStr(Sha1($F->_NS($NameSpace).$Name, True), 0, 16));
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      Return ['Class'=>'V5', 'Hash'=>$Bin];
    }
  }
?>