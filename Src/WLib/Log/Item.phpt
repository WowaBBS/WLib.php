<?
  $this->Load_Type('/Log/Level');
  ini_set('log_errors_max_len', 1000000);
  
  class T_Log_Item
  {
    Var $Outer    = null  ;
    Var $Logger   = null  ;
    Var $Level    = null  ;
    Var $Message  = []    ;
    Var $Fatal    = false ;
    Var $Finished = false ;
    Var $File     = false ;
    Var $Line     = false ;
    Var $Col      = false ;
    
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
      if($Level->Show!==false)
        Array_Unshift($List, $Level->Show);
      $this->AddArr($List);
      $this->Fatal  =$Level->Fatal;
      //Example: $this->Log('Fatal', 'Unreachable place');
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
    }

    Function BackTrace($Skip=0)
    {
      $this->SetStack(Debug_BackTrace(), $Skip);
    }

    Function SetStackFromException($Exception)
    {
      $this->SetStack($Exception->getTrace());
    }
    
    //TODO:
    function GetStackAsString()
    {
      $Res= [];
      $Count = 0;
      ForEach($this->Stack As $Frame)
      {
        $Args = '';
        If(IsSet($Frame['args']))
        {
          $Args = [];
          ForEach($Frame['args']As $Arg)
          {
            // TODO: $this->DebugL($Arg,3);
            Switch(GetType($Arg))
            {
            Case 'boolean'       : $Args[] = $Arg? 'true':'false'    ; break;
            Case 'integer'       : $Args[] = $Arg                    ; break;
            Case 'double'        : $Args[] = $Arg                    ; break;
            Case 'string'        : $Args[] = "'".$Arg."'"            ; break;
            Case 'object'        : $Args[] = Get_Class($Arg)         ; break;
            Case 'array'         : $Args[] = 'Array'                 ; break;
            Case 'NULL'          : $Args[] = 'null'                  ; break;
            Case 'resource'      : $Args[] = Get_Resource_Type($Arg) ; break;
            Case 'float'         : $Args[] = $Arg                    ; break;
            Case 'unknown type'  : $Args[] = $Arg                    ; break;
            Case 'user function' : $Args[] = $Arg                    ; break;
            Default              : $Args[] = $Arg                    ; break;
            }
          }   
          $Args = Join(', ', $Args);
        }
        $Res[]= SPrintF('#%s %s(%s): %s(%s)',
          $Count,
          $Frame['file'     ],
          $Frame['line'     ],
          $Frame['function' ],
          $Args
        );
        $Count++;
      }
      return Implode("\n", $Res);
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
    
    Function ToString()
    {
      $Message=[];
      $z1=$this->File !==false;
      $z2=$this->Line !==false && $this->Line>0;
      $z3=$this->Col  !==false;
      
      if($z1) $Message[]=$this->File;
      if($z2 || $z3)
      {
         $Message[]='(';
         if($z2) $Message[]=$this->Line ;
         if($z1 && $z3) $Message[]=',';
         if($z3) $Message[]=$this->Col  ;
         $Message[]=')';
      }
      if($z1) $Message[]=' ';

      ForEach($this->Message As $Line)
      {
        ForEach($Line As $Str)
          $Message[]=$Str; // TODO: Check Is_String and debug
        $Message[]="\n";
      }
      if($this->Stack)
      {
        $Message[]="\n";
        $Message[]=$this->GetStackAsString();
      }
      return Implode('', $Message);
    }
  }
?>