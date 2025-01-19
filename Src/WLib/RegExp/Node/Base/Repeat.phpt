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
      $Min=$Min;
      $Max=$Max;
      If($Min===0 && $Max=== 1) $Res[]='?'; Else
      If($Min===0 && $Max===-1) $Res[]='*'; Else
      If($Min===1 && $Max===-1) $Res[]='+'; Else
      {
        $Res[]='{';
        $Res[]=$Min;
        If($Min!==$Max)
        If($Max>0)
        {
          $Res[]=',';
          $Res[]=$Max;
        }
        $Res[]='}';
      }
      $Res[]=$this->Type;
    }
  }
  