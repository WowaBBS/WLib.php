<?
  $this->Load_Type('/BD/Expression/Array');
  
  Class T_BD_Expression_Func extends T_BD_Expression_Array
  {
    Var $Func=''; // Callable
    
    Static Function Create($Factory, $Rec, $Arr)
    {
      $Res=new Self();
      $Res->Func=$Rec['Args'][0];
      $Res->List=$Factory->CreateArray($Arr);
      return $Res;
    }
    
    Function Calc(Array $Rec=[], Array $Args=[])
    {
      $ArgValues=Parent::Calc($Rec, $Args);
      return ($this->Func)(...$ArgValues);
    }

    Function __ToString()
    {
      return $this->Func.'('.Implode(', ', $this->List).')';
    }
  }
?>