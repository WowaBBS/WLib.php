<?
  Class T_FS_Attr_Hash
  {
    Public $Hash='';
    Public $Type='Unknown';
    
    Function __Construct($Hash, $Type) { $this->Hash=$Hash; $this->Type=$Type; }
    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Function GetType() { Return $this->Type; }
    
    Function ToInt() { Return $this->Value; }
    Function ToOct() { Return DecOct($this->ToInt()); }
    
    Function ToBinary() { Return $this->Hash; }
    Function ToString() { Return StrToUpper(Bin2Hex($this->Hash)); }

  //****************************************************************
  // Debug
  
    Function ToDebug() { Return $this->ToString().' '.$this->GetType(); }
    Function _Debug_Serialize(Array &$Res)
    {
      $Res=$this->ToDebug();
    }
  
  //****************************************************************
  }
?>
