<?
  Function _Unit_Stream_MOutput()
  {
    Global $FOutput;
    $FOutput=@FOpen('php://output', 'wb');
    Stream_Set_Blocking($FOutput, False);
    Stream_Output_Lock(True);
  }
 
  Function Stream_Output_Handler($Str)
  {
    If($Str!=='')
      Trigger_Error('Output "'.$Str.'"', E_USER_WARNING); // TODO: Logger
    Return '';
  //Return $Str;
  }
 
  Function Stream_MOutput_Done()
  {
    If(Ob_List_Handlers())
      Stream_Output_UnLock(False);
    Global $FOutput;
    FClose($FOutput);
  }
 
 
  Function Stream_Output_Lock($z=True)
  {
    Static $Z=False;
    If($Z==$z)
      Return;
    If($z)
    {
      $Res=@Ob_Start('Stream_Output_Handler', 1);
    //Debug('a'.$Res);
    //Debug(ob_list_handlers());
    }
    Else
     {
    //@Ob_End_Flush();
      Ob_End_Clean();
    //Debug('b');
    //While(@Ob_End_Clean());
    }
    $Z=$z;
  }
 
  Function Stream_Output_UnLock()
  {
    Stream_Output_Lock(False);
  }
 
  Function Stream_Output_Write($Data)
  {
    Stream_Output_Lock(False);
    Global $FOutput;
    $Res=FWrite($FOutput, $Data);
    Stream_Output_Lock(True);
    Return $Res;
  }
?>