<?
  Class T_HTTP_Cookie_Item
  {
    Var $Name    = False ;
    Var $Value   = False ;
    Var $Domain  = False ;
    Var $Path    = False ;
    Var $Expires = False ;
    Var $Secure  = False ;
 
    Function __Construct()
    {
    }
 
    Function Parse($Str)
    {
      $l=Explode(';', $Str);
      $kv=Explode('=', Trim(Array_Shift($l)), 2);
      $r=[];
      ForEach($l As $i)
      {
        $i=Explode('=', Trim($i), 2);
        $r[StrToLower($i[0])]=$i[1];
      }
      $r[0]=$kv[0];
      $r[1]=$kv[1];
      If(IsSet($r['expires']))
        $r[2]=StrToTime($r['expires']);
    }
 
    Function ToString()
    {
      $Res=[RawUrlEnCode($this->Name).'='.RawUrlEnCode($this->Value)];
      If($this->Expires) $Res[]='expires='.GMDate("D, d M Y H:i:s", $this->Expires).' GMT';
      If($this->Domain ) $Res[]='domain='.$this->Domain;
      If($this->Path   ) $Res[]='path='  .$this->Path  ;
      If($this->Secure ) $Res[]='secure';
      Return Implode('; ', $Res);
    }
  }
?>