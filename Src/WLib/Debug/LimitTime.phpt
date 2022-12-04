<?
  Function LimitTime($Logger ,$Name=null, $Limit=null)
  {
    Return New T_Debug_LimitTime([$Logger ,$Name, $Limit]);
  }
  
  Class T_Debug_LimitTime
  {
  //Var $Weak       ;
    Var $Logger     ;
    Var $Started = 0;
    Var $Limit   = 1;
    Var $Name    ='';
    
    Var $Next       ;
    Var $Prev       ;
    
    Static $Current;
  
    Function __Construct($Args)
    {
    //$this->Weak=WeakReference::Create($this);
      $this->Init($Args);
      $this->Start();
    }
    
    Function __Destruct()
    {
      if($this->Started)
        $this->Finish();
    }
    
    Function Init($Args)
    {
      $Args[]=null;
      $Current=Static::$Current?->Get();
      
      $this->Logger =Is_Object  ($Args[0])                    ? Array_Shift($Args):$Current?->Logger;
      $this->Name   =Is_String  ($Args[0])||Is_Array($Args[0])? Array_Shift($Args):Null;
      $this->Limit  =Is_Integer ($Args[0])||Is_Float($Args[0])? Array_Shift($Args):($Current?? $this)->Limit;
    }
    
    Function Next($Name, $Limit=null)
    {
      $this->_Finish();
      $this->Name=$Name;
      if($Limit)
        $this->Limit=$Limit;
      $this->_Start();
    }
    
    Function Start()
    {
      $this->_Start();
      $this->_Add();
    }
    
    Function Finish()
    {
      $this->_Finish();
      $this->_Remove();
    }
    
    Function Push(...$Args)
    {
      if(Static::$Current?->Get()!==$this)
        $this->Log('Fatal', 'Push: LimitTime is not current: ', Static::$Current?->Get()->GetPath())->BackTrace();
      $Res=New Static($Args);
      $Res->Prev=$this;
      Return $Res;
    }
    
    Function Pop()
    {
      if(Static::$Current?->Get()!==$this)
        $this->Log('Fatal', 'Pop: LimitTime is not current: ', Static::$Current?->Get()->GetPath())->BackTrace();
      $Res=$this->Prev;
      $this->Finish();
      Static::$Current=WeakReference::Create($Res);
      Return $Res;
    }
    
    Function Get() { return $this; }
    
    Function GetLogger() { return $this->Logger?? $this->Prev->Get()->GetLogger()?? $GLOBALS['Loader']; }
    
    Function GetName()
    {
      $v=$this->Name;
      if(Is_String ($v)) Return $v;
      if(Is_Null   ($v)) Return $this->Name=$this->Logger->ToDebugInfo();
      $Res=[];
      ForEach($v As $i)
      {
        If(Is_Object($i)) $Res[]=$i->ToDebugInfo(); else
                          $Res[]=$i;
      }
      Return $this->Name=Implode('/', $Res);
    }
    
    Function GetPath()
    {
      $Res=[];
      $Item=$this;
      While($Item)
      {
        $Res[]=$Item->GetName();
        $Item=$Item->Prev?->Get();
      }
      $Res=Array_Reverse($Res);
      Return Implode('/', $Res);
    }
    
    Function Log($LogLevel, ...$Args)
    {
      Array_UnShift($Args, $this->GetPath(), ': ');
      return $this->GetLogger()->Log($LogLevel, ...$Args);
    }
    
    Protected Function _Start()
    {
      if($this->Started)
        $this->Log('Error', 'LimitTime was started')->BackTrace();
      $this->Started=HRTime(True);
    }
    
    Protected Function _Finish()
    {
      if(!$this->Started)
        return $this->Log('Error', 'LimitTime was\'nt started')->BackTrace();
      $Time=(HRTime(True)-$this->Started)*1e-9;
      $this->Started=0;
      if($Time<=$this->Limit) return; //It`s ok
      $this->Log('Error', 'Time ', $Time, ' is out ',$this->Limit);
      $Prev=$this;
      While($Prev=$Prev->Prev?->Get())
         $Prev->Limit+=$Time;
    }

    Protected Function _Add()
    {
      if(Static::$Current?->Get()===$this || $this->Prev || $this->Next)
      {
        $this->Log('Error', 'Adding: LimitTime is busy')->BackTrace();
        $this->Remove();
      }
      
      $this->Prev=Static::$Current;
      $Weak=WeakReference::Create($this); //$this->Weak;
      Static::$Current=$Weak;
      if($this->Prev)
        $this->Prev->Get()->Next=$Weak;
    }
    
    Protected Function _Remove()
    {
      $IsCurrent=Static::$Current?->Get()===$this;

      $Prev=$this->Prev; $this->Prev=Null;
      $Next=$this->Next; $this->Next=Null;

      if($IsCurrent)
        Static::$Current=$Prev;
      else
        $this->Log('Error', 'Removing: LimitTime is not current: ', Static::$Current?->Get()->GetPath())->BackTrace();
      
      if($Prev) $Prev->Get()->Next=$Next;
      if($Next) $Next->Get()->Prev=$Prev;
    }
  }
?>