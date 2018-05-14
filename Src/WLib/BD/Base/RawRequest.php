<?
  $Loader->Load_Class('/Object');

  Class C_BD_Base_RawRequest Extends C_Object
  {
    Var $Request=Array();
 
    Protected Function _Init(Array $Args)
    {
      Parent::_Init($Args);
      $this->Assign($Args[0] ?? $Args['Request']);
    }

    Function Assign($ARequest='')
    {
      If(Is_Array  ($ARequest)) $this->Request=$ARequest; Else
      If(Is_Object ($ARequest)) $this->Request=$ARequest->Request;
    }
 
  // $Name - ��������� ������� (��� ����������)
  // $Type - ��� �������������
  //    0 - �������
  //    1 - ������� ��� ������� ��������
  //    ? - ������� ��� ������ ��������������� ��������
  //    * - ������� ���������� (���� �� �����������)
  // $Table  - ��� ������� ��� ���� �������
  // $Fields - ������ �����
  // $Where  - ������� �����
    Function Table($Name, $Type, $Table, $Fields=[], $Where=[])
    {
      If(!Is_Array  ($Where  )) $Where  =[$Where];
      If(!Is_Array  ($Fields )) $Fields =[$Fields];
      If(!Is_String ($Table  )) $Table  =$Table->Name;
      $this->Request[]=['Table', $Name, $Type, $Table, $Fields, $Where];
    }
 
    // ������� ������� �� ������(�)
    Function Where($Where)
    {
      If(!Is_Array($Where)) $Where=[$Where];
      $this->Request[]=['Where', $Where];
    }
 
    // ���� ������� ������� �� ������(�)
    Function Having($Having)
    {
      If(!Is_Array($Having)) $Having=[$Having];
      $this->Request[]=['Having', $Having];
    }
 
    // ������������ �� ����(-��)
    Function GroupBy($Group)
    {
      If(!Is_Array($Group)) $Group=[$Group];
      $this->Request[]=['Group', $Group];
    }
 
    // ����������� �� ����
    Function Sort($Sort, $z=True)
    {
      If(!Is_Array($Sort)) $Sort=[$Sort=>$z];
      
      $Res=[];
      ForEach($Sort As $k=>$v)
        $Res[Is_Integer($k)? $v:$k]=$z;
      $this->Request[]=['Sort', $Sort];
    }
 
    Function Fields($Fields)
    {
      If(!Is_Array($Fields)) $Fields=[$Fields];
      
      $this->Request[]=['Fields', $Fields];
    }
 
    Function Limit($Beg, $Count)
    {
      $this->Request[]=['Limit', $Beg, $Count];
    }
  }
?>