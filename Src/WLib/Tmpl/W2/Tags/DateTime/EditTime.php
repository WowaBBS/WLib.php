<?
  // (EditTime:InName;OutDate;FormName)
  // Function Tmpl_EditTime(&$Vars, $Time, $Field, $FormName='')
 
  Class T_W2_Tag_EditTime Extends T_W2_Tag__Func
  {
    Static $FuncInfo=[
      'Name'=>'Tmpl_EditTime',
      'FArgs'=>[
        [False      ,'Vars' ],
        ['Time'     ,'Var'  ,False],
        ['Field'    ,'Str'  ,False],
        ['FormName' ,'Str'  ,''   ],
      ],
      'minArgs'=>3,
      'Args'=>true,
    ];
  }
?>