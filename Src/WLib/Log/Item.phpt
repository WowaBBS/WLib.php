<?
  class T_Log_Item
  {
    Var $Outer    = null;
    Var $Logger   = null;
    Var $Level    = 'Log';
    Var $Message  = [];
    Var $Fatal    = false;
    Var $Finished = false;
    
    Function __Construct($Outer, $Logger, $Level, $List)
    {
      $this->Outer  = $Outer  ;
      $this->Logger = $Logger ;
      static $Levels=[//         Show         Fatal
        'Debug'   =>['Debug'   ,'[Debug] '   ,false ,],
        'Log'     =>['Log'     , False       ,false ,],
        'Warning' =>['Warning' ,'[Warning] ' ,false ,],
        'Error'   =>['Error'   ,'[Error] '   ,false ,],
        'Fatal'   =>['Fatal'   ,'[Fatal] '   ,true  ,],
      ];
      if(IsSet($Levels[$Level]))
        $Info=$Levels[$Level];
      else
      {
        $this->Add('[Error] ', 'LogLevel "', $Level, '" is not supported by logger');
        $Info=$Levels['Fatal'];
      }
      $Level=$Info[0];
      if($Info[1]!==false)
        Array_Unshift($List, $Info[1]);
      $this->AddArr($List);
      $this->Fatal=$Info[2];
      //$this->Log('Fatal', 'Unreachable place');
    }
    
    Function Done() { $this->Finish(); $this->Message=[]; $this->Outer=null; $this->Logger=null; }
    Function __Destruct() { $this->Finish(); }
    
    Function Debug($Vars, $Limit=-1) // TODO: To Log
    {
      $this->Outer->Debug($Vars, $Limit);
    }
    
    Function Call($CallBack)
    {
      $CallBack($this);
      return $this;
    }
    
    Function Add(... $Args)
    {
      return $this->AddArr($Args);
    }
    
    Function __invoke(... $Args)
    {
      return $this->AddArr($Args);
    }
    
    Function AddArr(Array $v)
    {
      $this->Message[]=$v;
      return $this;
    }
    
    Function AddStr()
    {
      return $this->AddArr([$Str]);
    }
    
    Function Finish()
    {
      if($this->Finished)
        return;
      $this->Finished=true;
      if($this->Logger)
        $this->Logger->LogItem($this);
      else
        ForEach($this->Message As $Message)
        {
          ForEach($Message As $Str)
            echo $Str; // TODO: Check Is_String and debug
          echo "\n";
        }
      if($this->Fatal)
        UnSupported();
    }
  }
?>