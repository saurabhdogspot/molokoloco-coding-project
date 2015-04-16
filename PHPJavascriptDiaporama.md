_Library edited from 2005 to 2007..._ Framework here : [trunk/SITE\_01\_SRC/js/proto/optional/](http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC#SITE_01_SRC%2Fjs%2Fproto%2Foptional)

## PHP (fonctions.php) + HTML ##

```

<div id="magazine_slide">
	<?php
		
	$JS = '<script type="text/javascript">'.chr(13).chr(10).'// <![CDATA['.chr(13).chr(10);
	$JSE = chr(13).chr(10).'// ]]>'.chr(13).chr(10).'</script>';	
	
	
	// Standard script balise --------------------
	function js($script, $echo=TRUE) {
		global $JS,$JSE;
		$js = $JS.$script.chr(13).$JSE;
		if ($echo) echo $js;
		else return $js;
	}

	// JSON CLEAN STRING --------------------
	function cleanJson($string) {
		$string = str_replace("'", "\'", $string);
		$string = str_replace("{", "\{", $string);
		$string = str_replace("}", "\}", $string);
		$string = str_replace(chr(10), '', $string);
		$string = str_replace(chr(13), '', $string);
		return $string;
	}

	// Convert bi-dimentional php array to javascript array --------------------
	function getScriptBiArray($arr_name, $arr) {
		$myJs = "var ".$arr_name." = {";
		$j=0;
		foreach($arr as $key=>$val) {
			if (is_array($val)) {
				$myJs .= $j.":{";
				foreach($val as $key2=>$val2) {
					$myJs .= $key2.":'".cleanJson($val2)."',";
				}
				$myJs = substr($myJs, 0, -1);
				$myJs .= "},";
			}
			else $myJs .= $key.":'".cleanJson($val)."',";
			$j++;
		}
		$myJs = substr($myJs, 0, -1).'};';
		return $myJs;
	}

	
	
	// BUILD IMAGES SLIDE
	$arr_images = array();
	$Q = q("SELECT id, titre, visuel FROM mod_magazines WHERE visuel!='' ORDER BY datepub DESC LIMIT 10");
	foreach ($Q as $G) {
		$i =& new FILE();
		if ($i->isMedia('medias/magazine/medium/'.$G['visuel'])) {
			$arr_images[] = array(
				'img'=>'medias/magazine/medium/'.$G['visuel'],
				'lien'=>'#'.$G['id'],
				'titre'=>$G['titre']
			);
			if (!isset($once_mag)) {
				$once_mag = 1;
				$i->image();
			}
		}
	}
	$js_array = getScriptBiArray('arrImage', $arr_images);
	$js_array .= "\n myDiap = new diaporama(arrImage, {div : 'magazine_slide',tempo : 5,effect : 'appear'});"; //scroll
	
	js($js_array);
	?>
</div>

```

## GENERATED HTML ##

```

	<div id="flickrSlideShow">
		<a id="a_3" href="./telechargement-des-magazines-pdf-r60.html#M129"><img src="medias/magazine/medium/080506124350_couv_129.jpg" id="id_2" name="id_2" alt="Couv 129" border="0" width="189" height="267" /></a>
	</div>

	<script type="text/javascript">
	// <![CDATA[
	var arrImage = {
		0:{img:'medias/magazine/medium/080506124350_couv_129.jpg',lien:'./telechargement-des-magazines-pdf-r60.html#M129',titre:'Test'},
		1:{img:'medias/magazine/medium/080415163453_080414135518_campus_culture_p01.jpg',lien:'./telechargement-des-magazines-pdf-r60.html#M29',titre:''},
		2:{img:'medias/magazine/medium/080415163521_080414135111_campus_128-p01_v2.jpg',lien:'./telechargement-des-magazines-pdf-r60.html#M18',titre:''},
		3:{img:'medias/magazine/medium/080418191218_campus_lycee_couv.jpg',lien:'./telechargement-des-magazines-pdf-r60.html#M326',titre:''},
		4:{img:'medias/magazine/medium/080415163419_080414132656_campus_lycee_couv.jpg',lien:'./telechargement-des-magazines-pdf-r60.html#M010',titre:''}
	};
	myDiap = new diaporama(arrImage, { 
			div : 'flickrSlideShow',
			tempo : 6,
			effect : 'slide',
			transition : 0.6,
			control : true,
			printInfo : false
	});
	// ]]>
	</script>

```

## JAVASCRIP : 212\_diaporama.js ##

```

/*///////////////////////////////////////////////////////////////////////////////////////////////////////
///// Code mixing by Molokoloco - www.borntobeweb.fr - BETA TESTING FOR EVER !       (o_O)       ///////
///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// SLIDESHOW / DIAPORAMA ////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////*/

if (typeof db == 'undefined') die("212_diaporama.js requires 200_tools.js");
if (typeof Effect == 'undefined') die("212_diaporama.js requires 110_effects.js");
if (typeof startOverlay == 'undefined') db("212_diaporama.js requires 214_modal-dialogue.js");

/* ATTEMPT TO BUILD THIS
	
	<div id="xxx">
		<div style="overflow: hidden; position: relative; display: block; height: 265px; width: 280px;" id="diaporamaBoxImage">
			<div style="position: relative; margin-top: 12.5px;" id="diaporamaBoxImageEffect">
				<a href="http://www.flickr.com/photos/mschmahl/802196014/" target="_blank">
					<img width="160" height="240" border="0" title="http://www.toto.com/" src="toto.jpg" alt="toto.jpg" id="diaporamaImage"/>
				</a>
			</div>
		</div>
		<div style="position: relative;" id="diaporamaControler">
			<img width="12" height="13" border="0" style="cursor: pointer;" id="precedante" title="Précédante" src="images/ico_js/back.gif"/> <img width="12" height="13" border="0" style="cursor: pointer;" id="pause" title="Pause" src="images/ico_js/pause.gif"/> <img width="12" height="13" border="0" style="cursor: pointer; display: none;" id="lecture" title="Lecture" src="images/ico_js/play.gif"/> <img width="12" height="13" border="0" style="cursor: pointer;" id="suivante" title="Suivante" src="images/ico_js/next.gif"/>
		</div>
	</div>
*/

var diaporama = Class.create();
diaporama.prototype = { // EN COURS D'EVOLUTION... N'EST PAS FINI !!!! // CHECK IF NO CONTROL !!

	initialize: function(arrImage) {
		
		// Arguments
		var options = Object.extend({arrImage:arrImage}, arguments[1] || {});

		// Whitch conteneur
		if (isId(options.div)) this.boxElement = options.div;
		else if (isSet(startDivBox) && typeof startDivBox == 'function') {
			startOverlay();
			
			this.boxElement = 'dyn_overlay';
			new Effect.Opacity(this.boxElement,100);
			Element.setStyle(this.boxElement, {border:'none', background:'none', textAlign:'center'});
		}
		else return printInfo('diaporama() : Pas de div containeur');

		// Sequence images
		this.arrImage = options.arrImage;
		this.currentImg = 0;
		this.totImg = 0;
		for (var att in this.arrImage) this.totImg++; // this.arrImage.length; // Not work ?
		if (this.totImg < 1) return printInfo('diaporama() : aucune image d&eacute;tect&eacute;e');

		// Params utilisateur
		this.control = (options.control == true ? true : false); // Bouttons actions ?
		this.printInfo = (options.printInfo == true ? true : false); // Afficher les actions des controls
		this.globalTempo = options.tempo ? options.tempo : 6; // 6 secondes par defaut
		this.transition = options.transition ? options.transition : this.globalTempo/10; // 0.6 seconde par defaut
		this.marge = options.marge ? options.marge : 6;
		this.imgStyle = options.imgStyle ? ' style="'+options.imgStyle+'"' : '';
		this.imgStyle += options.imgClass ? ' class="'+options.imgClass+'"' : '';
		this.lienStyle = options.lienStyle ? ' style="'+options.lienStyle+'"' : '';
		this.lienStyle += options.lienClass ? ' class="'+options.lienClass+'"' : '';
		this.effect = options.effect ? options.effect : 'scroll';

		// Params interne
		var allowEffect = $w('appear slide scroll blind');
		if (!inArray(this.effect, allowEffect)) this.effect = 'appear';

		this.tempo = this.globalTempo; // Current Tempo 
		this.objetTimeOut = null; // Stock timeOut event
		
		$(this.boxElement).makePositioned();
		$(this.boxElement).makeClipping();
		
		this.boxHeight = parseInt(Element.getHeight(this.boxElement));
		this.boxWidth = parseInt(Element.getWidth(this.boxElement));

		this.ctrHeight = 0; // Not yet
		this.imgBoxHeight = 0; // Not yet

		this.imgBoxId = 'diaporamaBoxImage';
		this.imgBoxIdEffect = 'diaporamaBoxImageEffect';
		this.imgId = 'diaporamaImage';
		this.ctrBoxId = 'diaporamaControler';
		
		// Html Templates
		this.divConteneurImg = '<div id="'+this.imgBoxId+'" style="display:none;position:relative;display:block;overflow:hidden;"><div id="'+this.imgBoxIdEffect+'" style="position:relative;"></div></div>';
		this.lienOpenTpl = new Template('<a href="#{lien}" '+this.lienStyle+' onFocus="this.blur();" >'); // target="_blank"
		this.imgTpl = new Template('<img id="'+this.imgId+'" alt="#{alt}" src="#{src}" width="#{width}" height="#{height}" #{title} border="0" '+this.imgStyle+' />');
		this.lienClose = '<a/>';
		this.divControler = '<div id="'+this.ctrBoxId+'" style="position:relative;display:block;margin-top:'+this.marge+'px;">&nbsp;</div>';
		
		// Images bouttons control
		this.imgBack = 'images/ico_js/back.gif';
		this.imgPause = 'images/ico_js/pause.gif';
		this.imgPlay = 'images/ico_js/play.gif';
		this.imgNext = 'images/ico_js/next.gif';
		this.imgTempo = 'images/ico_js/tempo.gif';
		
		// Let's go
		this._makeContainer();
		this._setImgSrc();
	},

	setTempo: function(tempo) {
		tempo = parseInt(tempo);
		if (this.tempo < 2 || this.tempo > 99999) this.tempo = this.globalTempo;
		else this.tempo = tempo;
		this.suivante();
	},
	
	lecture: function() {
		this._stopTime();
		this._makeTimed();
		if (this.control) {
			Element.hide('lecture');
			Element.show('pause');
		}
		if (this.printInfo) printInfo('Lecture');
	},
	
	pause: function() {
		this._stopTime();
		if (this.control) {
			Element.hide('pause');
			Element.show('lecture');
		}
		if (this.printInfo) printInfo('Pause');
	},
	
	suivante: function() {
		this._stopTime();
		if (!isSet(this.currentImg) || this.currentImg >= (this.totImg-1)) this.currentImg = 0;
		else this.currentImg++;
		if (this.control) {
			Element.hide('lecture');
			Element.show('pause');
		}
		this._unloadImage();
		if (this.printInfo) printInfo('Suivante');
	},
	
	precedante: function() {
		this._stopTime();
		if (!isSet(this.currentImg) || this.currentImg < 1) this.currentImg = this.totImg - 1;
		else this.currentImg--;
		if (this.control) {
			Element.hide('lecture');
			Element.show('pause');
		}
		this._unloadImage();
		if (this.printInfo) printInfo('Précedante');
	},

	_makeContainer: function() {
		
		$(this.boxElement).update(this.divConteneurImg);

		if (this.control) { // To finish :)

			new Insertion.Bottom(this.boxElement, this.divControler); // After ?
			
			// Make control images
			var controler = '<img src="'+this.imgBack+'" border="0" title="Précédante" id="precedante" style="cursor:pointer;">';
			controler += ' <img src="'+this.imgPause+'" border="0" title="Pause" id="pause" style="cursor:pointer;">';
			controler += ' <img src="'+this.imgPlay+'" border="0" title="Lecture" id="lecture" style="cursor:pointer; display:none;">';
			controler += ' <img src="'+this.imgNext+'" border="0" title="Suivante" id="suivante" style="cursor:pointer;">';
			// controler += ' <a href="javascript:void(0);" onClick="Element.toggle(\'slideTempoSpan\');this.blur();" title="Choisir le tempo" id="tempotoggler"><img src="'+this.imgTempo+'" width="15" height="15" border="0"></a>';
			
			$(this.ctrBoxId).hide();
			$(this.ctrBoxId).update(controler);
			Effect.Appear(this.ctrBoxId, {duration : 0.2} ); // (this.tempo/2)
			
			Event.observe('precedante', 'click', this.precedante.bindAsEventListener(this));
			Event.observe('pause', 'click', this.pause.bindAsEventListener(this));
			Event.observe('lecture', 'click', this.lecture.bindAsEventListener(this));
			Event.observe('suivante', 'click', this.suivante.bindAsEventListener(this));

			// Fill box height
			this.ctrHeight = parseInt(Element.getHeight(this.ctrBoxId)) + (this.marge * 2); 
			this.imgBoxHeight = this.boxHeight - this.ctrHeight;
		}
		else this.imgBoxHeight = this.boxHeight;
		
		Element.setStyle(this.imgBoxId, {height:this.imgBoxHeight+'px'});
	},
	
	_makeImg: function() {
		
		
		
		this._centerDivImg(imgPreloader.width, imgPreloader.height);
		
		$(this.imgBoxIdEffect).hide();
		
		var myHtml = '';
		var imgInfoArr = {};
		var lienInfoArr = {};
   
		if (isSet(this.arrImage[this.currentImg]['lien'])) {
			lienInfoArr['lien'] = this.arrImage[this.currentImg]['lien'];
			myHtml += this.lienOpenTpl.evaluate(lienInfoArr);
		}
	
		imgInfoArr['src'] = this.arrImage[this.currentImg]['img'];
		imgInfoArr['alt'] = baseName(imgInfoArr['src']);
		imgInfoArr['width'] = imgPreloader.width;
		imgInfoArr['height'] = imgPreloader.height;
		
		if (isSet(this.arrImage[this.currentImg]['titre']))
			imgInfoArr['title'] = ' title="'+this.arrImage[this.currentImg]['titre']+'"';
		else if (isSet(this.arrImage[this.currentImg]['lien']))
			imgInfoArr['title'] = ' title="'+this.arrImage[this.currentImg]['lien']+'"';
		
		myHtml += this.imgTpl.evaluate(imgInfoArr);
		
		// To check... DOM inserting seem to append end tag... 
		//if (isSet(this.arrImage[this.currentImg]['lien']))
			//myHtml += this.lienClose;
		
		//if (isSet(this.arrImage[this.currentImg]['titre']))
			//myHtml += '<br />'+this.arrImage[this.currentImg]['titre']+'';
	 
		$(this.imgBoxIdEffect).update(myHtml);

		switch(this.effect) {
			case 'slide' : Effect.SlideDown(this.imgBoxIdEffect, {duration : this.transition, afterFinish: this._makeTimed.bind(this) }); break;
			case 'scroll' : Effect.ScrollFromLeft(this.imgBoxIdEffect, {duration : this.transition, afterFinish: this._makeTimed.bind(this) }); break;
			case 'blind' : Effect.BlindDown(this.imgBoxIdEffect, {duration : this.transition, afterFinish: this._makeTimed.bind(this) }); break;
			default : Effect.Appear(this.imgBoxIdEffect, {duration : this.transition, afterFinish: this._makeTimed.bind(this) });
		}
		
		if (!this.control) { // Fly over auto-pause
			Event.observe(this.imgId, 'mouseover', this.pause.bindAsEventListener(this));
			Event.observe(this.imgId, 'mouseout', this.lecture.bindAsEventListener(this));
			Event.observe(this.imgId, 'click', this.pause.bindAsEventListener(this));
		}
	},
	
	_centerDivImg: function(imgWidth, imgHeight) {
		var divImgPadTop = (this.imgBoxHeight - imgHeight) / 2;
		var divImgPadLeft = (this.boxWidth - imgWidth) / 2;

		Element.setStyle(this.imgBoxIdEffect, {left:divImgPadLeft+'px', marginTop:divImgPadTop+'px',width:imgWidth+'px', height:imgHeight+'px'});
		//Element.morph(this.imgBoxIdEffect, 'margin-top:'+divImgPadTop+'px;', {duration : (this.transition/2)});
		//divCtrMargTop = this.boxHeight - imgHeight - (divImgTop*2) - this.ctrHeight;
		//Element.setStyle(this.ctrBoxId, {paddingTop:divCtrMargTop+'px'});
	},
	
	_stopTime: function() {
		if (this.objetTimeOut) this.objetTimeOut.stop();
	},
	
	_unloadImage: function() {
		this._stopTime();

		if (isId(this.imgId)) {
			switch(this.effect) {
				case 'slide' : Effect.SlideUp(this.imgBoxIdEffect, {duration : (this.transition/2), afterFinish: this._setImgSrc.bind(this) } ); break;
				case 'scroll' : Effect.ScrollToRight(this.imgBoxIdEffect, {duration : (this.transition/2), afterFinish: this._setImgSrc.bind(this) } ); break;
				case 'blind' : Effect.BlindUp(this.imgBoxIdEffect, {duration : (this.transition/2), afterFinish: this._setImgSrc.bind(this) } ); break;
				default : Effect.Fade(this.imgBoxIdEffect, {duration : (this.transition/2), afterFinish: this._setImgSrc.bind(this) } ); break;
			}
		}
		else this._setImgSrc();
	},

	_setImgSrc: function() {
		imgPreloader = new Image();
		imgPreloader.onload = this._makeImg.bindAsEventListener(this);
		imgPreloader.src = this.arrImage[this.currentImg]['img'];
	},
	
	_makeTimed: function() {
		this.objetTimeOut = new PeriodicalExecuter(this.suivante.bind(this), this.tempo);
		this._preloadImage();
	},
	
	_preloadImage: function() {
		var nextImg;
		if (!isSet(this.currentImg) || this.currentImg >= (this.totImg-1)) nextImg = 0;
		else nextImg = this.currentImg + 1;
		loadImg(this.arrImage[nextImg]['img']);
	}
};

```

## CSS ##

```

#flickrSlideShow {
	height:260px;
	width:260px;
	text-align:center;
	background:#FFCC00;
}
#diaporamaImage {
	border:1px solid #D8B849;
}

```


## For more information : svn/trunk/trunk/SITE\_01\_SRC/ ##
http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC/