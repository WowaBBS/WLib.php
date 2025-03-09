<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_List Extends T_RegExp_Node_Base_Base
  {
    Var $List=[];
    
    Function __Construct(Array $List=[]) { $this->List=$List; }
    
    Static Function ArgsToArgs($Args)
    {
      Switch(Count($Args))
      {
      Case 0: $Args=[[]]; Break;
      Case 1:
        If(Is_Array($Args[0]?? 0) && Is_String($Args[0][0]?? 0) || 
           Is_String($Args[0]?? 0))
          $Args=[$Args];
        Break;
      Default:
        $Args=[$Args];
      }
      Return $Args;
    }
    
    Function Optimize($Own)
    {
      If(!Parent::Optimize($Own))
        Return Null;
        
      $List=[];
      ForEach($this->List As $Item)
        If($Item=$this->Optimize_Object($Item))
          $List[]=$Item;
      $this->List=$List;
      
      If(Count($List)===0) Return Null;
      If(Count($List)===1) Return $List[0];
      
      Return $this;
    }
    
    Function Init($Res)
    {
      Parent::Init($Res);
      
      $List=[];
      ForEach($this->List As $Node)
        If($Node)
          $List[]=$Res->Node($Node);
      $this->List=$List;
    }
    
    Function Validate($Res)
    {
      ForEach($this->List As $Node)
        If(!$Res->NodeStr($Node))
          Return False;
      Return True;
    }
  }
  