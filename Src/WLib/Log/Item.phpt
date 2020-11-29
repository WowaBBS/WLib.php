<?
  $this->Load_Type('/Log/Level');
  ini_set('log_errors_max_len', 1000000);
  
  class TLoggerUnsupportedException extends Exception
  {
  }
  
  class T_Log_Item
  {
    Var $Outer     = null  ;
    Var $Logger    = null  ;
    Var $Level     = null  ;
    Var $ShowLevel = False ;
    Var $Data      = []    ;
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
      //Example: $this->Log('Fatal', 'Unreachable place');
    }
    
    Function Done() { $this->Finish(); $this->Data=[]; $this->Outer=null; $this->Logger=null; }
    Function __Destruct() { $this->Finish(); }
    
    Function Debug($Vars, $Limit=-1) { $this->Data[]=['Debug', $Vars, $Limit]; return $this; } 
    
    Function Call($CallBack) { $CallBack($this); return $this; } // TODO: Remove?
    
    Function Add(... $Args) { return $this->AddArr($Args); }
    
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
    
    Function AddArr(Array $v) { $this->Data[]=['Message', $v]; return $this; }
    
    Function AddStr(String $Str) { return $this->AddArr([$Str]); } //<TODO: Remove?

    //****************************************************************
    // Stack
    
    Function SetStack(Array $List, Int $Skip=0, Int $Count=1000)
    {
      $this->NoBackTrace();
      if($Skip>0)
        Array_Splice($List, 0, $Skip);
      if(Count($List)>$Count)
        Array_Splice($List, $Count);
      $this->Data[]=['Stack', $List];
      return $this;
    }

    Function BackTrace($Skip=0)
    {
      return $this->SetStack(Debug_BackTrace(), $Skip+1);
    }

    Function SetStackFromException($Exception)
    {
      return $this->SetStack($Exception->getTrace());
    }
    
    Function NoBackTrace ($v=true) { $this->Data['Stack'    ]=['Flag', !$v]; return $this; }
    Function Progress    ($v=true) { $this->Data['Progress' ]=['Flag',  $v]; return $this; }
    
    //****************************************************************
    
    Var $Importance=1;
    
    Function Unimportant() { $this->Importance=0; return $this; }
    Function SetImportance($v) { $this->Importance=$v; return $this; }
    
    //****************************************************************
    Function Finish()
    {
      if($this->Finished)
        return;
      $this->Finished=true;
      if($this->Data['Stack'][1]?? $this->Level->Stack)
        $this->BackTrace(1);
      if($this->Logger)
        $this->Logger->LogItem($this);
      if($this->Fatal)
      {
      //debug_print_backtrace();
        throw new TLoggerUnsupportedException('Unsupported');
        //UnSupported();
      }
    }
    
    Function ToFormat($Res)
    {
      if($this->File!==False)
        $Res->File($this->File, $this->Line, $this->Col);
        
      $Progress=$this->Data['Progress'][1]?? $this->Level->Progress;
      if($Progress)
        $Res->BeginProgress();

      if($this->ShowLevel!==False)
        $Res->WriteLogLevel($this->ShowLevel, $this->Level);
        
      ForEach($this->Data As $Data)
        Switch($Data[0])
        {
        Case 'Message':
          $Res->Write(... $Data[1]);
          $Res->NewLine();
          break;
        Case 'Debug':
          $Res->Debug($Data[1], $Data[2]);
          break;
        Case 'Stack':
          $Res->Stack($Data[1]);
          $Res->NewLine();
          break;
        Case 'Flag':
          break;
        Default:
          $Res->Write('[LogError] not ype of data', $Data[0]);
          $Res->NewLine();
          $Res->Debug($Data, 4);
          break;
        }
      if($Progress)
        $Res->EndProgress();
    }
  }
?>