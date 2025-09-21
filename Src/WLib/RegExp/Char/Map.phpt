<?
  $this->Load_Type('/Object/WeakProxy');

  Class T_RegExp_Char_Map
  {
    Var $Builder =Null  ;
    Var $Map     =[];
    Var $End     =False ;
    Var $Static  =False ;
    Var $Key     =Null  ;
    
    Function __Construct($Builder) { $this->Builder=$Builder; }
    
    Function __Destruct()
    {
      If($this->Static)
        $this->Builder->CharMap_Remove($this->Key);
    }
    
    Function Builder_MakeWeakProxy() { $this->Builder=New T_Object_WeakProxy($this->Builder); Return $this; }
    
    Function _ToStatic() { $this->Static=True; Return WeakReference::Create($this); }
    Function ToStatic() { Return $this->Static? $this:$this->Builder->CharMap_ToStatic($this); }
    
    Function GetKey() { Return $this->Key??=$this->_GetKey(); }
    
    Static Function _CharCodesToKey($List)
    {
      $Left=-1;
      $Res=[];
      $Pos=-1;
      ForEach($List As $Char)
      {
        If($Left<0 || $Left+1!==$Char)
          $Pos=$Char;
        $Left=$Res[$Pos]=$Char;
      }
      $List=$Res;
      $Res=[];
      ForEach($List As $From=>$To)
        $Res[]=$From.$To;
      $Res=Implode('', $Res);
    //Return Count($List)===1? $Res:'['.$Res.']';
      Return '['.$Res.']';
    }
    
    Private Function _GetKey()
    {
      $Keys=[];
      ForEach($this->Map As $Char=>$Sub)
        $Keys[$Sub->GetKey()][]=$Char;
      If(!$Keys)
        Return '';
      
      $Res=[];
      ForEach($Keys As $Key=>$Chars)
      //$Res[]=Static::_CharCodesToKey($Chars).$Key; //Less memory
      //If(Count($Chars)!==1)
          $Res[]='['.Pack('C*', ...$Chars).']'.$Key; //Fastest
      //Else
      //  $Res[]=$Chars[0];
      If($this->End)
        $Res[]='';
      $Res=Count($Res)>1? '('.Implode('|', $Res).')': $Res[0];
      Return $Res;
    }
    
    Function GetRegExpArr($Ends=Null)
    {
      $Builder=$this->Builder;
      $Keys=[];
      $Subs=[];
      ForEach($this->Map As $Char=>$Sub)
      {
        $Key=$Sub->GetKey();
        $Keys[$Key][]=$Char;
        $Subs[$Key]??=$Sub;
      }
      
      $Or=['Or'];
      $End=$Ends===False || $this->End;
      ForEach($Keys As $Key=>$Chars)
      {
        $Sub=$Subs[$Key];
        
        If(!$Sub->Map && $Ends===False) Continue;
        
        $Sequence=['Sequence'];
        $Sequence[]=$Builder->_CharCodesToRegexpArr($Chars);
        
        If($R2=$Sub->GetRegExpArr($Ends))
        {
          $End=False;
          $Sequence[]=$R2;
        }
        
        If(Count($Sequence)>1)
          $Or[]=$Sequence;
      }
      
      If($this->End)
        $Ends=False;
      
      If($Ends!==Null)
        $Or[]=$Ends? '$':'';
      Return ['Group', $Or, False];
    }
    
    //TODO: Remove
    Function GetRegExpStr($Ends=Null)
    {
      $Builder=$this->Builder;
      $Keys=[];
      $Subs=[];
      ForEach($this->Map As $Char=>$Sub)
      {
        $Key=$Sub->GetKey();
        $Keys[$Key][]=$Char;
        $Subs[$Key]??=$Sub;
      }
      
      $Or=[];
      $End=$Ends===False || $this->End;
      ForEach($Keys As $Key=>$Chars)
      {
        $Sub=$Subs[$Key];
        If(!$Sub->Map && $Ends===False) Continue;

        $R2=$Sub->GetRegExpStr($Ends);
        If(StrLen($R2))
          $End=False;
        $Or[]=$Builder->_CharCodesToRegexpStr($Chars).$R2;
      }
      
      if($this->End)
        $Ends=False;
      
      Switch(Count($Or))
      {
      Case 0: Return '';
      Case 1:
        If($Ends===Null)
          Return $Or[0];
        If($Ends===False && $End)
          Return $Or[0].'?';
        Break;
      }
      If($Ends!==Null)
        $Or[]=$Ends? '$':'';
      Return '(?:'.Implode('|', $Or).')';
    }
    
    Private Function _Invalidate() { $this->Key=Null; Return $this; }

    Function BeginUpdate() { return $this->Static? Clone $this:$this; }
    Function EndUpdate() { return $this->_Invalidate()->ToStatic(); }
    
    Function AddEnd($v=true) { $this->End=True; Return $this; }
    
    Function AddStr($s, $i=0)
    {
      if(StrLen($s)<=$i)
        Return $this->AddEnd();
      $c=Ord($s[$i]); $i++;
      
      if($Sub=$this->Map[$c]?? Null)
        $Sub=$Sub->BeginUpdate()->AddStr($s, $i)->EndUpdate();
      ElseIf(StrLen($s)>$i)
        $Sub=$this->Create()->AddStr($s, $i)->ToStatic();
      Else
        $Sub=$this->ItemEnd();
      $this->Map[$c]=$Sub;
      Return $this;
    }
    
    Function Create() { Return $this->Builder->CharMap_Create(); }
    Function ItemEnd() { Return $this->Builder->CharMap_End(); }

  //****************************************************************
  // Debug
    
    Function _Debug_Serialize(Array &$Res)
    {
      UnSet($Res['Builder']);
    }
  
  //****************************************************************
  }
?>