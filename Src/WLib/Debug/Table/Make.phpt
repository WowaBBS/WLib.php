<? NameSpace WLib\Debug\Table;
  
  Class T_Make 
  {
    Var $Columns =[]; // Idx=>FieldName
    
    Function __Construct($Columns)
    {
      $this->Columns=$Columns;
    }
    
    Function From($List, $SkipFirst=False)
    {
      $Res   =[];
      $Next  =0;
      ForEach($List As $Key=>$Rec)
      {
        If(Is_Int($Key))
          If($Next===$Key)
          {
            $Key=Null;
            $Next++;
          }
          Else
            $Next=Null;
          
        If(!Is_Array($Rec)) Continue; //TODO: Error?
        
        If($SkipFirst) { $SkipFirst=False; Continue; }
        
        $Row=$this->Row($Rec);
        
        If($Key===Null)
          $Res[]=$Row;
        Else
          $Res[$Key]=$Row;
      }
      
      Return $Res;
    }
    
    Function Row($Rec)
    {
      $Res=[];
      ForEach($Rec As $k=>$v)
        $Res[$this->Columns[$k]?? $k]=$v;
      Return $Res;
    }
    
    Static Function ToMap(Array $List)
    {
      If(!$List) Return $List;
      $Make=New Static(Array_First($List));
      Return $Make->From($List, True);
    }
  }
?>