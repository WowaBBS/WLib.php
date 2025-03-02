<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_Set Extends T_RegExp_Node_Base_Base
  {
    Var $Chars=[];
    
    Function __Construct($Chars=[]) { $this->Chars=$Chars; }

    Function Init($Res)
    {
      Parent::Init($Res);
    
      $Chars=$this->Chars;
      ForEach($Chars As $k=>$Char)
      {
        if(Is_Array($Char))
        {
          If(Count($Char)===2) //TODO: Validate chars
            $this->Chars[$k]=$Res->Range($Char[0], $Char[1]);
        }
      }
    }
    
    Function Make($Res)
    {
      $Res[]='[';
      ForEach($this->Chars As $Char)
        $Res[]=$Char;
      $Res[]=']';
    }

    Function Validate($Res)
    {
      ForEach($this->Chars As $k=>$v)
        If(!$Res->Chars($v))
          Return False;
      Return True;
    }
  }
  