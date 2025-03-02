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
        [ Null  ,'\n'  ,'\n'         ],
        ['Name' ,'P='  ,'(?P=Name)'  ],
        [ 123   ,'kn'  ,'\k123'      ],
        ['Name' ,'k<'  ,'\k<Name>'   ],
        ['Name' ,'k\'' ,'\k\'Name\'' ],
        ['Name' ,'k{'  ,'\k{Name}'   ],
        [ 123   ,'gn'  ,'\g123'      ],
        ['Name' ,'g{'  ,'\g{Name}'   ],
        ['Name' ,'g<'  ,'\g<Name>'   ],
        ['Name' ,'g\'' ,'\g\'Name\'' ],
      ]);
    }
    
    Function TestCheck($f)
    {
      $this->CheckFunc($f->Check(...), [
        ['aaa'  ,'!'   ,'(?'.'!' .'aaa)'],
        ['aaa'  ,'='   ,'(?'.'=' .'aaa)'],
        ['aaa'  ,'<!'  ,'(?'.'<!'.'aaa)'],
        ['aaa'  ,'<='  ,'(?'.'<='.'aaa)'],
      ]);
    }
    
    Function TestComment($f)
    {
      $this->CheckFunc($f->Comment(...), [
        ['aaa'  ,'(?#aaa)'],
      //['a)a'  ,'(?#a\)a)'], TODO:
      ]);
    }
    
    Function TestGroup($f)
    {
      $this->CheckFunc($f->Group(...), [
        ['Node',  True  ,''   ,'('            .''   .'Node' .')'],
        ['Node',  Null  ,'|'  ,'(?|'          .''   .'Node' .')'],
        ['Node', 'Name' ,'<'  ,'(?<'  .'Name' .'>'  .'Node' .')'],
        ['Node', 'Name' ,'\'' ,'(?\'' .'Name' .'\'' .'Node' .')'],
        ['Node',  False ,':'  ,'(?:'          .''   .'Node' .')'],
        ['Node',  False ,'>'  ,'(?\>'         .''   .'Node' .')'],
      ]);
    }
    
    Function TestIf($f)
    {
      $this->CheckFunc($f->If(...), [
        ['Cond',  'Then'  ,'Else' ,'(?(Cond)Then|Else)' ],
        ['Cond',  'Then'          ,'(?(Cond)Then)'      ],
      ]);
    }
    
    Function TestRecursive($f)
    {
      $this->CheckFunc($f->Recursive(...), [
        [0      ,'R'  ,'(?R)'      ],//(?R)
        [1      ,'?'  ,'(?1)'      ],//(?1)
        ['Name' ,'>'  ,'(?P>Name)' ],//(?P>name)
        ['Name' ,'&'  ,'(?&Name)'  ],//(?&name)
      ]);
    }
    
  //****************************************************************
  // Char
  
    Function TestClass($f)
    {
      $this->CheckFunc($f->Class(...), [
        ['\w' ,'\w' ],
        ['\s' ,'\s' ],
      ]);
    }
  
    Function TestHex($f)
    {
      $this->CheckFunc($f->Hex(...), [
        [0x00 ,'\x00' ],
        [0x01 ,'\x01' ],
        [0x10 ,'\x10' ],
        [0xFF ,'\xff' ],
        ['a'  ,'\x61' ],
      ]);
    }
  
    Function TestOct($f)
    {
      $this->CheckFunc($f->Oct(...), [
        [0x00 ,'\000' ],
        [0x01 ,'\001' ],
        [0x10 ,'\020' ],
        [0377 ,'\377' ],
        ['a'  ,'\141' ],
      ]);
    }
  
    Function TestOne($f)
    {
      $this->CheckFunc($f->One(...), [
        ['a' ,'a' ],
        ['z' ,'z' ],
      ]);
    }
    
    Function TestRange($f)
    {
      $this->CheckFunc($f->Range(...), [
        ['a' ,'z' ,'a-z' ],
        ['a' ,'a' ,'a-a' ],
        ['0' ,'9' ,'0-9' ],
      ]);
    }
    
    Function TestSet($f)
    {
      $this->CheckFunc($f->Set(...), [
        [['a', 'b', 'c']  ,'[abc]'],
        [['a', 'b', ['c', 'f']] ,'[abc-f]'],
      ]);
    }
    
    
  //****************************************************************
  }
?>