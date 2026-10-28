<? NameSpace WLib\Object;

Class T_ShutDown
{
  Var Array $List =[];
//Var $Loader { Get=>$this->Loader?->Get(); Set($v) { $this->Logger=$v? \WeakReference::Create($v):null; } }
  Var $Loader { Get=>$this->Loader?->Get(); Set=>$value? \WeakReference::Create($value):null; }
  Var $Logger { Get=>$this->Loader?? \WLib\Log\Logger::Get(); }
  
  Function __Construct($Loader=Null)
  {
    $this->Loader=$Loader;
    Register_ShutDown_Function($this->Handler_Start(...));
  }
  
  Function Add(Callable $Func, $Key=Null)
  {
    $Key ??= $Func;
    If (Is_Object($Key))
      $Key = Spl_Object_Id($Key);
    If(Array_Key_Exists($Key, $this->List))
      $this->Logger->Log('Error', 'Shutdown function has already exists')->Dump(['Old'=>$this->List[$Key],'New'=>$Func]);
    $this->List[$Key] = $Func;
  }
  
  Function Remove($KeyOrFunc)
  {
    If (Is_Object($Key))
      $Key = Spl_Object_Id($Key);
    UnSet($this->List[$Key]);
  }
  
  Function Handler_Item()
  {
    if(!$this->List) return $this->Finish();
    Register_ShutDown_Function($this->Handler_Item(...));
    $this->Run_Next();
  }
  
  Function Handler_Start()
  {
    Register_ShutDown_Function($this->Handler_Item(...));
  }
  
  Function Finish()
  {
    $this->Loader?->OnShutdown();
    $this->Loader = null;
  }
  
  Function Force()
  {
    While ($this->List)
      $this->Run_Next();
    $this->Finish();
  }
  
  Function Run_Next()
  {
    Try
    {
      $Func = Array_Pop($this->List);
      $Func();
    }
    Catch(\Throwable $e)
    {
      Try
      {
        $this->Logger->log('Error', 'ShutDown function has an exception:')
          ->Dump(['Func'=>$Func])
          ->Exception($e);
      }
      Catch(\Throwable $e) {}
    }
  }
}