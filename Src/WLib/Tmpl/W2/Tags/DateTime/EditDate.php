<?
  // (EditDate:InName;OutDate;FormName;Style;BeginYear;EndYear)
  // Function Tmpl_EditDate(&$Vars, $Time, $Field, $FormName='',
  //     $Style=False, $BeginYear=-5, $EndYear=2)
  Class T_W2_Tag_EditDate Extends T_W2_Tag__Func
  {
    Static $FuncInfo=[
      'Name'=>'Tmpl_EditDate',
      'FArgs'=>[
        [False      ,'Vars' ],
        ['Time'     ,'Var'  ,False],
        ['Field'    ,'Str'  ,False], 
        ['FormName' ,'Str'  ,''   ],
        ['Style'    ,'Str'  ,''   ],
        ['BYear'    ,'Int'  ,-5   ],
        ['EYear'    ,'Int'  , 2   ],
      ],
      'minArgs'=>3,
      'Args'=>true,
    ];
  }
?>