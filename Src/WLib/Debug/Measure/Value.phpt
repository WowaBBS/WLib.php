<? NameSpace WLib\Debug\Measure;
  $this->Load_Lib('/Log/Logger'); Use \WLib\Log\Logger;
  $Loader->Load_Interface('/Debug/Custom');
  $Loader->Load_Type('/Debug/Item');
  $this->Load_Type('/Debug/Measure/Rules');
  
  Function Size      (Int $Size) { Return SizeBytes($Size); }
  Function SizeBytes (Int $Size) { Return Value($Size, 'SizeBytes'); }
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
      
      If ($Rule->Scale !== 1)
        $v*=$Rule->Scale;
        
      $f=FMod($v, 1);
      If($f<0.01) $Precision=0; Else
      If($f<0.1 ) $Precision=1; Else
      If($v> 100) $Precision=0; Else
      If($v>  10) $Precision=1; Else
      If($v>   1) $Precision=2; Else
                  $Precision=Null;
      
      If(Is_Null($Precision))
        $Res[]=$v;
      Else
      {
        $s=Number_Format($v, $Precision);
        If($v>=1000)
          $s=StrTr($s, ',', '`');
        $Res[]=DebugItem($s, $Rules->Type_Num);
      }
      
        If(($Postfix=$Rule->Postfix)!=='')
          $Res[]=$Postfix;
      
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