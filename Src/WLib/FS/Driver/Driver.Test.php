<?
  $this->Load_Class('/UnitTest/Case');
  
  Class Test_FS_Driver_Driver Extends C_UnitTest_Case
  {
    Var $Factory;
  
    Function _Init($Args)
    {
      $this->Factory=$this->Create_Object('/FS/Driver/Factory');
      Parent::_Init($Args);
      $this->Test_Register_Argument_Name_Value('Factory', $this->GetFactory());
    }
    
    Function GetFactory() { Return $this->Factory; }
    
    Function TestCanGenerateValid($Factory)
    {
      $Factory->Create('Base'   );
      $Factory->Create('Map'    );
      $Factory->Create('Mixed'  );
      $Factory->Create('Null'   );
      $Factory->Create('Router' );
      $Factory->Create('System' );
    }

    Function TestSystem($Factory)
    {
      Include 'Example.Attr.php8';
    /*
      $FS=$Factory->Create('System');
      $this->Log('Debug', 'Node:' )->Debug($FS[__FILE__  ]);
      $this->Log('Debug', 'Mode: ',        $FS[__FILE__  ]->Get('Mode'));
      $this->Log('Debug', 'Attrs:')->Debug($FS[__FILE__  ]->Get(['Path', 'Created', 'Mode', 'DeviceId', 'NodeId', 'Md5', 'Sha1', 'Content']));
      $this->Log('Debug', 'Attrs:')->Debug($FS[__DIR__   ]->Get(['Path', 'Created', 'Mode', 'DeviceId', 'NodeId'])); //TODO:, 'Md5', 'Sha1'
      $this->Log('Debug', 'Attrs:')->Debug($FS['Unknown' ]->Get(['Path', 'Stat'])); //TODO:'Created', 'Mode', 'Md5', 'Sha1'

      $Node=$FS['Test'];
      $this->Log('Debug', 'TestFunc    : ', $Node->Call('TestFunc', ['a'=>1, 'b'=>2]));
      $this->Log('Debug', 'TestGet     : ', $Node->Get('Test', ['a'=>1, 'b'=>2]));
      $this->Log('Debug', 'TestSet     : ', $Node->Set('Test', 'InTestValue', ['a'=>1, 'b'=>2]));
      $this->Log('Debug', 'UnknownFunc : ', $Node->Call('UnknownFunc', ['a'=>1, 'b'=>2]));
      $this->Log('Debug', 'UnknownGet  : ', $Node->Get('Unknown', ['a'=>1, 'b'=>2]));
      $this->Log('Debug', 'UnknownSet  : ', $Node->Set('Unknown', 'InTestValue', ['a'=>1, 'b'=>2]));
    */
    }
  }
?>
