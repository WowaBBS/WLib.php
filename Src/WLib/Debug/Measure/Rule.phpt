<? NameSpace WLib\Debug\Measure;
  
  Class T_Rule
  {
    Var $Value   ;
    Var $Scale   ;
    Var $Postfix ;
    
    Function __Construct($Value, $Postfix)
    {
      $this->Value   =$Value   ;
      $this->Scale   =$Value? 1/$Value:1;
      $this->Postfix =$Postfix ;
    }
    
    Static Function Compare($a, $b)
    {
      Return $a->Value <=> $b->Value;
    }
  }
?>