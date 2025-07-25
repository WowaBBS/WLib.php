<?
  $Loader->Load_Type('/Inet/HTTP/GetRequest');
  $Loader->Load_Type('/Inet/Protocols');
  $Loader->Load_Type('/FS/Path');
 
  Class T_Inet_Url Implements Stringable
  {
    Var $URL      ; // Full address URL Protocol://User:Password@Domain:Port/Path?Param#ID
  // Parsed
    Var $Protocol ;
    Var $User     ;
    Var $Password ;
    Var $Domain   ;
    Var $Port     ;
    Var $Path     ;
    Var $Param    ;
    Var $ID       ;
    Var $ProtIP   ; // Protocol
  // Other
    Var $DefPort  ; // Default port
    
    Static Function Create($URL=False, $URL1=False)
    {
      Return New Self($URL, $URL1);
    }
 
    Function __Construct($URL=False, $URL1=False)
    {
      $this->Clear();
      If($URL1 !==False) $this->Assign($URL1 );
      If($URL  !==False) $this->Assign($URL  );
    }
 
    Function _Debug_Serialize(&$Res)
    {
      $Res=$this->ToString();
    }
    
    Function _Clone()
    {
      $Res=Static::Create();
      $Res->Assign_Object($this);
      Return $Res;
    }
 
    Function Clear()
    {
      $this->URL      ='';
      $this->Protocol ='';
      $this->User     ='';
      $this->Password ='';
      $this->Domain   ='';
      $this->Port     = 0;
      $this->Path     =T_FS_Path::Create();
      $this->Param    =New T_Inet_HTTP_GetRequest();
      $this->ID       =False;
      $this->ProtIP   ='tcp';
      $this->DefPort  =0;
    }
 
    Function Assign_Object($URL) // TODO: CLone?
    { // TODO: Remove casting to bool
      If($URL->URL      ) $this->URL      =$URL->URL      ;
      If($URL->Protocol ) $this->Protocol =$URL->Protocol ;
      If($URL->User     ) $this->User     =$URL->User     ;
      If($URL->Password ) $this->Password =$URL->Password ;
      If($URL->Domain   ) $this->Domain   =$URL->Domain   ;
      If($URL->Port     ) $this->Port     =$URL->Port     ;
  
      If(!$URL->Path->IsEmpty())
        If($URL->Path->IsRoot())
          $this->Path->Assign($URL->Path);
        Else
          $this->Path->Add($URL->Path);
    //If($URL->Param   )
                         $this->Param->Clear();
                         $this->Param->Assign($URL->Param->ToString());
      If($URL->ID      ) $this->ID       = $URL->ID       ;
      If($URL->ProtIP  ) $this->ProtIP   = $URL->ProtIP   ;
      If($URL->DefPort ) $this->DefPort  = $URL->DefPort  ;
    }
 
    // $CDom
    //   NULL  - Auto detect Url type, if it can be domain or path
    //   True  - The Url is a Domain likely
    //   False - The Url is a Path   likely
    Function Assign_String($URL, $CDom=Null)
    {
    //$this->Clear();
      $this->URL=$URL;
      // Extract Id
      $Matches=Explode('#', $URL, 2);
      $URL=$Matches[0];
      If(IsSet($Matches[1]))
        $this->ID=$Matches[1];
      Else
        $this->ID='';
      If($URL==='')
        Return;
      // Extract request parameters
      $Matches=Explode('?', $URL, 2);
      $URL=$Matches[0];
      $this->Param->Clear();
      If(IsSet($Matches[1]))
        $this->Param->Assign($Matches[1]);
      // Extract Protocol
      If($t=Preg_Match('/^(\w+):(?:\\/\\/)?(.*)$/', $URL, $Matches))
      {
        $this->Protocol=$Matches[1];
        If(!$this->DefPort)
        {
          $Protocols=T_Inet_Protocols::Get();
          $this->DefPort=$Protocols->Prot2Port($this->Protocol);
        }
        $URL=$Matches[2];
        $CDom=True;
      }
      $Matches=Explode('/', $URL, 2);
      If($CDom===Null)
      { //Detecting the type of the Url
      //$Matches[0] In['', '.', '..']
        $CDom=False; //Always Path !!!
      }
      // Extract Path
      If($CDom)
      {
        $URL  =$Matches[0];
        $Path =IsSet($Matches[1])? '/'.$Matches[1]:'';
      }
      Else
      {
        $Path =$URL;
        $URL  ='';
      }
      // Set the Path
      If($Path!=='')
      {
        If($Path[0]=='/')
          $this->Path->Assign($Path);
        Else
          $this->Path->Add($Path);
      //If($this->Path->Path)
      //  $this->Path->Add($Path);
      //Else
      //  $this->Path->Add('/'.$Path);
      }
      If($URL==='')
        Return;
      // Extract UserName and Password
      $Matches=Explode('@', $URL, 2);
      If(!IsSet($Matches[1]))
        $URL=$Matches[0];
      Else
      {
        $URL=$Matches[1];
        $Matches=Explode(':', $Matches[0]);
        $this->User=$Matches[0];
        If(IsSet($Matches[1]))
          $this->Password=$Matches[1];
      }
  
      // Extract Port
      $Matches=Explode(':', $URL, 2);
      If(!IsSet($Matches[1]))
        $this->Port=$this->DefPort;
      Else
      {
        $this->Port=(Int)$Matches[1]; // TODO: If numeric
        $URL=$Matches[0];
      }
      If($URL)
        $this->Domain=$URL;
    }
 
    Static Function _Def_Hash()
    {
      Return [
        'URL'      =>'',
        'Protocol' =>'',
        'User'     =>'',
        'Password' =>'',
        'Domain'   =>'',
        'Port'     => 0,
        'Path'     =>[],
        'Param'    =>[],
        'ID'       =>False,
        'ProtIP'   =>'tcp',
        'DefPort'  => 0,
      ];
    }
 
    Static Function _Null_Hash()
    {
      Return [
        'URL'      =>False,
        'Protocol' =>False,
        'User'     =>False,
        'Password' =>False,
        'Domain'   =>False,
        'Port'     =>False,
        'Path'     =>[],
        'Param'    =>[],
        'ID'       =>False,
        'ProtIP'   =>False,
        'DefPort'  =>False,
      ];
    }
 
    Function Assign_Array($URL)
    {
      $D=$this->_Null_Hash();
      ForEach($D As $k=>$v)
        If(!IsSet($URL[$k]))
          $URL[$k]=$v;
  
      If($URL['URL'      ]) $this->URL      =$URL['URL'      ];
      If($URL['Protocol' ]) $this->Protocol =$URL['Protocol' ];
      If($URL['User'     ]) $this->User     =$URL['User'     ];
      If($URL['Password' ]) $this->Password =$URL['Password' ];
      If($URL['Domain'   ]) $this->Domain   =$URL['Domain'   ];
      If($URL['Port'     ]) $this->Port     =$URL['Port'     ];
  
      If($URL['Path'])
        If($URL['Path'][0]==='')
          $this->Path->Assign($URL['Path']);
        Else
          $this->Path->Add($URL['Path']);
      //If($URL->Param   )
      $this->Param->Clear();
      If($URL['Param'])
        $this->Param->Assign($URL['Param']);
      $this->ID       = $URL['ID'      ];
      If($URL['ProtIP'  ]) $this->ProtIP   = $URL['ProtIP'  ];
      If($URL['DefPort' ]) $this->DefPort  = $URL['DefPort' ];
    }
 
    Function As_Hash()
    {
      $Res=[
        'URL'      =>$this->URL      ,
        'Protocol' =>$this->Protocol ,
        'User'     =>$this->User     ,
        'Password' =>$this->Password ,
        'Domain'   =>$this->Domain   ,
        'Port'     =>$this->Port     ,
        'Path'     =>$this->Path  ->As_Array(),
        'Param'    =>$this->Param ->As_Array(),
        'ID'       =>$this->ID       ,
        'ProtIP'   =>$this->ProtIP   ,
        'DefPort'  =>$this->DefPort  ,
      ];
      $D=$this->_Def_Hash();
      ForEach($D As $k=>$v)
        If($Res[$k]===$v)
          UnSet($URL[$k]);
      Return $Res;
    }
 
    Function Assign($URL, $Z=Null)
    {
      $this->Clear();
      Switch(GetType($URL))
      {
      Case 'object' : $this->Assign_Object ($URL, $Z); Break;
      Case 'string' : $this->Assign_String ($URL, $Z); Break;
      Case 'array'  : $this->Assign_Array  ($URL, $Z); Break;
      Default: FAbstract();
      }
    }
 
    Function __toString() { return $this->ToString(); }
    
    Function ToString()
    {
      $Res=[];
      If($this->Domain)
      {
        If($this->Protocol) { $Res[]=$this->Protocol; $Res[]='://'; }
        If($this->User || $this->Password)
        {
          $Res[]=$this->User;
          If($this->Password) { $Res[]=':'; $Res[]=$this->Password; }
          $Res[]='@';
        }
        $Res[]=$this->Domain;
        If($this->Port && $this->Port!==$this->DefPort) { $Res[]=':'; $Res[]=$this->Port; }
      }
      If(!$this->Path->IsEmpty())
        $Res[]=$this->Path->ToUrl();
      $Get=$this->Param->ToString();
      If($Get      ) { $Res[]='?'; $Res[]=$Get      ; }
      If($this->ID ) { $Res[]='#'; $Res[]=$this->ID ; }
      Return Implode('', $Res);
    }
 
    Function PathFrom($AURL, $Cs=False)
    {
      If(StrCaseCmp($this->Protocol ,$AURL->Protocol )!=0) Return False; //Cs
      If(StrCaseCmp($this->Domain   ,$AURL->Domain   )!=0) Return False; //Cs
      If($this->User     !=$AURL->User     ) Return False;
      If($this->Password !=$AURL->Password ) Return False;
      If($this->Port     !=$AURL->Port     ) Return False;
      $this->Protocol ='';
      $this->Domain   ='';
      $this->User     ='';
      $this->Password ='';
      $this->Port     = 0;
  
      $this->URL      ='';
  
      $this->Path->PathFrom($AURL->Path, False, $this->ID!==False || $this->Param->Params);
  
    //$this->ID       =False;
      $this->ProtIP   ='tcp';
      $this->DefPort  =0;
      Return True;
    }
  }

  //Doesn't work in PHP8.4 #[Deprecated("Use T_Inet_Url As TUrl;")]
  Class TUrl Extends T_Inet_Url {}
?>