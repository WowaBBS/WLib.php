<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_Oct Extends T_RegExp_Node_Char_Base
  {
    Var $Char =0;
    
    Function IsSolid  () { Return True; }
    
    Function __Construct($Char=0) { $this->Char=$Char; }

    Function Make($Res)
    {
      $R=DecOct($Res->CharToInt8($this->Char));
      Switch($l=StrLen($R))
      {
      Case 1: $Res[]='\00' ; $Res[]=$R; Break;
      Case 2: $Res[]='\0'  ; $Res[]=$R; Break;
      Case 3: $Res[]='\\'  ; $Res[]=$R; Break;
      Default:
        $Res->Error();
        $Res[]='\\'  ; 
        $Res[]=SubStr($R, -3);
      }
    }

    Function Validate($Res)
    {
      Return $Res->Char8($this->Char);
    }
  }
  