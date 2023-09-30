<?php
  $Loader->Load_Type('/Type/Map/Multi');
 
  Class T_Inet_Mime_Header Extends T_Type_Map_Multi
  {
    Var $EOL="\r\n";
 
    Function Assign($Data=False)
    {
      If(Is_String($Data))
        Return $this->Parse($Data);
      Return parent::Assign($Data);
    }
 
    Function Add_Header($AHeader)
    {
      $List=$AHeader->AsArray(0,1);
      ForEach($List As $v)
        $this->Add($v[0],$v[1]);
    }
 
    Function Parse($Data)
    {
      If(!Is_Array($Data))
      {
        $Data=Str_Replace("\r\n","\n",$Data);
      //$Data=Str_Replace(["\r\n","\n\r"],"\n",$Data);
      //$Data=Str_Replace("\r","\n",$Data);
        $Data=Explode("\n",$Data);
      } 
      ForEach($Data As $Item)
        $this->ParseLine($Item);
    }
 
    Function ParseLine($v)
    {
      $v=Explode(': ', $v, 2);
      If(Count($v)===1)
        Return $this->Add('', $v[0]);
      $this->Add($v[0], $v[1]);
    }
 
    Function AsString()
    {
      $Res=[];
      ForEach($this->Values As $v)
        $Res[]=$v[0].': '.$v[1];
      $Res[]='';
      Return Implode($this->EOL, $Res);
    }
 
    Function Length()
    {
      $Res=Count($this->Values)*(2+StrLen($this->EOL));
      ForEach($this->Values As $v)
        $Res+=StrLen($v[0])+StrLen($v[1]);
      Return $Res;
    }
 
    Function Save_To_Stream(&$AStream)
    {
      $Res=[];
      $EOL=$this->EOL;
      ForEach($this->Values As $v)
        $AStream->Write($v[0].': '.$v[1].$EOL);
    }
 
    Function Load_From_Stream(&$AStream)
    {
      While(True)
      {
        $Str=$AStream->Get_Line();
        If(!$Str)
          Break;
        $this->ParseLine($Str);
      }
      Return True;
    }
    
    Static $Custom=[ //TODO: Remove?
      'CONTENT_LENGTH'         =>'Content-Length' ,
      'CONTENT_TYPE'           =>'Content-Type'   ,
      'REDIRECT_AUTHORIZATION' =>'Authorization'  ,
    //'Authorization'          =>'Authorization'  ,
    ];
    
    Static $Fix=[
      'A-Im'             =>'A-IM'             ,
      'Content-Md5'      =>'Content-MD5'      ,
      'Http2-Settings'   =>'HTTP2-Settings'   ,
      'Te'               =>'TE'               ,
      'Dnt'              =>'DNT'              ,
      'X-Att-DeviceId'   =>'X-ATT-DeviceId'   ,
      'X-Uidh'           =>'X-UIDH'           ,
      'X-Request-Id'     =>'X-Request-ID'     ,
      'X-Correlation-Id' =>'X-Correlation-ID' ,
      'Correlation-Id'   =>'Correlation-ID'   ,
      'Sec-Gpc'          =>'Sec-GPC'          ,
      'Accept-Ch'        =>'Accept-CH'        ,
      'Etag'             =>'ETag'             ,
      'Im'               =>'IM'               ,
      'P3p'              =>'P3P'              ,
      'Www-Authenticate' =>'WWW-Authenticate' ,
      'X-WebKit-Csp'     =>'X-WebKit-CSP'     ,
      'Expect-Ct'        =>'Expect-CT'        ,
      'Nel'              =>'NEL'              ,
      'X-Request-Id'     =>'X-Request-ID'     ,
      'X-Correlation-Id' =>'X-Correlation-ID' ,
      'X-UA-Compatible'  =>'X-UA-Compatible'  ,
      'X-XSS-Protection' =>'X-XSS-Protection' ,
      'Mime-Version'     =>'MIME-Version'     ,
      'Oc-Checksum'      =>'OC-Checksum'      ,
      'X-Oc-Mtime'       =>'X-OC-MTime'       ,
      'Ms-Author-Via'    =>'MS-Author-Via'    ,
    ];
    
    Static Function _GetFromServer()
    {
      ForEach($_SERVER As $Name=>$Value)
      {
        $Key=Static::$Custom[$Name]?? (SubStr($Name, 0, 5)==='HTTP_'? False:
          Static::NormKey(SubStr($Name, 5)));
        If(!Is_String($Key)) Continue;
        $Headers[$Key]=$Value;
      }
      Return $Headers;
    }
  
    Static Function GetCurrentRequest()
    {
      If(Function_Exists('GetAllHeaders'))
        Return GetAllHeaders();
      Else
        Return Static::_GetFromServer();
    }
    
    Function LoadCurrentRequest() { $this->Assign(Static::GetCurrentRequest()); }
  //Function LoadCurrentResponse() { $this->Assign(Apache_Response_Headers()); }
    Function LoadCurrentResponse() { $this->Assign(Headers_List()); }
  //Function LoadResponse() { $this->Assign($http_response_header); }
    
    Static Function NormKey($v) { $v=StrTr(UCWords(StrToLower(StrTr($v, '_-', '  '))), ' ', '-'); Return Static::$Fix[$v]?? $v;}

  //****************************************************************
  // T_Type_Map_Multi
 
    Function Get($Key) { Return Implode("\n", $this->GetList($Key)); }
    Function Put($Key, $Value) { Return $this->PutList($Key, Explode("\n", $Value)); }
    Function Add($Key, $Value) { Return $this->AddList($Key, Explode("\n", $Value)); }
    
    Function Append($Data=[])
    {
      If(Is_String($Data))
        Return $this->Parse($Data);
      
      ForEach($Data As $k=>$v)
        If(Is_Int($k))
          $this->ParseLine($v);
        Else
          $this->Add($k, $v);
    }
 
    Function _GetMapKey($v) { Return Static::NormKey($v); }
    
  //****************************************************************
  }
?>