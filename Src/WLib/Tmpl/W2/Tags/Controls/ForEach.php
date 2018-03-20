<?
  Class T_W2_Tag_ForEach
  {
    Static $InnerTags=[
      'item' => ['#Template','Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Key'  , $Var[1]);
      If(IsSet($Var[2])) $Tag->SetAttr('Item' , $Var[2]);
      If(IsSet($Var[3])) $Tag->SetAttr('Type' , $Var[3]);
    }
 
    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $Item=$Tag->GetAttr('Item');
      $Var =$Tag->GetAttr('Var' );
      $Key =$Tag->GetAttr('Key' );
      $Type=$Tag->GetAttr('Type');
  
      $vVar =$Info->Var_Add('Var' ,$Id);
      $vm   =$Info->Var_Add('m'   ,$Id);
      $vv   =$Info->Var_Add('v'   ,$Id);
  
      $Info->Add_Line($vVar.'='.$Info->Vars_Get($Var).';');
      $Info->Add_Line('If(Is_Array('.$vVar.'))');
      $Info->Add_Line('ForEach('.$vVar.' As '.$vm.'=>'.$vv.')');
      If($Type==='i')
        $Info->Add_Line('  If(Is_Int('.$vm.'))');
      If($Type==='I')
        $Info->Add_Line('  If(!Is_Int('.$vm.'))');
      $Info->Add_Line(' {');
  
      $With=[];
      If($Key)
        $With[$Key]=$vm;
      If($Item)
      //$With[$Item]=$vv;
        $With[$Item]='&'.$vVar.'['.$vm.']';
    //Debug($With);
  
      $T=$Info->Tab;
      $Info->Tab=$T.'  ';
  
      If($With) $Info->Vars_WithA($With);
      $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
      If($With) $Info->Vars_EndWith();
  
      $Info->Tab=$T;
      $Info->Add_Line(' }');
    }
  }
?>