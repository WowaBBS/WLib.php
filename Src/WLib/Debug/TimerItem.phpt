<?
  class T_Debug_TimerItem
  {
    Var $Time     =0.0      ;
    Var $Count    =0        ;
    Var $Name     ='NoName' ;
    Var $Title    =''       ;
    Var $TimeStr  =''       ;
    Var $CountStr =''       ;
    
    Function MakeStr()
    {
      $this->TimeStr  =T_Debug_Timer::TimeToStr($this->Time);
      $this->CountStr =(String)                 $this->Count;
    }
    
    Function Update($Time, $Count=1)
    {
      $this->Time  +=$Time  ;
      $this->Count +=$Count ;
    }
  }
  
?>