<?
  Use C_RegExp_Node_Validator As Validator ;
  Use C_RegExp_Node_Maker     As Maker     ;
  Use C_RegExp_Node_Factory   As Factory   ;

  Class T_RegExp_Node_Base_Base Implements Stringable
  {
    Function __Construct() {}
    
    Function Init(Factory $Res)
    {
    }
    
    Function Make(Maker $Res) { $Res->Error(); }
    
    Function Validate(Validator $Factory) { Return False; }
    
    Static Function _GetMaker()
    {
      Global $Loader;
      Return $Loader->Create_Object('/RegExp/Node/Maker');
    }
    
    Function ToString(Maker $Maker=Null)
    {
      $Maker??=Self::_GetMaker();
      $this->Make($Maker);
      Return $Maker->ToString();
    }

    Function __toString() { return $this->ToString(); }

    Function IsValid() { Return True; }
  }
  