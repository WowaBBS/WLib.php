<?
  Class T_FS_Attr_IntId
  {
    Public $Value=0;
    
    Function __Construct($v) { $this->Value=$v; }
    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function GetType() { Return $this->Type; }
    
    Function ToInt() { Return $this->Value; }
    Function ToHex()
    {
      $GroupBy=4; 
      $Res=DecHex($this->Value);
      $Res=StrToUpper($Res);
      $Res=Str_Pad($Res, IntDiv(StrLen($Res)+$GroupBy-1, $GroupBy)*$GroupBy, '0', STR_PAD_LEFT);
      $Res=Implode('_', Str_Split($Res, $GroupBy));
      Return '0x'.$Res;
    }
    
    Function ToBinary() { Return Hex2Bin($this->ToHex()); }
    Function ToString() { Return $this->Value<0x10000? $this->ToInt():$this->ToHex(); }

  //****************************************************************
  // Debug
  
    Function ToDebug() { $i=$this->ToInt(); $s=$this->ToString(); Return $i===$s? $s:$s.' '.$i; }
    Function _Debug_Serialize(Array &$Res)
    {
      $Res=$this->ToDebug();
    }
  
  //****************************************************************
  }
?>
