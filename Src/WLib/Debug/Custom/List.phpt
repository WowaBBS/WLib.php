<? NameSpace WLib\Debug\Custom;
  $Loader->Load_Interface('/Debug/Custom');
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  
  Function DebugList(Array $List) { Return New T_Debug_List($List); }

  Class T_List Implements \WLib\Debug\I_Custom, \Stringable
  {
    //Cache
    Var ?Array  $List=Null;
    Var ?String $Text=Null;
    
    Function __Construct(?Array $List=Null)
    {
      $this->List=$List;
    }
    
    Function GetList() { Return $this->List??=$this->MakeList(); }
    Function MakeList() { Return Logger::Error('MakeList is not defined for:')->Dump($this)->Ret([]); }
    
    // Interface \WLib\Debug\I_Custom
    Function Debug_Write(\WLib\Log\C_Format $To)
    {
      ForEach($this->GetList() As $v)
        $To($v);
    }

    Function ToString() { Return $this->Text??=Join($this->GetList()); }
    
    Function __ToString() { Return $this->ToString(); }
  };
?>