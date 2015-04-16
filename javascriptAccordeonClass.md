_Library edited from 2005 to 2007..._ Framework here : [trunk/SITE\_01\_SRC/js/proto/optional/](http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC#SITE_01_SRC%2Fjs%2Fproto%2Foptional)

# 215\_accordeon.js #

## Exemple ##
```

// Si le lien qui ouvre possède un href, celui-ci et loadé en ajax dans le conteneur
<a href="javascript:void(0);" class="accordeon2 off" onfocus="blur();">Titre 1</a>
<div class="accordeon2">Texte cache 1 bla bla bla bla bla</div>

<a href="_membres_vip_suscribe.php" class="accordeon2 off" onfocus="blur();">Titre 2</a>
<div class="accordeon2">&nbsp;</div>
...
<?php js(" new Accordeon('a.accordeon2', 'div.accordeon2', {tClassOff:'off', tClassOn:'in', tempo:0.4, observe:'click'}); "); ?>

```

## Class Javascript ##

```

/*///////////////////////////////////////////////////////////////////////////////////////////////////////
///// Code mixing by Molokoloco - www.borntobeweb.fr - BETA TESTING FOR EVER !       (o_O)       ///////
/////////////////////////////////////////////////////////////////////////////////////////////////////*/

// ------------------------- CLASS ACCORDEON ---------------------------------- //
Accordeon = Class.create();
Accordeon.prototype = {
	initialize: function(xTitles, xPanes, options) {
		this.xTitles = $$(xTitles);
		this.xPanes = $$(xPanes);
		if (!this.xTitles || this.xTitles.length < 1) die('No xTitles detected ('+xTitles+')');
		else if (this.xTitles.length != this.xPanes.length) die('Length mismatch between xTitles ('+this.xTitles.length+') and xPanes ('+this.xPanes.length+')');
		this.tClassOff 		= options.tClassOff || 'off';
		this.tClassOn 		= options.tClassOn || 'on';
		this.tClassApply 	= options.tClassApply || 'before'; // before / after
		this.tempo 			= options.tempo || 0.6;
		this.observe 		= options.observe || 'click'; // click / mouseover
		this.hideFirst 		= options.hideFirst || true;
		this._activeTitle 	= -1;
		this._effectAnim 	= false;
		this._xUrl = {};
		for (var i=0; i<this.xTitles.length; i++) {
			if (i!=0 || this.hideFirst) $(this.xPanes[i]).hide();
			else {
				this.togglePane(i, true);
				this._activeTitle = i;
			}
			if (isSet(this.xTitles[i].href)) this._xUrl[i] = this.xTitles[i].href; // Stock link href
			Event.observe(this.xTitles[i], this.observe, this.ctrPane.bindAsEventListener(this, i), true); // Observe link
		}
	},
	setTitleClassOn: function(i) {
		$(this.xTitles[i]).addClassName(this.tClassOn);
		$(this.xTitles[i]).removeClassName(this.tClassOff);
	},
	setTitleClassOff: function(i) {
		$(this.xTitles[i]).addClassName(this.tClassOff);
		$(this.xTitles[i]).removeClassName(this.tClassOn);
	},
	toggleTitleClass: function(i, display) {
		if (display) {
			if (this._activeTitle >= 0) this.setTitleClassOff(this._activeTitle);
			this.setTitleClassOn(i);
		}
		else {
			this.setTitleClassOff(i);
			if (this._activeTitle >= 0) this.setTitleClassOn(this._activeTitle);
		}
	},
	togglePane: function(i, display) {
		if (!isId(this.xTitles[i]) || this._effectAnim) return;
		this._effectAnim = true;
		this.effectOpenParams = {
			duration: this.tempo,
			transition: Effect.Transitions.linear,
			afterFinish:function(effect){
				if (!display && this._xUrl[i]) $(this.xPanes[i]).update('');
				if (this.tClassApply != 'before') this.toggleTitleClass(i, display);
				this._effectAnim = false;
				new Effect.ScrollTo(this.xTitles[i], {offset: -90});
				//if (typeof setPageSize == 'function') setPageSize();
			}.bind(this, display)
		};
		if (display && this._xUrl[i]) { // Get Ajax content of href
			specs = this._xUrl[i].split('?');
			contentUrl = specs[0]
			parameters = specs[1];
			new Ajax.Request(contentUrl, {
				method: 'get',
				evalScripts: true,
				parameters: parameters,
				onSuccess: function(transport) {
					$(this.xPanes[i]).update(transport.responseText);
					if (!$(this.xPanes[i]).id) $(this.xPanes[i]).id = getUniqueId();
					close_btn = $$('#'+$(this.xPanes[i]).id+' a.close_btn')[0]; // <a href="javascript:void(0);" class="close_btn"><button>Fermer</button></a> ?
					if (close_btn) Event.observe(close_btn, 'click', this.ctrPane.bindAsEventListener(this, i), false);
				}.bind(this)
			});
		}
		if (this._activeTitle >= 0) {
			new Effect.Parallel([				
					new Effect.BlindUp($(this.xPanes[this._activeTitle])),
					(display ? new Effect.BlindDown($(this.xPanes[i])) : new Effect.BlindUp($(this.xPanes[i])) )
			], this.effectOpenParams);
		}
		else ( display ? new Effect.BlindDown($(this.xPanes[i]), this.effectOpenParams) : new Effect.BlindUp($(this.xPanes[i]), this.effectOpenParams) );
		if (this.tClassApply == 'before') this.toggleTitleClass(i, display);
	},
	togglePanes: function(display) {
		for(var i=0; i<this.xTitles.length; i++) this.togglePane(i, display);
	},
	ctrPane: function(event, i) {
		if (!event || typeof Event.element != 'function') return;
		if (i == this._activeTitle) {
			this._activeTitle = -1;
			this.togglePane(i, false);
		}
		else {
			this.togglePane(i, true);
			this._activeTitle = i;
		}
		Event.stop(event); // Don't open href
	}
};

```