<?
  return [
  //****************************************************************
  // m120515_122132_initial.php
    ['Type', 'PK', 'Integer', 'Primary'=>true, 'AutoInc'],
    ['Table', 'lookup',
      ['Fields',
        'id'       =>[ 'PK'           ],
      //'id'       =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'name'     =>[['VarChar', 128]],
        'code'     =>[ 'Integer'      ],
        'type'     =>[['VarChar', 128]],
        'position' =>[ 'Integer'      ],
      ],

      ['Rows',
        //id  , name                ,code, type                 ,position
        
        // Insert crash report statuses
        [null ,'Waiting'            ,   1, 'CrashReportStatus'  ,1],
        [null ,'Processing'         ,   2, 'CrashReportStatus'  ,2],
        [null ,'Ready'              ,   3, 'CrashReportStatus'  ,3],
        [null ,'Invalid'            ,   4, 'CrashReportStatus'  ,4],
      
        // Insert debug info statuses
        [null ,'Waiting'            ,   1, 'DebugInfoStatus'    ,1],
        [null ,'Processing'         ,   2, 'DebugInfoStatus'    ,2],
        [null ,'Ready'              ,   3, 'DebugInfoStatus'    ,3],
        [null ,'Invalid'            ,   4, 'DebugInfoStatus'    ,4],
  
        // Insert user statuses
        [null ,'Active'             ,   1, 'UserStatus'         ,1],
        [null ,'Disabled'           ,   2, 'UserStatus'         ,2],
  
        // Insert user group statuses
        [null ,'Active'             ,   1, 'UserGroupStatus'    ,1],
        [null ,'Disabled'           ,   2, 'UserGroupStatus'    ,2],
  
        // Insert project statuses
        [null ,'Active'             ,   1, 'ProjectStatus'      ,1],
        [null ,'Disabled'           ,   2, 'ProjectStatus'      ,2],
  
        // Insert operation statuses
        [null ,'Started'            ,   1, 'OperationStatus'    ,1],
        [null ,'Succeeded'          ,   2, 'OperationStatus'    ,2],
        [null ,'Failed'             ,   3, 'OperationStatus'    ,3],
  
        // Insert symbol load statuses
        [null ,'No symbols loaded.' ,   0, 'SymLoadStatus'      ,0],
        [null ,'Symbols loaded.'    ,   1, 'SymLoadStatus'      ,1],
  
        // Insert bug statuses
        [null ,'New'                ,   1, 'BugStatus'          ,1],
        [null ,'Reviewed'           ,   2, 'BugStatus'          ,2],
        [null ,'Accepted'           ,   3, 'BugStatus'          ,3],
        [null ,'Started'            ,   4, 'BugStatus'          ,4],
        [null ,'Fixed'              , 101, 'BugStatus'          ,5],
        [null ,'Verified'           , 102, 'BugStatus'          ,6],
        [null ,'Duplicate'          , 103, 'BugStatus'          ,7],
        [null ,'WontFix'            , 104, 'BugStatus'          ,8],
  
        // Insert bug priority statuses
        [null ,'Low'                ,   1, 'BugPriority'        ,2],
        [null ,'Medium'             ,   2, 'BugPriority'        ,1],
        [null ,'High'               ,   3, 'BugPriority'        ,3],
        [null ,'Critical'           ,   4, 'BugPriority'        ,4],
  
        // Insert bug reproducability statuses
        [null ,'NotTried'           ,   1, 'BugReproducability' ,1],
        [null ,'Never'              ,   2, 'BugReproducability' ,2],
        [null ,'Sometimes'          ,   3, 'BugReproducability' ,3],
        [null ,'Always'             ,   4, 'BugReproducability' ,4],
      ],
    ],
    ['Table', 'usergroup',
      ['Type', 'Status', 'EnumInt', 'Type'=>'Integer',
        1=>'Active'   , // This user is an active user.
        2=>'Disabled' , // This user is a retired user.
      ],
      ['Type', 'Flag', 'SetInt', 'Type'=>'Integer',
        0x1=>'Standard Group' , // This group is standard.
        0x2=>'Cant Disable'   , // This group can't be disabled.
        0x4=>'Cant Update'    , // This group can't be updated.
      ],
      ['Fields',
        'id'                         =>[ 'PK',          ],
    //  'id'                         =>[ 'Integer'      ], // PRIMARY KEY AUTOINCREMENT',
        'name'                       =>[['VarChar',  32]],
        'description'                =>[['VarChar', 256]],
        'status'                     =>[ 'Status'       ],
        'flags'                      =>[ 'Flag'         ],
        'gperm_access_admin_panel'   =>[ 'Integer'      ],
        'pperm_browse_crash_reports' =>[ 'Integer'      ],
        'pperm_browse_bugs'          =>[ 'Integer'      ],
        'pperm_browse_debug_info'    =>[ 'Integer'      ],
        'pperm_manage_crash_reports' =>[ 'Integer'      ],
        'pperm_manage_bugs'          =>[ 'Integer'      ],
        'pperm_manage_debug_info'    =>[ 'Integer'      ],
        'default_sidebar_tab'        =>[['VarChar',  16]],
        'default_bug_status_filter'  =>[['VarChar',  16]],
      ],

      // Insert standard user groups
      ['Row',
        'name'        =>'Admin'           ,
        'description' =>'Administrators'  ,
        'status'      =>'Active'          ,
        'flags'       =>['Standard Group' ,
                       //'Cant Disable'   ,
                         'Cant Update'    ],
        'gperm_access_admin_panel'   =>1,
        'pperm_browse_crash_reports' =>1,
        'pperm_browse_bugs'          =>1,
        'pperm_browse_debug_info'    =>1,
        'pperm_manage_crash_reports' =>1,
        'pperm_manage_bugs'          =>1,
        'pperm_manage_debug_info'    =>1,
        'default_sidebar_tab'        =>'Digest',
        'default_bug_status_filter'  =>'open',
      ],
      ['Row',
        'name'        =>'Dev'            ,
        'description' =>'Developers'     ,
        'status'      =>'Active'         ,
        'flags'       =>'Standard Group' ,
        'gperm_access_admin_panel'   =>0,
        'pperm_browse_crash_reports' =>1,
        'pperm_browse_bugs'          =>1,
        'pperm_browse_debug_info'    =>1,
        'pperm_manage_crash_reports' =>1,
        'pperm_manage_bugs'          =>1,
        'pperm_manage_debug_info'    =>1,
        'default_sidebar_tab'        =>'Digest',
        'default_bug_status_filter'  =>'owned',
      ],
      ['Row',
        'name'        =>'QA'                ,
        'description' =>'Quality Assurance' ,
        'status'      =>'Active'            ,
        'flags'       =>'Standard Group'    ,
        'gperm_access_admin_panel'   =>0,
        'pperm_browse_crash_reports' =>1,
        'pperm_browse_bugs'          =>1,
        'pperm_browse_debug_info'    =>0,
        'pperm_manage_crash_reports' =>1,
        'pperm_manage_bugs'          =>1,
        'pperm_manage_debug_info'    =>0,
        'default_sidebar_tab'        =>'Digest',
        'default_bug_status_filter'  =>'verify',
      ],
      ['Row',
        'name'        =>'Guest'          ,
        'description' =>'Limited Users'  ,
        'status'      =>'Active'         ,
        'flags'       =>'Standard Group' ,
        'gperm_access_admin_panel'   =>0,
        'pperm_browse_crash_reports' =>1,
        'pperm_browse_bugs'          =>1,
        'pperm_browse_debug_info'    =>0,
        'pperm_manage_crash_reports' =>0,
        'pperm_manage_bugs'          =>0,
        'pperm_manage_debug_info'    =>0,
        'default_sidebar_tab'        =>'Digest',
        'default_bug_status_filter'  =>'open',
      ],
    ],
    ['Table', 'user',
      ['Type', 'Status', 'EnumInt', 'Type'=>'Integer',
        1=>'Active'   , // This user is an active user.
        2=>'Disabled' , // This user is a retired user.
      ],
      ['Type', 'Flag', 'SetInt', 'Type'=>'Integer',
        0x1=>'Standard User'     , // This user is a standard account.
        0x2=>'Password Resetted' , // This user must change his password on login.
      ],
      ['Fields',
        'id'              =>[ 'PK'           ],
      //'id'              =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'username'        =>[['VarChar', 128], 'Unique'=>True], //UNIQUE',
        'usergroup'       =>[ 'Integer'      ],
        'password'        =>[['VarChar', 128]],
        'salt'            =>[['VarChar', 128]],
        'pwd_reset_token' =>[['VarChar', 128], null],
        'status'          =>[ 'Integer'      ],
        'flags'           =>[ 'Integer'      ],
        'email'           =>[['VarChar', 128]],
      ],

    // Insert root user
      ['Row',
        'username'        =>'root',
        'usergroup'       =>1,
        'password'        =>'7dcfe0dd0af7bf680e0ae5e410ac02ee',
        'salt'            =>'e8wqopb0guk8ryhbargqzfahmqaz5td8',
        'pwd_reset_token' =>null,
        'status'          =>'Active',
        'flags'           =>['Standard User', 'Password Resetted'],
        'email'           =>'test@localhost',
      ],
    ],
    ['Table', 'appversion',
      ['Fields',
        'id'         =>[ 'PK'           ],
      //'id'         =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'project_id' =>[ 'Integer'      ],
        'version'    =>[['VarChar',  32]],
      ],
      ['Constraint', 'Name'=>'uc_Version', 'Unique', ['project_id', 'version']],
    ],
    ['Table', 'project',
      ['Fields',
      //'id'          =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'          =>['PK'            ],
        'name'        =>[['VarChar',  32]],
        'description' =>[['VarChar', 256]],
        'status'      =>[ 'Integer'      ],
        'crash_reports_per_group_quota'   =>['Integer'],
        'crash_report_files_disc_quota'   =>['Integer'],
        'bug_attachment_files_disc_quota' =>['Integer'],
        'debug_info_files_disc_quota'     =>['Integer'],
      ],
    ],
    ['Table', 'user_project_access',
      ['Fields',
      //'id'           =>[ 'Integer' ], //PRIMARY KEY AUTOINCREMENT',
        'id'           =>[ 'PK'      ],
        'user_id'      =>[ 'Integer' ],
        'project_id'   =>[ 'Integer' ],
        'usergroup_id' =>[ 'Integer' ],
      ],
    //CONSTRAINT uc_UserID UNIQUE (user_id, project_id)
    ],
    ['Table', 'crashreport',
      ['Fields',
      //'id'                  =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'                  =>[ 'PK'           ],
        'srcfilename'         =>[['VarChar', 512]],
        'filesize'            =>[ 'Integer'      ],
        'date_created'        =>[ 'Integer', null],
        'received'            =>[ 'Integer'      ],
        'status'              =>[ 'Integer'      ],
        'ipaddress'           =>[['VarChar',  32]],
        'md5'                 =>[['VarChar',  32]],
        'groupid'             =>[ 'Integer'      ],
        'crashguid'           =>[['VarChar',  36]],
        'project_id'          =>[ 'Integer'      ],
        'appversion_id'       =>[ 'Integer'      ],
        'emailfrom'           =>[['VarChar',  32]],
        'description'         =>[ 'Text'         ],
        'crashrptver'         =>[['VarChar',  16]],
        'exception_type'      =>[['VarChar',  64]],
        'exception_code'      =>[ 'BigInt' , null],
        'exception_thread_id' =>[ 'Integer', null],
        'exceptionmodule'     =>[['VarChar', 512]],
        'exceptionmodulebase' =>[ 'BigInt' , null],
        'exceptionaddress'    =>[ 'BigInt' , null],
        'exe_image'           =>[['VarChar',1024]],
        'os_name_reg'         =>[['VarChar', 512]],
        'os_ver_mdmp'         =>[['VarChar', 128]],
        'os_is_64bit'         =>[ 'Integer', null],
        'geo_location'        =>[['VarChar',  16]],
        'product_type'        =>[['VarChar', 128]],
        'cpu_architecture'    =>[['VarChar',  64]],
        'cpu_count'           =>[ 'Integer', null],
        'gui_resource_count'  =>[ 'Integer', null],
        'open_handle_count'   =>[ 'Integer', null],
        'memory_usage_kbytes' =>[ 'Integer', null],
      ],
    ],
    ['Table', 'fileitem',
      ['Fields',
        'id'             =>[ 'PK'            ],
        'crashreport_id' =>[ 'Integer'       ],
        'filename'       =>[['VarChar' , 512]],
        'description'    =>[['VarChar' , 512]],
      ],
    ],
    ['Table', 'customprop',
      ['Fields',
        'id'              =>[ 'PK'           ],
        'crashreport_id'  =>[ 'Integer'      ],
        'name'            =>[['VarChar', 128]],
        'value'           =>['Text'          ],
      ],
    ],
    ['Table', 'thread',
      ['Fields',
        'id'              =>[ 'PK'           ],
        'thread_id'       =>[ 'Integer'      ],
        'crashreport_id'  =>[ 'Integer'      ],
        'stack_trace_md5' =>[['VarChar',  32]],
      ],
    ],
    ['Table', 'stackframe',
      ['Fields',
      //'id'              =>[ 'Integer'       ], //PRIMARY KEY AUTOINCREMENT',
        'id'              =>[ 'PK'            ],
        'thread_id'       =>[ 'Integer'       ],
        'addr_pc'         =>[ 'BigInt'        ],
        'module_id'       =>[ 'Integer', null ],
        'offs_in_module'  =>[ 'Integer', null ],
        'symbol_name'     =>[['VarChar' ,2048]],
        'und_symbol_name' =>[['VarChar' ,2048]],
        'offs_in_symbol'  =>[ 'Integer', null ],
        'src_file_name'   =>[['VarChar' , 512]],
        'src_line'        =>[ 'Integer', null ],
        'offs_in_line'    =>[ 'Integer', null ],
      ],
    ],
    ['Table', 'module',
      ['Fields',
        'id'                   =>[ 'PK'            ],
        'crashreport_id'       =>[ 'Integer'       ],
        'name'                 =>[['VarChar' , 512]],
        'sym_load_status'      =>[ 'Integer'       ],
        'loaded_debug_info_id' =>[ 'Integer', null ],
        'file_version'         =>[['VarChar' ,  32]],
        'timestamp'            =>[ 'Integer', null ],
      ],
    ],
    ['Table', 'processingerror',
      ['Fields',
        'id'      =>['PK'      ],
        'type'    =>['Integer' ],
        'srcid'   =>['Integer' ],
        'message' =>['Text'    ],
      ],
    ],
    ['Table', 'crashgroup',
      ['Fields',
        'id'              =>[ 'PK'           ],
        'created'         =>[ 'Integer'      ],
        'status'          =>[ 'Integer'      ],
        'project_id'      =>[ 'Integer'      ],
        'appversion_id'   =>[ 'Integer'      ],
        'title'           =>[['VarChar', 256]],
        'md5'             =>[['VarChar',  32]],
      ],
    ],
    ['Table', 'bug',
      ['Fields',
    //  'id'                 =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'                 =>[ 'PK'           ],
        'date_created'       =>[ 'Integer'      ],
        'date_last_modified' =>[ 'Integer'      ],
        'date_closed'        =>[ 'Integer', null],
        'project_id'         =>[ 'Integer'      ],
        'appversion_id'      =>[ 'Integer'      ],
        'status'             =>[ 'Integer'      ],
        'summary'            =>[['VarChar', 256]],
        'description'        =>[ 'Text'         ],
        'reported_by'        =>[ 'Integer'      ],
        'assigned_to'        =>[ 'Integer', null],
        'priority'           =>[ 'Integer'      ],
        'reproducability'    =>[ 'Integer'      ],
        'merged_into'        =>[ 'Integer', null],
      ],
    ],
    ['Table', 'bug_change',
      ['Fields',
        'id'               =>['PK'           ],
        'bug_id'           =>['Integer'      ],
        'timestamp'        =>['Integer'      ],
        'user_id'          =>['Integer'      ],
        'flags'            =>['Integer'      ],
        'status_change_id' =>['Integer', null],
        'comment_id'       =>['Integer', null],
      ],
    ],
    ['Table', 'bug_status_change',
      ['Fields',
        'id'              =>['PK'           ],
        'status'          =>['Integer', null],
        'assigned_to'     =>['Integer', null],
        'priority'        =>['Integer', null],
        'reproducability' =>['Integer', null],
        'merged_into'     =>['Integer', null],
      ],
    ],
    ['Table', 'bug_attachment',
      ['Fields',
        'id'            =>[ 'PK'           ],
        'bug_change_id' =>[ 'Integer'      ],
        'filename'      =>[['VarChar', 512]],
        'filesize'      =>[ 'Integer'      ],
        'md5'           =>[['VarChar',  32]],
      ],
    ],
    ['Table', 'bug_comment',
      ['Fields',
      //'id'   =>['Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'   =>['PK'           ],
        'text' =>['Text'         ],
      ],
    ],
    ['Table', 'bug_crashreport',
      ['Fields',
      //'id'              =>['Integer'], //PRIMARY KEY AUTOINCREMENT',
        'id'              =>['PK'     ],
        'bug_id'          =>['Integer'],
        'crashreport_id'  =>['Integer'],
      ],
    //CONSTRAINT uc_Mapping UNIQUE (bug_id, crashreport_id)
    ],
    ['Table', 'bug_crashgroup',
      ['Fields',
    //'id'              =>['Integer'], //PRIMARY KEY AUTOINCREMENT',
      'id'              =>['PK'     ],
      'bug_id'          =>['Integer'],
      'crashgroup_id'   =>['Integer'],
      ],
    //CONSTRAINT uc_Mapping UNIQUE (bug_id, crashgroup_id)
    ],
    ['Table', 'debuginfo',
      ['Fields',
      //'id'              =>[ 'Integer'       ], //PRIMARY KEY AUTOINCREMENT',
        'id'              =>[ 'PK'            ],
        'project_id'      =>[ 'Integer'       ],
        'dateuploaded'    =>[ 'Integer'       ],
        'status'          =>[ 'Integer'       ],
        'filename'        =>[['VarChar' , 512]],
        'guid'            =>[['VarChar' ,  48]],
        'md5'             =>[['VarChar' ,  32]],
        'filesize'        =>[ 'Integer'       ],
      ],
    ],
    ['Table', 'operation',
      ['Fields',
      //'id'              =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'              =>[ 'PK'           ],
        'status'          =>[ 'Integer'      ],
        'timestamp'       =>[ 'Integer'      ],
        'optype'          =>[ 'Integer'      ],
        'srcid'           =>[ 'Integer'      ],
        'cmdid'           =>[['VarChar',  32]],
        'operand1'        =>[ 'Text'         ],
        'operand2'        =>[ 'Text'         ],
        'operand3'        =>[ 'Text'         ],
      ],
    ],
    ['Table', 'mail_queue',
      ['Fields',
      //'id'              =>[ 'Integer'      ], //PRIMARY KEY AUTOINCREMENT',
        'id'              =>[ 'PK'           ],
        'create_time'     =>[ 'Integer'      ],
        'status'          =>[ 'Integer'      ],
        'sent_time'       =>[ 'Integer', null],
        'recipient'       =>[['VarChar',1024]],
        'email_subject'   =>[['VarChar', 256]],
        'email_headers'   =>[['VarChar',1024]],
        'email_body'      =>[ 'Text'         ],
      ],
    ],
    ['Table', 'AuthItem',
      ['Fields',
        'name'        =>[['VarChar', 64 ], 'Primary'=>true],
        'type'        =>[ 'Integer'     ],
        'description' =>[ 'Text', null  ],
        'bizrule'     =>[ 'Text', null  ],
        'data'        =>[ 'Text', null  ],
      ],
    ],
    ['Table', 'AuthItemChild',
      ['Fields',
        'parent ' =>[['VarChar', 64]],
        'child'   =>[['VarChar', 64]],
      ],
      ['Primary', ['parent', 'child']],
      ['Foreign' ,'parent' ,'AuthItem', 'name', 'Cascade'],
      ['Foreign' ,'child'  ,'AuthItem', 'name', 'Cascade'],
    ],
    ['Table', 'AuthAssignment',
      ['Fields',
        'itemname' =>[['VarChar', 64]],
        'userid'   =>[['VarChar', 64]],
        'bizrule'  =>[ 'Text',   null],
        'data'     =>[ 'Text',   null],
      ],
      ['Primary', ['itemname','userid']],
      ['Foreign' ,'itemname'  ,'AuthItem', 'name', 'Cascade'],
    ],
    
  //****************************************************************
  // m121110_163852_bug_assigned_to_required.php
    ['Update/Table', 'bug',
      // TODO: UPDATE {{bug}} SET assigned_to=-1 WHERE assigned_to IS NULL
      ['Fields/Update',
        'assigned_to'        =>[ 'Integer', -1],
      ],
    ],

  //****************************************************************
  // m121114_141005_user_cur_project_field.php
    ['Update/Table', 'user',
      ['Fields',
        'cur_project_id'    =>['Integer', 'null'],
        'cur_appversion_id' =>['Integer', 'null'], 
      ],
    ],
    
  //****************************************************************
  // m130125_051239_add_module_guidnage_field.php
    ['Update/Table', 'module',
      ['Fields',
        'matching_pdb_guid' =>[['VarChar', 48], 'null'], 
      ],
    ],
    
  //****************************************************************
  // m130227_153955_add_project_age_flag.php
    ['Update/Table', 'project',
      ['Fields',
        'require_exact_build_age' =>['Integer', 1], 
      ],
    ],
    
  //****************************************************************
  // m130320_130659_exceptionaddress_unsigned.php
    ['Update/Table', 'crashreport',
      ['Fields',
        'exceptionaddress'    =>[['BigInt' ,'Unsigned'], null],
        'exceptionmodulebase' =>[['BigInt' ,'Unsigned'], null],
        'exception_code'      =>[['BigInt' ,'Unsigned'], null],
      ],
    ],
    
  //****************************************************************
  // m130414_150316_add_indexes.php
    ['Update/Table', 'crashreport',
      ['Index', 'Name'=>'crashreport_crashguid', 'crashguid'],
      ['Index', 'Name'=>'crashreport_project', ['project_id', 'appversion_id', 'groupid']],
      ['Index', 'Name'=>'crashreport_crashgroup', 'groupid'],
    ],
    ['Update/Table', 'fileitem',
      ['Index', 'Name'=>'fileitem_crashreport', 'crashreport_id'],
    ],
    ['Update/Table', 'customprop',
      ['Index', 'Name'=>'customprop_crashreport', 'crashreport_id'],
    ],
    ['Update/Table', 'thread',
      ['Index', 'Name'=>'thread_crashreport', 'crashreport_id'],
    ],
    ['Update/Table', 'stackframe',
      ['Index', 'Name'=>'stackframe_thread', 'thread_id'],
    ],
    ['Update/Table', 'module',
      ['Index', 'Name'=>'module_crashreport', 'crashreport_id'],
    ],
    ['Update/Table', 'processingerror',
      ['Index', 'Name'=>'processingerror_src', ['srcid', 'type']],
    ],
    ['Update/Table', 'crashgroup',
      ['Index', 'Name'=>'crashgroup_project', ['project_id', 'appversion_id']],
    ],
    ['Update/Table', 'debuginfo',
      ['Index', 'Name'=>'debuginfo_project', 'project_id'],
    ],
  //****************************************************************
  ];
?>