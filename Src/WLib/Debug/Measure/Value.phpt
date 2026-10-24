<? NameSpace WLib\Debug\Measure;
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  $Loader->Load_Interface('/Debug/Custom'     );
  $Loader->Load_Interface('/Debug/Table/Cell' );
  $Loader->Load_Type('/Debug/Custom/Item');
  $Loader->Load_Type('/Debug/Custom/List');
  $this->Load_Type('/Debug/Measure/Rules');
  
  Function Size      (Int $Size, $Type='SizeBytes') { Return SizeBytes($Size, $Type); }
  Function SizeBytes (Int $Size, $Type='SizeBytes') { Return Value($Size, $Type); }
  Function Time      (Float|Int $Time) { Return Value($Time, 'Time'); }
  Function Value     (Float|Int $Size, $Type='Default') { Return New T_Value($Size, $Type); }
  
  Class T_Value
    Extends    \WLib\Debug\Custom\T_List
    Implements \WLib\Debug\Table\I_Cell
  {
    Var Float|Int $Value =0;
    Var String    $Type  ='Default';
    
    Function __Construct(Float|Int $Value, String $Type='Default')
    {
      $this->Value = $Value ;
      $this->Type  = $Type  ;
    }
    
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
    
    // Interface \WLib\Debug\Table\I_Cell
    Function Debug_Table_Align(&$Align):Void { $Align??=1; }
  }
?>