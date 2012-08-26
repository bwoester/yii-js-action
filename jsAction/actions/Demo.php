<?php



class Demo extends CViewAction
{

  public function __construct( $controller, $id )
  {
    parent::__construct( $controller, $id );
    Yii::setPathOfAlias( '_jsAction', dirname(__FILE__).'/../' );
    $this->basePath = '_jsAction.views.demo';
  }

}
