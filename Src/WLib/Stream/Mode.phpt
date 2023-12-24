<?
  Class T_Stream_Mode
  {
    Var $Read      =False;
    Var $Write     =False;

    Var $Exclusive =False; // Взаимоисключение
    Var $Shareable =False; // Разделённый

    Var $Create    =False; // Создаёт файл, если он не существует
    Var $NotExist  =False; // Открывает не существующий файл
    Var $Exist     =False; // Открывает существующий файл
    Var $Clear     =False; // Делает нулевой размер файла
    Var $Append    =False; // Переносит указатель в конец файла
    Var $MakePath  =False; // Create path

    Var $Binary    =False; // Двоичные данные
    Var $Text      =False; // Текстовые данные
    
    Static Function New($Mode, $Logger=Null)
    {
      If($Mode InstanceOf Static) Return $Mode;
      Return New Static($Mode, $Logger);
    }
    
    Function __Construct($Mode, $Logger=Null)
    {
      $this->Set($Mode, $Logger);
    }
    
    Function Set($Mode, $Logger=Null)
    {
      Switch(GetType($Mode))
      {
      Case 'integer' : $this->SetInt($Mode, $Logger); Break;
      Case 'string'  : $this->SetStr($Mode, $Logger); Break;
      Case 'array'   : $this->SetArr($Mode, $Logger); Break;
      }
    }
    
    Function SetInt($v, $Logger=Null)
    {
      If($v&omRead      ) $this->Read      =True;
      If($v&omWrite     ) $this->Write     =True;

      If($v&omExclusive ) $this->Exclusive =True;
      If($v&omShareable ) $this->Shareable =True;
                                           
      If($v&omCreate    ) $this->Create    =True;
      If($v&omNotExist  ) $this->NotExist  =True;
      If($v&omExist     ) $this->Exist     =True;
      If($v&omClear     ) $this->Clear     =True;
      If($v&omAppend    ) $this->Append    =True;
      If($v&omMakePath  ) $this->MakePath  =True;

      If($v&omBinary    ) $this->Binary    =True;
      If($v&omText      ) $this->Text      =True;
    }
    
    Function ToInt()
    {
      $v=0;
      
      If($this->Read      ) $v|=omRead      ;
      If($this->Write     ) $v|=omWrite     ;

      If($this->Exclusive ) $v|=omExclusive ;
      If($this->Shareable ) $v|=omShareable ;

      If($this->Create    ) $v|=omCreate    ;
      If($this->NotExist  ) $v|=omNotExist  ;
      If($this->Exist     ) $v|=omExist     ;
      If($this->Clear     ) $v|=omClear     ;
      If($this->Append    ) $v|=omAppend    ;
      If($this->MakePath  ) $v|=omMakePath  ;

      If($this->Binary    ) $v|=omBinary    ;
      If($this->Text      ) $v|=omText      ;
      
      Return $v;
    }

    Function SetStr($Mode, $Logger=Null) //OpC2W
    {
      For($i=0, $c=StrLen($Mode); $i<$c; $i++)
        Switch($Mode[$i])
        {
        Case 'r': $this->SetArray(['Read'    ,'Exists'            ]); Break;
        Case 'w': $this->SetArray(['Write'   ,'Clear'   ,'Create' ]); Break;
        Case 'a': $this->SetArray(['Write'   ,'Append'  ,'Create' ]); Break;
        Case 'x': $this->SetArray(['Write'   ,'NotExist'          ]); Break; 
        Case '+': $this->SetArray(['Read'    ,'Write'             ]); Break; //<TODO
        Case 'b': $this->SetArray(['Binary'                       ]); Break;
        Case 't': $this->SetArray(['Text'                         ]); Break;
        Default : //<TODO: Error because unknown
        }
    }
    
    Function SetArr($List, $Logger=Null)
    {
      ForEach($List As $k=>$v)
      {
        Switch(GetType($k))
        {
        Case 'integer' : $Key=$v; $Value=True; Break;
        Case 'string'  : $Key=$k; $Value=$v  ; Break;
        Default: Continue 2; //<TODO: Error
        }

        $Value=(Bool)$Value;
        Switch($Key)
        {
        Case 'Read'      : $this->Read      =$Value; Break;
        Case 'Write'     : $this->Write     =$Value; Break;

        Case 'Exclusive' : $this->Exclusive =$Value; Break;
        Case 'Shareable' : $this->Shareable =$Value; Break;

        Case 'Create'    : $this->Create    =$Value; Break;
        Case 'NotExists' : $this->NotExists =$Value; Break;
        Case 'Exists'    : $this->Exists    =$Value; Break;
        Case 'Clear'     : $this->Clear     =$Value; Break;
        Case 'Append'    : $this->Append    =$Value; Break;
        Case 'MakePath'  : $this->MakePath  =$Value; Break;

        Case 'Text'      : $this->Text      =$Value; Break;
        Case 'Binary'    : $this->Binary    =$Value; Break;
        Case 'None'      :                           Break;
        Default: ($Logger?? $GLOBALS['Loader'])->Log('Error', 'Unknown Stream Mode: ', $Key, ' Mode: ' ,$List);
        }
      }
    }

    Function ToOpenMode() //OpW2C
    {
      If($this->Read ) $Res=$this->Write? 'r+':'r'; Else
      If($this->Write) $Res=$this->Clear? 'w':'r+'; Else
                       $Res='';

      $Res.=$this->Text? 't':'b';
    //If($this->Binary) $Res.='b';
      Return $Res;
    }
    
    Function ToCommands() //OpW2CCmd
    {
      $Res=[];
      If($this->MakePath ) $Res[]=['CreatePath'];
      If($this->Exist    ) $Res[]=['Exists' ,True ];
      If($this->NotExist ) $Res[]=['Exists' ,False];
      Else                 $Res[]=['Open'   ,$this->ToOpenMode()];
      If($this->Create   ) $Res[]=['Open'   ,$this->NotExist? 'x+':'w+'];
                           $Res[]=['TestOpen'   ];
      If($this->Exclusive) $Res[]=['Lock'   ,LOCK_EX];
      If($this->Shareable) $Res[]=['Lock'   ,LOCK_SH];
      If($this->Clear    ) $Res[]=['Clear' ];
      If($this->Append   ) $Res[]=['Append'];
      Return $Res;
    }

  }
?>
