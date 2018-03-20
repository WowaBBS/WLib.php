<?
  Class T_W2_Tag_Arr
  {
    Static $InnerTags=[
      'item' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr(&$Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Item' , $Var[1]);
    }

    Function MakePHP(&$Info, &$Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
      $Item=$Tag->GetAttr('Item');
  
      $vVar =$Info->Var_Add('Var' ,$Id);
      $vm   =$Info->Var_Add('m'   ,$Id);
      $vv   =$Info->Var_Add('v'   ,$Id);
  
      If($Item)
        $Info->Add_Line($vVar.'=&'.$Info->Vars_Get($Tag->GetAttr('Var')).';');
      Else        
        $Info->Add_Line($vVar.'='.$Info->Vars_Get($Tag->GetAttr('Var')).';');
      $Info->Add_Line('If(Is_Array('.$vVar.'))');
      $Info->Add_Line('ForEach('.$vVar.' As '.$vm.'=>'.$vv.')');
      $Info->Add_Line('  If(Is_Integer('.$vm.'))');
      $Info->Add_Line(' {');
      $T=$Info->Tab;
      $Info->Tab=$T.'  ';
      If($Item)
        $Info->Vars_WithA([$Item=>'&'.$vVar.'['.$vm.']']);
      Else
        $Info->Vars_WithV($vVar.'['.$vm.']');
      If(IsSet($Tags['item']))
        $Tags['item'][0]->MakePHPInnerId($Info, $Tags['item'][1]);
      Else
        $Info->Add_Line('// Error Block not avalible');
      $Info->Vars_EndWith();
      $Info->Tab=$T;
      $Info->Add_Line(' }');
    }
  }
?>