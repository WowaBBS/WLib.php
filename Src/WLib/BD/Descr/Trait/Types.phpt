<?
  $Loader->Load_Type('/BD/Descr/Trait/Args'); // TODO: Load_Trait
  
  Trait T_BD_Descr_Trait_Types
  {
    Use T_BD_Descr_Trait_Args;
    Var $Types  =[];
    
    Function Create_Type($Name, $Descr)
    {
      $Type=$this->Get_Type($Descr);
      if(IsSet($this->Types[$Name]))
        $this->Log('Error', 'Type ', $Name, ' already exists');
      return $this->Types[$Name]=$Type;
    }

    Function Create_Enum($Name, $List)
    {
    //$Type=$this->Create_Object('/BD/Descr/Type/Enum', ['Descr'=>$List, 'TypeName'=>$Name]);
      $Type=$this->Create_Object('/BD/Descr/Type/Enum', ['Values'=>$List, 'TypeName'=>$Name]);
      if(IsSet($this->Types[$Name]))
        $this->Log('Error', 'Type ', $Name, ' already exists');
      return $this->Types[$Name]=$Type;
    }

    Function Update_Enum($Name, $List)
    {
      if(($Type=$this->Types[$Name]?? null)&& $Type->IsEnum())
        $Type->Update_Descr($List);
      else
        $this->Log('Fatal', 'Type ', $Name, ' not found');
    }
  
    Function Get_Type($Descr)
    {
      if(Is_String($Descr))
        $Descr=[$Descr];
      $TypeName=Static::Args_PopOrGet($Descr, 'Type');
      if(!$TypeName)
      {
        $this->Log('Fatal', 'TypeName is null')->Debug($Descr);
        return null;
      }
      
      if($Type=$this->Types[$TypeName]?? False)
        return $Type->Create($Descr);
      if($Type=$this->Get_Singleton('/BD/Descr/Type/'.$TypeName, [], ['Safe'=>True]))
        return $Type->Create($Descr);
        
      if($Parent=$this->Types_GetParent())
      {
        $Descr['Type']=$TypeName; // TODO???
        return $Parent->Get_Type($Descr);
      }
        
      $this->Log('Error', 'TypeName ', $TypeName, ' not found')->Debug($Descr);
      return null;
    }
    
    Abstract Function Types_GetParent();

  }
?>