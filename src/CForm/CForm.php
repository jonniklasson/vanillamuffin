<?php
class CForm implements ArrayAccess {

  /**
   * Properties
   */
  public $form;     // array with settings for the form
  public $elements; // array with all form elements
  

  /**
   * Constructor
   */
  public function __construct($form=array(), $elements=array()) {
    $this->form = $form;
    $this->elements = $elements;
  }


  /**
   * Implementing ArrayAccess for this->elements
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->elements[] = $value; } else { $this->elements[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->elements[$offset]); }
  public function offsetUnset($offset) { unset($this->elements[$offset]); }
  public function offsetGet($offset) { return isset($this->elements[$offset]) ? $this->elements[$offset] : null; }


  /**
   * Add a form element
   */
  public function AddElement($element) {
    $this[$element['name']] = $element;
    return $this;
  }
  

  /**
   * Return HTML for the form
   */
  public function GetHTML() {
    $id      = isset($this->form['id'])      ? " id='{$this->form['id']}'" : null;
    $class    = isset($this->form['class'])   ? " class='{$this->form['class']}'" : null;
    $name    = isset($this->form['name'])    ? " name='{$this->form['name']}'" : null;
    $action = isset($this->form['action'])  ? " action='{$this->form['action']}'" : null;
    $method = " method='post'";
    $elements = $this->GetHTMLForElements();
    $html = <<< EOD
\n<form{$id}{$class}{$name}{$action}{$method}>
<fieldset>
{$elements}
</fieldset>
</form>
EOD;
    return $html;
  }


  /**
   * Return HTML for the elements
   */
  public function GetHTMLForElements() {
    $html = null;
    foreach($this->elements as $element) {
      $html .= $element->GetHTML();
    }
    return $html;
  }
  

  /**
   * Check if a form was submitted and perform validation and call callbacks
   */
  public function CheckIfSubmitted() {
    $submitted = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $submitted = true;
      foreach($this->elements as $element) {
        if(isset($_POST[$element['name']])) {
          $element['value'] = $_POST[$element['name']];
          if(isset($element['callback'])) {
            call_user_func($element['callback'], $this);
          }
        }
      }
    }
    return $submitted;
  }
  
  
}