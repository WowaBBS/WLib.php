<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Base_Repeat Extends T_RegExp_Node_Base_Base
  {
    Var $Node ;
    Var $Min=1;
    Var $Max=1;
    Var $Type=''; // '', '+', '?'
 
    Function __Construct($Node, $Min=0, $Max=-1, $Type='')
    {
      $this->Node =$Node ;
      $this->Min  =$Min  ;
      $this->Max  =$Max  ;
      $this->Type =$Type ;
    }

    Function Make($Res)
    {
      $Res[]=$this->Node;
      $Min=$this->Min;
      $Max=$this->Max;
      If($Min===0 && $Max=== 1) $Res[]='?'; Else
      If($Min===0 && $Max===-1) $Res[]='*'; Else
      If($Min===1 && $Max===-1) $Res[]='+'; Else
      {
        $Res[]='{';
        $Res[]=$Min;
        If($Min!==$Max)
        {
          $Res[]=',';
          If($Max>0)
            $Res[]=$Max;
        }
        $Res[]='}';
      }
      $Res[]=$this->Type;
    }

    Function Validate($Res)
    {
      If(!$Res->NodeStr($this->Node)) Return False;
      // TODO: $Type In '', '+', '?';
      // TODO: $Min In [0..$Max]
      // TODO: $Max In [<0, 1..]
      Return True;
    }
  }
  