<?

 If(!Function_Exists('OpW2C'))
 {
   Function OpW2C($AMode, $Try=0)
   {
     $Attr='';
     $ZR=$AMode&omRead ;
     $ZW=$AMode&omWrite;
     If($ZR&&$ZW)
       $Attr.='r+';
     ElseIf($ZR)
       $Attr.='r';
     ElseIf($ZW)
     {
       If($AMode&omClear)
         $Attr.='w';
       Else
         $Attr.='r+';
     }
     If($AMode&omText)
       $Attr.='t';
     Else
       $Attr.='b';
   //If($AMode&omBinary)
   //  $Attr.='b';
     Return $Attr;
   }

   Function OpW2CCmd($AMode, $Try=0)
   {
     $Res=[];
     If($AMode&omMakePath ) $Res[]=['CreatePath'];
     If($AMode&omExist    ) $Res[]=['Exists',True ];
     If($AMode&omNotExist ) $Res[]=['Exists',False];
     Else                   $Res[]=['Open'  ,OpW2C($AMode)];
     If($AMode&omCreate   ) $Res[]=['Open'  ,'w+'];
                            $Res[]=['TestOpen'   ];
     If($AMode&omExclusive) $Res[]=['Lock'  ,LOCK_EX];
     If($AMode&omShareable) $Res[]=['Lock'  ,LOCK_SH];
     If($AMode&omClear    ) $Res[]=['Clear' ];
     If($AMode&omAppEnd   ) $Res[]=['AppEnd'];
     Return $Res;
   }

   Function OpC2W($AMode)
   {
     $Res=0;
     For($i=0; $i<StrLen($AMode); $i++)
       Switch($AMode{$i})
       {
       Case 'r':
         $Res|=omRead     ;
         $Res|=omExists   ;
         Break;

       Case 'w':
         $Res|=omWrite    ;
         $Res|=omClear    ;
         $Res|=omCreate   ;
         Break;

       Case 'a':
         $Res|=omWrite    ;
         $Res|=omAppEnd   ;
         $Res|=omCreate   ;
         Break;

       Case 'x':
         $Res|=omWrite    ;
         $Res|=omNotExist ;
         Break;

       Case '+':
         $Res|=omRead     ;
         $Res|=omWrite    ;
         Break;

       Case 'b':
         $Res|=omBinary   ;
         Break;

       Case 't':
         $Res|=omText     ;
         Break;
       }
     Return $Res;
   }

   Define('omNotOpen'   ,0x00000000); // �� ���������      //
   Define('omReadOnly'  ,0x00000001); // ����� ������      //
   Define('omRead'      ,0x00000001); // ����� ������      //
   Define('omWriteOnly' ,0x00000002); // ����� ������      //
   Define('omWrite'     ,0x00000002); // ����� ������      //
   Define('omReadWrite' ,0x00000003); // ������/������     //

   Define('omExclusive' ,0x00000004); // ����������������  //
   Define('omShareable' ,0x00000008); // ����������       //

   Define('omCreate'    ,0x00000010); // ������ ����, ���� �� �� ���������� //
   Define('omNotExist'  ,0x00000020); // ��������� �� ������������ ����      //
   Define('omExist'     ,0x00000040); // ��������� ������������ ����         //
   Define('omClear'     ,0x00000080); // ������ ������� ������ �����         //
   Define('omAppEnd'    ,0x00000100); // ��������� ��������� � ����� �����   //
   Define('omMakePath'  ,0x00000200); // Create path                         //

   Define('omBinary'    ,0x00000400); // �������� ������                     //
   Define('omText'      ,0x00000800); // ��������� ������                    //
   Define('omRecurce'   ,0x00001000); //                                     //
 }

?>