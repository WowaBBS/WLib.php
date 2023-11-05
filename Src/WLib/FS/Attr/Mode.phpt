<?
  Class T_FS_Attr_Mode
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
    
    Function ToDebug() { Return $this->ToString().' '.$this->ToOct().' '.$this->GetType(); }
  }
?>
