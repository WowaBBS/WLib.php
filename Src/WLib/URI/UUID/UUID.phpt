<?
  $this->Load_Enum('/URI/UUID/Family');
  
  Use E_URI_UUID_Family  As Family  ;
  Use C_URI_UUID_Factory As Factory ;

  Class T_URI_UUID_UUID
  {
    Function _GetActulVersion (): Int    { Return Family::GetVersion ($this->_ToBinary()); }
    Function _GetActulFamily  (): Family { Return Family::Get        ($this->_ToBinary()); }

    Static Function GetDesiredVersion (): Int    { Return -1; }
    Static Function GetDesiredFamily  (): Family { Return Family::Reserved; }

    Function GetVersion (): Int    { Return Static::GetDesiredVersion (); }
    Function GetFamily  (): Family { Return Static::GetDesiredFamily  (); }

    Function IsNil(): Bool { Return False; }

    Function _ToBinary(): String { Return E_URI_UUID_Family::_Nil; }
    Function ToBinary(): String { $this->Validate(); Return $this->_ToBinary(); }
    
    Function ToHex(): String { Return Bin2Hex($this->ToBinary()); }
    Function ToString(): String { Return VsPrintF('%s%s-%s-%s-%s-%s%s%s', Str_Split($this->ToHex(), 4)); }

    Function __toString() { return $this->ToString(); }

    Function ToUrn(): String { Return 'urn:uuid:'.$this->ToString(); }
    Function ToDec(): String { Return Gmp_StrVal(Gmp_Init($this->ToHex(), 16), 10); }
    Function ToOid(): String { Return '2.25.'.$this->ToDec(); }
    
    Private Function __Clone() { Throw New Error('Cannot clone immutable '.__CLASS__.' object'); }
    Function __WakeUp(): Void { $this->Validate(); }

    Function Validate()
    {
      $v=$this->_ToBinary();
      If(!Is_String($v))  Throw New \TypeError('Expected binary value to be of type string, but found '.GetType($v));
      If(StrLen($v)!==16) Throw New \TypeError('Expected binary value to be exactly 16 bytes long, but found '.StrLen($v));
      If($this->GetVersion ()!=$this->_GetActulVersion ()) Throw New \TypeError('Expected version '.$this->_GetActulVersion ().' is not desired '.$this->GetVersion ());
      If($this->GetFamily  ()!=$this->_GetActulFamily  ()) Throw New \TypeError('Expected family ' .$this->_GetActulFamily  ().' is not desired '.$this->GetFamily  ());
      Return True;
    }
    
    Function UnPack() { Return Static::_UnPack($this->ToBinary()); }
    Function GetTime100ns() { Return $this->UnPack()['Time']?? Null; }
    Function GetTime() { $r=$this->GetTime100ns(); Return Is_Null($r)? Null:$r*1e-7; }
    
    Function Equals  ($v) { Return $this->ToBinary()===$v->ToBinary(); }
    Function Less    ($v) { Return $this->ToBinary() < $v->ToBinary(); }
    Function Greater ($v) { Return $this->ToBinary() > $v->ToBinary(); }
  }
?>