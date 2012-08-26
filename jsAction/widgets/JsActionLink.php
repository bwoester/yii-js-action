<?php

/**
 * Description of JsActionButton
 *
 * @author Benjamin
 */
class JsActionLink extends CWidget
{

  /////////////////////////////////////////////////////////////////////////////

  public $jsActionsComponentId = 'jsActions';
  public $htmlOptions = array();

  private $_action = '';

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return JsAction
   */
  public function getAction()
  {
    if (!($this->_action instanceof JsAction)) {
      $jsActionsComponent = $this->getJsActionsComponent();
      $this->_action = $jsActionsComponent->action( $this->_action );
    }

    return $this->_action;
  }

  /////////////////////////////////////////////////////////////////////////////

  public function setAction( $action )
  {
    $this->_action = $action;
  }

  /////////////////////////////////////////////////////////////////////////////

	/**
	 * Initializes the view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		$this->htmlOptions['id'] = $this->getId();
		$this->htmlOptions['href'] = '#';

    $cs = $this->getClientScript();

    // TODO - could be a script file
    $cs->registerScript( 'JsActionLink::init', '
      var JsActionLink = JsActionLink || {};
      JsActionLink.on_action_changed = function( jsAction )
      {
        if (jsAction.isEnabled()) {
          this.removeClass( "JsActionLink-disabled" );
        } else {
          this.addClass( "JsActionLink-disabled" );
        }
        this.text( jsAction.getText() );

        // TODO: The JsActionLink might also implement the other hints a
        //       JsAction provides (images, tooltips, checked/ unchecked state, ...)

      }
    ');
	}

  /////////////////////////////////////////////////////////////////////////////

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run()
	{
    $id = $this->getId();
    $jsAction = $this->getAction();
    $jsActions = $this->getJsActionsComponent();

    if ($jsAction->enabled) {
      $this->removeCssClass( 'JsActionLink-disabled' );
    } else {
      $this->addCssClass( 'JsActionLink-disabled' );
    }

    echo CHtml::tag( 'a', $this->htmlOptions, $jsAction->text );

    $jsActions->registerTrigger( $id, 'click', $jsAction->getId() );
    $jsActions->connect( $jsAction->getId(), JsActions::SIG_CHANGED, 'function( jsAction ) {
      JsActionLink.on_action_changed.call( this, jsAction );
    }', "#$id" );

	}

  /////////////////////////////////////////////////////////////////////////////

  protected function addCssClass( $cssClass )
  {
    $strCssClasses = array_key_exists( 'class', $this->htmlOptions )
      ? $this->htmlOptions['class']
      : '';
    $aCssClasses = $strCssClasses === ''
      ? array()
      : explode( ' ', $strCssClasses );
    if (!in_array($cssClass,$aCssClasses)) {
      $aCssClasses[] = $cssClass;
    }
    $this->htmlOptions['class'] = implode( ' ', $aCssClasses );
  }

  /////////////////////////////////////////////////////////////////////////////

  protected function removeCssClass( $cssClass )
  {
    $strCssClasses = array_key_exists( 'class', $this->htmlOptions )
      ? $this->htmlOptions['class']
      : '';
    $aCssClasses = $strCssClasses === ''
      ? array()
      : explode( ' ', $strCssClasses );
    if (($key=  array_search($cssClass,$aCssClasses)) !== false) {
      unset( $aCssClasses[$key] );
    }
    $this->htmlOptions['class'] = implode( ' ', $aCssClasses );
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
   * @return JsActions
   */
  private function getJsActionsComponent()
  {
    return Yii::app()->getComponent( $this->jsActionsComponentId );
  }

  /////////////////////////////////////////////////////////////////////////////

}

