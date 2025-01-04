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
    
    Function GetRegExp($Ends=Null)
    {
      $Builder=$this->Builder;
      $Keys=[];
      $Prev=[];
      $Subs=[];
      ForEach($this->Map As $Char=>$Sub)
      {
        $Key=$Sub->GetKey();
        $Keys[$Key][]=$Char;
        $Subs[$Key]??=$Sub;
      }
      
      $Key='';
      $Res=[];
      If($Ends!==False)
      {
        ForEach($Keys As $Key=>$Chars)
          $Res[]=$Builder->_CharCodesToRegexp($Chars).$Subs[$Key]->GetRegExp($Ends);
        If($this->End)
        {
          If(Count($Res)===1 && $Key==='')
            Return $Res[0].'?';
          $Res[]='';
        }
        ElseIf($Ends===True)
          $Res[]='$';  
      }
      Else
      {
        $End=True;
        ForEach($Keys As $Key=>$Chars)
        {
          $Sub=$Subs[$Key];
          If(!$Sub->Map) Continue;
          
          $R2=$Sub->GetRegExp($Ends);
          If(StrLen($R2))
            $End=False;
          $Res[]=$Builder->_CharCodesToRegexp($Chars).$R2;
        //If(!$Sub->End) $End=False;
        }
        If(!$Res) Return '';  //$this->End || 
        
        {
          If($End && Count($Res)===1) // && $Key==='')
            Return $Res[0].'?';
          $Res[]='';
        }
      }
      
      // TODO: If($Res[Count($Res)-1]==='')  Add ?
      Return Count($Res)>1? '(?:'.Implode('|', $Res).')': $Res[0];
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
  
    Protected Function _Debug_Info(Array &$Res)
    {
      if(IsSet($Res['Back_Memory' ])) unset($Res['Back_Memory' ]);
    }
    
    Function _Debug_Serialize(Array &$Res)
    {
      UnSet($Res['Builder']);
    }
  
  //****************************************************************
  }
?>