<?
  $this->Load_Type('/RegExp/Node/Base');
  
  Class T_RegExp_Node_Group Extends T_RegExp_Node_Base
  {
    Var $Id   =True;
    Var $Node ;
    Var $Type =Null; //'', ':', '<' ,'\'', '|'
    
    Static $Types=[
      ''   =>['('    ,''   ,')'], //(        -- Indexed
      '|'  =>['(?|'  ,''   ,')'], //(?|      -- Group indexed catches
      ':'  =>['(?:'  ,''   ,')'], //(?:      -- Not catch
      '<'  =>['(?<'  ,'>'  ,')'], //(?<name> -- Named
      '\'' =>['(?\'' ,'\'' ,')'], //(?'name' -- Named
    ];
    
    Function __Construct($Node, $Id=Null, $Type=Null) { $this->Node=$Node; $this->Id=$Id; $this->Type=$Type; }
    
    Static Function DetectType($Id)
    {
      If($Id===True  ) Return ''  ;
      If($Id===Null  ) Return ':' ;
      If($Id===False ) Return '|' ;
      If(Is_String($Id)) Return True? '<':'\'';
      Return Null;
    }
    
    Function Make($Res)
    {
      $Id   =$this->Id   ;
      $Type =$this->Type ;
      
      If(Is_Null($Type??=Self::DetectType($Id)))
        Return $Res->Error('Unknown Id');
      
      [$Begin, $Mid, $End]=Self::$Types[$Type]?? Self::$Types[''];
      $Res->Begin($Begin, $this->Id, $Mid);
      $Res[]=$this->Node;
      $Res->End($End);
    }
  }
  