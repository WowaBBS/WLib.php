<? NameSpace WLib\Log;
  class Logger
  {
    Static Function Get():C_Logger { return \WLib\Object\C_Loader::Get()->GetLogger(); }
    
    Static Function LogItem($LogLevel, ...$Args):T_Item { Return Self::Get()->Log($LogLevel, ...$Args); }
    
    Static Function Debug     (...$Args):T_Item { Return Self::LogItem('Debug'    , ...$Args); }
    Static Function Progress  (...$Args):T_Item { Return Self::LogItem('Progress' , ...$Args); }
    Static Function Log       (...$Args):T_Item { Return Self::LogItem('Log'      , ...$Args); }
    Static Function Note      (...$Args):T_Item { Return Self::LogItem('Note'     , ...$Args); }
    Static Function Warning   (...$Args):T_Item { Return Self::LogItem('Warning'  , ...$Args); }
    Static Function Error     (...$Args):T_Item { Return Self::LogItem('Error'    , ...$Args); }
    Static Function Fatal     (...$Args):T_Item { Return Self::LogItem('Fatal'    , ...$Args); }
    Static Function Dump      ($Vars, $Limit=-1):T_Item { Return Self::Debug()->Dump($Vars, $Limit=-1); }
  }
