<?  
  Class T_System_Thread_PThreads_Worker Extends Thread
  {
    Var $Proc;
    Var $Args;
    
    Function __Contruct($Proc, $Args) { $this->Proc=$Proc; $this->Args=$Args; }
    Function Run() { $this->Proc(...$this->Args); }
  }
?>