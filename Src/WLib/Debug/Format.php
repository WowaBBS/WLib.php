<? NameSpace WLib\Debug;

  $Loader->Load_Type('/Debug/Measure/Value' );
  
  $Loader->Load_Type('/Debug/Custom/Depth'  );
  $Loader->Load_Type('/Debug/Custom/Item'   );
  $Loader->Load_Type('/Debug/Custom/List'   );
  
  $Loader->Load_Type('/Debug/HexDump'       );
  $Loader->Load_Type('/Debug/Table/List'    );
  $Loader->Load_Type('/Debug/Table/Make'    );

  Class Format
  {
    Static Function Measure ($v, $Format='Default'):I_Custom { Return New Measure\T_Value($v, $Format); }
    Static Function Numeric ($v, $Add=''):I_Custom { Return Self::Measure($v, $Add===''? 'Default'    :'Default'    .$Add); }
    Static Function Size    ($v, $Add=''):I_Custom { Return Self::Measure($v, $Add===''? 'SizeBytes'  :'SizeBytes'  .$Add); }
    Static Function Speed   ($v, $Add=''):I_Custom { Return Self::Measure($v, $Add===''? 'SpeedBytes' :'SpeedBytes' .$Add); }
    Static Function Time    ($v, $Add=''):I_Custom { Return Self::Measure($v, $Add===''? 'Time'       :'Time'       .$Add); }

    Static Function Log_Depth (Int $Level        ):I_Custom { Return New Custom\T_Depth ($Level       ); }
    Static Function Log_Item  ($Value, $Type=Null):I_Custom { Return New Custom\T_Item  ($Value, $Type); }
    Static Function Log_List  (Array $List       ):I_Custom { Return New Custom\T_List  ($List        ); }

    Static Function HexDump($Data, $Args=[]):I_Custom { Return New T_HexDump($Data, $Args); }
    
    Static Function Table(Array $List, Array $Args=[]):I_Custom { Return Table\T_List::Cr    ($List, $Args); }
    Static Function ToMap(Array $List                ):Array    { Return Table\T_Make::ToMap ($List       ); } //TODO: Make table
    
  //TODO:
  // base_convert
  //DataFormat($Prefix='', $Postfix='', Int $Base=0, String $Split='_', Int $Chunk=4, Int $Pad=0)
  //Static Function Data(Int|String $Value, Int $Base=0, Int $Pad=0)
  //Static Function Hex(Int|String $Value, Int $Pad=0, $Format=Null)
  //Static Function Oct(Int|String $Value, Int $Pad=0, $Format=Null)
  //Static Function Bin(Int|String $Value, Int $Pad=0, $Format=Null)
  }