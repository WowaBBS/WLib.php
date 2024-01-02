<?
  Class T_FS_CSS_Checker_Item
  {
    Var $Checker ;
    Var $Next    =[]; //<List of nodes
    Var $Events  =[];
    
    Function __Construct($Checkers=[], $Event=Null)
    {
      If($Checkers)
        $this->Create($Checkers, $Event);
    }
    
    Function Create($Checkers, $Event)
    {
      $Checker=Array_Shift($Checkers);
      If($this->Checker && $this->Checker!==$Checker)
        Return $this->Log('Fatal', 'Checker wrong')->Ret();
      $this->Checker=$Checker;
      $this->ChreateSub($Checkers, $Event);
    }
    
    Function ChreateSub($Checkers, $Event)
    {
      If(!$Checkers)
        Return $this->AddEvent($Event);
      $Checker=$Checkers[0];
      
      If($Checker->IsEnd())
        $this->AddEvent($Event);
    
      $Id=$Checker->GetId();
      $Item=$this->Next[$Id]??=New Static();
      $Item->Create($Checkers, $Event);
    }
    
    Function AddEvent($Event)
    {
      If($Event)
        $this->Events[]=$Event;
    }
    
    Function AddToMap($Map)
    {
      $Checker=$this->Checker;
      $Checker->AddToMap($Map, Spl_Object_Id($this), $this);
      If($Checker->IsRec())
        ForEach($this->Next As $Next)
          $Next->AddToMap($Map);
    }
    
    Function Process($Map, $Node)
    {
    //$this->Log('Debug', 'Process ', $Node->Name);
      $Checker=$this->Checker;
      If(!$Checker->Check($Node)) Return;
      
      ForEach($this->Events As $Event)
        $Event();
      
      ForEach($this->Next As $Next)
        $Map->AddItem($Next);
    }

    Function Log(...$Args) { Return $GLOBALS['Loader']->Log(...$Args); }
  }
