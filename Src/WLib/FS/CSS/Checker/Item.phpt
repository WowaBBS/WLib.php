<?
  Class T_FS_CSS_Checker_Item
  {
    Var $Checker ;
    Var $Next    =[]; //<List of nodes
    Var $Events  =[];
    
    Function __Construct($Checker=Null, $Event=Null)
    {
      $this->Checker=$Checker;
      $this->AddEvent($Event);
    }
    
    Function CreateSub($Checkers, $Event)
    {
      If(!$Checkers)
        Return $this->AddEvent($Event);
      $Checker=Array_Shift($Checkers);
      
      If($Checker->IsEnd())
        $this->AddEvent($Event);
    
      $Id=$Checker->GetId();
      $Item=$this->Next[$Id]??=New Static($Checker, $Checkers? Null:$Event);
      $Item->CreateSub($Checkers, $Event);
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
        $this->AddToMapSub($Map);
    }
    
    Function AddToMapSub($Map)
    {
      ForEach($this->Next As $Next)
        $Next->AddToMap($Map);
    }
    
    Function Process($Map, $Node)
    {
    //$this->Log('Debug', 'Process ', $Node->Name);
      $Checker=$this->Checker;
      If($Checker->IsRec() && $Node->IsDir())
      {
        $Map->AddItem($this);
      }
      If($Checker->Check($Node))
      {
        ForEach($this->Events As $Event)
          $Event();
        
        ForEach($this->Next As $Next)
          $Map->AddItem($Next);
      }
    }

    Function Log(...$Args) { Return $GLOBALS['Loader']->Log(...$Args); }
  }
