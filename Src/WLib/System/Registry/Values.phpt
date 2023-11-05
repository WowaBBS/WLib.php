<?
  Class T_System_Registry_Values Implements \Iterator
  {
    Protected $Key      ; //<The registry key whose values are being iterated over.
    Protected $Pos   =0 ; //<int The current iterator position.
    Protected $Names =[]; //<\VARIANT A (hopefully) enumerable variant containing the value names.
    Protected $Types =[]; //<\VARIANT A (hopefully) enumerable variant containing the data types of values.
  
    Function __Construct($Key) { $this->Key=$Key; }
  
    Function ReWind():Void
    {
      $this->Pos=0;
      $Values=$this->Key->EnumValues()?? [];
      $this->Names=Array_Keys   ($Values);
      $this->Types=Array_Values ($Values);
    }
  
    Function Valid       ():Bool   { Return $this->Pos<Count($this->Names); }
    Function Current     ():Mixed  { Return $this->Key->GetValue($this->Key(), $this->CurrentType()); }
    Function CurrentType ():String { Return          $this->Types[$this->Pos]; }
    Function Key         ():String { Return (String )$this->Names[$this->Pos]; }
    Function Next        ():Void   { $this->Pos++; }
  }
