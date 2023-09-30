<?
  //   k1 => v1
  //   k2 => v2
  //   k1 => v3
  
  // Old name was T_Array_Hash_MKey and T_Array_MHash
 
  Class T_Type_Map_Multi Implements \ArrayAccess, \Countable, \IteratorAggregate
  {
    Var $Pairs =[];
    Var $Map   =[];
    Var $Free  =[];
 
    Function __Construct($Arr=[])
    {
      $this->Assign($Arr);
    }
 
    Function Clear()
    {
      $this->Pairs =[];
      $this->Map   =[];
      $this->Free  =[];
    }
 
    Function Assign($Data)
    {
      $this->Clear();
      $this->Append($Data);
    }
    
    Function Append($Data)
    {
      ForEach($Data As $k=>$v)
        $this->Add($k, $v);
    }
 
    Function Append_Pairs($Data, $Key=0, $Value=1)
    {
      ForEach($Data As $v)
        $this->Add($v[$Key], $v[$Value]);
    }
 
  //Function Count() { Return Count($this->Pairs); }
    Function CountBy ($Key                     ) { Return Count($this->Map[$this->_GetMapKey($Key)]?? []); }
    Function Has     ($Key                     ) { Return IsSet($this->Map[$this->_GetMapKey($Key)]); }
    Function Add     ($Key, $Value             ) { Return $this->_Add     ($this->_GetMapKey($Key), $Key, $Value       ); }
    Function Put     ($Key, $Value             ) { Return $this->_Put     ($this->_GetMapKey($Key), $Key, $Value       ); }
    Function PutIdx  ($Key, $Value, Int   $Idx ) { Return $this->_PutIdx  ($this->_GetMapKey($Key), $Key, $Value, $Idx ); }
    Function GetLast ($Key                     ) { Return $this->_GetIdx  ($this->_GetMapKey($Key)                     ); }
    Function GetIdx  ($Key,         Int   $Idx ) { Return $this->_GetIdx  ($this->_GetMapKey($Key),               $Idx ); }
    Function GetList ($Key                     ) { Return $this->_GetList ($this->_GetMapKey($Key)                     ); }
    Function PutList ($Key, Array $Value       ) { Return $this->_PutList ($this->_GetMapKey($Key), $Key, $Value       ); }
    Function AddList ($Key, Array $Value       ) { Return $this->_AddList ($this->_GetMapKey($Key), $Key, $Value       ); }
    Function Del     ($Key                     ) { Return $this->_DelIdxs ($this->_GetMapKey($Key)                     ); }
    Function DelIdx  ($Key,         Int   $Idx ) { Return $this->_DelIdxs ($this->_GetMapKey($Key),              [$Idx]); }
    Function DelIdxs ($Key,         Array $Idxs) { Return $this->_DelIdxs ($this->_GetMapKey($Key),               $Idxs); }
    
    Function Get($Key) { Return $this->GetLast($Key); }
 
    Function _GetNextIdx() { Return Array_Pop($this->Free)?? Count($this->Pairs); }
    Function _GetMapKey($v) { Return $v; }
    
    Function _Add($MapKey, $Key, $Value=True)
    {
      If(!IsSet($this->Map[$MapKey]))
        $this->Map[$MapKey]=[];
      $i=$this->_GetNextIdx() ;
      $this->Map[$MapKey][]=$i;
      $this->Pairs[$i]=[$Key, $Value];
    }
 
    Function _GetIdx($MapKey, $Idx=Null)
    {
      $v=$this->Map[$MapKey]?? [];
      $Idx=$v[$Idx?? Count($v)-1]?? Null;
      Return Is_Null($Idx)? Null:$this->Pairs[$Idx][1];
    }
 
    Function _GetList($MapKey)
    {
      $v=$this->Map[$MapKey]?? [];
      $Res=[];
      ForEach($v As $Idx)
        $Res[]=$this->Pairs[$Idx][1];
      Return $Res;
    }
 
    Function _PutList($MapKey, $Key, Array $Values)
    {
      $this->_DelIdxs($MapKey);
      $this->_AddList($MapKey, $Key, $Values);
    }
 
    Function _AddList($MapKey, $Key, Array $Values)
    {
      ForEach($Values As $Value)
        $this->_Add($MapKey, $Key, $Value);
    }
 
    Function _Put($MapKey, $Key, $Value)
    {
      $this->_DelIdxs($MapKey);
      Return $this->_Add($MapKey, $Key, $Value);
    }
    
    Function _PutIdx($MapKey, $Key, $Value, $Idx)
    {
      If(!IsSet($this->Map[$Key]))
        Return False;
      $V=$this->Map[$Key];
      If($Idx===False)
        $Idx=Count($V)-1;
      If(!IsSet($V[$Idx]))
        Return False;
      $this->Pairs[$V[$Idx]][1]=$Value;
      Return True;
    }
 
    Function _DelIdxs($MapKey, $Idxs=Null)
    {
      $H=$this->Map;
      $H=$H[$MapKey]?? [];
      If(!$H) Return 0;
      $Res=[];
      $Idxs??=Array_Keys($H);
      ForEach($Idxs As $i)
      {
        If($i<0)
          $i+=Count($H);
        If(!Is_Null($k=$H[$i]?? Null))
        {
          UnSet($this->Pairs[$k]);
          UnSet($H[$i]);
          $Res[$k]=$k;
        }
      }
      If($H)
        $this->Map[$MapKey]=Array_Values($H);
      Else
        UnSet($this->Map[$MapKey]);
      $this->Free+=$Res;
      Return Count($Res);
    }
 
    Function Get_Values($Key)
    {
      $Res=[];
      If(!IsSet($this->Map[$Key]))
        Return $Res;
      $V=$this->Map[$Key];
      ForEach($V As $R)
        $Res[]=$this->Pairs[$R];
      Return $Res;
    }
 
    Function AsArray($Key='Key',$Value='Value')
    {
      $Res=[];
      ForEach($this->Pairs As $l)
        $Res[]=[$Key=>$l[0], $Value=>$l[1]];
      Return $Res;
    }
 
    Function Iterate()
    {
      ForEach($this->Pairs As [$k, $v])
        Yield $k=>$v;
    }
 
   #/****************************************************************
   #/ Magic methods
   #
   # Function __Get   (String $k)     { return $this->Get   ($k);     }
   # Function __IsSet (String $k)     { return $this->Has   ($k);     }
   # Function __Set   (String $k, $v) {        $this->Set   ($k, $v); }
   # Function __UnSet (String $k)     {        $this->UnSet ($k);     }
  
   //****************************************************************
   // ArrayAccess interface
 
     Function OffsetExists     ($k    ):Bool  { return $this->Has($k    ); }
     Function OffsetGet        ($k    ):Mixed { return $this->Get($k    ); }
     Function OffsetSet        ($k ,$v):Void  {        $this->Put($k, $v); }
     Function OffsetUnset      ($k    ):Void  {        $this->Del($k    ); }
     
   //****************************************************************
   // Countable interface
 
     Function Count():Int { Return Count($this->Pairs); }
     
   //****************************************************************
   // IteratorAggregate interface
     
     Function GetIterator():Traversable
     {
       Return $this->Iterate(); //New T_Type_Map_Multi_Iterator($this);
     }
     
   //****************************************************************
  }
 
 // ***************************************************************************************
?>