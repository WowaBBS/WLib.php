<?
  $Loader->Load_Interface('/Debug/Custom');
  
  Use T_Debug_Column As Column ;
  Use T_Debug_Table  As Table  ;

  Class T_Debug_Table Implements I_Debug_Custom
  {
    Var $Columns =[];
  //Var $Fields  =[];
    Var $List    =[];
    
    Static Function Cr(Array $List) //TODO: Add $Columns and $Args
    {
      Return New Static($List);
    }
    
    Static Function ToMap(Array $List)
    {
      If(!$List) Return $List;
      $Columns=Null;
      $Res=[];
      $Next=0;
      ForEach($List As $Key=>$Rec)
      {
        If(Is_Int($Key))
          If($Next===$Key)
          {
            $Key=Null;
            $Next++;
          }
          Else
            $Next=Null;
          
        If(!Is_Array($Rec)) Continue;
        
        If($Columns===Null) { $Columns=$Rec; Continue; }
        $Row=[];
        ForEach($Rec As $k=>$v)
          $Row[$Columns[$k]?? $k]=$v;
        If($Key===Null)
          $Res[]=$Row;
        Else
          $Res[$Key]=$Row;
      }
      
      Return $Res;
    }
    
    Function __Construct($List) //TODO: Add $Columns and $Args
    {
      // Create columns
      $ColumnKey=New Column('#');
      $Columns=$this->GetColumns($List, $ColumnKey);

      $Res=[];
      ForEach($List As $Key=>$Item)
      {
        $Rec=[];
        $ColumnKey->Rec_Pack($Rec, $Key);
        ForEach($Columns As $Column)
          $Column->Rec_Pack_Row($Rec, $Item);
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
    
    Function GetColumns($List, $Prev)
    {
      $Map=[];
      ForEach($List As $Key=>$Item)
        ForEach($Item As $k=>$v)
          $Map[$k]??=True;

      $Columns=[];
      ForEach($Map As $Name=>$Tmp)
        $Columns[]=$Prev=New Column($Name, $Prev);
      
      Return $Columns;
    }
    
  //****************************************************************
  // Interface I_Debug_Custom
  
    Function Debug_Write_Columns(C_Log_Format $To)
    {
      ForEach($this->Columns As $Column)
        $Column->Debug_Write_Header($To);
    }
    
    Function Debug_Write(C_Log_Format $To)
    {
      $To("\n", 'NewLine');
      $this->Debug_Write_Columns($To);
      
      $Columns=$this->Columns;
      ForEach($this->List As $Rec)
      {
        $To("\n", 'NewLine');
        ForEach($this->Columns As $Column)
          $Column->Debug_Write_Rec($To, $Rec);
      }
    }
  //****************************************************************
  }

  Class T_Debug_Column
  {
    Var $Idx   =    0;
    Var $Key   =   '';
    Var $Name  =   '';
    Var $Align = Null; // 0.1
    Var $Size  =    0;
    Var $Split =  ' ';
    
    Function __Construct($Key, $Prev=Null)
    {
      $this->Idx  =$Prev? $Prev->Idx+2:0;
      $this->Key  =$Key  ;
      $this->Name =$Key  ;
      $this->Size =StrLen($Key);
    }
    
    Function Rec_Pack(&$Rec, $Value)
    {
      $Idx=$this->Idx;
      $Type=GetType($Value);
      Switch($Type)
      {
      Case 'boolean': $Value=$Value? 'True':'False'; Break;
    //Case 'null'   : $Value='Null'; Break;
      Default: $Value=(string)$Value;
      }
      
      $Rec[$Idx  ]=$Value ;
      $Rec[$Idx+1]=$Type  ;
    }
    
    Function Rec_Pack_Row(&$Rec, $Item)
    {
      $this->Rec_Pack($Rec, $Item[$this->Key]?? Null);
    }
    
    Function UpdateSize($s)
    {
      $this->Size=Max($this->Size, StrLen($s));
    }
    
    Static $Tabs=[];
    
    Static Function Tab($Len) { Return Static::$Tabs[$Len]??=Str_Repeat(' ', $Len); }
    
  //****************************************************************
  // Interface I_Debug_Custom
  
    Function Debug_Write_Value(C_Log_Format $To, $Value, $Type, $Class=Null)
    {
      $Add=$this->Size-StrLen($Value);

      Switch($Type)
      {
      Case 'integer' : $Align=1; $Class??='Num'   ; Break;
      Case 'double'  : $Align=1; $Class??='Num'   ; Break;
      Case 'boolean' : $Align=0; $Class??='Resvd' ; Break;
    //Case 'null'    : $Align=0; $Class??='Resvd' ; $Value='Null'; Break;
      Default        : $Align=0; $Class??='Str'   ; Break;
      }
      
      $LAdd=Round($Add*$Align);
      $RAdd=$Add-$LAdd;
      
      If($LAdd>0) $To(Static::Tab($LAdd), 'Def');
      $To($Value, $Class);
      If($RAdd>0) $To(Static::Tab($RAdd), 'Def');
      $To($this->Split, 'Def');
    }
    
    Function Debug_Write_Header(C_Log_Format $To)
    {
      $this->Debug_Write_Value($To, $this->Name, 'string', 'Resvd');
    }
    
    Function Debug_Write_Rec(C_Log_Format $To, $Rec)
    {
      $Idx=$this->Idx;
      $Value =$Rec[$Idx  ]?? '';
      $Type  =$Rec[$Idx+1]?? '';

      $this->Debug_Write_Value($To, $Value, $Type);
    }
  
  //****************************************************************
  }
  
?>