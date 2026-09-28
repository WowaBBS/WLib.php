<?
  NameSpace WLib\Debug;
  $Loader->Load_Interface('/Debug/Custom');
  
  Function Depth(Int $Level) { Return New TDepth($Level); }

  Class TDepth Implements \WLib\Debug\ICustom
  {
    Var Int $Depth=0;
    
    Function __Construct(Int $Depth=10)
    {
      $this->Depth=$Depth;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(\WLib\Log\CFormat $To)
    {
      $To->Log_Depth=$this->Depth;
    }
  };
?>