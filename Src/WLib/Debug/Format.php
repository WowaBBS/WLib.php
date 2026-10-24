<? NameSpace WLib\Debug;

  $Loader->Load_Type('/Debug/Measure/Value' );
  
  $Loader->Load_Type('/Debug/Custom/Depth'  );
  $Loader->Load_Type('/Debug/Custom/Item'   );
  $Loader->Load_Type('/Debug/Custom/List'   );
  
  $Loader->Load_Type('/Debug/HexDump'       );
  $Loader->Load_Type('/Debug/Table/List'    );

  Class Format
  {
    Static Function Measure ($v, $Format='Default'):I_Custom { Return New Measure\T_Value($v, $Format); }
    Static Function Numeric ($v):I_Custom { Return Self::Measure($v               ); }
    Static Function Size    ($v):I_Custom { Return Self::Measure($v, 'SizeBytes'  ); }
    Static Function Speed   ($v):I_Custom { Return Self::Measure($v, 'SpeedBytes' ); }
    Static Function Time    ($v):I_Custom { Return Self::Measure($v, 'Time'       ); }
    
    Static Function Log_Depth (Int $Level        ):I_Custom { Return New Custom\T_Depth ($Level       ); }
    Static Function Log_Item  ($Value, $Type=Null):I_Custom { Return New Custom\T_Item  ($Value, $Type); }
    Static Function Log_List  (Array $List       ):I_Custom { Return New Custom\T_List  ($List        ); }

    Static Function HexDump($Data, $Args=[]):I_Custom { Return New T_HexDump($Data, $Args); }
    
    Static Function Table(Array $List, Array $Args=[]):I_Custom { Return Table\T_List::Cr    ($List, $Args); }
    Static Function ToMap(Array $List                ):Array    { Return Table\T_List::ToMap ($List       ); }
  }