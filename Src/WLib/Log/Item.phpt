<?
  $this->Load_Type('/Log/Level');
  ini_set('log_errors_max_len', 1000000);
  
  class T_Log_Item
  {
    Var $Outer     = null  ;
    Var $Logger    = null  ;
    Var $Level     = null  ;
    Var $ShowLevel = False ;
    Var $Message   = []    ;
    Var $Fatal     = false ;
    Var $Finished  = false ;
    Var $File      = false ;
    Var $Line      = false ;
    Var $Col       = false ;
    
    Function __Construct($Outer, $Logger, $Level, $List)
    {
      $this->Outer  = $Outer  ;
      $this->Logger = $Logger ;
      $Levels=T_Log_Level::GetMapByName();
      if(IsSet($Levels[$Level]))
        $Level=$Levels[$Level];
      else
      {
        $this->Add('[Error] ', 'LogLevel "', $Level, '" is not supported by logger');
        $Level=$Levels['Fatal'];
      }
      $this->Level=$Level;
      $this->ShowLevel=$Level->Show;
      $this->AddArr($List);
      $this->Fatal  =$Level->Fatal;
      if($Level->Stack)
        $this->BackTrace(2);
      //Example: $this->Log('Fatal', 'Unreachable place');
    }
    
    Function Done() { $this->Finish(); $this->Message=[]; $this->Outer=null; $this->Logger=null; }
    Function __Destruct() { $this->Finish(); }
    
    Var $Debug=[];
    
    Function Debug($Vars, $Limit=-1) // TODO: To Log
    {
      $this->Debug[]=[$Vars, $Limit];
    //$this->Outer->Debug($Vars, $Limit);
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
    
    Function ShowLevel($v) { $this->ShowLevel=$v; return $this; }
    
    Function File($File, $Line=false, $Col=false)
    {
      if(Is_Array($File))
      {
        $this->File = $File['File' ]?? $File[0]         ;
        $this->Line = $File['Line' ]?? $File[1]?? $Line ;
        $this->Col  = $File['Col'  ]?? $File[2]?? $Col  ;
      }
      else
      {
        $this->File = $File ;
        $this->Line = $Line ;
        $this->Col  = $Col  ;
      }
      return $this;
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

    //****************************************************************
    // Stack
    Var $Stack=[];

    Function SetStack(Array $List, Int $Skip=0, Int $Count=1000)
    {
      if($Skip>0)
        Array_Splice($List, 0, $Skip);
      if(Count($List)>$Count)
        Array_Splice($List, $Count);
      $this->Stack=$List;
      return $this;
    }

    Function BackTrace($Skip=0)
    {
      $Skip++;
      return $this->SetStack(Debug_BackTrace(), $Skip);
    }

    Function SetStackFromException($Exception)
    {
      return $this->SetStack($Exception->getTrace());
    }
    
    Function NoBackTrace()
    {
      $this->Stack=[];
      return $this;
    }
    
    //****************************************************************
    Function Finish()
    {
      if($this->Finished)
        return;
      $this->Finished=true;
      if($this->Logger)
        $this->Logger->LogItem($this);
      if($this->Fatal)
      {
      //debug_print_backtrace();
      
        UnSupported();
      }
    }
    
    Function ToFormat($Res)
    {
      if($this->File!==False)
        $Res->File($this->File, $this->Line, $this->Col);
        
      if($this->ShowLevel!==False)
        $Res->WriteLogLevel($this->ShowLevel, $this->Level);

      ForEach($this->Message As $Line)
      {
        $Res->Write(... $Line);
        $Res->NewLine();
      }
      if($this->Stack)
      {
        $Res->Stack($this->Stack);
        $Res->NewLine();
      }
      ForEach($this->Debug As $Debug)
        $Res->Debug($Debug[0], $Debug[1]);
    }
  }
?>