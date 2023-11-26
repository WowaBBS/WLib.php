<?
  $Loader->Load_Type('/FS/Attr/Date/UnixTime' ); Use T_FS_Attr_Date_UnixTime As FileTime ;
  $Loader->Load_Type('/FS/Attr/Mode'          ); Use T_FS_Attr_Mode          As Mode     ;
  $Loader->Load_Type('/FS/Attr/Hash'          ); Use T_FS_Attr_Hash          As Hash     ;
  $Loader->Load_Type('/FS/Attr/IntId'         ); Use T_FS_Attr_IntId         As IntId    ;

  // Node:
  //  Is_Dir        Boolean
  //  Is_File       Boolean
  //  Is_Link       Boolean
  //  Type          EnumString [File, Directory, Link, Socket, ... Fifo, Char, Block]
  //  Writeble      Boolean
  //  Is_Readable   Boolean
  //  Is_Writable   Boolean
  //  Is_Executable Boolean 
  //  Exists        Boolean
  //  Created       FileDate
  //  Modified      FileDate
  //  LastAccess    FileDate
  //SymLink:
  //  Link          String
  //File:
  //  Size          Integer
  //  Content       String <|Stream
  //  Stream        Stream
  //  Md5           String
  //Optional:
  //  Stat
  //
  //Device:
  //  Device_Id
  //  Disk_Free
  //  Disk_Total
  //  Disk_Used
  
  Class T_FS_Driver_Attr
  {
    Static Function Init_System($Attr)
    {
      $Attr->Register([
        'Node'       =>['Private'=>True, 'Cache'=>False], //System   fn()=>[]   ,
        'Args'       =>['Private'=>True, 'Cache'=>False], //System   fn()=>[]   ,
        'Attr'       =>['Private'=>True, 'Cache'=>False], //System?? fn()=>[]   ,
        'Driver'     =>['Private'=>True, 'Cache'=>False], //System   fn()=>Null ,
        'Path'       =>['Private'=>True, 'Cache'=>False], //System   fn()=>''   ,
      ]);
    }
    
    Static Function Init_Path($Attr)
    {
      $Attr->Register([
        'PathInfo'   => fn($Path)=>PathInfo($Path),                  // /www/htdocs/inc/lib.inc.php
        'Folder'     => fn($PathInfo)=>$PathInfo['dirname'   ]     , // /www/htdocs/inc
        'Name'       => fn($PathInfo)=>$PathInfo['basename'  ]     , // lib.inc.php
        'Ext'        => fn($PathInfo)=>$PathInfo['extension' ]?? '', // php
        'Nick'       => fn($PathInfo)=>$PathInfo['filename'  ]     , // lib.inc
        'NoExt'      => fn($Path, $Ext)=>($l=StrLen($Ext))? SubStr($Path, 0, -$l):$Path, // /www/htdocs/inc/lib.inc //TODO
      ]);
    }
  
    Static Function Init_Stat($Attr)
    {
      $Attr->Register([
      //'Stat'          => fn()=>Static::_EmptyStat(),
        'Is_Executable' => fn($Mode)=>$Mode->Is_Executable (),
        'Is_Readable'   => fn($Mode)=>$Mode->Is_Readable   (),
        'Is_Writable'   => fn($Mode)=>$Mode->Is_Writable   (),
        
        'Is_Dir'        => fn($Type)=>$Type==='Dir'   ,
        'Is_File'       => fn($Type)=>$Type==='File'  ,
        'Is_Link'       => fn($Stat)=>$Stat['Is_Link'],
        'Exists'        => fn($SysPath)=>(Bool)$Stat,

        'Type'          => fn($Mode)=>$Mode->GetType(),
        'Device_Id'     => fn($Stat)=>IntId   ::New($Stat['dev'     ]), // 0
        'Node_Id'       => fn($Stat)=>IntId   ::New($Stat['ino'     ]), // 1
        'Mode'          => fn($Stat)=>Mode    ::New($Stat['mode'    ]), // 2
        'NumLinks'      => fn($Stat)=>              $Stat['nlink'   ] , // 3
        'User_Id'       => fn($Stat)=>              $Stat['uid'     ] , // 4
        'Group_Id'      => fn($Stat)=>              $Stat['gid'     ] , // 5
        'Device_Type'   => fn($Stat)=>              $Stat['rdev'    ] , // 6
        'Size'          => fn($Stat)=>              $Stat['size'    ] , // 7
        'LastAccess'    => fn($Stat)=>FileTime::New($Stat['atime'   ]), // 8
        'Modified'      => fn($Stat)=>FileTime::New($Stat['mtime'   ]), // 9
        'Created'       => fn($Stat)=>FileTime::New($Stat['ctime'   ]), //10
        'Block_Size'    => fn($Stat)=>              $Stat['blksize' ] , //11
        'Block_Count'   => fn($Stat)=>              $Stat['blocks'  ] , //12

        'Dir_Size'      => fn($Node)=>$Node->Is_Dir()?     $Node->ForEachRes(0                  ,fn($Res, $n)=>$Res +    $n['Dir_Size'      ]         ):$Node['Size'     ],
        'Dir_Modified'  => fn($Node)=>$Node->Is_Dir()?     $Node->ForEachRes($Node['Modified' ] ,fn($Res, $n)=>$Res->Max($n['Dir_Modified'  ])        ):$Node['Modified' ],
        'Dir_Md5'       => fn($Node)=>$Node->Is_Dir()? Hash::FromBinary($Node->ForEachRes(''    ,fn($Res, $n)=>$Res .    $n['_Hash_Md5_Str' ] ), 'Md5'):$Node['Md5'      ],
        
        '_Hash_Md5_Str' => fn($Modified, $Created, $Size, $Dir_Md5)=>$Modified.'|'.$Created.'|'.$Size.'|'.$Dir_Md5.';',
      ]);
    }    

    Static Function Init_StatAlt($Attr)
    {
      $Attr->Register([
        'Is_Executable' => fn($SysPath)=>Is_Executable ($SysPath),
        'Is_Readable'   => fn($SysPath)=>Is_Readable   ($SysPath),
        'Is_Writable'   => fn($SysPath)=>Is_Writable   ($SysPath),
        
        'Is_Dir'        => fn($SysPath)=>Is_Dir        ($SysPath),
        'Is_File'       => fn($SysPath)=>Is_File       ($SysPath),
        'Is_Link'       => fn($SysPath)=>Is_Link       ($SysPath),
        'Exists'        => fn($SysPath)=>FileExists    ($SysPath),

        'Type'          => fn($SysPath)=>             FileType  ($SysPath) ,
        'Device_Id'     => fn($SysPath)=>New IntId   (LinkInfo  ($SysPath)), // 0
        'Node_Id'       => fn($SysPath)=>New IntId   (FileINode ($SysPath)), // 1
        'Mode'          => fn($SysPath)=>New Mode    (FilePerms ($SysPath)),
      //'NumLinks'      => fn($Stat   )=>             $Stat['nlink'   ]    , // 3
        'User_Id'       => fn($SysPath)=>             FileOwner ($SysPath) ,
        'Group_Id'      => fn($SysPath)=>             FileGroup ($SysPath) ,
      //'Device_Type'   => fn($Stat   )=>             $Stat['rdev'    ]    , // 6
        'Size'          => fn($SysPath)=>             FileSize  ($SysPath) ,
        'LastAccess'    => fn($SysPath)=>New FileTime(FileATime ($SysPath)),
        'Modified'      => fn($SysPath)=>New FileTime(FileMTime ($SysPath)),
        'Created'       => fn($SysPath)=>New FileTime(FileCTime ($SysPath)),
      //'Block_Size'    => fn($Stat   )=>             $Stat['blksize' ]    , //11
      //'Block_Count'   => fn($Stat   )=>             $Stat['blocks'  ]    , //12
      ]);
    }
    
    Static Function Init_Test($Attr)
    {
      $Attr->Register([
        'Test_Func' => fn($Driver,        $Args)=>$Driver->Log('Debug', 'Test_Func ' ,$Args)->Ret('TestResult'),
        'Test'      =>[fn($Driver,        $Args)=>$Driver->Log('Debug', 'Test_Get '  ,$Args)->Ret('TestValue'),
                       fn($Driver, $Test, $Args)=>$Driver->Log('Debug', 'Test_Set '  ,$Test, ' ', $Args)->Ret('TestRes')],
      ]);
    }
    
    Static Function Init_Disk($Attr)
    {
      $Attr->Register([
        'Disk_Total' => fn($SysPath)=>Disk_Total_Space ($SysPath),
        'Disk_Free'  => fn($SysPath)=>Disk_Free_Space  ($SysPath),
        'Disk_Used'  => fn($Disk_Total, $Disk_Free)=>$Disk_Total>0? $Disk_Total-$Disk_Free:$Disk_Total,
      ]);
      If(False) //TODO:
      $Attr->Register([
        'Disk'=>['List', [
          'Total' => fn($SysPath)=>Disk_Total_Space ($SysPath),
          'Free'  => fn($SysPath)=>Disk_Free_Space  ($SysPath),
          'Used'  => fn($Total, $Free)=>$Total>0? $Total-$Free:$Total,
        ]],
      ]);
    }
  }
?>