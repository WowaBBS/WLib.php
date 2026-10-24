<?
  $Loader->Load_Interface('/Debug/Custom');
  $Loader->Load_Type('/Debug/Item');
  
  Function SizeBytes (Int $Size) { Return New T_Debug_SizeBytes($Size); }
  Function Measure   (Int $Size) { Return New T_Debug_SizeBytes($Size); }
  
  Class T_Debug_Measure_Base Implements I_Debug_Custom
  [
  }

  Class T_Debug_Measure Implements I_Debug_Custom
  {
    Var  Int   $Value;
    Var ?Array $List;
    Var  Array $Rules=[
    // >      
      [ 10, 'Q' ],
      [  9, 'R' ],
      [  8, 'Y' ],
      [  7, 'Z' ],
      [  6, 'E' ],
      [  5, 'P' ],
      [  4, 'T' ],
      [  3, 'G' ],
      [  2, 'M' ],
      [  1, 'k' ,'da', 'h'],
      [  0, ''  ],
      [- 1, 'd' ,'c', 'm'],
      [- 2, 'u' ],
      [- 3, 'n' ],
      [- 4, 'p' ],
      [- 5, 'f' ],
      [- 6, 'a' ],
      [- 7, 'a' ],
      [- 8, 'y' ],
      [- 9, 'r' ],
      [-10, 'q' ],
    ];
    
    Function __Construct(Int $Value, String $Postfix)
    {
      $this->Value   = $Value   ;
      $this->Postfix = $Postfix ;
    }
    
    Function GetList() { Return $this->List??=$this->MakeList(); }
    
    Function MakeList()
    {
      $v = $this->Size;
      
      $Res=[];
      If($v<0)
      {
        $Res[]='-';
        $v=-$v;
      }
      
      ForEach($this->Rules As [$MoreThan, $Div, $Precision, $Postfix])
      {
        If($MoreThan && $v<$MoreThan) Continue;
        If($Div) $v/=$Div;
        $Type_Num='Num';
        If(!Is_Null($Precision))
          $Res[]=DebugItem(Number_Format($v, $Precision), $Type_Num);
        If($Postfix!=='')
          $Res[]=$Postfix;
        Break;
      }
      
      Return $Res;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(C_Log_Format $To)
    {
      ForEach($this->GetList() As $v)
        $To($v);
    }
  };
?>