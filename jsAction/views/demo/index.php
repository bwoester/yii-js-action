<?php

$app = Yii::app();

/* @var $this CController */
/* @var $app CWebApplication */

?>


<p>
  Simple Demo about jsAction...
</p>

<p>
  <button class="action_enableAction1">Enable Action 1</button>
  <button class="action_disableAction1">Disable Action 1</button>

  &nbsp;&nbsp;&nbsp;

  <button class="action_enableAction2">Enable Action 2</button>
  <button class="action_disableAction2">Disable Action 2</button>

  &nbsp;&nbsp;&nbsp;

  <button class="action_enableAction3">Enable Action 3</button>
  <button class="action_disableAction3">Disable Action 3</button>
</p>

<p>
  <button class="action_1">Action 1</button>
  <button class="action_2">Action 2</button>
  <button class="action_3">Action 3</button>

  &nbsp;&nbsp;&nbsp;

  <button class="action_1">Action 1</button>
  <button class="action_2">Action 2</button>
  <button class="action_3">Action 3</button>

  &nbsp;&nbsp;&nbsp;

  <button class="action_1">Action 1</button>
  <button class="action_2">Action 2</button>
  <button class="action_3">Action 3</button>
</p>


<p>
  <a href="#" class="action_1">Action 1</a>
  <a href="#" class="action_2">Action 2</a>
  <a href="#" class="action_3">Action 3</a>

  &nbsp;&nbsp;&nbsp;

  <a href="#" class="action_1">Action 1</a>
  <a href="#" class="action_2">Action 2</a>
  <a href="#" class="action_3">Action 3</a>

  &nbsp;&nbsp;&nbsp;

  <a href="#" class="action_1">Action 1</a>
  <a href="#" class="action_2">Action 2</a>
  <a href="#" class="action_3">Action 3</a>
</p>

<?php

/* @var $am CAssetManager */
$am = $app->getAssetManager();
/* @var $cs CClientScript */
$cs = $app->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCss('disabledLinks', '

  a.disabled {
    pointer-events: none;
    cursor: default;
    text-decoration: none;
    color: #DDD;
  }

');
//$cs->registerScriptFile( $am->publish(Yii::getPathOfAlias('_jsAction.assets.js').'/pub-sub.js') );
$cs->registerScriptFile( $am->publish(Yii::getPathOfAlias('_jsAction.assets.js').'/jsAction.js') );
$cs->registerScript( 'jsAction', '

  // Publishers
  $(".action_1").click( function(ev) {
    JsAction.Action("action1").trigger();
  });

  $(".action_2").click( function(ev) {
    JsAction.Action("action2").trigger();
  });

  $(".action_3").click( function(ev) {
    JsAction.Action("action3").trigger();
  });

  $(".action_enableAction1").click( function(ev) {
    JsAction.Action("action1").setEnabled(true);
  });

  $(".action_disableAction1").click( function(ev) {
    JsAction.Action("action1").setDisabled(true);
  });

  $(".action_enableAction2").click( function(ev) {
    JsAction.Action("action2").setEnabled(true);
  });

  $(".action_disableAction2").click( function(ev) {
    JsAction.Action("action2").setDisabled(true);
  });

  $(".action_enableAction3").click( function(ev) {
    JsAction.Action("action3").setEnabled(true);
  });

  $(".action_disableAction3").click( function(ev) {
    JsAction.Action("action3").setDisabled(true);
  });



  // Subscribers
  JsAction.Action("action1").connect( JsAction.SIG_TRIGGERED, function () {
    alert( "Action 1" );
  });

  JsAction.Action("action2").connect( JsAction.SIG_TRIGGERED, function () {
    alert( "Action 2" );
  });

  JsAction.Action("action3").connect( JsAction.SIG_TRIGGERED, function () {
    alert( "Action 3" );
  });

  JsAction.Action("action1").connect( JsAction.SIG_CHANGED, function ()
  {
    var a = JsAction.Action("action1");

    if (a.isEnabled())
    {
      $("button.action_disableAction1").removeAttr( "disabled" );
      $("button.action_enableAction1").attr( "disabled", "disabled" );
      $("button.action_1").removeAttr( "disabled" );
      $("a.action_1").removeClass( "disabled" );
    }
    else
    {
      $("button.action_disableAction1").attr( "disabled", "disabled" );
      $("button.action_enableAction1").removeAttr( "disabled" );
      $("button.action_1").attr( "disabled", "disabled" );
      $("a.action_1").addClass( "disabled" );
    }
  });

  JsAction.Action("action2").connect( JsAction.SIG_CHANGED, function ()
  {
    var a = JsAction.Action("action2");

    if (a.isEnabled())
    {
      $("button.action_disableAction2").removeAttr( "disabled" );
      $("button.action_enableAction2").attr( "disabled", "disabled" );
      $("button.action_2").removeAttr( "disabled" );
      $("a.action_2").removeClass( "disabled" );
    }
    else
    {
      $("button.action_disableAction2").attr( "disabled", "disabled" );
      $("button.action_enableAction2").removeAttr( "disabled" );
      $("button.action_2").attr( "disabled", "disabled" );
      $("a.action_2").addClass( "disabled" );
    }
  });

  JsAction.Action("action3").connect( JsAction.SIG_CHANGED, function ()
  {
    var a = JsAction.Action("action3");

    if (a.isEnabled())
    {
      $("button.action_disableAction3").removeAttr( "disabled" );
      $("button.action_enableAction3").attr( "disabled", "disabled" );
      $("button.action_3").removeAttr( "disabled" );
      $("a.action_3").removeClass( "disabled" );
    }
    else
    {
      $("button.action_disableAction3").attr( "disabled", "disabled" );
      $("button.action_enableAction3").removeAttr( "disabled" );
      $("button.action_3").attr( "disabled", "disabled" );
      $("a.action_3").addClass( "disabled" );
    }
  });

');