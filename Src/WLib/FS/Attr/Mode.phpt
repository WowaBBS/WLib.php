<?
  Class T_FS_Attr_Mode
    Implements Stringable 
  {
    Public Int $Value=0;
    
    Function __Construct($v) { $this->Value=$v; }
    Static Function New(...$Args) { Return New Static(...$Args); }
    
    Static $Types=[
       1=>['p', 'Fifo'   ],
       2=>['c', 'Char'   ],
       4=>['d', 'Dir'    ],
       6=>['b', 'Block'  ],
       8=>['-', 'File'   ],
      10=>['l', 'Link'   ],
      12=>['s', 'Socket' ],
    ];
    
    Function GetType() { Return Static::$Types[$i=$this->Value>>12][1]?? 'Unknown'.$i; }
    
    Function Is_Executable () { return $this->ToInt()&1; }
    Function Is_Readable   () { return $this->ToInt()&4; }
    Function Is_Writable   () { return $this->ToInt()&2; }
    
    Function ToInt() { Return $this->Value; }
    Function ToOct() { Return DecOct($this->ToInt()); }
    
    Function ToString()
    {
      $m=$this->Value;
      $Res =Static::$Types[$m>>12][0]?? 'u';
      $Res.=Static::ToChar($m, 2);
      $Res.=Static::ToChar($m, 1);
      $Res.=Static::ToChar($m, 0);
      Return $Res; //.' '.$this->GetType();
    }
    Function __ToString() { Return $this->ToString(); }

    Static Function ToChar($m, $p)
    {
      $c=($m>>($p*3))&7;
      $r=$c&4 ?1:0;
      $w=$c&2 ?1:0;
      $x=$c&1 ?1:0;
      $z=$m&(1>>($p+9))? 1:0;
      Return 
        '-r'[$r].
        '-w'[$w].
      //($z? ($p? 'Ss':'Tt'): '-x')[$x];
        '-xTtSs'[$x+($z<<$p)];
    }
    
    Static Function _GetType($v) { Return Static::$Types[$i=$v>>12][1]?? 'Unknown'.$i; }
  //Static Function _IsLink($v) { Return $v>>12===10; }
    
  //****************************************************************
  // Debug
  
    Function ToDebug() { Return $this->ToString().' '.$this->ToOct().' '.$this->GetType(); }
    Function _Debug_Serialize(Array &$Res)
    {
      $Res=$this->ToDebug();
    }
  
  //****************************************************************
  }
?>
