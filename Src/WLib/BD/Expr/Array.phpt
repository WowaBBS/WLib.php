<?
  $this->Load_Type('/BD/Expr/Base');
  
  Class T_BD_Expr_Array extends T_BD_Expr_Base
  {
    Var $List=[]; // Array of T_BD_Expr_Base
    
    Static Function Create($Factory, $Rec, $Arr)
    {
      $Res=new Self();
      $Res->List=$Factory->CreateArray($Arr);
      return $Res;
    }
    
    Function Calc(Array $Rec=[], Array $Args=[])
    {
      $Res=[];
      ForEach($this->List As $k=>$v)
        $Res[$k]=$v->Calc($Rec, $Args);
      return $Res;
    }

    Function __ToString()
    {
      return '['.Implode(', ', $this->List).']';
    }
  }
?>