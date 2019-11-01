<?
  $this->Load_Type('/BD/Expr/Base');

  Class T_BD_Expr_Arg extends T_BD_Expr_Base
  {
    Var $Name=''; // String|Int
    
    Static Function Create($Factory, $Rec, $Arr)
    {
      $Res=new Self();
      $Res->Name=Array_Shift($Arr);
      if($Arr)
        $Factory->Log('Fatal', '');
      return $Res;
    }
    
    Function Calc(Array $Rec=[], Array $Args=[])
    {
      return $Args[$this->Name];
    }
    
    Function __ToString()
    {
      return '@'.$this->Name;
    }
  }
?>