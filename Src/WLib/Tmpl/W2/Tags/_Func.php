<?
  Class T_W2_Tag__Func
  {
    Static $FuncInfo=[
      // �������� �������
      'Name'=>'',
      // ��������� ���������� �������
      //   1 - �������� ���������, False - ��� �������� (����������� ��� Vars)
      //   2 - ��� ���������
      //      Vars  - ������� ���������� Vars
      //      Var   - �������� ���������� ���������
      //      Val   - �������� ��������� ��������� ��� ����
      //      Str   - �������� ��������� ��������� ��� ������
      //      Int   - �������� ��������� ��������� ��� ����� �����
      //      Float - �������� ��������� ��������� ��� ����� �����
      //      Path  - ����������� �� ������� ????
      //   3 - �������� �� ���������
      'FArgs'=>[
        [False   ,'Vars' ],
        ['Name1' ,'Var'  ,'Def'],
        ['Name2' ,'Path' ,'Def'],
        ['Name3' ,'Str'  ,''   ],
        ['Name4' ,'Int'  ,10   ],
      ],
      // ����������� ���������� ����������
      'minArgs'=>2,
      'Args'=>['Name1', 'Name2', 'Name3'],
    ];
 
    Static $InnerTags=[
      '#Data' => ['#Template', 'Default'],
    ];
 
    Function MakeAttr($Tag)
    {
      If(!$Tag->HasAttributes())
        Return;
      $Var=Explode(';', $Tag->Params);
      $Args=&$this::$FuncInfo['Args'];
      If($Args===True)
      {
        $Args=[];
        ForEach($this::$FuncInfo['FArgs']As $a)
          If($a[0]!==False)
            $Args[]=$a[0];
      }
      ForEach($Args As $k=>$v)
        If(IsSet($Var[$k]))
        {
          If($Var[$k]!=='')
            $Tag->SetAttr($v, $Var[$k]);
        }
        Else
          Break;
    }
 
    Function MakePHP($Builder, $Tag, $Tags)
    {
      $Args=[];
      $CArgs=0;
      $FuncInfo=&$this::$FuncInfo;
      ForEach($FuncInfo['FArgs']As $FArg)
      {
        If($FArg[0])
        {
          $Val=$Tag->GetAttr($FArg[0]);
          If($Val===False)
            $Val=$FArg[2];
          Else
            $CArgs=Count($Args)+1;
        }
        Switch($FArg[1])
        {
        Case 'Vars'  : $Val='&'.$Builder->Vars(); Break;
        Case 'Var'   : $Val=$Builder->Vars_Get($Val); Break;
        Case 'Val'   : Break;
        Case 'Str'   : $Val="'".$Val."'"; Break;
        Case 'Int'   : $Val=(Int)$Val; Break;
        Case 'Float' : $Val=(Float)$Val; Break;
        Case 'Path'  : $Val=$Builder->ParsePath($Val); Break;
        };
        $Args[]=$Val;
      }

      $minArgs=$FuncInfo['minArgs'];
      If($CArgs<$minArgs)
        $CArgs=$minArgs;
      If(Count($Args)>$CArgs)
        $Args=Array_Slice($Args, 0, $CArgs);
  
      $Builder->Out->Evaluate($FuncInfo['Name'].'('.Implode(', ', $Args).')');
    }
  }
?>