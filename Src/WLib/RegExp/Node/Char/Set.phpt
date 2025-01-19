<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_Set Extends T_RegExp_Node_Base_Base
  {
    Var $Chars=[];
    
    Function __Construct($Chars=[]) { $this->Chars=$Chars; }

    Function Make($Res)
    {
      $Res[]='[';
      ForEach($this->Chars As $Char)
        $Res[]=$Char;
      $Res[]=']';
    }
  }
  