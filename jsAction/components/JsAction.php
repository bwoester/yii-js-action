<?php

/**
 * Description of JsAction
 *
 * @author Benjamin
 */
class JsAction extends CComponent
{
  private $_id = '';

  public $checkable   = false;
  public $checked     = false;
  public $enabled     = true;
  public $icon        = '';
  public $iconText    = '';
  public $text        = '';
  public $toolTip     = '';
  public $visible     = true;
  public $whatIsThis  = '';

  public function getId() {
    return $this->_id;
  }

  public function __construct( $id )
  {
    $this->_id = $id;
  }
}
