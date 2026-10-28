<? NameSpace WLib\Object;

Class T_AutoLoad
{
  Var $Loader { Get { Try{ Return $this->Loader?->Get(); } Catch(\Throwable $e){} Return Null; } Set($v) { $this->Loader=$v? \WeakReference::Create($v):null; } }
  Var $Handler=Null;

  Function __Construct($Loader=Null)
  {
    $this->Loader=$Loader;
    $Weak = \WeakReference::Create($this);
    $this->Handler = fn($Class)=>$Weak->Get()?->Handler($Class);
    $this->Register();
  }
  
  Function Register   () { \Spl_AutoLoad_Register   ($this->Handler); }
  Function UnRegister () { \Spl_AutoLoad_UnRegister ($this->Handler); }
  
  Var $Detect=[ //TODO:
    ['C_'     ,['Class'     ]],
    ['T_'     ,['Type'      ]],
    ['I_'     ,['Interface' ]],
    ['Test_'  ,['UnitTest'  ]],
    ['Trait_' ,['Trait'     ]],
    ['S_'     ,['Struct'    ]],
    ['E_'     ,['Enum', 'Exception' ]],
    [''       ,['Lib'       ]],
  ];
  
  Function Detect($Name)
  {
    ForEach($this->Detect As $Item)
      If(Str_Starts_With($Name, $Item[0]))
        Return $Item;
  }
  
  Function Handler($RequiredClass)
  {
    $Loader=$this->Loader;
    $Path = Explode('\\', $RequiredClass);
  //$Loader->Log('Debug', 'Required class ', $Path);
    If(Count($Path)>1)
    {
      $Class     =Array_Pop($Path);
      $NameSpace =Join('\\', $Path);
      $Lib       =Array_Shift($Path);
      [$Prefix, $Types]=$this->Detect($Class);
      $Class = SubStr($Class, StrLen($Prefix));
      Array_Push($Path, $Class);
    }
    Else
    {
      [$Prefix, $Types]=$this->Detect($RequiredClass);
      $Class = SubStr($RequiredClass, StrLen($Prefix));
      $Path  = Explode('_', $Class);
    }
    Array_UnShift($Path, '');
    $Path  = Join('/', $Path);
    $Mode=['Safe'=>True];
    ForEach($Types As $Type)
      If($Res = $Loader->_Load_Lib($Path ,$Mode ,$Type))
      {
        $Loader->Log('Warning', 'Class ', $Res, ' wan\'t preloaded');
        return;
      }
  }
}