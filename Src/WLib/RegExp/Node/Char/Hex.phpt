<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_Hex Extends T_RegExp_Node_Char_Base
  {
    Var $Char =0;
    
    Function IsSolid  () { Return True; }
    
    Function __Construct($Char=0) { $this->Char=$Char; }

    Function Make($Res)
    {
      $R=DecHex($Res->CharToInt8($this->Char));
      Switch($l=StrLen($R))
      {
      Case 1: $Res[]='\x0' ; $Res[]=$R; Break;
      Case 2: $Res[]='\x'  ; $Res[]=$R; Break;
      Default:
        $Res->Error();
        $Res[]='\x';
        $Res[]=SubStr($R, -2);
      }
    }

    Function Validate($Res)
    {
      Return $Res->Char8($this->Char);
    }
  }
  