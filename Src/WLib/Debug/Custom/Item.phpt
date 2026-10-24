<? NameSpace WLib\Debug\Custom;
  $Loader->Load_Interface('/Debug/Custom');
  
//Function DebugItem($Value, $Type=Null) { Return $Value; }
//Function DebugItem($Value, $Type=Null) { Return Is_Null($Type)? $Value:New T_Item($Value, $Type); }
  Function DebugItem($Value, $Type=Null) { Return New T_Item($Value, $Type); }
//Function DebugItem($Value, $Type=Null) { Return [$Value, $Type]; }

  Class T_Item Implements \WLib\Debug\I_Custom, \Stringable
  {
    Var $Value = ''    ;
    Var $Type  = 'Def' ;
    
    Function __Construct($Value, $Type=Null)
    {
      $this->Value =$Value ;
      $this->Type  =$Type  ;
    }
    
    // Interface \WLib\Debug\I_Custom
    Function Debug_Write(\WLib\Log\C_Format $To)
    {
      $To($this->Value, $this->Type);
    }
    
    Function ToString() { Return $this->Value; }
    
    Function __ToString() { Return $this->ToString(); }
  };
?>