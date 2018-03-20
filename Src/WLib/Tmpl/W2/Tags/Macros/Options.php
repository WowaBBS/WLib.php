<?
  // (EditDate:InName;OutDate;FormName;Style;BeginYear;EndYear)
  // Function Tmpl_EditDate(&$Vars, $Time, $Field, $FormName='',
  //     $Style=False, $BeginYear=-5, $EndYear=2)
  Class T_W2_Tag_Options Extends T_W2_Tag__Func
  {
    Static $FuncInfo=[
      'Name'=>'Tmpl_Options',
      'FArgs'=>[
        ['Var'      ,'Var'  ,False],
        ['List'     ,'Var'  ,False],
        ['Value'    ,'Str'  ,'Value'],
        ['Title'    ,'Str'  ,'Title'],
      ],
      'minArgs'=>3,
      'Args'=>true,
    ];
  }
?>