<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Char_Set Extends T_RegExp_Node_Base_Base
  {
    Var $Chars=[];
    
    Function IsSolid  () { Return True; }
    
    Function __Construct(...$Chars) { $this->Chars=$Chars; }

  //Static Function ArgsToArgs($Args)
    Static Function _ArgsToArgs($Args) //TODO: Was ArgsToArgs, Remove
    {
      Switch(Count($Args))
      {
      Case 0: $Args=[[]]; Break;
      Case 1:
        If(//Is_Array($Args[0]?? 0) && Is_String($Args[0][0]?? 0) || 
           Is_String($Args[0]?? 0))
          $Args=[$Args];
        Break;
      Default: $Args=[$Args];
      }
      Return $Args;
    }
    
    Function Init($Res)
    {
      Parent::Init($Res);
    
      $Chars=$this->Chars;
      ForEach($Chars As $k=>$Char)
      {
        If(Is_Array($Char))
        {
          If(Count($Char)===2)
          {
            [$a, $b]=$Char;
            if(Is_String($a) && $Res->GetType($a))
            {
              $this->Chars[$k]=$Res->Node($Char);
            //$GLOBALS['Loader']->Log('Debug', 'Set.Char: ', $this->Chars[$k]);
            }
            Else //TODO: Validate chars
              $this->Chars[$k]=$Res->Range($a, $b);
          }
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
  