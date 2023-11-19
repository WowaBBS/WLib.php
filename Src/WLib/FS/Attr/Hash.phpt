<?
  Class T_FS_Attr_Hash
    Implements Stringable 
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
    Function __ToString() { Return $this->ToString(); }

  //****************************************************************
  // TODO: Add Factory, Builder, Maker
  
    Static Function FromBinary($Data, $Type)
    {
      Switch($Type)
      {
      Case 'Md5'  : Return New Static(Md5  ($Data, True), $Type);
      Case 'Sha1' : Return New Static(Sha1 ($Data, True), $Type);
      Default: Return New Static('Unknown '.$Type, 'Error');
      }
    }
    
    Static Function FromFile($File, $Type)
    {
      If(!Is_File($File))
        Return New Static('File iw wrong '.$File, 'Error');
      Switch($Type)
      {
      Case 'Md5'  : Return New Static(Md5_File  ($File, True), $Type);
      Case 'Sha1' : Return New Static(Sha1_File ($File, True), $Type);
      Default: Return New Static('Unknown '.$Type, 'Error');
      }
    }
    
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
