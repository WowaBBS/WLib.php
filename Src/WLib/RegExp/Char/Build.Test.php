<?
  $this->Load_Class('/UnitTest/Case');
  $this->Load_Type('/FS/Attr/Mode');
  
  Use T_FS_Attr_Mode As Mode;
  
  Class Test_RegExp_Char_Build Extends C_UnitTest_Case
  {
    Function TestABC()
    {
      $Builder=$this->Get_Singleton('/RegExp/Char/Builder'); //TODO: Bug with some name of test class
      
      $Res1=$Builder->FromListWords(['abc']);
      $Res2=$Builder->FromListWords(['abc'], True  );
      $Res3=$Builder->FromListWords(['abc'], False );
      
      $Check1='abc';
      $Check2='(?:a(?:b(?:c|$)|$)|$)';
      $Check3='(?:ab?|)$';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
      $this->AssertSame($Check3, $Res3);
    }
    
    Function TestABCD()
    {
      $Builder=$this->Get_Singleton('/RegExp/Char/Builder'); //TODO: Bug with some name of test class
      
      $List=[
        'abc',
        'abd',
        'adc',
        'add',
      ];
      $Res1=$Builder->FromListWords($List);
      $Res2=$Builder->FromListWords($List, True  );
      $Res3=$Builder->FromListWords($List, False );
      
      $Check1='a[bd][cd]';
      $Check2='(?:a(?:[bd](?:[cd]|$)|$)|$)';
      $Check3='(?:a[bd]?|)$';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
      $this->AssertSame($Check3, $Res3);
    }
    
    Function TestPhp()
    {
      $Builder=$this->Get_Singleton('/RegExp/Char/Builder'); //TODO: Bug with some name of test class
      
      $List=[
      # '<?',
        '<?=',
        '<?php',
      ];
      $Res1=$Builder->FromListWords($List);
      $Res2=$Builder->FromListWords($List, True  );
      $Res3=$Builder->FromListWords($List, False );
      
      $Check1='\<\?(?:\=|php)';
      $Check2='(?:\<(?:\?(?:\=|p(?:h(?:p|$)|$)|$)|$)|$)';
      $Check3='(?:\<(?:\?(?:ph?|)|)|)$';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
      $this->AssertSame($Check3, $Res3);
      
      $List=[
        '<?',
        '<?=',
        '<?php',
      ];
      $Res1=$Builder->FromListWords($List);
      $Res2=$Builder->FromListWords($List, True  );
      $Res3=$Builder->FromListWords($List, False );
      
      $Check1='\<\?(?:\=|php|)';
      $Check2='(?:\<(?:\?(?:\=|p(?:h(?:p|$)|$)|)|$)|$)';
      $Check3='(?:\<(?:\?(?:ph?|)|)|)$';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
      $this->AssertSame($Check3, $Res3);
    }
    
    Function TestBom()
    {
      $Builder=$this->Get_Singleton('/RegExp/Char/Builder'); //TODO: Bug with some name of test class
      
      $Boms=[
        "\xEF\xBB\xBF"                     ,"\xEF\xBB" ,"\xEF",
        "\xFE\xFF"                                     ,"\xFE",
        "\xFF\xFE"                                     ,"\xFF",
        "\x00\x00\xFE\xFF" ,"\x00\x00\xFE" ,"\x00\x00" ,"\x00",
        "\xFF\xFE\x00\x00" ,"\xFF\xFE\x00" ,
      ];
      $Res1=$Builder->FromListWords($Boms);
      $Res2=$Builder->FromListWords(Array_Slice($Boms, 0, -6));
      
      $Check1='(?:\x00(?:\x00(?:\xFE\xFF?|)|)|\xEF(?:\xBB\xBF?|)|\xFE\xFF?|\xFF(?:\xFE(?:\x00\x00?|)|))';
      $Check1='(?:\000(?:\000(?:\xFE\xFF?|)|)|\xEF(?:\xBB\xBF?|)|\xFE\xFF?|\xFF(?:\xFE(?:\000\000?|)|))';
      $Check2='(?:\xEF(?:\xBB\xBF?|)|\xFE\xFF?|\xFF\xFE?)';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
    }

    Function TestBom2()
    {
      $Builder=$this->Get_Singleton('/RegExp/Char/Builder'); //TODO: Bug with some name of test class
      
      $Boms=[
        "\xEF\xBB\xBF"     ,
        "\xFE\xFF"         ,
        "\xFF\xFE"         ,
        "\x00\x00\xFE\xFF" ,
        "\xFF\xFE\x00\x00" ,
      ];
      $Res1=$Builder->FromListWords($Boms);
      $Res2=$Builder->FromListWords($Boms, True  );
      $Res3=$Builder->FromListWords($Boms, False );
      
      $Check1='(?:\000\000\xFE\xFF|\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE(?:\000\000|))';
      $Check2='(?:\000(?:\000(?:\xFE(?:\xFF|$)|$)|$)|\xEF(?:\xBB(?:\xBF|$)|$)|\xFE(?:\xFF|$)|\xFF(?:\xFE(?:\000(?:\000|$)|)|$)|$)';
      $Check3='(?:\000(?:\000\xFE?|)|\xEF\xBB?|\xFE|\xFF(?:\xFE\000?|)|)$';
      $this->AssertSame($Check1, $Res1);
      $this->AssertSame($Check2, $Res2);
      $this->AssertSame($Check3, $Res3);
    }
  }
?>