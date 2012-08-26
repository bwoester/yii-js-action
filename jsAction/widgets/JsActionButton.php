<?php

/**
 * Description of JsActionButton
 *
 * @author Benjamin
 */
class JsActionButton extends CWidget
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

    $cs = $this->getClientScript();

    // TODO - could be a script file
    $cs->registerScript( 'JsActionButton::init', '
      var JsActionButton = JsActionButton || {};
      JsActionButton.on_action_changed = function( jsAction )
      {
        if (jsAction.isEnabled()) {
          this.removeAttr( "disabled" );
        } else {
          this.attr( "disabled", "disabled" );
        }
        this.html( jsAction.getText() );

        // TODO: The JsActionButton might also implement the other hints a
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
      unset( $this->htmlOptions['disabled'] );
    } else {
      $this->htmlOptions['disabled'] = 'disabled';
    }

    echo CHtml::tag('button', $this->htmlOptions, $jsAction->text );

    $jsActions->registerTrigger( $id, 'click', $jsAction->getId() );
    $jsActions->connect( $jsAction->getId(), JsActions::SIG_CHANGED, 'function( jsAction ) {
      JsActionButton.on_action_changed.call( this, jsAction );
    }', "#$id" );

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

