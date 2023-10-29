<?
  $this->Load_Type('/URI/UUID/Family/Rfc4122');
  $this->Load_Type('/URI/UUID/Rfc4122/V1');
  
  Use C_URI_UUID_Factory    As Factory ;
  Use T_URI_UUID_Rfc4122_V1 As V1      ;

  # Variant 1, Version 2 UUID
  # - 32 bit Local Domain Number
  # - 16 bit Mid Time
  # -  4 bit Version (fix 0x2)
  # - 12 bit High Time
  # -  2 bit Variant (fix 0b10)
  # -  6 bit Clock Sequence
  # -  8 bit Local Domain
  # - 48 bit MAC Address
  Class T_URI_UUID_Rfc4122_V2 Extends T_URI_UUID_Family_Rfc4122 //V1 "Fatal error: Declaration of " "must be compatible with"
  {
    Static Function GetDesiredVersion(): Int { Return 2; }

    Static Function _Create(Factory $F, Int|String $Domain, ?Int $Id=Null, $Hns=Null, $Seq=Null, Mac|String|Null $Mac=Null): Self
    {
      $Domain =Static::_Domain   ($Domain);
      $Id     =Static::_DomainId ($Domain, $Id);
      $Hns  ??=$F->TimeStamp100ns();
      $Tim    =($Hns-V1::GetTimeOffset())>>32;
      $Seq=$F->_Seq($Tim, $Seq, 6, Self::Class);
      $Res=Pack('NnnCC', $Id, $Tim, $Tim>>16, $Seq, $Domain);
      Return Self::_Make($Res.$F->_Mac($Mac));
    }
    
    Static Function _Domain(Int|String $v)
    {
      If(Is_Int($v)) Return $v;
      If(Is_String($v))
        Return Match($v){
          'Preson' ,'Uid' =>0, //DCE_DOMAIN_PERSON  // uid  -- Person (e.g. POSIX UID)
          'Group'  ,'Gid' =>1, //DCE_DOMAIN_GROUP   // gid  -- Group (e.g. POSIX GID)
          'Org'           =>2, //DCE_DOMAIN_ORG     // org  -- Organization
          'Site'          =>3,                      // site -- Site-defined
          Default         =>Throw \TypeError('Unknown domain: '.$v),
        };
    }

    Static Function _DomainId(Int $Domain, ?Int $v)
    {
      Return $v?? Match($Domain){ //TODO:
        0=>Posix_GetUid(), //Posix_GetEUid() Posix_GetPGid()
        1=>Posix_GetGid(), //Posix_GetEGid() Posix_GetPGrp()
        Default=>Throw \TypeError('Domain Id is not defined'),
      };   
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$Id, 'b'=>$b, 'c'=>$c, 'd'=>$Seq, 'e'=>$Domain]=UnPack('Na/nb/nc/Cd/Ce', $Bin);
      Return [
        'Class'  =>'V2',
        'Domain' =>$Domain,
        'Id'     =>$Id,
        'Time'   =>($c<<48 | $b<<32)+V1::GetTimeOffset(),
        'Seq'    =>$Seq,
        'Mac'    =>SubStr($Bin, 10),
      ];
    }
  }
?>