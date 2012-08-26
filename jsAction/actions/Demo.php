<?php



class Demo extends CViewAction
{

  public function __construct( $controller, $id )
  {
    parent::__construct( $controller, $id );
    Yii::setPathOfAlias( '_jsAction', dirname(__FILE__).'/../' );
    $this->basePath = '_jsAction.views.demo';
  }

  public function run()
  {
    $app = $this->getApp();
    $app->setComponent( 'jsActions', Yii::createComponent(array(
      'class' => '_jsAction.components.JsActions'
    )));

    $jsActions = $app->getComponent( 'jsActions' );
    /* @var $jsActions JsActions */

    $action1 = $jsActions->action( 'action1', array(
      'text'  => 'Action 1',
    ));
    $action2 = $jsActions->action( 'action2', array(
      'text'  => 'Action 2',
    ));
    $action3 = $jsActions->action( 'action3', array(
      'text'  => 'Action 3',
    ));

    $action_enableAction1 = $jsActions->action( 'action_enableAction1', array(
      'text'    => 'Enable Action 1',
      'enabled' => false,
    ));
    $action_enableAction2 = $jsActions->action( 'action_enableAction2', array(
      'text'    => 'Enable Action 2',
      'enabled' => false,
    ));
    $action_enableAction3 = $jsActions->action( 'action_enableAction3', array(
      'text'    => 'Enable Action 3',
      'enabled' => false,
    ));

    $action_disableAction1 = $jsActions->action( 'action_disableAction1', array(
      'text'  => 'Disable Action 1',
    ));
    $action_disableAction2 = $jsActions->action( 'action_disableAction2', array(
      'text'  => 'Disable Action 2',
    ));
    $action_disableAction3 = $jsActions->action( 'action_disableAction3', array(
      'text'  => 'Disable Action 3',
    ));

    $jsActions->connect( 'action1', JsActions::SIG_TRIGGERED, 'function() { alert( "Action 1 triggered!" ); }');
    $jsActions->connect( 'action2', JsActions::SIG_TRIGGERED, 'function() { alert( "Action 2 triggered!" ); }');
    $jsActions->connect( 'action3', JsActions::SIG_TRIGGERED, 'function() { alert( "Action 3 triggered!" ); }');

    $jsActions->connect( 'action_enableAction1', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action1").setEnabled(true);
      JsAction.Action("action_enableAction1").setEnabled(false);
      JsAction.Action("action_disableAction1").setEnabled(true);
    }');
    $jsActions->connect( 'action_enableAction2', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action2").setEnabled(true);
      JsAction.Action("action_enableAction2").setEnabled(false);
      JsAction.Action("action_disableAction2").setEnabled(true);
    }');
    $jsActions->connect( 'action_enableAction3', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action3").setEnabled(true);
      JsAction.Action("action_enableAction3").setEnabled(false);
      JsAction.Action("action_disableAction3").setEnabled(true);
    }');

    $jsActions->connect( 'action_disableAction1', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action1").setEnabled(false);
      JsAction.Action("action_enableAction1").setEnabled(true);
      JsAction.Action("action_disableAction1").setEnabled(false);
    }');
    $jsActions->connect( 'action_disableAction2', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action2").setEnabled(false);
      JsAction.Action("action_enableAction2").setEnabled(true);
      JsAction.Action("action_disableAction2").setEnabled(false);
    }');
    $jsActions->connect( 'action_disableAction3', JsActions::SIG_TRIGGERED, 'function() {
      JsAction.Action("action3").setEnabled(false);
      JsAction.Action("action_enableAction3").setEnabled(true);
      JsAction.Action("action_disableAction3").setEnabled(false);
    }');

    parent::run();
  }

  /**
   * @return CWebApplication
   */
  private function getApp()
  {
    return Yii::app();
  }
}
