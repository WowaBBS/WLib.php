<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_Range Extends T_RegExp_Node_Base_Base
  {
    Var $From ='0';
    Var $To   ='9';
    
    Function __Construct($From='0', $To='9') { $this->From=$From; $this->To=$To; }

    Function Make($Res)
    {
      $Res[]=$From ;
      $Res[]='-'   ;
      $Res[]=$To   ;
    }
  }
  