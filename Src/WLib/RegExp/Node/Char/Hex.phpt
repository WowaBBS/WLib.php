<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Char_Hex Extends T_RegExp_Node_Base
  {
    Var $Char =0;
    
    Function __Construct($Char=0) { $this->Char=$Char; }

    Function Make($Res)
    {
      $R=DecHex($this->Char);
      Switch($l=StrLen($R))
      {
      Case 1: $Res[]='\0x0' ; $Res[]=$R; Break;
      Case 2: $Res[]='\0x'  ; $Res[]=$R; Break;
      Default:
        $Res->Error();
        $Res[]='\0x';
        $Res[]=SubStr($R, -2);
      }
    }
  }
  