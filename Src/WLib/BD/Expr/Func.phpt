<?
  $this->Load_Type('/BD/Expr/Array');
  
  Class T_BD_Expr_Func extends T_BD_Expr_Array
  {
    Var $Func=''; // Callable
    Var $ArgsNum=0;
    
    Static Function Create($Factory, $Rec, $Arr)
    {
      $Res=new Self();
      $Res->ArgsNum =$Rec['Args'][0];
      $Res->Func    =$Rec['Args'][1];
      if($Res->ArgsNum===1 && Count($Arr)>1 && Is_String($Arr[0]))
        $Arr=[$Arr];
      if($Res->ArgsNum>=0 && Count($Arr)!==$Res->ArgsNum)
        $Factory->Log('Error', 'Count arguments for ',$this->Func, ' is wrong: ', Json_Encode($Arr, $this->Flags, JSON_UNESCAPED_SLASHES));
      $Res->List    =$Factory->CreateArray($Arr);
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