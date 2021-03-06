<?
  Class T_W2_Tag_Arr
  {
    Static $InnerTags=[
      'item' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Item' , $Var[1]);
    }

    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
      $Item=$Tag->GetAttr('Item');
  
      $vVar =$Builder->Var_Add('Var' ,$Id);
      $vm   =$Builder->Var_Add('m'   ,$Id);
      $vv   =$Builder->Var_Add('v'   ,$Id);
  
      If($Item)
        $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($Tag->GetAttr('Var')).';');
      Else        
        $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($Tag->GetAttr('Var')).';');
      $Builder->Add_Line('If(Is_Array('.$vVar.'))');
      $Builder->Add_Line('ForEach('.$vVar.' As '.$vm.'=>'.$vv.')');
      $Builder->Add_Line('  If(Is_Integer('.$vm.'))');
      $Builder->Add_Line(' {');
      $T=$Builder->Tab;
      $Builder->Tab=$T.'  ';
      If($Item)
        $Builder->Vars_WithA([$Item=>'&'.$vVar.'['.$vm.']']);
      Else
        $Builder->Vars_WithV($vVar.'['.$vm.']');
      If(IsSet($Tags['item']))
        $Tags['item'][0]->MakePHPInnerId($Builder, $Tags['item'][1]);
      Else
        $Builder->Add_Line('// Error Block not avalible');
      $Builder->Vars_EndWith();
      $Builder->Tab=$T;
      $Builder->Add_Line(' }');
    }
  }
?>