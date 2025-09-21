<?
  $this->Load_Type('/RegExp/Node/Base/List');

  $this->Load_Type('/RegExp/Node/Base/Repeat'     ); Use T_RegExp_Node_Base_Repeat      As NodeRepeat    ;
  
  Class T_RegExp_Node_Base_Or Extends T_RegExp_Node_Base_List
  {
    Function IsOr    () { Return True; } //Count($this->List)>1
    
    Function Make($Res)
    {
      $z=False;
      ForEach($this->List As $Item)
      {
        If($z)
          $Res->Next('|');
        Else
          $z=True;
        $Res[]=$Item;
      }
    }

    Function Optimize($Optimizer, $Own)
    {
      If(($Res=Parent::Optimize($Optimizer, $Own))!==$this)
        Return $Res;
        
      $l=$this->List;
      If(Count($l)!==2)
        Return $this;
      
    //$GLOBALS['Loader']->Log('Debug', 'Or:')->Debug($l);
      
      If($l[0]->IsSolid() && $l[1]->IsEmpty()) Return New NodeRepeat($l[0], 0, 1); //TODO: Check scudge
      If($l[1]->IsSolid() && $l[0]->IsEmpty()) Return New NodeRepeat($l[0], 0, 1, '?');
      
      Return $this;
    }

  }
  