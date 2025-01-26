<?
  $Loader->Load_Interface('/Debug/Custom');
  
  Function DebugList(Array $List) { Return New T_Debug_List($List); }

  Class T_Debug_List Implements I_Debug_Custom
  {
    Var $List=[];
    
    Function __Construct(Array $List)
    {
      $this->List=$List;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(C_Log_Format $To)
    {
      ForEach($this->List As $v)
        $To($v);
    }
  };
?>