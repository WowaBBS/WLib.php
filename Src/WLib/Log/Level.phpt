<?
  class T_Log_Level
  {
    Var $Index = 0         ;
    Var $Name  = 'Debug'   ;
    Var $Show  = '[Debug]' ;
    Var $Fatal = false     ;
    Var $Php   = E_USER_NOTICE;
    Var $Stack = False;
    
    Function __Construct($Arr)
    {
      $this->Index =$Arr[0];
      $this->Name  =$Arr[1];
      $this->Show  =$Arr[2];
      $this->Fatal =$Arr[3];
      $this->Php   =$Arr[4];
      $this->Stack =$Arr[5];
    }
    
    Static Function GetList()
    {
      Static $Res=[];
      if($Res) return $Res;
      $Levels=[
        #Idx ,Name      ,Show         ,Fatal ,Php            ,Stack
        [ 0  ,'Debug'   ,'[Debug] '   ,false ,E_USER_NOTICE  ,False ],
        [ 1  ,'Log'     , False       ,false ,E_USER_NOTICE  ,False ],
        [ 2  ,'Note'    ,'[Note] '    ,false ,E_USER_NOTICE  ,False ],
        [ 3  ,'Warning' ,'[Warning] ' ,false ,E_USER_WARNING ,True  ],
        [ 4  ,'Error'   ,'[Error] '   ,false ,E_USER_WARNING ,True  ],
        [ 5  ,'Fatal'   ,'[Fatal] '   ,true  ,E_USER_ERROR   ,True  ],
      ];
      ForEach($Levels As $Level)
        $Res[]=New T_Log_Level($Level);
      return $Res;
    }
    
    Static Function GetMapByName()
    {
      Static $Res=[];
      if($Res) return $Res;
      ForEach(Static::GetList() As $Level)
        $Res[$Level->Name]=$Level;
      return $Res;
    }

    Static Function GetByName($Name, $Defailt)
    {
      $List=Static::GetMapByName();
      Return $List[$Name]?? $List[$Defailt];
    }
  }
?>