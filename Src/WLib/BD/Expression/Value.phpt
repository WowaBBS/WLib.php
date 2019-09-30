<?
  $this->Load_Type('/BD/Expression/Base');
  
  Class T_BD_Expression_Value extends T_BD_Expression_Base
  {
    Var $Value='';
    
    Static Function Create($Factory, $Rec, $Arr)
    {
      $Res=new Self();
      $Res->Value=Array_Shift($Arr);
      if(!$Arr)
        $Factory->Log('Fatal', '');
      return $Res;
    }
    
    Function Calc(Array $Rec=[], Array $Args=[])
    {
      return $this->Value;
    }

    Function __ToString()
    {
      return IsString($this->Value)? '"'.$this->Value.'"':$this->Value;
    }
  }
?>