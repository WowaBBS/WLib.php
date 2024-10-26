<?
  $Loader->Load_Interface('/Debug/Custom');
  
  Function HexDump($Data, $Args=[]) { Return New T_Debug_HexDump($Data, $Args); }

  Class T_Debug_HexDump Implements I_Debug_Custom
  {
    Var $Data   = '';
    Var $Args   = [];
    
    Var $Addr   = 0;
    Var $Tab    = '  ';
    Var $Chunk  = 16;
    
    Var $Addr_Split =' ';
    Var $Splits =[' ', ' ', ' ', ' '];
    
    Var $Cached =Null;
    
    Function __Construct($Data, $Args=[])
    {
      $this->Data=$Data;
      $this->Args=$Args;
    }
    
    Function Get() { Return $this->Cached??=$this->_Get(); }
    
    Static $DefArgs=Null;
    Static Function GetDefArgs() { Return Static::$DefArgs??=Static::_GetDefArgs(); }
    Static Function _GetDefArgs()
    {
      $Hide80=Str_Repeat(' ', 128);
      For($i=0; $i<128; $i++)
        $Hide80[$i]=Chr($i+0x80);
      return [
        'Repl'   =>Str_Repeat('.', 256),
        'Hide80' =>$Hide80,
      ];
    }

    Function _Get($Res=[])
    {
      $Data=$this->Data;
      $Args=$this->Args+Static::GetDefArgs();
      
      $Addr   =$Args['Addr'   ]??    0 ;
      $Tab    =$Args['Tab'    ]?? '  ' ;
      $Chunk  =$Args['Chunk'  ]??   16 ;
      $Hide   =$Args['Hide'   ]?? "\r\n\t\v\0\010\7\x98"; //x98 is in not in cp1251
      if(false) //TODO?
      $Hide  .=$Args['Hide80' ]; //\x80-\xFF
      $Repl   =$Args['Repl'   ];
      $Split2 =$Args['Split2' ]??    2 ;
      $Split  =$Args['Split'  ]?? [4=>'  ', 8=>' : ', 12=>'  '];
      $EnCode =$Args['EnCode' ]?? 'cp1251';
      $Addr_Align =2;
      $Addr_Min   =4;
      
      $IsInline=StrLen($Data)<=$Chunk;
      
      if($IsInline)
      {
        $Chunk=StrLen($Data);
        
        $Addr_Len=StrLen(DecHex($Addr));
        if($Addr_Len<$Addr_Min)
          $Addr_Len=$Addr_Min;
        $Addr_Len=($Addr_Len+$Addr_Align-1)&-$Addr_Align;
        $Addr_Ofs=0;
        $Tab='';
      }
      else
      {
        $Addr_End=$Addr+StrLen($Data)-$Chunk+1;
        $Addr_Len=StrLen(DecHex($Addr_End));
      //$Addr_Len=Max(StrLen(DecHex($Addr_End)), StrLen(DecHex($Addr)));
        if($Addr_Len<$Addr_Min)
          $Addr_Len=$Addr_Min;
        $Addr_Len=($Addr_Len+$Addr_Align-1)&-$Addr_Align;
        $Addr_Ofs=$Addr % $Chunk;
        $Addr-=$Addr_Ofs;
      }
      
      $Data_Len=StrLen($Data);
    //if(!$IsInline)
    //  $Res[]=['NewLine', "\n"];
      For($i=-$Addr_Ofs; $i<$Data_Len; $i+=$Chunk)
      {
        $Line=$i<0
          ?SubStr($Data, 0, $Chunk+$i) //The first time
          :SubStr($Data, $i, $Chunk);
        
        $Addr_Str=DecHex($Addr);
        $Addr_Str=StrLen($Addr_Str)>$Addr_Len
          ?SubStr($Addr_Str, 0, $Addr_Len)
          :Str_Pad(DecHex($Addr), $Addr_Len, '0', STR_PAD_LEFT);
        
        $Hex=Bin2Hex($Line);
        $Ansi=StrTr($Line, $Hide, $Repl);
        If($EnCode)
          $Ansi=IConv($EnCode, 'UTF-8', $Ansi);
        If($i<0) // The first time
        {
          $Ansi =Str_Repeat(' ', - $i    ).$Ansi ;
          $Hex  =Str_Repeat('.', -($i<<1)).$Hex  ;
        }
        ElseIf(StrLen($Line)<$Chunk) // The last time
        {
          $Hex.=Str_Repeat('.', ($Chunk-StrLen($Line))<<1);
        }
        
        if(!$IsInline)
        {
          $Res[]=['NewLine', "\n"];
          $Res[]=['Tab', $Tab];
        }
        $Res[]=['Addr', $Addr_Str];
        $Res[]=['Op', ':'];
        ForEach(Str_Split($Hex, $Split2)As $HexIdx=>$HexValue)
        {
          $Res[]=['Op', $Split[$HexIdx]?? ' '];
          $Res[]=['Hex', $HexValue];
        }
        $Res[]=['Op', ' | '];
        $Res[]=['Ansi', $Ansi];
        $Addr+=$Chunk;
      }
      return $Res;
    }
    
    // Interface I_Debug_Custom
    Function Debug_Write(C_Log_Format $To)
    {
      Static $TokenTypes=[ //TODO
        'Tab'     =>'Def'     ,
        'Op'      =>'Op'      ,
      //'Addr'    =>'Resvd'   ,
        'Addr'    =>'Num'     ,
      //'Hex'     =>'Num'     ,
        'Hex'     =>'Debug'   ,
        'Ansi'    =>'Str'     ,
        'NewLine' =>'NewLine' ,
      ];
      ForEach($this->Get() As [$Type, $Str])
        $To->_WriteToken($TokenTypes[$Type], $Str);
    }
    
    Function ToString()
    {
      $Res=[];
      ForEach($this->Get() As [$Type, $Str])
        $Res[]=$Str;
      Return Implode($Res);
    }
    
    Function __ToString() { Return $this->ToString(); }
  };
?>