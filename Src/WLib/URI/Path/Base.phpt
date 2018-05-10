<?
  $Loader->Begin_Type('/URI/Path/Base');
 
  $Loader->Using_Module('/System/Prop');
 
//Class T_Inet_URL_Path
  Class TPath Extends T_Property
  {
    Var $Path=[];
 
    Static Function PathAsArray($APath)
    {
      If(Is_Array  ($APath)) Return $APath;
      If(Is_Object ($APath)) Return Self::PathAsArray($APath->Path);
      If(Is_String ($APath)) Return Explode('/', StrTr(Trim($APath), '\\', '/'));
      If(Is_Numeric($APath)) Return [''.$APath];
      throw New Exception('Unknown path');
      Return [];
    }
   
    Function _Debug_Serialize(&$Res)
    {
      $Res=$this->Make();
    }
    
    Function __Construct($APath=False)
    {
      $this->Clear();
      If($APath!==False)
        $this->Assign($APath);
    }
 
    Function &_Clone()
    {
      $Res=New TPath($this->Path);
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
 
    Function Assign($APath='')
    {
      $this->Path=Self::PathAsArray($APath);
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
 
    // Добавляет путь $APath справа к существующему пути
    Function Add($APath)
    {
      $APath=Self::PathAsArray($APath);
      If(!$APath)
        Return;
      $c=Count($this->Path);
      If(($c==0)||(($c==1)&&($this->Path[0]==='')))
      {
        $this->Path=$APath;
        Return;
      }
      $z0=$APath[0]==='';
      If($z0)//&&!Count($this->Path))
        Array_Splice($APath, 0, 1);
      $z1=$this->IsDir();
      If($z1)
        $this->Del(-1);
      If(!$z0 && !$z1)
        Array_Splice($this->Path, Count($this->Path)-1, 1, $APath);
      Else
        Array_Splice($this->Path, Count($this->Path), 0, $APath);
    }
 
    // Добавляет путь $APath слева к существующему пути
    Function AddLeft($APath)
    {
      $APath=Self::PathAsArray($APath);
      If(!$APath)
        Return;
      If(!$APath[Count($APath)-1])
        Array_Splice($APath, -1, 1);
      If($this->IsRoot())
        $this->Del(0);
      Array_Splice($this->Path, 0, 0, $APath);
    }

    Function Norm($APath=False, $APath2=False)
    {
      If(!$this->IsRoot())
        $this->AddLeft($APath);
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
 
    Function Make()
    {
      Return Implode('/', $this->Path);
    }
 
    Function MakeUrl()
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
 
    // Сравнивает свой путь с путём $APath  (Можно упростить)
    //   $Cs    - включает регистронезависимое сравнение
    //   $ZFile - Сравнивать, включая имя файла
    //   Результат истинный, если оба пути совпадают
    Function Cmp($APath, $Cs=NULL, $ZFile=True)
    {
      $APath=Self::PathAsArray($APath);
      $C=Count($this->Path);
      If($C!=Count($APath))
        Return False;
     If(!$ZFile)
       $C--;
      If($Cs)
      {
        For($i=0; $i<$C; $i++)
          If($this->Path[$i]!=$APath[$i])
            Return False;
      }
      Else
      {
        For($i=0; $i<$C; $i++)
          If(StrCaseCmp($this->Path[$i], $APath[$i]))
            Return False;
      }
      Return True;
    }
 
    // Сравнивает свой путь с путём $APath
    //   $Cs - включает регистронезависимое сравнение
    //   Результат - Сколько одинаковых элементов пути (Включая файла)
    Function Compare($APath, $Cs=False)
    {
      $APath=Self::PathAsArray($APath);
      $C=Min(Count($this->Path), Count($APath));
      If($Cs)
      {
        For($i=0; $i<$C; $i++)
          If($this->Path[$i]!=$APath[$i])
            Return $i;
      }
      Else
      {
        For($i=0; $i<$C; $i++)
          If(StrCaseCmp($this->Path[$i], $APath[$i])!=0)
            Return $i;
      }
      Return $C;
    }
 
    Function PathFrom($APath, $Cs=False, $ZEnd=False)
    {
      $i=$this->Compare($APath, $Cs);
    //Debug(['PathFrom', $this->Make(), $APath->Make(), $i]);
    //If($ZEnd)
    //  If($APath->Len()!=$this->Len())
    //    $ZEnd=False;
      If(!$ZEnd)
        If($i&&($this->Len()==$i))
          $i--;
      If($i)
        $this->Del(0, $i);
      $c=$APath->Len()-$i-1;
      If($c>0)
        $this->AddLeft(Str_Repeat('../', $c));
    //Debug([$this->Make(), $c, $i]);
    }
  }
 
  $Loader->End_Type('/URI/Path/Base');
?>