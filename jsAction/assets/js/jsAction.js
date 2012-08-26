var JsAction = JsAction || {};

JsAction.SIG_CHANGED    = "changed";
JsAction.SIG_TOGGLED    = "toggled";
JsAction.SIG_TRIGGERED  = "triggered";

JsAction.ActionImpl = {};
JsAction.ActionImpl = (function() {

  function ActionImpl( options ) {

    ///////////////////////////////////////////////////////////////////////////

    var defaults = {
      checkable : false,
      checked   : false,
      enabled   : true,
      icon      : '',
      iconText  : '',
      text      : '',
      toolTip   : '',
      visible   : true,
      whatIsThis: ''
    };

    /* merge defaults and options, without modifying defaults */
    var d     = $.extend( {}, defaults, options );
    var that  = this;

    if (!("id" in d)) {
      throw "Error: an action must have an id!";
    }

    ///////////////////////////////////////////////////////////////////////////

    var topics = {};
    this.Signals = function( id )
    {
      var callbacks,
          topic = id && topics[ id ];

      if (!topic)
      {
        callbacks = jQuery.Callbacks();
        topic     = {
          publish:      callbacks.fire,
          subscribe:    callbacks.add,
          unsubscribe:  callbacks.remove
        };

        if (id) {
          topics[ id ] = topic;
        }
      }

      return topic;
    };

    ///////////////////////////////////////////////////////////////////////////

    this.emit = function( signalId, data )
    {
      console.log( 'Action "' + this.getId() + '" emits signal "' + signalId + '", data: "' + data + '".' );
      this.Signals( signalId ).publish( data );
    }

    this.getId = function() {
      return d.id;
    }

    this.isCheckable = function() {
      return d.checkable;
    }

    this.setCheckable = function( value )
    {
      if (d.checkable === value) {
        return;
      }

      d.checkable = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.isChecked = function() {
      return d.checked;
    }

    this.setChecked = function( value )
    {
      if (d.checked === value) {
        return;
      }

      d.checked = value;
      this.emit( JsAction.SIG_CHANGED );
      this.emit( JsAction.SIG_TOGGLED, value );
    }

    this.isEnabled = function() {
      return d.enabled;
    }

    this.setEnabled = function( value )
    {
      if (d.enabled === value) {
        return;
      }

      d.enabled = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.getIcon = function() {
      return d.icon;
    }

    this.setIcon = function( value )
    {
      if (d.icon === value) {
        return;
      }

      d.icon = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.getIconText = function() {
      return d.iconText;
    }

    this.setIconText = function( value )
    {
      if (d.iconText === value) {
        return;
      }

      d.iconText = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.getText = function() {
      return d.text;
    }

    this.setText = function( value )
    {
      if (d.text === value) {
        return;
      }

      d.text = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.getToolTip = function() {
      return d.toolTip;
    }

    this.setToolTip = function( value )
    {
      if (d.toolTip === value) {
        return;
      }

      d.toolTip = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.isVisible = function() {
      return d.visible;
    }

    this.setVisible = function( value )
    {
      if (d.visible === value) {
        return;
      }

      d.visible = value;
      this.emit( JsAction.SIG_CHANGED );
    }

    this.getWhatIsThis = function() {
      return d.whatIsThis;
    }

    this.setWhatIsThis = function( value )
    {
      if (d.whatIsThis === value) {
        return;
      }

      d.whatIsThis = value;
      this.emit( JsAction.SIG_CHANGED );
    }
  }

  ////////////////////////////////////////////////////////////////////////////

  ActionImpl.prototype.setDisabled = function( value ) {
    this.setEnabled( !value );
  }

  ////////////////////////////////////////////////////////////////////////////

  ActionImpl.prototype.toggle = function() {
    this.setChecked( !this.isChecked() );
  };

  ////////////////////////////////////////////////////////////////////////////

  ActionImpl.prototype.trigger = function() {
    this.emit( JsAction.SIG_TRIGGERED, this.isChecked() );
  };

  ////////////////////////////////////////////////////////////////////////////

  ActionImpl.prototype.connect = function( actionId, callbacks ) {
    this.Signals( actionId ).subscribe( callbacks );
  };

  ////////////////////////////////////////////////////////////////////////////

  ActionImpl.prototype.disconnect = function( actionId, callbacks ) {
    this.Signals( actionId ).remove( callbacks );
  };

  ////////////////////////////////////////////////////////////////////////////

  return ActionImpl;

})();

JsAction.Actions = {};

JsAction.Action = function( actionId )
{
  var action = actionId && JsAction.Actions[ actionId ];

  if (!action)
  {
    action = new JsAction.ActionImpl({
      id: actionId
    });

    if (actionId) {
      JsAction.Actions[ actionId ] = action;
    }
  }

  return action;
};




