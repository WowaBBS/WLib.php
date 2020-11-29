<?
  class T_Log_Level
  {
    Var $Index    = 0         ;
    Var $Name     = 'Debug'   ;
    Var $Show     = '[Debug]' ;
    Var $Fatal    = false     ;
    Var $Php      = E_USER_NOTICE;
    Var $Stack    = False;
    Var $Progress = False;
    
    Function __Construct($Arr)
    {
      $this->Index    =$Arr[0];
      $this->Name     =$Arr[1];
      $this->Show     =$Arr[2];
      $this->Fatal    =$Arr[3];
      $this->Php      =$Arr[4];
      $this->Stack    =$Arr[5];
      $this->Progress =$Arr[6];
    }
    
    Static Function GetList()
    {
      Static $Res=[];
      if($Res) return $Res;
      $Levels=[
        #Idx ,Name       ,Show         ,Fatal ,Php            ,Stack ,Progress
        [ 0  ,'Debug'    ,'[Debug] '   ,false ,E_USER_NOTICE  ,False ,False   ],
        [ 1  ,'Progress' , False       ,false ,E_USER_NOTICE  ,False ,True    ],
        [ 2  ,'Log'      , False       ,false ,E_USER_NOTICE  ,False ,False   ],
        [ 3  ,'Note'     ,'[Note] '    ,false ,E_USER_NOTICE  ,False ,False   ],
        [ 4  ,'Warning'  ,'[Warning] ' ,false ,E_USER_WARNING ,False ,False   ], // TODO True for some
        [ 5  ,'Error'    ,'[Error] '   ,false ,E_USER_WARNING ,False ,False   ], // TODO True for some
        [ 6  ,'Fatal'    ,'[Fatal] '   ,true  ,E_USER_ERROR   ,True  ,False   ],
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