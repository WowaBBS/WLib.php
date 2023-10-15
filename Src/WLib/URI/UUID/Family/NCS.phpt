<?
  $this->Load_Enum('/URI/UUID/Family');
  $this->Load_Type('/URI/UUID/Binary');
  
  Use E_URI_UUID_Family  As Family  ;
  Use C_URI_UUID_Factory As Factory ;

  // It was taken from:
  //  https://github.com/danielmarschall/oidinfo_api/blob/master/uuid_utils.inc.phps
  //  https://github.com/danielmarschall/oidplus/blob/master/vendor/danielmarschall/uuid_mac_utils/includes/uuid_utils.inc.php
  //  https://github.com/danielmarschall/uuid_mac_utils/blob/master/includes/uuid_utils.inc.php
 /*
  * Internal structure of variant #0 UUIDs
  *
  * The first 6 octets are the number of 4 usec units of time that have
  * passed since 1/1/80 0000 GMT.  The next 2 octets are reserved for
  * future use.  The next octet is an address family.  The next 7 octets
  * are a host ID in the form allowed by the specified address family.
  *
  * Note that while the family field (octet 8) was originally conceived
  * of as being able to hold values in the range [0..255], only [0..13]
  * were ever used.  Thus, the 2 MSB of this field are always 0 and are
  * used to distinguish old and current UUID forms.
  */
  /*
    Variant 0 UUID
    - 32 bit High Time
    - 16 bit Low Time
    - 16 bit Reserved
    -  1 bit Variant (fix 0b0)
    -  7 bit Family
    - 56 bit Node
  */
  // Example of an UUID: 333a2276-0000-0000-0d00-00809c000000
  // TODO: also show legacy format, e.g. 458487b55160.02.c0.64.02.03.00.00.00
  # see also some notes at See https://github.com/cjsv/uuid/blob/master/Doc
  /*
   NOTE: A generator is not possible, because there are no timestamps left!
   The last possible timestamp was:
       [0xFFFFFFFFFFFF] 2015-09-05 05:58:26'210655 GMT
   That is in the following UUID:
       ffffffff-ffff-0000-027f-000001000000
   Current timestamp generator:
       echo dechex(round((microtime(true)+315532800)*250000));
  */

   # Timestamp: Count of 4us intervals since 01 Jan 1980 00:00:00 GMT
   # 1/0,000004 = 250000
   # Seconds between 1970 and 1980 : 315532800
   # 250000*315532800=78883200000000
  Class T_URI_UUID_Family_NCS Extends T_URI_UUID_Binary
  {
    Function GetFamily(): Family { Return Family::NCS; }
    //34dc23469000.0d.00.00.7c.5f.00.00.00

    Static Protected $TimeOffset;
    Static Function GetTimeOffset() { Return Self::$TimeOffset??=GmMkTime(0, 0, 0, 1, 1, 1980)*10_000_000; }
    Function _GetActulVersion (): Int { Return -1; }
    
    Static Function _Make(?String $Res=Null): Self
    {
      If(StrLen($Res)!==16)
        Throw New InvalidArgumentException('Expected exactly 16 bytes, but got '.StrLen($Input));
      Static::_Fix($Res);
      Return New (Static::Class)($Res);
    }
    
    Static Function _Create(Factory $F, String $Node, Int|String $Family=Null, $Hns=Null, Int $Reserverd=0): Self
    {
      If(StrLen($Node)!==7) Throw New \TypeError('Unknown node: '.Bin2Hex($Node));
      $Hns??=$F->TimeStamp100ns();
      $t=IntDiv(($Hns-Self::GetTimeOffset()), 10_000_000/250_000);
      $F->_Seq($t, Null, 0, Self::Class);
      $Res=Pack('NnnC', $t>>16, $t, $Reserverd, $Family);
      Return Self::_Make($Res.$Node);
    }

    Static Function _UnPack($Bin)
    {
      Static::_UnFix($Bin);
      ['a'=>$a, 'b'=>$b, 'c'=>$Reserved, 'd'=>$Family]=UnPack('Na/nb/nc/nC', $Bin);
      Return [
        'Class'    =>'NCS',
        'Time'     =>($c<<16 | $b)*(10_000_000/250_000)+Self::GetTimeOffset(),
        'Family'   =>$Family,
        'Node'     =>SubStr($Bin, 9),
        'Reserved' =>$Reserved,
      ];
    }
    
    // https://community.hpe.com/t5/operating-system-hp-ux/value-of-af-inet6/td-p/2781595
    // https://learn.microsoft.com/en-us/windows/win32/api/winsock2/nf-winsock2-socket
    // https://man.archlinux.org/man/address_families.7.ru
    Static Function _Family($v)
    {
      Return Match($v){
        'Unspecified', 'UnSpec' =>  0, // Unspec
        'Unix'                  =>  1, // pipes, portals
        'IpV4'       ,'Inet'    =>  2, // Address for IP version 4.
        'ARPANET'               =>  3, // ARPANET imp addresses
        'Pup'                   =>  4, // Address for Pup protocols, e.g. BSP
        'MitChaos'   ,'Chaos'   =>  5, // Address for MIT CHAOS protocols
        'XeroxNs'    ,'Ns'      =>  6, // Address for Xerox NS protocols. IPX or SPX address.
        'NBS'                   =>  7, // Address for OSI protocols. Address for ISO protocols.
        'Ecma'                  =>  8, // European Computer Manufacturers Association (ECMA) address.
        'DataKit'               =>  9, // Address for Datakit protocols
        'Ccitt'      ,'X25'     => 10, // Addresses for CCITT protocols, such as X.25.
        'Sna'                   => 11, // IBM SNA address.
        'DecNet'                => 12, // DECnet address.
        'DataLink'   ,'Dli'     => 13, // Direct data-link interface address.
      
        'Lat'                   => 14,
        'HyLink'                => 15, // NSC Hyperchannel
        'AppleTalk'             => 16, // Apple Talk
        'Ots'                   => 17, // Used for OSI in the ifnets
        'Nit'                   => 18, // NIT
        'VmeLink'               => 19, // VME backplane protocols
        'Key'                   => 20, // IPSec PF_KEY protocol
        'Policy'                => 21, // IPSec PF_POLICY protocol
        'IpV6'      ,'Inet6'    => 22, // IPv6 protocol
      };
    }
    
    Static Function _Fix   (&$Res) { $Res[8]=Chr(Ord($Res[8])&0x7F); }
    Static Function _UnFix (&$Res) { $Res[8]=Chr(Ord($Res[8])&0x7F); }
  }
?>