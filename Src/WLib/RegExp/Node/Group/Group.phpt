<?
  $this->Load_Type('/RegExp/Node/Base/Base');
  
  Class T_RegExp_Node_Group_Group Extends T_RegExp_Node_Base_Base
  {
    Var $Id   =True;
    Var $Node ;
    Var $Type =Null; //'', ':', '<' ,'\'', '|'
    
    Static $Types=[
      ''   =>['('    ,''   ,')' ,'True' ], //(        -- Indexed
      '|'  =>['(?|'  ,''   ,')' ,'Null' ], //(?|      -- Group indexed catches
      '<'  =>['(?<'  ,'>'  ,')' ,'Str'  ], //(?<name> -- Named
      '\'' =>['(?\'' ,'\'' ,')' ,'Str'  ], //(?'name' -- Named
      ':'  =>['(?:'  ,''   ,')' ,'No'   ], //(?:      -- Not catch
      '>'  =>['(?\>' ,''   ,')' ,'No'   ], //(? >     -- Only Once
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
      
      [$Begin, $Mid, $End, $TypeId]=Self::$Types[$Type]?? Self::$Types[''];
      Switch($TypeId)
      {
      Case 'True' : if($Id!==True     ) Return $Res->Error('Should be True'  ,': ', $Id); Break;
      Case 'Null' : if($Id!==Null     ) Return $Res->Error('Should be Null'  ,': ', $Id); Break;
      Case 'Str'  : if(!Is_String($Id)) Return $Res->Error('Should be Str'   ,': ', $Id); Break;
      Case 'No'   : if($Id!==False    ) Return $Res->Error('Should be False' ,': ', $Id); Break;
      Default     :                     Return $Res->Error('Unknown TypeId ', $TypId);
      }
      If($TypeId==='Str')
        $Res->Begin($Begin, $this->Id, $Mid);
      Else
        $Res->Begin($Begin);
      $Res[]=$this->Node;
      $Res->End($End);
    }

    Function Validate($Res)
    {
      $Info=Self::$Types[$this->Type]?? Null;
      If(!$Info)
        Return $Res->Error('Unknown Type: ', $this->Type);
      Return True; //TODO: Check
    }
  }
  