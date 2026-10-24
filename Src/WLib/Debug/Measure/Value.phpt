<? NameSpace WLib\Debug\Measure;
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  $Loader->Load_Interface('/Debug/Custom');
  $Loader->Load_Type('/Debug/Item');
  $this->Load_Type('/Debug/Measure/Rules');
  
  Function Size      (Int $Size) { Return SizeBytes($Size); }
  Function SizeBytes (Int $Size) { Return Value($Size, 'SizeBytes'); }
  Function Time      (Float|Int $Time) { Return Value($Time, 'Time'); }
  Function Value     (Float|Int $Size, $Type='Default') { Return New T_Value($Size, $Type); }
  
  Class T_Value Implements \WLib\Debug\I_Custom
  {
    Var Float|Int $Value =0;
    Var String    $Type  ='Default';
    Var ?Array    $List;
    
    Function __Construct(Float|Int $Value, String $Type='Default')
    {
      $this->Value = $Value ;
      $this->Type  = $Type  ;
    }
    
    Function GetList() { Return $this->List??=$this->MakeList(); }
    
    Function MakeList()
    {
      $v = $this->Value;
      
      $Rules=T_Rules::Get($this->Type);
      
      $Res=[];
      If($v<0)
      {
        $Res[]='-';
        $v=-$v;
      }
      
      $Rule=$Rules->Find($v);
    //Logger::Debug('Found', ['Value'=>$v, 'Rule'=>$Rule]);
      $Rule->ToDebug($v, $Res);
      
      Return $Res;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(\WLib\Log\C_Format $To)
    {
      ForEach($this->GetList() As $v)
        $To($v);
    }
  }
?>