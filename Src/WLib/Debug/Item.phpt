<?
  $Loader->Load_Interface('/Debug/Custom');
  
//Function DebugItem($Value, $Type=Null) { Return $Value; }
//Function DebugItem($Value, $Type=Null) { Return Is_Null($Type)? $Value:New T_Debug_Item($Value, $Type); }
  Function DebugItem($Value, $Type=Null) { Return New T_Debug_Item($Value, $Type); }
//Function DebugItem($Value, $Type=Null) { Return [$Value, $Type]; }

  Class T_Debug_Item Implements I_Debug_Custom, Stringable
  {
    Var $Value = ''    ;
    Var $Type  = 'Def' ;
    
    Function __Construct($Value, $Type=Null)
    {
      $this->Value =$Value ;
      $this->Type  =$Type  ;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(C_Log_Format $To)
    {
      $To($this->Value, $this->Type);
    }
    
    Function ToString() { Return $this->Value; }
    
    Function __ToString() { Return $this->ToString(); }
  };
?>