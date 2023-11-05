<?
  Class T_System_Registry_Keys Implements \RecursiveIterator
  {
    Protected       $Key      ; //<T_System_Registry_Key The registry key whose values are being iterated over.
    Protected Int   $Pos   =0 ; //<The current iterator position.
    Protected Array $Names =[]; //<A (hopefully) enumerable variant containing the names of subkeys.
  
    Function __Construct($Key) { $this->Key=$Key; }
  
    Function HasChildren():bool
    {
      $Iterator=$this->GetChildren();
      $Iterator->ReWind();
      Return $Iterator->Valid();
    }
  
    Function GetChildren():?Static { Return New Static($this->Current()); }
  
    Function ReWind():Void
    {
      $this->Pos=0;
      $this->Names=$this->Key->EnumKey()?? [];
    }
  
    Function Valid   ():Bool   { Return $this->Pos<Count($this->Names); }
    Function Current ():Mixed  { Return $this->Key->GetSubKey($this->Key()); }
    Function Key     ():String { Return (String)$this->Names[$this->Pos]; }
    Function Next    ():Void   { $this->Pos++; }
  }
