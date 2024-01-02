<?
  Abstract Class T_FS_CSS_Checker_Base
  {
    Abstract Function Check($Node);
    Abstract Function AddToMap($Map, $k, $v);
    Abstract Function GetType();
    Function GetArg() { Return Null; }
    Function GetCheckArg() { Return $this->GetArg(); }
    Function IsRec() { Return False; }
    Function IsEnd() { Return False; }
    
    Function GetId() { Return $this->GetIdStr(); } //TODO: Str2Id?
    Function GetIdStr()
    {
      $Arg=$this->GetArg();
      If($Arg===Null)
        Return $this->GetType();
      If(Is_Array($Arg))
      {
        $Res=[];
        ForEach($Arg As $Checker)
          $Res[]=$Checker->GetIdStr();
        $Arg='['.Implode(',', $Res).']';
      }
      Else If(Is_Object($Arg))
        $Arg=':'.$Arg->GetIdStr();
      Else
        $Arg=':'.$Arg;

      Return $this->GetType().$Arg;
    }
    
    Function ToDebug()
    {
      Return $this->GetId();
    }
  }
