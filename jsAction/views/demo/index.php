<?php

$app = Yii::app();
$jsActions = $app->jsActions;

/* @var $this CController */
/* @var $app CWebApplication */
/* @var $jsActions JsActions */

/* @var $cs CClientScript */
$cs = $app->getClientScript();
$cs->registerCss('disabledLinks', '

  a {
    margin: 5px;
  }

  a.JsActionLink-disabled {
    cursor: default;
    text-decoration: none;
    color: #DDD;
  }

');

?>


<p>
  So this is a very simple demo.
</p>

<p>
  Basic idea about the JsActions is, that you can trigger actions from <b>somewhere</b>.
  Actions will emit <b>signals</b> when they change state or actually get triggered.
  You can <b>connect</b> as many <b>callbacks</b> as you want to each <b>signal</b>.
</p>

<p>
  This way, an application can define what <b>actions</b> a user might execute
  on a certain page, and it can register event handlers that care for the actual
  execution. The whole process does no longer depend on any actual html markup.
</p>

<p>
  You can try it by using the UI below, or you can open a console and trigger
  the actions manually.

  <pre>
    // trigger action1
    JsAction.Action("action1").trigger();

    // disable action1
    JsAction.Action("action1").setEnabled( false );

    // enable action1
    JsAction.Action("action1").setEnabled( true );

    // change action1's text
    JsAction.Action("action1").setText( "Hello world!" );
  </pre>
</p>

<p>
  html elements providing an UI to access JsActions should listen to the actions
  <b>changed()</b> signal and update their appeareance to reflect the state of
  an action. But they need no knowledge about any other html elements.
</p>

<p>
  The buttons and links used in this demo only reflect changes to an actions
  enabled and text property.
</p>

<p>
  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_enableAction1',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_disableAction1',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_enableAction2',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_disableAction2',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_enableAction3',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action_disableAction3',
  ));
  ?>

</p>

<p>
  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action3',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action3',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionButton', array(
    'action' => 'action3',
  ));
  ?>
</p>

<p>

  <?php
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action3',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action3',
  ));
  ?>

  &nbsp;&nbsp;&nbsp;

  <?php
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action1',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action2',
  ));
  $this->widget( '_jsAction.widgets.JsActionLink', array(
    'action' => 'action3',
  ));
  ?>
</p>

<?php
$jsActions->registerActions();
