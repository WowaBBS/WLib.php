<?
  $Loader->Using_Module('/System/Prop');

  Use \Deprecated As Deprecated;
  
  Class T_FS_Path //Extends T_Property
  {
    Var $Path=[];
    
    Static Function Create($Arg='') { return New Self($Arg); }
 
    Static Function PathAsArray($Path)
    {
      If(Is_Array  ($Path)) Return $Path;
      If(Is_Object ($Path)) Return Self::PathAsArray($Path->Path);
      If(Is_String ($Path)) Return Explode('/', StrTr(Trim($Path), '\\', '/'));
      If(Is_Numeric($Path)) Return [''.$Path];
      throw New Exception('Unknown path');
      Return [];
    }
   
    Function _Debug_Serialize(&$Res)
    {
      $Res=$this->ToString();
    }
    
    Function __Construct($Path=False)
    {
      $this->Clear();
      If($Path!==False)
        $this->Assign($Path);
    }
 
    Function _Clone()
    {
      $Res=Static::Create($this->Path);
      Return $Res;
    }
 
    Function Clear()
    {
      $this->Path=[];
    }
 
    Function IsNull()
    {
      Return !$this->Path;
    }
 
    Function Assign($Path='')
    {
      $this->Path=Self::PathAsArray($Path);
      Return True;
    }
 
    Function IsFile()
    {
      If($this->Path)
        Return $this->Path[Count($this->Path)-1]!=='';
      Else
        Return false;
    }
 
    Function FileName()
    {
      If($this->Path)
        Return $this->Path[Count($this->Path)-1];
      Else
        Return '';
    }
 
    Function FileExt()
    {
      If(!$this->Path)
        Return '';
      $Res=$this->Path[Count($this->Path)-1];
      if($Res=='')
        Return '';
      $Res=Explode('.', $Res);
      If(Count($Res)==1)
        Return '';
      Return $Res[Count($Res)-1];
    }
 
    Function IsDir()
    {
      If($this->Path)
        Return $this->Path[Count($this->Path)-1]===''; // TODO: End($this->Path)===''
      Else
        Return True;
    }
 
    // True - если начинается не на /
    Function IsRoot()
    {
      If($this->Path)
        Return $this->Path[0]==='';
      Else
        Return True;
    }
 
    //
    Function IsDisk()
    {
      If($this->Path)
      {
        $R=$this->Path[0];
        If((StrLen($R)==2)&&($R[1]==':'))
          Return $R[0];
        Else
          Return '';
      }
      Else
        Return '';
    }
 
    //
    Function GetRoot()
    {
      If($this->Path)
        Return !$this->Path[0];
      Else
        Return '';
    }
 
    // Добавляет путь $Path справа к существующему пути
    Function Add($Path)
    {
      $Path=Self::PathAsArray($Path);
      If(!$Path)
        Return $this;
      $c=Count($this->Path);
      If(($c==0)||(($c==1)&&($this->Path[0]==='')))
      {
        $this->Path=$Path;
        Return $this;
      }
      $z0=$Path[0]==='';
      If($z0)//&&!Count($this->Path))
        Array_Splice($Path, 0, 1);
      $z1=$this->IsDir();
      If($z1)
        $this->Del(-1);
      If(!$z0 && !$z1)
        Array_Splice($this->Path, Count($this->Path)-1, 1, $Path);
      Else
        Array_Splice($this->Path, Count($this->Path), 0, $Path);
      Return $this;
    }
 
    // Добавляет путь $Path слева к существующему пути
    Function AddLeft($Path)
    {
      $Path=Self::PathAsArray($Path);
      If(!$Path)
        Return;
      If(!$Path[Count($Path)-1])
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
      {
        $Name=$this->Path[$i];
        If($Name=='.')
        {
          $this->Del(0, $i+1);
          $i=0;
        }
        ElseIf($Name=='..')
        {
          If($i>0)
          {
            $i--;
            $this->Del($i, 2);
          }
          Else
            $this->Del(0);
        }
        Else
          $i++;
      }
    }
 
    Function Get($Key)
    {
      Return $this->Path[$Key];
    }
 
    Function Put($Key, $Value)
    {
      $this->Path[$Key]=$Value;
      Return True;
    }
 
    Function Del($Idx, $Count=1)
    {
      Return Array_Splice($this->Path, $Idx, $Count);
    }
    
    Function __toString() { return $this->ToString(); } 
    Function ToString() { Return Implode('/', $this->Path); }
    Function Make() { return $this->ToString(); }
 
    Function ToUrl()
    {
      $Res=$this->Path;
      ForEach($Res As $k=>$v)
        $Res[$k]=UrlEnCode($v);
      Return Implode('/', $Res);
    }
 
    Function Len()
    {
      Return Count($this->Path);
    }
 
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