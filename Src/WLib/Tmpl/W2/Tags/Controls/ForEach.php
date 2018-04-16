<?
  Class T_W2_Tag_ForEach
  {
    Static $InnerTags=[
      'item' => ['#Template','Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      If(IsSet($Var[0])) $Tag->SetAttr('Var'  , $Var[0]);
      If(IsSet($Var[1])) $Tag->SetAttr('Key'  , $Var[1]);
      If(IsSet($Var[2])) $Tag->SetAttr('Item' , $Var[2]);
      If(IsSet($Var[3])) $Tag->SetAttr('Type' , $Var[3]);
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Id=$Tag->Object_Id;
  
      $Item=$Tag->GetAttr('Item');
      $Var =$Tag->GetAttr('Var' );
      $Key =$Tag->GetAttr('Key' );
      $Type=$Tag->GetAttr('Type');
  
      $vVar =$Builder->Var_Add('Var' ,$Id);
      $vm   =$Builder->Var_Add('m'   ,$Id);
      $vv   =$Builder->Var_Add('v'   ,$Id);
  
      $Builder->Add_Line($vVar.'='.$Builder->Vars_Get($Var).';');
      $Builder->Add_Line('If(Is_Array('.$vVar.'))');
      $Builder->Add_Line('ForEach('.$vVar.' As '.$vm.'=>'.$vv.')');
      If($Type==='i')
        $Builder->Add_Line('  If(Is_Int('.$vm.'))');
      If($Type==='I')
        $Builder->Add_Line('  If(!Is_Int('.$vm.'))');
      $Builder->Add_Line(' {');
  
      $With=[];
      If($Key)
        $With[$Key]=$vm;
      If($Item)
      //$With[$Item]=$vv;
        $With[$Item]='&'.$vVar.'['.$vm.']';
    //Debug($With);
  
      $T=$Builder->Tab;
      $Builder->Tab=$T.'  ';
  
      If($With) $Builder->Vars_WithA($With);
      $Tags['item'][0]->MakePHPInnerId($Builder, $Tags['item'][1]);
      If($With) $Builder->Vars_EndWith();
  
      $Builder->Tab=$T;
      $Builder->Add_Line(' }');
    }
  }
?>