<? NameSpace WLib\Debug\Table;
  $Loader->Load_Interface('/Debug/Custom');
  $this->Load_Type('/Debug/Table/Column');
  
  Class T_List Implements \WLib\Debug\I_Custom
  {
    Var $Columns =[];
  //Var $Fields  =[];
    Var $List    =[];
    
    Static Function Cr(Array $List, Array $Args=[]) //TODO: Add $Columns and $Args
    {
      Return New Static($List, $Args);
    }
    
    Function __Construct($List, $Args) //TODO: Add $Columns and $Args
    {
      // Create columns
      $ColumnKey=New T_Column('#', Null, $Args['Columns']['#']?? []);
      $Columns=$this->GetColumns($List, $ColumnKey, $Args['Columns']?? []);

      $Res=[];
      ForEach($List As $Key=>$Item)
      {
        $Rec=[];
        $ColumnKey->Rec_Pack($Rec, $Key);
        ForEach($Columns As $Column)
          $Column->Rec_Pack_Row($Rec, $Item);
        For($i=Count($Columns)-1; $i>=0; $i--)
          If(!$Columns[$i]->CheckEnd($Rec))
            Break;
        $Res[]=$Rec;
      }
      
      $Columns=[$ColumnKey, ...$Columns];
      
      // Calculate sizes
      ForEach($Res As $Rec)
        ForEach($Columns As $Column)
      //ForEach($Rec As $Col=>$Val)
          $Column->UpdateSize($Rec[$Column->Idx]?? '');
      
      $this->Columns = $Columns ;
      $this->List    = $Res     ;
    }
    
    Function GetColumns($List, $Prev, $Args)
    {
      $Map=[];
      ForEach($List As $Key=>$Item)
        ForEach($Item As $k=>$v)
          $Map[$k]??=True;

      $Columns=[];
      ForEach($Map As $Name=>$Tmp)
        $Columns[]=$Prev=New T_Column($Name, $Prev, $Args[$Name]?? []);
      
      Return $Columns;
    }
    
  //****************************************************************
  // Interface \WLib\Debug\I_Custom
  
    Function Debug_Write_Columns(\WLib\Log\C_Format $To)
    {
      ForEach($this->Columns As $Column)
        $Column->Debug_Write_Header($To);
    }
    
    Function Debug_Write(\WLib\Log\C_Format $To)
    {
      $To("\n", 'NewLine');
      $this->Debug_Write_Columns($To);
      
      $Columns=$this->Columns;
      ForEach($this->List As $Rec)
      {
        $To("\n", 'NewLine');
        ForEach($this->Columns As $Column)
          If($Column->Debug_Write_Rec($To, $Rec))
            Break;
      }
    }
  //****************************************************************
  }

?>