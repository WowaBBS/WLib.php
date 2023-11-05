<?
  return [  
    'Assets'=>[
      ['Cpp/LibPath', '>Compiler',],
      ['Cpp/Lib',
        'User32.lib'   ,
        'kernel32.Lib' ,
        'Advapi32.lib' ,
      ],
      ['Cpp/Include', ''],
      ['Cpp/SrcPath', ''],
      ['Public'],
      ['Cpp/Define', '_CONSOLE',],
    //['Cpp/MakeDll' 
      ['Cpp/MakeLib',
        '>Sub'=>['Cpp/Src'=>'MockThread.cpp'],
        'Def'=>'MockThread.def',
        'DLL'=>'MOCK_THREAD_API',
      //'Name'=>'MockThread'
      ],
      ['Exec/Option:link',
        '>Remove'=>[
          '/NODEFAULTLIB',
        ],
        '/SUBSYSTEM:'=>'CONSOLE',
      ],
      ['Cpp/MakeExe' ,'>Sub'=>['Cpp/Src'=>'MockThreadTest.cpp'], 'Name'=>'MockThreadTest'],
      ['Module/Depends',
        '>External',
      ],
    //Deploy
      ['Target/Dir', 'Built' ,'>Parent'=>'Module/Path'],
      ['Target/Copy' ,'From'=>'Bin/Exe' ,'To'=>'',],
      ['Target/Copy' ,'From'=>'Bin/Dll' ,'To'=>'',],
    ],
  ];
?>