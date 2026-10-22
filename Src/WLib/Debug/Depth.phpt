<?
  NameSpace WLib\Debug;
  $Loader->Load_Interface('/Debug/Custom');
  
  Function Depth(Int $Level) { Return New T_Depth($Level); }

  Class T_Depth Implements \WLib\Debug\I_Custom
  {
    Var Int $Depth=0;
    
    Function __Construct(Int $Depth=10)
    {
      $this->Depth=$Depth;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(\WLib\Log\C_Format $To)
    {
      $To->Log_Depth=$this->Depth;
    }
  };
?>