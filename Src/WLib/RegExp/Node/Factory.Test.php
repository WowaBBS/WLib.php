<?
  $this->Load_Class('/UnitTest/Case');
  
  Class Test_RegExp_Node_Factory Extends C_UnitTest_Case
  {
    Function _Init($Args)
    {
      $Factory=$this->Create_Object('/RegExp/Node/Factory');
      Parent::_Init($Args);
      $this->Test_Register_Argument_Name_Value('Factory' ,$Factory);
      $this->Test_Register_Argument_Name_Value('f'       ,$Factory);
    }
    
    Function CheckRegexp($Node, $Desired)
    {
      $Actual=$Node->ToString();
      If($Desired!==$Actual)
        $this->Log('Error')
        # ('Desired :', $Desired )
        # ('Actual  :', $Actual  )
        # ->Debug($Node)
          ->Debug([
            'Desired' =>$Desired ,
            'Actual ' =>$Actual  ,
            'Node'    =>$Node    ,
          ]);
      Else
        $this->Log('Debug', 'Ok: ', $Actual);
    }
    
    Function CheckFunc($Func, $List)
    {
      ForEach($List As $Args)
      {
        $Desired=Array_Pop($Args);
        $this->CheckRegexp($Func(...$Args) ,$Desired);
      }
    }
  
    //****************************************************************
    // Base
    
    Function TestSequence($f)
    {
      $this->CheckFunc($f->Sequence(...), [[['1','2','3'], '123']]);
    }
  
    Function TestOr($f)
    {
      $this->CheckFunc($f->Or(...), [[['1','2','3'], '1|2|3']]);
    }
    
    Function TestRepeat($f)
    {
      $this->CheckFunc($f->Repeat(...), [
        ['a', 0, 1 ,'a?'     ],
        ['a', 0    ,'a*'     ],
        ['a', 1    ,'a+'     ],
        ['a', 5, 5 ,'a{5}'   ],
        ['a', 0,-2 ,'a{0,}'  ],
        ['a', 1,-2 ,'a{1,}'  ],
        ['a', 0, 2 ,'a{0,2}' ],
        ['a', 1, 2 ,'a{1,2}' ],
      ]);
    }
    
    //****************************************************************
    // Group
    
    Function TestBack($f)
    {
      $this->CheckFunc($f->Back(...), [
        [Null   ,'\n'  ,'\n'         ],
        ['Name' ,'P='  ,'(?P=Name)'  ],
        [123    ,'kn'  ,'\k123'      ],
        ['Name' ,'k<'  ,'\k<Name>'   ],
        ['Name' ,'k\'' ,'\k\'Name\'' ],
        ['Name' ,'k{'  ,'\k{Name}'   ],
        [123    ,'gn'  ,'\g123'      ],
        ['Name' ,'g{'  ,'\g{Name}'   ],
        ['Name' ,'g<'  ,'\g<Name>'   ],
        ['Name' ,'g\'' ,'\g\'Name\'' ],
      ]);     
    }         
    
    
  }
?>