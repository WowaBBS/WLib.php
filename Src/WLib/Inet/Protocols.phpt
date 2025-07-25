<?
  //*************************************************************************\\
  // Модуль : TProtocols                                                     \\
  // Тип    : Unit                                                           \\
  // Создан : 29.07.2002                                                     \\
  // Автор  : Савин Владимир Иванович                                        \\
  // e-mail : wowa_savin@mail.ru                                             \\
  // fido   : 2:5057/21.69 & 2:5057/21.777                                   \\
  //*************************************************************************\\
 
  Class T_Inet_Protocols //T_Uri_Url_Protocols
  {
    Var $Prot2Port = [];
    Var $Port2Prot = [];
    Var $Prot2Add  = [];
    Var $Add2Prot  = [];
    
    Static Function Get()
    {
      Static $Instance=null;
      if($Instance)
        return $Instance;
      return $Instance=new Self();
    }
  
    Function __Construct()
    {
      $this->AddProt('pop3'  ,  110);
      $this->AddProt('smtp'  ,   25);
      $this->AddProt('http'  ,   80);
      $this->AddProt('ftp'   ,   24);
      $this->AddProt('mysql' , 3306);
      $this->AddProt('rtmpt' ,   80);
   
      $this->AddP2A('ftp'  ,'ftp' );
      $this->AddP2A('http' ,'www' );
      $this->AddP2A('pop'  ,'pop' );
      $this->AddP2A('pop3' ,'pop' );
      $this->AddP2A('APop' ,'pop' );
      $this->AddP2A('SMTP' ,'smtp');
    }
  
    Function AddProt($Prot, $Port)
    {
      $Prot=StrToLower($Prot);
      $this->Prot2Port[$Prot]=$Port;
      $this->Port2Prot[$Port]=$Prot;
    }
  
    Function Prot2Port($Data, $Data2='tcp')
    {
      $Data=StrToLower($Data);
      If(IsSet($this->Prot2Port[$Data]))
        Return $this->Prot2Port[$Data];
      Return GetServByName($Data, $Data2);
    }
  
    Function Port2Prot($Data)
    {
      If(IsSet($this->Port2Prot[$Data]))
        Return $this->Port2Prot[$Data];
      Return GetServByPort((Int)$Data, 'tcp');
    }
  
    Function AddP2A($Prot, $Add)
    {
      $Prot = StrToLower($Prot );
      $Add  = StrToLower($Add  );
      $this->Prot2Add[$Prot]=$Add;
      $this->Add2Prot[$Add]=$Prot;
      $t=$this->Prot2Port($Prot, 'tcp');
      If(IsSet($t))
      {
        $this->Prot2Add[$t]=$Add;
        $this->Add2Prot[$Add]=$t;
      }
      $t=$this->Port2Prot($Prot);
      If(IsSet($t))
      {
        $this->Prot2Add[$t]=$Add;
        $this->Add2Prot[$Add]=$t;
      }
    }
  
    Function Prot2Add($Data)
    {
      $Res=$this->Prot2Add[StrToLower($Data)];
      If($Res)
        Return $Res;
      Return $Data;
    }
  
    Function Add2Prot($Data)
    {
      $Res=$this->Add2Prot[StrToLower($Data)];
      If($Res)
        Return $Res;
      Return $Data;
    }
  }
?>