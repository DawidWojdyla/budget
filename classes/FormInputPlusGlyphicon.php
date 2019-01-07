<?php
class FormInputPlusGlyphicon extends FormInput{
  public $glyphiconName;
  function __construct($glyphiconName, $name, $description = '', $value = '', $type = 'text', $required = true){
    $this->glyphiconName = $glyphiconName;
    $this->name = $name;
    $this->value = $value;
    $this->type = $type;
    $this->description = $description;
    $this->required = $required;
  }
  function getInputHTML(){
    return "<span class='glyphicon glyphicon-{$this->glyphiconName}'></span><input class='myRegisterInputs' type='$this->type' name='$this->name' placeholder='$this->description' value=$this->value>";
  }
}