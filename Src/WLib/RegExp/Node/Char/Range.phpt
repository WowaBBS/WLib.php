<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_Range Extends T_RegExp_Node_Char_Base
  {
    Var $From ='0';
    Var $To   ='9';
    
    Function __Construct($From='0', $To='9') { $this->From=$From; $this->To=$To; }

    Function Make($Res)
    {
      $Res[]=$this->From ;
      $Res[]='-'   ;
      $Res[]=$this->To   ;
    }

    Function Validate($Res)
    {
      $R =$Res->Char($this->From );
      $R|=$Res->Char($this->To   );
      $From =$Res->CharToInt($this->From );
      $To   =$Res->CharToInt($this->To   );
      If($From>$To) $Res->Error();
      
      Return $R;
    }
  }
  