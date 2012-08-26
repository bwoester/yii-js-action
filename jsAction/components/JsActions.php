<?php

/**
 * Description of JsActions
 *
 * @author Benjamin
 */
class JsActions extends CApplicationComponent
{
  const SIG_CHANGED   = 'JsAction.SIG_CHANGED';
  const SIG_TOGGLED   = 'JsAction.SIG_TOGGLED';
  const SIG_TRIGGERED = 'JsAction.SIG_TRIGGERED';

  /* @var $_actions CTypedMap */
  private $_actions = null;

  private $_triggers    = array();
  private $_connections = array();

  /////////////////////////////////////////////////////////////////////////////

	/**
	 * Initializes the application component.
	 * This method is required by {@link IApplicationComponent} and is invoked by application.
	 * If you override this method, make sure to call the parent implementation
	 * so that the application component can be marked as initialized.
	 */
	public function init()
	{
    Yii::setPathOfAlias( '_jsAction', dirname(__FILE__).'/..' );
    Yii::app()->setImport(array(
      '_jsAction.components.*',
    ));

    $this->_actions = new CTypedMap( 'JsAction' );
    parent::init();
	}

  /////////////////////////////////////////////////////////////////////////////

  public function action( $id, $aConfig=array() )
  {
    $actions = $this->getActions();

    if (!$actions->contains($id))
    {
      if (!isset($aConfig['class'])) {
        $aConfig['class'] = '_jsAction.components.JsAction';
      }

      $action = Yii::createComponent( $aConfig, $id );
      $actions->add( $id, $action );
    }
    else if (!empty($aConfig))
    {
      $action = $actions->itemAt( $id );

      foreach ($aConfig as $key => $value) {
        $action->$key = $value;
      }
    }

    return $actions->itemAt( $id );
  }

  /////////////////////////////////////////////////////////////////////////////

  public function registerTrigger( $elementId, $elementEvent, $jsActionId )
  {
    $this->_triggers[$jsActionId][$elementEvent][] = $elementId;
  }

  /////////////////////////////////////////////////////////////////////////////

  public function connect( $jsActionId, $signalId, $jsCallback, $elementSelector='' )
  {
    $this->_connections[$jsActionId][$signalId][] = array(
      'selector'    => $elementSelector,
      'jsCallback'  => $jsCallback,
    );
  }

  /////////////////////////////////////////////////////////////////////////////

  public function registerActions()
  {
    $am = $this->getAssetManager();

    $cs = $this->getClientScript();
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile( $am->publish(Yii::getPathOfAlias('_jsAction.assets.js').'/jsAction.js') );

    $script = '';

    // --- connections --------------------------------------------------------

    foreach ($this->_connections as $jsActionId => $aSignalConnections)
    {
      foreach ($aSignalConnections as $signalId => $aConnectionInfo)
      {
        foreach ($aConnectionInfo as $ci)
        {
          if ($ci['selector'] === '')
          {
            $script .= "
              JsAction.Action( '$jsActionId' ).connect( $signalId, function () {
                var callback = {$ci['jsCallback']};
                callback( JsAction.Action('$jsActionId') );
              });
            ";
          }
          else
          {
            $script .= "
              JsAction.Action( '$jsActionId' ).connect( $signalId, function () {
                var callback = {$ci['jsCallback']};
                callback.call( $('{$ci['selector']}'), JsAction.Action('$jsActionId') );
              });
            ";
          }
        }
      }
    }

    // --- actions ------------------------------------------------------------

    foreach ($this->getActions() as $id => $action)
    {
      $options = CJSON::encode( $action );
      $script .= '
        JsAction.Action( "'.$id.'" ).setData( '.$options.' );
      ';
    }

    // --- triggers -----------------------------------------------------------

    foreach ($this->_triggers as $jsActionId => $aTriggers )
    {
      foreach ($aTriggers as $elementEvent => $aElementIds )
      {
        for ($i = 0; $i < count($aElementIds); $i++) {
          $aElementIds[$i] = '#'.$aElementIds[$i];
        }

        $selector = implode( ',', $aElementIds );

        $script .= "
          $('$selector').on( '$elementEvent', function() {
            JsAction.Action( '$jsActionId' ).trigger();
            return false;
          });
        ";
      }
    }

    $cs->registerScript( 'JsActions::registerActions', $script );
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return CTypedMap
   */
  private function getActions()
  {
    return $this->_actions;
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return CClientScript
   */
  private function getClientScript()
  {
    return Yii::app()->clientScript;
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return CAssetManager
   */
  private function getAssetManager()
  {
    return Yii::app()->assetManager;
  }

  /////////////////////////////////////////////////////////////////////////////

}
