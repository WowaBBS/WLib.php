<?
  $Loader->Load_Type('/FS/Attr/Mode');
  $Loader->Load_Type('/FS/Attr/Hash');
  $Loader->Load_Type('/FS/Attr/IntId');
  $Loader->Load_Type('/FS/Attr/Date/UnixTime' );

  Use T_FS_Attr_Date_UnixTime As FileTime ;
  Use T_FS_Attr_Mode          As Mode     ;
  Use T_FS_Attr_Hash          As Hash     ;
  Use T_FS_Attr_IntId         As IntId    ;
  
  // Node:
  //  IsDir       Boolean
  //  IsFile      Boolean
  //  IsLink      Boolean
  //  Type        EnumString [File, Directory, Link, Socket, ... Fifo, Char, Block]
  //  Writeble    Boolean
  //  Readable    Boolean
  //# Executable  Boolean //?
  //  Exists      Boolean
  //  Created     FileDate
  //  Modified    FileDate
  //  LastAccess  FileDate
  //SymLink:
  //  Link        String
  //File:
  //  Size        Integer
  //  Content     String <|Stream
  //  Stream      Stream
  //  Md5         String
  //Optional:
  //  Stat
  //
  //Device:
  //  DeviceId
  //  FreeSpace
  //  TotalSpace
  
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
        'PathInfo'   => fn($Path)=>PathInfo($Path),             // /www/htdocs/inc/lib.inc.php
        'Folder'     => fn($PathInfo)=>$PathInfo['dirname'   ], // /www/htdocs/inc
        'Name'       => fn($PathInfo)=>$PathInfo['basename'  ], // lib.inc.php
        'Ext'        => fn($PathInfo)=>$PathInfo['extension' ], // php
        'Nick'       => fn($PathInfo)=>$PathInfo['filename'  ], // lib.inc
        'NoExt'      => fn($PathInfo)=>$PathInfo['extension' ], // /www/htdocs/inc/lib.inc
      ]);
    }
  
    Static Function Init_Stat($Attr)
    {
      $Attr->Register([
      //'Stat'       => fn()=>Static::_EmptyStat(),
      
        'IsDir'      => fn($Type)=>$Type==='Dir' ,
        'IsFile'     => fn($Type)=>$Type==='File' ,
        'IsLink'     => fn($Stat)=>$Stat['Is_Link'],
        'Exists'     => fn($RealPath)=>(Bool)$Stat,

        'Type'       => fn($Mode)=>$Mode->GetType(),
        'DeviceId'   => fn($Stat)=>New IntId   ($Stat['dev'     ]), // 0
        'NodeId'     => fn($Stat)=>New IntId   ($Stat['ino'     ]), // 1
        'Mode'       => fn($Stat)=>New Mode    ($Stat['mode'    ]), // 2
        'NumLinks'   => fn($Stat)=>             $Stat['nlink'   ] , // 3
        'UserId'     => fn($Stat)=>             $Stat['uid'     ] , // 4
        'GroupId'    => fn($Stat)=>             $Stat['gid'     ] , // 5
        'DeviceType' => fn($Stat)=>             $Stat['rdev'    ] , // 6
        'Size'       => fn($Stat)=>             $Stat['size'    ] , // 7
        'LastAccess' => fn($Stat)=>New FileTime($Stat['atime'   ]), // 8
        'Modified'   => fn($Stat)=>New FileTime($Stat['mtime'   ]), // 9
        'Created'    => fn($Stat)=>New FileTime($Stat['ctime'   ]), //10
        'BlockSize'  => fn($Stat)=>             $Stat['blksize' ] , //11
        'Blocks'     => fn($Stat)=>             $Stat['blocks'  ] , //12
      ]);
    }    

    Static Function Init_StatAlt($Attr)
    {
      $Attr->Register([
        'Executable' => fn($RealPath)=>Is_Executable ($RealPath),
        'Readable'   => fn($RealPath)=>Is_Readable   ($RealPath),
        'Writable'   => fn($RealPath)=>Is_Writable   ($RealPath),
        
        'IsDir'      => fn($RealPath)=>Is_Dir        ($RealPath),
        'IsFile'     => fn($RealPath)=>Is_File       ($RealPath),
        'IsLink'     => fn($RealPath)=>Is_Link       ($RealPath),
        'Exists'     => fn($RealPath)=>FileExists    ($RealPath),

        'Type'       => fn($RealPath)=>             FileType  ($RealPath) ,
        'DeviceId'   => fn($RealPath)=>New IntId   (LinkInfo  ($RealPath)), // 0
        'NodeId'     => fn($RealPath)=>New IntId   (FileINode ($RealPath)), // 1
        'Mode'       => fn($RealPath)=>New Mode    (FilePerms ($RealPath)),
      //'NumLinks'   => fn($Stat    )=>             $Stat['nlink'   ]     , // 3
        'UserId'     => fn($RealPath)=>             FileOwner ($RealPath) ,
        'GroupId'    => fn($RealPath)=>             FileGroup ($RealPath) ,
      //'DeviceType' => fn($Stat    )=>             $Stat['rdev'    ]     , // 6
        'Size'       => fn($RealPath)=>             FileSize  ($RealPath) ,
        'LastAccess' => fn($RealPath)=>New FileTime(FileATime ($RealPath)),
        'Modified'   => fn($RealPath)=>New FileTime(FileMTime ($RealPath)),
        'Created'    => fn($RealPath)=>New FileTime(FileCTime ($RealPath)),
      //'BlockSize'  => fn($Stat    )=>             $Stat['blksize' ] , //11
      //'Blocks'     => fn($Stat    )=>             $Stat['blocks'  ] , //12
      ]);
    }
    
    Static Function Init_Test($Attr)
    {
      $Attr->Register([
        'TestFunc' => fn($Driver, $Args)=>$Driver->Log('Debug', 'TestFunc ', $Args)->Ret('TestResult'),
        'Test'     =>[fn($Driver, $Args)=>$Driver->Log('Debug', 'TestGet ', $Args)->Ret('TestValue'), 
                      fn($Driver, $Test, $Args)=>$Driver->Log('Debug', 'TestSet ', $Test, ' ', $Args)->Ret('TestRes')],
      ]);
    }
    
    Static Function Init_Disk($Attr)
    {
      $Attr->Register([
        'DiskTotal' => fn($RealPath)=>Disk_Total_Space ($RealPath),
        'DiskFree'  => fn($RealPath)=>Disk_Free_Space  ($RealPath),
        'DiskUsed'  => fn($DiskTotal, $DiskFree)=>$DiskTotal>0? $DiskTotal-$DiskFree:$DiskTotal,
      ]);
    }
  }
?>