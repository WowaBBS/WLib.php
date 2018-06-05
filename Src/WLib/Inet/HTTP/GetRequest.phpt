<?
  // ***************************************************************************************
 
  Class T_Inet_HTTP_GetRequest
  {
    Var $List =[];
    Var $Map  =[];
 
    Function __Construct($Str='')
    {
      If($Str)
        $this->Assign($Str);
    }
 
    Function Clear()
    {
      $this->List =[];
      $this->Map  =[];
    }
 
    Function Assign($Str='')
    {
      $Str=Explode('&', $Str);
      ForEach($Str As $v)
      {
        $p=Explode('=', $v, 2);
        $this->Add(UrlDeCode($p[0]), IsSet($p[1])? UrlDeCode($p[1]):True);
      }
    }
 
    Protected Function _Assign_Map($Key, $Data) // TODO: Remove
    {
      ForEach($Data As $k=>$v)
      {
      //If(GetType($k)=='integer')
      //  $k=$Key.'[]';
      //Else
        $k=$Key.'['.$k.']';
        If(!Is_Array($v))
          $this->Add($k, $v);
        Else
          $this->_Assign_Map($k, $v);
      }
    }
 
    Function Assign_Map($Data) // TODO: Remove
    {
      ForEach($Data As $k=>$v)
        If(!Is_Array($v))
          $this->Add($k, $v);
        Else
          $this->_Assign_Map($k, $v);
      Return True;
    }
 
 
    Function Add($Key, $Value=True)
    {
      $MapItem=&$this->Map[$Key];
      $List=&$this->List;
      $List[]=[$Key, $Value];
      End($List);
      $MapItem[]=Key($List);
    }
 
    Function Get($Key)
    {
      $V=$this->Map[$Key] ?? [];
      Return $V? $this->List[End($V)][1]:False;
    }
 
    Function Put($Key, $Value)
    {
      $this->Del($Key);
      $this->Add($Key, $Value);
      Return True;
    }
 
    Function Del($Key)
    {
      $MapList=$this->Map[$Key] ?? [];
      if(!$MapList)
        return false;
      $List=&$this->List;
      ForEach($MapList As $Idx)
        UnSet($List[$Idx]);
      UnSet($this->Map[$Key]);
      Return true;
    }
 
    Function ToString()
    {
      $Res=[];
      ForEach($this->List as $v)
        If($v[1]===True)
          $Res[]=UrlEnCode($v[0]);
        Else
          $Res[]=UrlEnCode($v[0]).'='.UrlEnCode($v[1]);
      Return Implode("&", $Res);
    }

    Function Deprecated_Length() //
    {
      Return StrLen(ToString());
    }
 
    Function Save_To_Stream($Stream)
    {
      $z=False;
      ForEach($this->List As $v)
      {
        If($z)
          If($Stream->Write('&')!=1)
            Return False;
        $z=True;
        $R=UrlEnCode($v[0]);
        If($Stream->Write($R)!=StrLen($R))
          Return False;
        $v=$v[1];
        If($v===True)
          Continue;
        If($Stream->Write('=')!=1)
          Return False;
        $R=UrlEnCode($v);
        If($Stream->Write($R)!=StrLen($R))
          Return False;
      }
      Return True;
    }
 
    Function Save_To_Mime($Mime)
    {
      ForEach($this->List As $v)
      {
        $_Part=$Mime->Create_New_Part();
        $_Part->Header->Add(
          'Content-Disposition',
        //'form-data; name="'.UrlEnCode($v[0]).'"'
          'form-data; name="'.$v[0].'"'
        );
        $v=$v[1];
        If($v===True)
          $v='';
        $_Part->Data=(String)$v;
        $_Part->_UnLock();
      }
    }
  }
 
  // ***************************************************************************************
?>