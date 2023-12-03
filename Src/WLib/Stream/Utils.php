<?
  $Loader->Load_Type('/Stream/Mode'); Use T_Stream_Mode As Mode;
  
//TODO: $Loader->Log('Warning', 'Please use type /Stream/Mode instead');

  If(!Function_Exists('OpW2C'))
  {
    Function OpW2C    ($Mode) { Return Mode::New($Mode)->ToOpenMode(); }
    Function OpW2CCmd ($Mode) { Return Mode::New($Mode)->ToCommands(); }
    Function OpC2W    ($Mode) { Return Mode::New($Mode)->ToInt     (); }
    
  /*
    Function OpW2C($Mode, $Try=0)
    {
      If($Mode&omRead ) $Attr=$Mode&omWrite? 'r+':'r'; Else
      If($Mode&omWrite) $Attr=$Mode&omClear? 'w':'r+'; Else
                        $Attr='';
 
      $Attr.=$Mode&omText? 't':'b';
    //If($Mode&omBinary) $Attr.='b';
      Return $Attr;
    }
 
    Function OpW2CCmd($AMode, $Try=0)
    {
      $Res=[];
      If($AMode&omMakePath ) $Res[]=['CreatePath'];
      If($AMode&omExist    ) $Res[]=['Exists' ,True ];
      If($AMode&omNotExist ) $Res[]=['Exists' ,False];
      Else                   $Res[]=['Open'   ,OpW2C($AMode)];
      If($AMode&omCreate   ) $Res[]=['Open'   ,$AMode&omNotExist? 'x+':'w+'];
                             $Res[]=['TestOpen'   ];
      If($AMode&omExclusive) $Res[]=['Lock'   ,LOCK_EX];
      If($AMode&omShareable) $Res[]=['Lock'   ,LOCK_SH];
      If($AMode&omClear    ) $Res[]=['Clear' ];
      If($AMode&omAppend   ) $Res[]=['Append'];
      Return $Res;
    }
 
    Function OpC2W($AMode)
    {
      $Res=0;
      For($i=0; $i<StrLen($AMode); $i++)
        Switch($AMode[$i])
        {
        Case 'r': $Res|=omRead     |omExists   ; Break;
        Case 'w': $Res|=omWrite    |omClear    |omCreate   ; Break;
        Case 'a': $Res|=omWrite    |omAppend   |omCreate   ; Break;
        Case 'x': $Res|=omWrite    |omNotExist ; Break;
        Case '+': $Res|=omRead     |omWrite    ; Break;
        Case 'b': $Res|=omBinary   ; Break;
        Case 't': $Res|=omText     ; Break;
        }
      Return $Res;
    }
  */
  }
  
  Const omNotOpen   =0x00000000; // Не открывать      //
  Const omReadOnly  =0x00000001; // Толко чтение      //
  Const omRead      =0x00000001; // Толко чтение      //
  Const omWriteOnly =0x00000002; // Толко запись      //
  Const omWrite     =0x00000002; // Толко запись      //
  Const omReadWrite =0x00000003; // Чтение/запись     //
 
  Const omExclusive =0x00000004; // Взаимоисключение  //
  Const omShareable =0x00000008; // Разделённый       //
 
  Const omCreate    =0x00000010; // Создаёт файл, если он не существует //
  Const omNotExist  =0x00000020; // Открывает не существующий файл      //
  Const omExist     =0x00000040; // Открывает существующий файл         //
  Const omClear     =0x00000080; // Делает нулевой размер файла         //
  Const omAppend    =0x00000100; // Переносит указатель в конец файла   //
  Const omMakePath  =0x00000200; // Create path                         //
 
  Const omBinary    =0x00000400; // Двоичные данные                     //
  Const omText      =0x00000800; // Текстовые данные                    //
//Const omRecurce   =0x00001000; //                                     //
?>