<?
  //*************************************************************************\\
  // Unit    : MEvents                                                       \\
  // Date    : 29.08.2002                                                    \\
  // Creator : Wowa Savin <wowa@activesolutions.info>                        \\
  // (c) Active solutions                                                    \\
  //*************************************************************************\\
 
  Class T_System_Delegate implements ArrayAccess
  {
    Var $List=[];
  
    //****************************************************************
    // ArrayAccess interface

    Public Function offsetExists     ($k):bool { return IsSet($this->List[$k]);   }
    Public Function offsetGet        ($k)      { return       $this->List[$k];    } 
    Public Function offsetSet        ($k ,$v)  {
      if(is_null($k))
        $this->Add($v);
      else
        $this->List[$k]=$v; // TODO: Error?
    }
    Public Function offsetUnset      ($k)      {        UnSet($this->List[$k]); }
    
    //****************************************************************
    
    Function Add($Proc)
    {
      $this->List[]=$Proc;
    }
  
    Function _Call(Array $Args) :Array
    {
      $Res=[];
      ForEach($this->List As $Handle=>$Proc)
      {
        $R=$Proc(... $Args);
        If(!Is_Null($R))
          $Res[$Handle]=$R;
        UnSet($R);
      }
      Return $Res;
    }
    
    Function Call(... $Args) :Array { return $this->_Call($Args); }
    Function __invoke(... $Args) :Array { return $this->_Call($Args); }
    
    Static Function Create(... $Args) { return new Self($Args); }
  }
  
  Class TDelegate extends T_System_Delegate {};
  
?>