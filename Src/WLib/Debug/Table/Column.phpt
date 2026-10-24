<? NameSpace WLib\Debug\Table;
  $Loader->Load_Interface('/Debug/Custom');
  
  Class T_Column
  {
    Var $Idx   =    0;
    Var $Key   =   '';
    Var $Name  =   '';
    Var $Align = Null; // 0.1
    Var $Class = Null; // 0.1
    Var $Size  =    0;
    Var $Split =  ' ';
    
    Function __Construct($Key, $Prev=Null, Array $Args=[])
    {
      $this->Idx   =$Prev? $Prev->Idx+2:0;
      $this->Key   =$Key  ;
      $this->Name  =$Key  ;
      $this->Size  =StrLen($Key);
      $this->Align =$Args['Align']?? $this->Align;
      $this->Class =$Args['Class']?? $this->Class;
    }
    
    Function CheckEnd(&$Rec)
    {
      $Idx=$this->Idx;
      If($Rec[$Idx]!=='') Return False;
      $Rec[$Idx+1]='End';
      Return True;
    }
    
    Function Rec_Pack(&$Rec, $Value)
    {
      $Idx=$this->Idx;
      $Type=GetType($Value);
      Switch($Type)
      {
      Case 'boolean' : $Value=$Value? 'True':'False'; Break;
      Case 'double'  : If(!Is_Finite($Value)) { $Value=Is_InFinite($Value)? ($Value<0? '-Inf':'Inf'):'NaN'; Break; }
      Case 'object'  : If($Value InstanceOf \WLib\Debug\I_Custom) { $Type='Custom'; Break; }
    //Case 'null'   : $Value='Null'; Break;
      Default: $Value=(String)$Value;
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
  // Interface \WLib\Debug\I_Custom
  
    Function Debug_Write_Value(\WLib\Log\C_Format $To, $Value, $Type, $Class=Null, $IsEnd=False)
    {
      $Len=StrLen($Value);
      $Add=$this->Size-$Len;
      $Class??=$this->Class;
      $Align  =$this->Align;

      Switch($Type)
      {
      Case 'integer' : $Align??=1; $Class??='Num'   ; Break;
      Case 'double'  : $Align??=1; $Class??='Num'   ; Break;
      Case 'boolean' : $Align??=0; $Class??='Resvd' ; Break;
    //Case 'null'    : $Align??=0; $Class??='Resvd' ; $Value='Null'; Break;
      Case 'Custom'  :
        If($Value InstanceOf I_Cell)
          $Value->Debug_Table_Align($Align);
        Else
          $Align??=0;
      Break;
      Case 'End'     : 
        Return;
      Default        : $Align??=0; $Class??='Str'   ; Break;
      }
      
      $LAdd=Round($Add*$Align);
      $RAdd=$Add-$LAdd;
      
      If($LAdd>0) $To(Static::Tab($LAdd), 'Def');
      $To($Value, $Class);
      If($IsEnd) Return True;
      If($RAdd>0) $To(Static::Tab($RAdd), 'Def');
      $To($this->Split, 'Def');
      Return False;
    }
    
    Function Debug_Write_Header(\WLib\Log\C_Format $To)
    {
      $this->Debug_Write_Value($To, $this->Name, 'string', 'Resvd');
    }
    
    Function Debug_Write_Rec(\WLib\Log\C_Format $To, $Rec)
    {
      $Idx=$this->Idx;
      $Value =$Rec[$Idx  ]?? '';
      $Type  =$Rec[$Idx+1]?? '';
      $End   =$Rec[$Idx+3]?? 'End';

      Return $this->Debug_Write_Value($To, $Value, $Type, Null, $End==='End');
    }
  
  //****************************************************************
  }
  
?>