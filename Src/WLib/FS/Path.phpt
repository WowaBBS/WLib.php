<?
  $Loader->Using_Module('/System/Prop');

  Use \Deprecated As Deprecated;
  
  Class T_FS_Path //Extends T_Property
  {
    Var $Path=[];
    
  //Static Function New($Path='') { return New Self($Path); }
  //Static Function Cr($Path='') { return New Self($Path); }
    Static Function Create($Path='') { return New Self($Path); }
 
    Static Function PathAsArray($Path)
    {
      If(Is_Array  ($Path)) Return $Path;
      If(Is_Object ($Path)) Return Self::PathAsArray($Path->Path);
      If(Is_String ($Path)) Return Explode('/', StrTr(Trim($Path), '\\', '/'));
      If(Is_Numeric($Path)) Return [(String)$Path];
      throw New Exception('Unknown path');
      Return [];
    }
   
    Function _Debug_Serialize(&$Res) { $Res=$this->ToString(); }
    
    Function __Construct($Path=False)
    {
      $this->Clear();
      If($Path!==False)
        $this->Assign($Path);
    }
 
    Function _Clone() { Return Static::Create($this->Path); }
    Function Clear() { $this->Path=[]; }
    Function IsEmpty() { Return !$this->Path; }
  //Function IsNull() { Return !$this->Path; } //<Deprecated
    Function Assign($Path='') { $this->Path=Self::PathAsArray($Path); Return True; }
 
    Function IsDir() { Return $this->FileName()===''; }
    Function IsFile() { Return $this->FileName()!==''; }
    Function FileName() { Return ($c=Count($p=$this->Path))? $p[$c-1]:''; }
 
    Function GetExt()
    {
      $Res=$this->FileName();
      if($Res=='') Return '';
      $Res=Explode('.', $Res, 2);
      If(Count($Res)==1)
        Return '';
      Return $Res[1];
    }
     
  //Function IsUp() { Return ($this->Path[0]?? '')==='..'; }
    Function IsRoot() { Return ($this->Path[0]?? '')===''; } // True - если начинается не на /
    Function IsDisk() { $R=$this->Path[0]??''; Return StrLen($R)===2 && $R[1]===':'? $R[0]:''; }
  //Function GetRoot() { Return $this->Path[0]?? ''; } //<TODO: Remove?
 
    // Добавляет путь $Path справа к существующему пути
    Function Add($Path)
    {
      $Path=Self::PathAsArray($Path);
      If(!$Path)
        Return $this;
      $c=Count($this->Path);
      If($c===0 || $c===1 && $this->Path[0]==='')
      {
        $this->Path=$Path;
        Return $this;
      }
      $z0=$Path[0]==='';
      $z1=$this->IsDir();
      If($z0) Array_Splice($Path, 0, 1); //&&!$c)
      If($z1) $this->Del(-1);
      If($z0 || $z1) Array_Splice($this->Path, $c   ,0 ,$Path);
      Else           Array_Splice($this->Path, $c-1 ,1 ,$Path);
      Return $this;
    }
 
    // Добавляет путь $Path слева к существующему пути
    Function AddLeft($Path)
    {
      $Path=Self::PathAsArray($Path);
      If(!$Path)
        Return;
      If($Path[Count($Path)-1]==='')
        Array_Splice($Path, -1, 1);
      If($this->IsRoot())
        $this->Del(0);
      Array_Splice($this->Path, 0, 0, $Path);
    }

    Function Norm($Path=False, $Path2=False)
    {
      If(!$this->IsRoot())
        $this->AddLeft($Path);
      $i=0;
      While($i<Count($this->Path))
        Switch($Name=$this->Path[$i])
        {
        Case '.'  : $this->Del(0, $i+1); $i=0; Break;
        Case '..' : $i>0? $this->Del(--$i, 2):$this->Del(0); Break;
        Default: $i++;
        }
    }
 
    Function Get($k) { Return $this->Path[$k]; }
    Function Put($k, $v) { $this->Path[$k]=$v; Return True; }
    Function Del($Idx, $Count=1) { Return Array_Splice($this->Path, $Idx, $Count); }
    
    Function __toString() { return $this->ToString(); } 
    Function ToString() { Return Implode('/', $this->Path); }
    Function Make() { Return $this->ToString(); }
 
    Function ToUrl()
    {
      $Res=$this->Path;
      ForEach($Res As $k=>$v)
        $Res[$k]=UrlEnCode($v);
      Return Implode('/', $Res);
    }
 
    Function Len() { Return Count($this->Path); }
 
    // Сравнивает свой путь с путём $Path  (Можно упростить)
    //   $Cs    - включает регистронезависимое сравнение
    //   $ZFile - Сравнивать, включая имя файла
    //   Результат истинный, если оба пути совпадают
    Function Cmp($Path, $Cs=NULL, $ZFile=True)
    {
      $Path=Self::PathAsArray($Path);
      $C=Count($this->Path);
      If($C!=Count($Path))
        Return False;
     If(!$ZFile)
       $C--;
      If($Cs)
      {
        For($i=0; $i<$C; $i++)
          If($this->Path[$i]!=$Path[$i])
            Return False;
      }
      Else
      {
        For($i=0; $i<$C; $i++)
          If(StrCaseCmp($this->Path[$i], $Path[$i]))
            Return False;
      }
      Return True;
    }
 
    // Сравнивает свой путь с путём $Path
    //   $Cs - включает регистронезависимое сравнение
    //   Результат - Сколько одинаковых элементов пути (Включая файла)
    Function Compare($Path, $Cs=False)
    {
      $Path=Self::PathAsArray($Path);
      $C=Min(Count($this->Path), Count($Path));
      If($Cs)
      {
        For($i=0; $i<$C; $i++)
          If($this->Path[$i]!=$Path[$i])
            Return $i;
      }
      Else
      {
        For($i=0; $i<$C; $i++)
          If(StrCaseCmp($this->Path[$i], $Path[$i])!=0)
            Return $i;
      }
      Return $C;
    }
 
    Function PathFrom($Path, $Cs=False, $ZEnd=False)
    {
      $i=$this->Compare($Path, $Cs);
    //Debug(['PathFrom', $this->ToString(), $Path->ToString(), $i]);
    //If($ZEnd)
    //  If($Path->Len()!=$this->Len())
    //    $ZEnd=False;
      If(!$ZEnd)
        If($i && $this->Len()==$i)
          $i--;
      If($i)
        $this->Del(0, $i);
      $c=$Path->Len()-$i-1;
      If($c>0)
        $this->AddLeft(Str_Repeat('../', $c));
    //Debug([$this->ToString(), $c, $i]);
    }
  }

  #[Deprecated("Use T_FS_Path As TPath;")]
  Class TPath Extends T_FS_Path {}
?>