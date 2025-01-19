<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_Oct Extends T_RegExp_Node_Base_Base
  {
    Var $Char =0;
    
    Function __Construct($Char=0) { $this->Char=$Char; }

    Function Make($Res)
    {
      $R=DecOct($this->Char);
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
  }
  