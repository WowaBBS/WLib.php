<?
  class T_Debug_Timer
  {
    Var $StartTime =0        ;
    Var $Manager   =null     ;
    Var $Name      ='NoName' ;
    Var $Title     =''       ;
    Var $Logger    =null     ;
    
    Const Timer_Coef=1e-9;
  //Const Timer_Coef=1.0;
    
    Static Function GetTime()
    {
    //return MicroTime(true);
      return HrTime(true);
    }
    
    Final Function __Construct(Array $Args)
    {
    //$this->StartTime =$Args['StartTime' ]??$this->StartTime ;
      $this->Manager   =$Args['Manager'   ]??$this->Manager   ;
      $this->Name      =$Args['Name'      ]??$this->Name      ;
      $this->Title     =$Args['Title'     ]??$this->Title     ;
      $this->Logger    =$Args['Logger'    ]??$this->Logger    ;
    }
  
    Final Function __Destruct()
    {
      if($this->StartTime!==0)
        $this->Finish();
    }
    
    Function Start()
    {
      if($this->StartTime!==0)
        $this->Manager->Log('Error', $this->Name, ' timer already started');
      $this->StartTime = Static::GetTime();
      if($this->Logger)
        $this->Logger->Log('Log', $this->Name, ': Begin ', $this->Title);
    }
    
    Static Function TimeToStr($Time)
    {
      $v=Floor($Time*100);
      $Ms   =$v%100; $v=Floor($v/100); $Ms   =''.$Ms   ; if(StrLen($Ms   )<2) $Ms   ='0'.$Ms   ;
      $Sec  =$v% 60; $v=Floor($v/ 60); $Sec  =''.$Sec  ; if(StrLen($Sec  )<2) $Sec  ='0'.$Sec  ;
      $Min  =$v% 60; $v=Floor($v/ 60); $Min  =''.$Min  ; if(StrLen($Min  )<2) $Min  ='0'.$Min  ;
      $Hour =$v    ;
      return $Hour.':'.$Min.':'.$Sec.'.'.$Ms;
    }
    
    Function Finish($Coef=1)
    {
      if($this->StartTime===0)
        $this->Manager->Log('Error', $this->Name, ' timer is not started');
      $DeltaTime=(Static::GetTime()-$this->StartTime)*$Coef*Static::Timer_Coef;
      if($this->Logger)
        $this->Logger->Log('Log', $this->Name, ': Finish ', 
          Number_Format($DeltaTime, 3, '.', ''),
          ' sec'
        );
      if($this->Manager)
        $this->Manager->Update($this->Name, $DeltaTime);
      $this->StartTime=0;
    }
  }
  
?>