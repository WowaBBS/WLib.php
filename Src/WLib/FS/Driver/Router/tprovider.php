<?
 Unit('FS/Router/TProvider');

 Uses('FS/Base/TProvider');
 Uses('FS/Router/TNode');
 Uses('FS/Null/TProvider');

 Class T_FS_Router_Provider Extends T_FS_Base_Provider
 {
   Var $Base = False;
   Var $RouterFile='location.php';

   Var $LHash =   Array() ;

 /*
   Function _Init($Args)
   {
    parent::_Init($Args);
    $BasePath = &New TPath();
   }
 */
   Function &_GetNode($Path,$Fld=False)
   {
    $Res=&$this->Base->Node($Path);
    If(IsSet($Fld))
      $Res=&$Res->Node($Path);
    Return $Res;
   }

   Function _GetLocationRules($Path)
   {
    $Mode=$Path->Make();
    If(IsSet($this->LHash[$Mode]))
      $Location=$this->LHash[$Mode];
    Else
     {
      $Node=&$this->_GetNode($this->RouterFile);

      $PMFL=$Node->Nodes();
      $LocationRes=Array();
      ForEach($PMFL As $k=>$vtmp34875)
       {
        $Location=Array();
        $PMFL[$k]->IncludePhp(
          Array('Location'=>&$Location),
          Array('Location'));
        $LocationRes=Array_Merge($LocationRes,$Location);
       }
      //If(!$PMFL)
      //  $LocationRes=Array(Array('Folder'=>-1));
      $LocationRes[]=Array('Folder'=>-1);
      $Location=$LocationRes;
      $this->LHash[$Mode]=$Location;
     }
    Return $Location;
   }

   Function _SelectRules($Path,$Fld,$Location)
   {
    ForEach($Location As $L)
     {
      $F=$L['Folder'];
      $z=1;
      If($F===0)
       { // Правило для текущей директории, безусловный переход
        //$Fld=$L['Mode'].($L['Mode']&&$Fld?'/':'').$Fld;
        Return $L;
       }
      ElseIf($F===' ')
       { // Правило для текущей директории, если она конечная точка
        If($Fld==='')
          Return $L;
       }
      ElseIf($F===1)
       { // Следущая директория - это параметр
        If($Fld!=='')
          Return $L;
       }
      ElseIf($F===-1)
       { // Следущая директория - это папка в текущей
        $Node=&$this->_GetNode($Path,$Fld);
        If($Node->IsDir())
         {
          $L['Mode']=$Fld;
          Return $L;
         }
       }
      ElseIf(StrCaseCmp($F,$Fld)==0)
       { // Следущая директория - это конкретная директория
        If(!IsSet($L['Mode']))
          $L['Mode']=$Fld;
        Return $L;
       }
     }
    Return Array();
   }

   Function _GetLoc(&$Vars, $Path, $Fld='')
   {
    $Loc=$this->_GetLocationRules($Path);
    If(!$Loc)
      Return False;
    $L=$this->_SelectRules($Path,$Fld,$Loc);
    If(!$L)
      Return False;
    If(IsSet($L['Vars']))
     {
      If(!Is_Array($L['Vars']))
        $VNames=Explode('.',$L['Vars']);
      $Vs=&$Vars;
      ForEach($VNames As $VName)
        If(!$VName)
         {
          $Vs[]=Array();
          End($Vs);
          $Vs=&$Vs[Key($Vs)];
         }
        Else
         {
          If(!IsSet($Vs[$VName]))
            $Vs[$VName]=Array();
          $Vs=&$Vs[$VName];
         }
      $Vs=$Fld;
     }
    If(IsSet($L['Exec']))
     {
      $PMF=&$this->_GetNode($L['Exec']);
      $PMF->IncludePhp(Array('Vars'=>&$Vars),Array('Vars'));
     }
    $P=&New TPath($L['Mode']);
    $P->Norm($Path);
    $Path->Assign($P);
    Return True;
   }

   Function _GetRoute($Path)
   {
    If(Is_Object($Path))
      $Mode=$Path->Path;
    Else
      $Mode=$Path;
    If(Is_Array($Mode))
      $Mode=Implode('/',$Mode);
    Static $HashRoute=Array();
    If(IsSet($HashRoute[$Mode]))
      Return $HashRoute[$Mode];
    $HashRoute[$Mode]=Array();
    $Res=&$HashRoute[$Mode];
    $Mode=Explode('/',$Mode);

    $Vars=Array();
    $Mode[]='';
    $SMode=&New TPath();
    ForEach($Mode As $Fld)
      If(!$this->_GetLoc(&$Vars, &$SMode, &$Fld))
        Return False;
    $Res['Path']=&$SMode;
    $Res['Vars']= $Vars ;
    Return $Res;
   }

   //Function &Node($Path)
   //{
   // //Debug($Path);
   // //MErrorHandler(0,1,1,1,$Vars);
   //
   // $Res=&$this->Create_Object('FS/Router/Node');
   // $Res->Path->Assign($Path);
   // $Res->Provider=&$this;
   // $Rt=$this->_GetRoute($Path);
   // //Debug($Rt);
   // $Res->MyVars=$Rt['Vars'];
   // $Res->Base=$this->Base->Node($Rt['Path']);
   // Return $Res;
   //}

   Function &BaseNode($Path)
   {
    $Rt=$this->_GetRoute($Path);
    //Debug(Array(Implode('/',($Rt))));
    //Debug(Array($Path->Make(),$Rt['Path']->Make()));
    If($Rt)
      Return $this->Base->Node($Rt['Path']);
    Return $GLOBALS['FS_Null_Node'];
   }

//   Function IsFile($Path)           { $Base=$this->Node($Path); Return $Base->IsFile();         }
//   Function IsDir($Path)            { $Base=$this->Node($Path); Return $Base->IsDir();          }
//   Function Exists($Path)           { $Base=$this->Node($Path); Return $Base->Exists();         }
//   Function &Stream($Path,$AMode)   { $Base=$this->Node($Path); Return $Base->Stream($AMode);   }
//   Function Files($Path,$Mask=False,$Attr=3) { $Base=$this->Node($Path); Return $Base->Files($Mask,$Attr); }
//   Function Nodes($Path)            { $Base=$this->Node($Path); Return $Base->Nodes();          }
//   Function IncludePhp($Path,$U=Array(),$P=Array()) { Return $Base->IncludePhp($U,$P);          }
//   Function LoadFile($Path)         { $Base=$this->Node($Path); Return $Base->LoadFile  ();       }
//   Function LoadText($Path)         { $Base=$this->Node($Path); Return $Base->LoadText  ();       }
//   Function SaveFile($Path,$Data)   { $Base=$this->Node($Path); Return $Base->SaveFile  ($Data); }
//   Function SaveText($Path,$Data)   { $Base=$this->Node($Path); Return $Base->SaveText  ($Data); }
//   Function AppendFile($Path,$Data) { $Base=$this->Node($Path); Return $Base->AppendFile($Data); }
//   Function AppendText($Path,$Data) { $Base=$this->Node($Path); Return $Base->AppendText($Data); }
//   Function &URL($Path)             { $Base=$this->Node($Path); Return $Base->URL();          }
//   Function Vars($Path)             { $Base=$this->Node($Path); Return $Base->MyVars;               }

   Function IsFile($Path)           { $Base=&$this->BaseNode($Path); Return $Base->IsFile();         }
   Function IsDir($Path)            { $Base=&$this->BaseNode($Path); Return $Base->IsDir();          }
   Function Exists($Path)           { $Base=&$this->BaseNode($Path); Return $Base->Exists();         }
   Function &Stream($Path,$AMode)   { $Base=&$this->BaseNode($Path); Return $Base->Stream($AMode);   }
   Function Files($Path,$Mask=False,$Attr=3) {
        $Base=&$this->BaseNode($Path); Return $Base->Files($Mask,$Attr);
    }
   Function Nodes($Path)            { $Base=&$this->BaseNode($Path); Return $Base->Nodes();          }
   Function IncludePhp($Path,$U=Array(),$P=Array()) { $Base=&$this->BaseNode($Path); Return $Base->IncludePhp($U,$P);}
   Function LoadFile($Path)         { $Base=&$this->BaseNode($Path); Return $Base->LoadFile  ();      }
   Function LoadText($Path)         { $Base=&$this->BaseNode($Path); Return $Base->LoadText  ();      }
   Function SaveFile($Path,$Data)   { $Base=&$this->BaseNode($Path); Return $Base->SaveFile  ($Data); }
   Function SaveText($Path,$Data)   { $Base=&$this->BaseNode($Path); Return $Base->SaveText  ($Data); }
   Function AppendFile($Path,$Data) { $Base=&$this->BaseNode($Path); Return $Base->AppendFile($Data); }
   Function AppendText($Path,$Data) { $Base=&$this->BaseNode($Path); Return $Base->AppendText($Data); }
   Function &URL($Path)             { $Base=&$this->BaseNode($Path); Return $Base->URL();             }
   Function Vars($Path)             { $Base=&$this->BaseNode($Path); Return $Base->MyVars;            }
 }

 EndUnit();
?>