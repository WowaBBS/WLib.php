<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_Hex Extends T_RegExp_Node_Char_Base
  {
    Var      $Char      =0;
    Var Bool $UpperCase =True;
    
    Function IsSolid  () { Return True; }
    
    Function __Construct($Char=0, $UpperCase=True)
    {
      $this->Char      =$Char      ;
      $this->UpperCase =$UpperCase ;
    }

    Function Make($Res)
    {
      $R=DecHex($Res->CharToInt8($this->Char)); // TODO: Optional StrToUpper
      If($this->UpperCase)
        $R=StrToUpper($R);
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
  