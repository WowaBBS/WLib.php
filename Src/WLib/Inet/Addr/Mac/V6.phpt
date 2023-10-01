<?
  Class T_Inet_Addr_Mac_V6
  {
    Protected $Addr='\0\0\0\0\0\0';
    
    Function __Construct(String $v)
    {
      If(StrLen($v)!==6)
        Throw New \TypeError('Mac is wrong: '.$v);
      $this->Addr=$v;
    }
    
    Function ToBinary() { Return $this->Addr; }
    Function ToString($Split=':', $Chars=2) { Return Implode($Split, Str_Split(StrToUpper(Bin2Hex($this->ToBinary())), $Chars)); }
    Function __toString() { return $this->ToString(); }

  //****************************************************************
  // Debug
  
    Function _Debug_Serialize(&$Res) { $Res=$this->ToString(); }
    
  //****************************************************************
  }
?>