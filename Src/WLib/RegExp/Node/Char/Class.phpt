<?
  $this->Load_Type('/RegExp/Node/Char/Base');
  
  Class T_RegExp_Node_Char_Class Extends T_RegExp_Node_Char_Base
  {
    Var $Name ='\w';
    
    Function IsSolid  () { Return True; }
    
    Function __Construct($Name='\w') { $this->Name=$Name; }

    Function Make($Res)
    {
      $Res[]=$this->Name;
    }
    
    static $Allowed=[
      '\a' =>1 , //alarm, that is, the BEL character (hex 07)
    //'\cx'    , //"control-x", where x is any character
      '\e' =>1 , //escape (hex 1B)
      '\f' =>1 , //formfeed (hex 0C)
      '\n' =>1 , //newline (hex 0A)
    //'\p{xx}' , //a character with the xx property, see unicode properties for more info
    //'\P{xx}' , //a character without the xx property, see unicode properties for more info
      '\r' =>1 , //carriage return (hex 0D)
      '\R' =>1 , //line break: matches \n, \r and \r\n
      '\t' =>1 , //tab (hex 09)
    //'\xhh'   , //character with hex code hh
    //'\ddd'   , //character with octal code ddd, or backreference
    //'\x{...}',
           
      '\d' =>1, //any decimal digit
      '\D' =>1, //any character that is not a decimal digit
      '\h' =>1, //any horizontal whitespace character
      '\H' =>1, //any character that is not a horizontal whitespace character
      '\s' =>1, //any whitespace character
      '\S' =>1, //any character that is not a whitespace character
      '\v' =>1, //any vertical whitespace character
      '\V' =>1, //any character that is not a vertical whitespace character
      '\w' =>1, //any "word" character
      '\W' =>1, //any "non-word" character

      '\b' =>1, //word boundary
      '\B' =>1, //not a word boundary
      '\A' =>1, //start of subject (independent of multiline mode)
      '\Z' =>1, //end of subject or newline at end (independent of multiline mode)
      '\z' =>1, //end of subject (independent of multiline mode)
      '\G' =>1, //first matching position in subject
    ];

    Function Validate($Res)
    {
      Return IsSet(Static::$Allowed[$this->Name]);
    }
  }
