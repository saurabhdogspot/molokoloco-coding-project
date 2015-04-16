# JQUERY TIPS #

This is some fonctions i take from the web, jQuery DOC, ... and others i made...


---


**Sommaire :**




---


## SITES JQUERY ##

  * http://api.jquery.com
  * http://docs.jquery.com || http://docs.jquery.com/Alternative_Resources
  * http://jqueryui.com
  * http://plugins.jquery.com

Les codeurs derrière jQuery...

  * http://ejohn.org (Father of jQuery)
  * http://addyosmani.com
  * http://brandonaaron.net
  * http://benalman.com
  * ...
  * https://github.com/jquery/jquery

Others :

  * http://www.b2bweb.fr/molokoloco/best-must-know-ressources-for-building-the-new-web-%E2%98%85/ (My personnel webdev bookmarks)
  * http://net.tutsplus.com/tutorials/javascript-ajax/14-helpful-jquery-tricks-notes-and-best-practices/
  * http://james.padolsey.com/javascript/things-you-may-not-know-about-jquery/
  * ...

...et..

  * jQuery VS Vanilla JS : https://gist.github.com/harmstyler/7468978

## jQuery 1.7 Cheat Sheet ##

http://woorkup.com/wp-content/uploads/2011/12/jQuery-17-Visual-Cheat-Sheet1.pdf

## jQuery 1.6 Cheat Sheet ##

http://woorkup.com/wp-content/uploads/2011/05/jQuery-1.6-Visual-Cheat-Sheet.pdf

## jQuery 1.4 Cheat Sheet ##

[Image PNG](http://www.b2bweb.fr/bonus/jQueryCheatSheet-1-4.png)|[FichierPDF](http://labs.impulsestudios.ca/downloads/impulse_studios-jquery_cheat_sheet-1.0.pdf)

[![](http://www.b2bweb.fr/bonus/jQueryCheatSheet-1-4-small.png)](http://labs.impulsestudios.ca/downloads/impulse_studios-jquery_cheat_sheet-1.0.pdf)

## Inclure jQuery ##

```
<!-- Grab Google CDN's jQuery. fall back to local if necessary -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>!window.jQuery && document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>
```

ou

```
<script src="http://code.jquery.com/jquery-latest.js"></script>
```

## Injecter jQuery dans une page ##

// jquerify.js
// https://github.com/bgrins/devtools-snippets
// Add jQuery to any page that does not have it already.

```
(function () {

  if ( !window.jQuery ) {
    var s=document.createElement('script');
    s.setAttribute('src','//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js');
    document.body.appendChild(s);
  }

})();
```

## jQuery INIT ##

```

// When jQuery is ready
$(function(){ /*...*/ });

// When document DOM is ready
$(document).ready(function(){
    $('a').click(function(event){
        event.preventDefault();
    });
});

// When all is loaded, includind external files
$(window).bind('load', function()  { /* ... */ });

```

## What is jQuery ? ##

  * http://jsfiddle.net/molokoloco/8t6Qk/

```
$('<img/>')
    .load(function(event) {
        $(this)
            .css({
                opacity: 0,
                top: (($(window).scrollTop() || 0) - $(this).height()) + 'px',
                position: 'absolute',
                left: '50%',
                margin: '0 0 0 -' + ($(this).width() / 2) + 'px' // horizontal center
            })
            .animate({
                opacity: 1,
                top: ($(window).scrollTop() || 0) + 'px'
            }, 800)
            .delay(3000)
            .fadeOut(600, function() {
                $(this).remove();
            });
    })
    .error(function() {})
    .attr('src', 'http://jsfiddle.net/img/logo.png')
    .appendTo('body');
```

## Catch/Find an element with CSS like selector ##

```

$('p#info').html('Test'); // <p id="info">Test</p>
$('p:first, td.odd').addClass('bigText'); // <td class="odd bigText">
$('body').attr('onload')
$('#quicktimePlayer').empty();
$('#player').append(otherElement);
$('#id').click(/*...*/)
$(document).ready(/*...*/)
$('img').load(function(e) { /*...*/ })
$('ul').find('li:last-child');
$('p', document).size();
$('p[a]').hide();
$('a[(text()="Suivante")]').show();
$(xml.responseXML);
$('input[type=password]').attr('type','text');
$('title', xml.responseXML); // Finds all title elements within an XML document
$('p').height()
$('/html/body//p').attr({align:'center'});
$('body').css({'overflow' : 'hidden'});
$('button:gt(1)').attr('disabled','disabled'); // Disables buttons greater than the 1st button.
$('ul li:last').after('<li>Added text ' + p + '</li>');
$(':input'); // Matches all input, textarea, select and button elements
$('form input:text') // iniput type=text
$('form > *'); // formChildren 
if ($(this).is(':first-child')) {}
if ( $(this).hasClass('protected') )
$('div').show().fadeOut('slow');
$("#myselect").val();
$('<div/>').text('This is fun & stuff').html(); // htmlentities == "This is fun &amp; stuff"
$maDiv = $('<div />', {text: $this.attr('title')});
$("#myselect option:selected").text();
$("span").fadeIn("slow");
if($(element).is(":visible") == "true") {}

$('#target div:not(#exclude)').hide();
$("div:contains('John')").css('text-decoration', 'underline');
$(item.content).find("img[src]:contains('http')");
$('div:not(:has(img))')

var foundin = $('*:contains("some string bla bla")');
$('#myTable tr:last').after('<tr>...</tr>');
var elements = $('#someid input[type=sometype][value=somevalue]').get();
$('a').slice(0,10);
$.each($('form#formEdit').serializeArray(), function(i, o){ siteObj[o.name] = o.value; });
var id = $('#someAnchor').get(0).id; // The get method is particularly helpful, as it can translate your jQuery collection into an array
$(xml).find('article').each(function(i) {
    alert($(this).find('titre').text()); 
});

$('p a').each(function() { // Affiche les URL des liens dans les paragraphes
    $(this).after(' ['+$(this).attr('href')+'] ');
})

var q = 'search';
$('.recordSleeveBk').css({ opacity: '0.4' }).removeClass('glow');
$('.recordSleeveBk').filter('[data-artist*="' + q + '"]').animate({ opacity: '1.0' }).addClass('glow');

$( ".container" )
  .contents()
    .filter(function() {
      return this.nodeType === 3;
    })
      .wrap( "<p></p>" )
      .end()
    .filter( "br" )
    .remove();


$.each(['a','b','c'], function(i, l){
    alert("Index #" + i + ": " + l );
});

$.each({name: "John", lang: "JS"}, function(k, v){
    alert("Key: " + k + ", Value: " + v );
});

this.columns.each(function(item) { this.buildHeader(item); }, this);

var css_link = $('<link>', {rel: 'stylesheet', type: 'text/css', href: 'style.css'});
css_link.appendTo('head');

var $myInput = $('input#search');
$myInput
    .data('valInit', $myInput.val())
    .focus(function() { if ($(this).val() == $(this).data('valInit')) $(this).val(''); })
    .blur(function() { if ($(this).val() == '') $(this).val($(this).data('valInit')); });

$(window).load(function(){
    if ( window.location.hash ) {
        var destination = $( window.location.hash ).offset().top;
        $('html:not(:animated),body:not(:animated)').scrollTop( destination );
    }
});

var popUp = function(message, delay) {
    delay = delay || 5000;
    $('<div />')
        .addClass('ui-loader ui-overlay-shadow ui-corner-all')
        .css({opacity: 0.96, top: $(window).scrollTop() + 100})
        .html('<h1>Message...</h1><p>'+message+'</p>')
        .appendTo('body')
        .hide().fadeIn(200)
        .delay(delay)
        .fadeOut(400, function(){ $(this).remove(); });
};

$('body').css('zoom', $(window).width() / 1920);


if (!(options.node instanceof jQuery)) {
    options.node = $(options.node);
}

```

## SHORTCUT MEMO ##

```

if (/^[\w\d\_\.]{4,}$/.test($('#username').attr('value'))) alert('Ok');

if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) return;

if (/(_on)/.test($(this).attr('src'))) $(this).attr({src: $(this).attr('src').split('_on.png')[0]+'.png'});

var imgId = '#site_img_'+$(this).attr('id').split('_')[2];

var domaine = $(this).attr('href').split('/')[2].replace(/(\.www)/g, '');

var loadJs = function(src) { $('head').append('<' + 'script type="text/javascript" src="'+src+'"></sc'+'ript>'); };

$('<div id="#slide-' + i + '"></div>')  
    .load('slides/' + i + '.html')  // INCLUDE
    .appendTo($container);

// Update tag
$('img.hate').attr({
    src: '/images/love.gif',
    alt: 'jQuery Logo'
});

// Create tag (link)
var $a = $('<a/>', {  
    id : 'someId',  
    className : 'someClass',  
    href : 'somePath.html'  
}).appentTo('body');

$('div').text($('img').attr('alt'));

$('div.example').css('width', function(index) {
  return index * 50;
});

if ($('#myDiv').is('.pretty')) $('#myDiv').show();

$('#myDiv:visible').animate({left: '+=200px'}, 'slow');

$('button').each(function()  {
    var el = $(this);
    var elId = el.attr('id');
});

var targetOffset = $('li.selectedShow').offset().top;
targetOffset = targetOffset-14;
$('html,body').animate({scrollTop: targetOffset},5);

$('div.scrollable:eq(1) div.items div').click(function() { 
    $(this).fadeOut().fadeIn();   
});

if (!$(event.target).is('div') && !$(event.target).parents().is('div')) { // outside div
    $('div').hide();
}

$('div')
    .attr('id', function(arr) { return 'div-id' + arr; })
    .each(function() { $('span', this).html('(ID = <b>' + this.id + '</b>)'); });

$('p').eq(0).css('color', 'red') // First

$('<div><p>Hello</p></div>').appendTo('body');

$(document).keypress(function (e) {
    //$('#duree').text(e.which);
    toggleMenu();
});

$(document.body).click(function () {
    $(document.body).append($('<div>'));
    var n = $('div').length;
}).trigger('click');

$(document.body).click(function () {
    $('div').each(function (i) {
        if (this.style.color != 'blue') this.style.color = 'blue';
        else this.style.color = '';
    });
});

$('li').slice(2, 4).css('background-color', 'green');  

// Toggle all checkboxes
var tog = false; // or true if they are checked on load
$('a').click(function() {
    $("input[type=checkbox]").attr("checked",!tog);
    tog = !tog;
});

// index of an element
$("ul > li").click(function () {
    var index = $(this).prevAll().length;
});


var nextTrack = function() {
    soundManager.stopAll();
    if ($('li.active').next().click().length == 0) {
        $('.tracks li:first').click();
    }
}â€‹;â€‹

// see if an image is loaded
var imgsrc = 'img/image1.png';
$('<img/>').load(function(){alert('image loaded');}).error(function(){alert('error loading image');}).attr('src', imgsrc);

// Storing DATAS with elements...
var adiv = $("div").get(0);
jQuery.data(adiv, "test", { first: 16, last: "pizza!" });
$("span:first").text(jQuery.data(adiv, "test").first);
$("span:last").text(jQuery.data(adiv, "test").last);

// Or
$("div").data('storeName', 'stockValue');
alert($("div").data("storeName"));
$("div").removeData();
$("div").remove();


// When you bind a "live" event it will bind also to future elements
$("p").live("click", function(){
    $(this).after("<p>Another paragraph!</p>");
});



// Toggle multiple classes
$('div').toggleClass( "a b" ); 
// <div class="c">
$('div').toggleClass( "a c" );
// <div class="a">
$('div').toggleClass( "a b c", false );
// <div>
$('div').toggleClass( "a b c", true ); 
// <div class="a b c">

```

### jquery event for images loaded ###
// Stack http://stackoverflow.com/questions/910727/jquery-event-for-images-loaded/28486292#28486292
// Demo http://jsfiddle.net/molokoloco/NWjDb/

```
$(function() { // Wait dom ready
    var $img = $('img'), // images collection
        totalImg = $img.length,
        waitImgDone = function() {
            totalImg--;
            if (!totalImg) {
                console.log($img.length+" image(s) chargée(s) !");
            }
        };
    $img.each(function() {
        if (this.complete) waitImgDone(); // already here..
        else $(this).load(waitImgDone).error(waitImgDone); // completed...
    });
});
```

### Shuffle the DOM ###

```
$.fn.shuffle = function () {
    var allElems = this.get(),
        getRandom = function (max) {
            return Math.floor(Math.random() * max);
        },
        shuffled = $.map(allElems, function () {
            var random = getRandom(allElems.length),
                randEl = $(allElems[random]).clone(true)[0];
            allElems.splice(random, 1);
            return randEl;
        });
    this.each(function (i) {
        $(this).replaceWith($(shuffled[i]));
    });
    return $(shuffled);
};

$('ul#menu li').shuffle();
```

## BINDABLES EVENTS ##

  * http://api.jquery.com/category/events/

```

/*
    bind() trigger() unbind() delegate() undelegate() live() die() 
    blur() focus()  change() error() load() unload() beforeunload()
    keydown() keypress() keyup()
    one() click() dblclick() mouseenter() mouseleave() hover() mousedown() mousemove() mouseout() mouseover() mouseup() 
    ready() resize() scroll() select() submit() toggle()
*/


$('#btnG').hide();
var showButton = function(e) { 
    $(document).unbind('mousemove', showButton);
    $('#btnG').show();
    $('#q').focus();
};
$(document).mousemove(showButton);


// Pour déclencher un click
$currentFocusItem[0].click(); // Work in more browser
$currentFocusItem.click();    // Do not work in all browser

// To open a select menu :
// Like i see there, it work in Chrome :
// http://stackoverflow.com/a/10136523/174449

var event = document.createEvent('MouseEvents');
event.initMouseEvent('mousedown', true, true, window);
element.dispatchEvent(event);


$(window).bind('resize', function() {
    resizeFrame();
});

$('div').one('click', function() { /*... Only first time*/ });

$('div#fox img, div#ie img, div#saf img').hover(
    function(event) { $(this).stop(true, true).animate({marginTop:'0px'}, {duration:500}); }, 
    function(event) { $(this).stop(true, true).animate({marginTop:'-28px'}, {duration:500}); }
);

$('.thumbLien').hover(
    function () {
        var imgId = '#site_img_'+$(this).attr('id').split('_')[2];
        cvi_glossy.modify($(imgId)[0], {shadow:66});
    }, 
    function () {
        var imgId = '#site_img_'+$(this).attr('id').split('_')[2];
        cvi_glossy.modify($(imgId)[0], {shadow:20});
    }
);

$('#foo').bind('mouseenter mouseleave', function() {
    $(this).toggleClass('focus');
});

$('#foo').bind({
    click: function() {
        // do something
    },
    mouseover: function() {
        // do something
    },
    mouseout: function() {
        // do something
    }
});
$('#foo').trigger('click'); // Do event

$('input#search').trigger($.Event('keydown', {which:$.ui.keyCode.ENTER, keyCode:$.ui.keyCode.ENTER}));

$doc.trigger({type: 'startPlay', percent: percent});

// Listen to events from a particular context // OPTIMISATION !

$('table').delegate('td', 'hover', function(){
    $(this).toggleClass("active");
});

// Or...

$('table#data').bind('click', function(event) { 
    var cell = $(event.target).closest('td');
});

// "return false" is actually doing three very separate things when you call it:
//   1. event.preventDefault();
//   2. event.stopPropagation();
//   3. Stops callback execution and returns immediately when called.

$('a').click(function (e) {
    // here your code
    e.preventDefault(); // cancel default behavior
});
$('a').click();

$('#myImage').attr('src', 'image.jpg').load(function() {
    alert('Image Loaded');
});

$('#text').keypress(function(e){
    socket.emit('client_data', {'letter': String.fromCharCode(e.charCode)});
});

// Horloge
var pad = function(s) { return (s < 10 ? '0'+s : s); }
var timer = setInterval(function() {
    var dt = new Date();
    $('#horloge').html(pad(dt.getHours())+':'+pad(dt.getMinutes())+':'+pad(dt.getSeconds()));
}, 1000);


// When clicking on an image we keep track of the index (child item index)
$('#thumbs_container').delegate('li','click tap',function(){
    current = $(this).index();
});

// Listening mouse move only when mouse down...

var mouseIsMove = function(evt) { disturb(evt.pageX, evt.pageY); };
var mouseIsDown = function(evt) { $('body').bind('mousemove', mouseIsMove); };
var mouseIsUp = function(evt) { $('body').unbind('mousemove', mouseIsMove); };
$('body')
    .bind('mousedown', mouseIsDown)
    .bind('mouseup click', mouseIsUp);


// Adjust & auto-zoom
$(document).ready(function() {
  var w = screen.width;
  var h = screen.height;

  var bw = $(window).width();
  var bh = $(window).height();

  var wRatio = bw/w;
  var hRatio = bh/h;
  var ratio = (wRatio + hRatio) / 2;

  $('body').css('zoom', ratio);
});
```

// TRIPPLE Click ?

```
$.tripleclickThreshold = 1000;

$.event.special.tripleclick = {
	setup: function( data ) {
		$(this)
			.data( 'tripleclick', { clicks: 0, last: 0, threshold: data })
			.on( 'click', $.event.special.tripleclick.handler );
	},
	teardown: function() {
		$(this)
			.removeData( 'tripleclick' )
			.off( 'click', $.event.special.tripleclick.handler );
	},
	handler: function(event) {
		var elem = $(this),
			data = elem.data( 'tripleclick' ),
			threshold = data.threshold || $.tripleclickThreshold;
		if ( event.timeStamp - data.last > threshold ) {
			data.clicks = 0;
		}
		data.last = event.timeStamp;
		if ( ++data.clicks === 3 ) {
			elem.triggerHandler( 'tripleclick' );
			data.clicks = 0;
		}
	}
};
```

// TROTTLE RESIZE

```
var windowTmr = null; // Timeout..

$window.on('resize', function() {   // Trottle resize...
    if (windowTmr) clearTimeout(windowTmr);
    windowTmr = setTimeout(function() {   // Trottle resize...
        windowTmr = null;
        $.waypoints('refresh'); // Action
    }, 1600); // Trottle resize
});
```

## JQUERY SELECTORS (CSS3 like xPath) ##

http://api.jquery.com/category/selectors/

Returns: jQuery Array<Element(s)> Matches

<strong>Selector     Example     Description     Reference</strong>

  * `*`     $("`*`")     It will select all the elements     http://api.jquery.com/all-selector/
  * #id     $("#myid")     The element with id name myid will be selected     http://api.jquery.com/id-selector/
  * .class     $(".myclass")     The element with class name myclass will be selected     http://api.jquery.com/class-selector/
  * .class1.class2     $(".class\_first. class\_second")     It will select all the elements of class\_first and class\_second classes     http://api.jquery.com/class-selector/
  * element     $("p")     All p elements will be selected     http://api.jquery.com/element-selector/
  * :first     $("li:first")     The first li element will be selected     http://api.jquery.com/first-selector/
  * :last     $("li:last")     The last li element will be selected     http://api.jquery.com/last-selector/
  * :even     $("tr:even")     All even tr elements will be selected     http://api.jquery.com/even-selector/
  * :odd     $("tr:odd")     All odd tr elements will be selected     http://api.jquery.com/odd-selector/
  * :eq(index)     $("ul li:eq(2)")     The index starts at 0. The third element in a list will be selected.     http://api.jquery.com/eq-selector/
  * :gt(no)     $("ul li:gt(2)")     List elements with an index greater than 2 will be selected     http://api.jquery.com/gt-selector/
  * :lt(no)     $("ul li:lt(2)")     List elements with an index less than 2 will be selected     http://api.jquery.com/lt-selector/
  * :header     $(":header")     All the header elements will be selected (ex. h1,h2,â€¦)     http://api.jquery.com/header-selector/
  * sel1,sel2,sel3     $("p,td,.myclass")     All elements with matching selectors will be selected     http://api.jquery.com/multiple-selector/
  * :contains(text)     $(":contains (â€˜smartnetzoneâ€™)")     All elements which contains the text smartnetzone will be selected     http://api.jquery.com/contains-selector/
  * :visible     $("table:visible")     All visible tables will be selected     http://api.jquery.com/visible-selector/
  * :empty     $(":empty")     All elements with no child elements will be selected     http://api.jquery.com/empty-selector/
  * :hidden     $("p:hidden")     All hidden p elements will be selected     http://api.jquery.com/hidden-selector/
  * :reset     $(":reset")     All input elements with type="reset" will be selected     http://api.jquery.com/reset-selector/
  * :button     $(":button")     All input elements with type="button" will be selected     http://api.jquery.com/button-selector/
  * :file     $(":file")     All input elements with type="file" will be selected     http://api.jquery.com/file-selector/
  * :submit     $(":submit")     All input elements with type="submit" will be selected     http://api.jquery.com/submit-selector/
  * :input     $(":input")     All input elements will be selected     http://api.jquery.com/input-selector/
  * :text     $(":text")     All input elements with type="text" will be selected     http://api.jquery.com/text-selector/
  * :password     $(":password")     All input elements with type="password" will be selected     http://api.jquery.com/password-selector/
  * :enabled     $(":enabled")     All enabled input elements will be selected     http://api.jquery.com/enabled-selector/
  * :disabled     $(":disabled")     All disabled input elements will be selected     http://api.jquery.com/disabled-selector/
  * :selected     $(":selected")     All selected input elements will be selected     http://api.jquery.com/selected-selector/
  * :radio     $(":radio")     All input elements with type="radio" will be selected     http://api.jquery.com/radio-selector/
  * :checkbox     $(":checkbox")     All input elements with type="checkbox" will be selected     http://api.jquery.com/checkbox-selector/
  * [attribute](attribute.md)     $("[href](href.md)")     All elements with a href attribute will be selected     http://api.jquery.com/has-attribute-selector/
  * [attribute=value]     $("[href='index.html']")     All elements with a href attribute value equal to "index.html" will be selected     http://api.jquery.com/attribute-equals-selector/
  * [attribute!=value]     $("[href!='index.html']")     All elements with a href attribute value not equal to "index.html" will be selected     http://api.jquery.com/attribute-not-equal-selector/
  * [attribute$=value]     $("[href$='.jpg']")     All elements with a href attribute value ending with ".jpg" will be selected     http://api.jquery.com/attribute-ends-with-selector/
  * :animated   $("div:animated")         // All elements that are currently being animated.


```
$('div#login').show()
$("[href$='.jpg']").attr({target:'_blank');
$('div#header ul > li:even').attr({align:'right'});
$('div.ok,div.error').remove()
```

## CUSTOM SELECTORS ##

http://www.jquery.info/spip.php?article82

```

$.extend($.expr[':'], {
    external: function(a,i,m) { // VÃ©rifie si les liens sont externes (Ne fonctionne que pour les Ã©lÃ©ments qui ont un href)
        if (!a.href) return false;
        return a.hostname && a.hostname !== window.location.hostname;
    },
    inView: function(a) { // VÃ©rifier si l'Ã©lÃ©ment est actuellement dans la zone de vue (viewport)
        var st = (document.documentElement.scrollTop || document.body.scrollTop),
            ot = $(a).offset().top,
            wh = (window.innerHeight && window.innerHeight < $(window).height()) ? window.innerHeight : $(window).height();
        return ot > st && ($(a).height() + ot) < (st + wh);
    },
    block: function(elem) {
        return $(elem).css("display") === "block";
    },
    hasData : function(elem) {
        return !$.isEmptyObject( $(elem).data() );
    }
});

// Utilisation :

$('a:external'); // SÃ©lectionne toutes les ancres qui pointent vers une page ou un site externe
$('div:inView'); // SÃ©lectionne tous les Ã©lÃ©ments div qui sont dans la zone de vue actuelle
$("p:hasData").text("has data"); // grabs paras that have data attached

```

## INSERT ELEMENT ##

```

/*
<ul class="sortUlLink">
    <li class="sortLink"><a href="http://image-swirl.googlelabs.com">Swirl</a></li>
    <li class="sortLink"><a href="http://translate.google.fr/">Traductions</a></li>
    <!--// Insert Here //-->
    <li class="liAddLink"><a class="addLink" href="javascript:void(0);" onclick="add(this);">[+]</a></li>
</ul>
*/

var add = function(elm) {
    var liParent = $(elm).parent();
    $('<li class="sortLink"><a href="#">Something</a></li>').insertBefore(liParent);
};

```

## KEYS ##

```

var event2key = {'97':'a', '98':'b', '99':'c', '100':'d', '101':'e', '102':'f', '103':'g', '104':'h', '105':'i', '106':'j', '107':'k', '108':'l', '109':'m', '110':'n', '111':'o', '112':'p', '113':'q', '114':'r', '115':'s', '116':'t', '117':'u', '118':'v', '119':'w', '120':'x', '121':'y', '122':'z', '37':'left', '39':'right', '38':'up', '40':'down', '13':'enter'};

$(document).keypress(function(e) {
    $('.l').each(function() {
        if (event2key[e.which] != '' && $(this).html().charAt(0).toLowerCase() ==  event2key[e.which]) $(this).attr('class', 'l hightlight');
        else $(this).attr('class', 'l');
    });

        switch(event2key[(e.which || e.keyCode)]) {
        case 'left': break;
        case 'right': break;
        case 'up': break;
        case 'down': break;
        case 'enter': break;
                case 'a': break;
    }
});

```

## BROWSERS ##

```

$('#browser').html( 'You are using the browser: ' + $.browser.browser() );
$.browser.version.string();
$.browser.version.number();
$.browser.OS();
var firefox = $.browser.firefox();

```

## ARRAY Build in functions ##

```

jQuery.isArray( obj )   //  Returns: Boolean // Added in jQuery 1.3 Determine if the parameter passed is an array.
jQuery.isFunction( obj )   //  Returns: Boolean // Determine if the parameter passed is a Javascript function object.
jQuery.trim( str )
jQuery.param({width:160, height:105}); // width=160&height=105
jQuery.each( object, callback )   //  Returns: Object // A generic iterator function
jQuery.extend( deep, target, object1, objectN )   //  Returns: Object // Extend one object with one or more others, returning the modified object.
jQuery.grep( array, callback, invert )   //  Returns: Array // Filter items out of an array, by using a filter function.
jQuery.makeArray( obj )   //  Returns: Array // Turns anything into a true array.
jQuery.map( array, callback )   //  Returns: Array // Translate all items in an array to another array of items.
jQuery.inArray( value, array )   //  Returns: Number // Determine the index of the first parameter in the Array (-1 if not found).
jQuery.merge( first, second )   //  Returns: Array // Merge two arrays together.
jQuery.unique( array )   //  Returns: Array // Remove all duplicate elements from an array of elements. Note that this only works on arrays of DOM elements
 
// NATIVES...  --------------------------------------------------------------- //
 
var x = [];
x.push(1);
var x = [0, 3, 1, 2];
x.reverse() // [2, 1, 3, 0]
x.join(' - ') // '2 - 1 - 3 - 0'
x.pop() // [2, 1, 3]
x.unshift(-1) // [-1, 2, 1, 3]
x.shift() // [2, 1, 3]
x.sort() // [1, 2, 3]
x.splice(1, 2) // [2, 3]
 
// --------------------------------------------------------------- //
 
x = Math.ceil(6.01); //donne x = 7
x = Math.floor(6.01); //donne x = 6
x = Math.round(6.01); //donne x = 6
x = Math.max(6,7.25); //donne x = 7.25
x = Math.min(6,7.25); //donne x = 6
x = Math.pow(3,3); //donne x = 27
x = Math.random(); //donne x = 0.6489534931546957

```

## Wait finish // Defered Done ##

  * Live example : http://jsfiddle.net/molokoloco/2ZmjC/
  * http://msdn.microsoft.com/en-us/scriptjunkie/gg723713.aspx
  * http://jsfiddle.net/molokoloco/2ZmjC/

```

promise.then( doneCallback, failCallback )
// is equivalent to
promise.done( doneCallback ).fail( failCallback )

// http://tutorialzine.com/2011/03/custom-facebook-wall-jquery-graph/

var graphUSER = 'http://graph.facebook.com/'+options.id+'/?fields=name,picture&callback=?',
    graphPOSTS = 'http://graph.facebook.com/'+options.id+'/posts/?callback=?&date_format=U&limit='+options.limit;

$.when($.getJSON(graphUSER),$.getJSON(graphPOSTS)).done(function(user,posts){
    // user[0] contains information about the user (name and picture);
    // posts[0].data is an array with wall posts;
    var fb = {
        user : user[0],
        posts : []
    };
    $.each(posts[0].data,function(){
        if(this.type != 'link' && this.type!='status'){
            return true;
        }
        this.from.picture = fb.user.picture;
        fb.posts.push(this);
    });
    // Rendering the templates:
    $('#headingTpl').tmpl(fb.user).appendTo('body');
});
```

// From : http://stackoverflow.com/questions/6538470/jquery-deferred-waiting-for-multiple-ajax-requests-to-finish

```
function updateAllNotes () {
        var getarray = [], i, len;
        for (i = 0, len = data.length; i < len; i += 1) {
            getarray.push(getNote(data[i].key));
        };
        $.when.apply($, getarray).done(function () {
          // do things that need to wait until ALL gets are done
        });
};
```

```
$.ajaxSetup({
    dataType: "jsonp"
});

function getTweets() {
    $.ajax("http://api.twitter.com/statuses/user_timeline/danwellman.json", {
        success: function(data) {
            var arr = [];
            for (var x = 0; x < 5; x++) {
                var dataItem = {};
                dataItem["tweetlink"] = data[x].id_str;
                dataItem["timestamp"] = convertDate(data, x);
                dataItem["text"] = breakTweet(data, x);
                arr.push(dataItem);
            }
            tweetData = arr;
        }
    });
}
function getFriends() {
    /* ... */
}
function getFollows() {
    /* ... */
}

//execute once all requests complete
$.when(getTweets(), getFriends(), getFollows()).then(function(){
    //apply templates
});
```

```
var fetchTweets = function() {
    var dfd = new $.Deferred();
    $.ajax({
        type: 'GET',
        dataType: 'jsonp',
        url: 'http://search.twitter.com/search.json?q=html5',
        success: function(tweets) {
            var twitter = $.map(tweets.results, function(obj, index) {
                return {
                    username: obj.from_user,
                    tweet: obj.text,
                    imgSource: obj.profile_image_url,
                    geo: obj.geo
                };
            });
            dfd.resolve(twitter);
        }
    });
    return dfd.promise();
};

$.when(fetchTweets()).done(function(twitter) {
    console.log(twitter);
});
```

```
var Menu = (function(){
    var init = function() {
        loadPage();
    },
    loadPage = function() {
        $ac_loading.show();
        $.when(loadImages()).done(function(){
            /* ... */
        });
    },
    loadImages = function() {
        return $.Deferred(
            function(dfd) {
                var total_images = $ItemImages.length,
                loaded = 0;
                for(var i = 0; i < total_images; ++i){
                    $('<img/>').load(function() {
                        ++loaded;
                        if (loaded === total_images) dfd.resolve();
                    }).attr('src' , $ItemImages[i]);
                }
            }
        ).promise();
    };
    return {
        init : init
    };
})();

Menu.init();
```

The Promise exposes only the Deferred methods needed to attach additional handlers or determine the state (then, done, fail, always,pipe, progress, and state), but not ones that change the state (resolve, reject, progress, resolveWith, rejectWith, and progressWith).

```
function getData(){
   return $.get('/echo/html/');
}

function showDiv(){
    var dfd = $.Deferred();
    
    $('#foo').fadeIn( 1000, dfd.resolve );
    
    return dfd.promise();
}

$.when( getData(), showDiv() )
    .then(function( ajaxResult ){
        console.log('The animation AND the AJAX request are both done!');

        // â€˜ajaxResultâ€™ is the serverâ€™s response
    });
```


  * jQuery.Deferred()    A constructor that creates a new Deferred object, can take an optional initFunction parameter that will be called right after the deferred has been constructed.
  * jQuery.when()    A way to execute callback functions based on one or more objects that represent asynchronous tasks.
  * jQuery.ajax()    Performs an asynchronous Ajax requests where the jqXHR objects returned by $.ajax() implement the Promise interface, giving them all the properties, methods, and behaviour of a Promise.
  * deferred.then(resolveCallback,rejectCallback)    Handlers to be called when the Deferred object is resolved or rejected.
  * deferred.done()    Functions or array of functions that are called when the Deferred object is resolved.
  * deferred.fail()    Functions or array of functions that are called when the Deferred is rejected.
  * deferred.resolve(arg1, arg2, ...)    Resolve a Deferred object and call any 'done' Callback with the given arguments.
  * deferred.resolveWith(context,args)    Resolve a Deferred object and call any 'done' Callback with the given context and arguments.
  * deferred.isResolved    Determine whether a Deferred object has been resolved.
  * deferred.reject(arg1, arg2, ...)    Reject a Deferred object and call any 'fail' Callback with the given arguments.
  * deferred.rejectWith(context,args)    Reject a Deferred object and call any 'fail' Callback with the given context and arguments.
  * deferred.promise()    Returns a promise, that is an immutable view of the deferred object: the promise can be passed around safely since the underlying deferred cannot be resolved or rejected through it.


## PROXY ##

```
setTimeout($.proxy( function () {
        // "this" now refers to our element as we wanted
        $( this ).addClass( "active" ); 
}, this), 500);
```

## ANIMATE ##

  * http://www.robertpenner.com/easing/easing_demo.html
  * http://www.learningjquery.com/2009/02/quick-tip-add-easing-to-your-animations
  * http://coding.smashingmagazine.com/2011/10/04/quick-look-math-animations-javascript/


```

// Short !
$('.block').animate({width:'70%', fontSize:'3em', borderWidth:'10px'}, 1500);
$('div#mydiv').slideUp(300).delay(800).fadeIn(400);

// Full function...
$('#myDiv').animate({ // what we are animating
        opacity:0,
        width:'toggle', 
        height:150
    }, {
        duration: 'fast', // how fast we are animating or in seconds
        easing: 'swing', // the type of easing
        specialEasing: {
            width: 'linear',
            height: 'easeOutBounce'
        },
        step: function(now, fx) {
            var data = fx.elem.id + ' ' + fx.prop + ': ' + now;     
            $('body').append('<div>' + data + '</div>');
        }
        complete: function() { // the callback
            alert('done');
            $(this).addClass('done');
        }
    }
);

// Optionnal parameter... milliseconds setInterval
jQuery.fx.interval = 100;

// hook into jQuery's animation mechanism by adding a property to the jQuery.fx.step object:
$.fx.step["someCSSProp"] = function(fx){
     $.cssHooks["someCSSProp"].set( fx.elem, fx.now + fx.unit );
};

// Be carefull when use animate...
$('.page').stop().animate({width: '20%'}, 200);
// jQuery automaticcaly put overflow:hidden no element..
// to override this... put in CSS style :
.page { overflow: visible !important; }

```

```
// HELPERS native SETTIMEOUT (setTimeout)

setTimeout("alert('bouh');"); // buys you some time until the DOM elements are loaded

setTimeout(maFonction, 60 * 1000); // in 60 seconds

var arg = 'bouh !',
    myTimeout = setTimeout(function(_arg) {
        alert(_arg);
    }, 10*1000, arg); // Pass callback argument at the end !
if (Math.rand() > 0.5) clearTimeout(myTimeout); // Don't bouh ?
```


## Chaining ASYNC method ##

  * http://kenneth.kufluk.com/blog/2010/08/chaining-asynchronous-methods-in-jquery-using-the-queue/

```
$.fn.makeYellowForFiveSeconds = function() {
    // I'm only using actions which act on jQuery objects, so I don't need to use 'each' as above.  
    this.css( { 'background-color' : 'yellow', color : 'yellow' } );
    // reset the colour in five seconds time
    var that = this; 
    this.queue(function() {
        setTimeout(function() {
            that.css( { 'background-color' : 'none', color : 'inherit' } );
            that.dequeue();
        }, 5000);
    });
    // action the next method in the chain
    return this;
};

```

## Emulating 3D with CSS... ##

```
/* 
#
# .photoflat {  
#     -moz-transform: scale(1) rotate(0deg) translate(0px, 0px) skew(-21deg, 10deg);  
#     transform-origin: 0% 0%;  
#     -webkit-transform: scale(1) rotate(0deg) translate(0px, 0px) skew(-21deg, 10deg);  
#     -moz-box-shadow:0px 1px 3px #333333 ;  
#     -webkit-box-shadow:0px 1px 3px #333333;  
#     box-shadow:0px 1px 3px #333333;  
#     margin-left:-43px;  
#     border:1px solid white;  
#     position:relative;  
# }  
*/

$(this).css('-moz-transform', 'scale(' + dist + ') skew(' + skew2 +'deg, 0deg)');  
$(this).css('-webkit-transform', 'scale(' + dist + ') skew(' + skew2 +'deg, 0deg)');  

var d = 0;
setInterval(
    function () { div.style['MozTransform'] = 'rotate(' + (d++ % 360) + 'deg)'; },
    100
);
```

```
$(this).hide('puff', {}, 1000);

/*
    Effects that can be used with Show/Hide/Toggle:
        Blind - Blinds the element away or shows it by blinding it in.
        Clip - Clips the element on or off, vertically or horizontally.
        Drop - Drops the element away or shows it by dropping it in.
        Explode - Explodes the element into multiple pieces.
        Fold - Folds the element like a piece of paper.
        Puff - Scale and fade out animations create the puff effect.
        Slide - Slides the element out of the viewport.
        Scale - Shrink or grow an element by a percentage factor.
 
    Effects that can be only used stand-alone:
        Bounce - Bounces the element vertically or horizontally n-times.
        Highlight - Highlights the background with a defined color.
        Pulsate - Pulsates the opacity of the element multiple times.
        Shake - Shakes the element vertically or horizontally n-times.
        Size - Resize an element to a specified width and height.
        Transfer - Transfers the outline of an element to another.
*/
```

Request animation

```
window.requestAnimFrame = (function(){
      return  window.requestAnimationFrame       || 
              window.webkitRequestAnimationFrame || 
              window.mozRequestAnimationFrame    || 
              window.oRequestAnimationFrame      || 
              window.msRequestAnimationFrame     || 
              function(/* function */ callback, /* DOMElement */ element){
                window.setTimeout(callback, 1000 / 60);
              };
    })();

function render() {
      // do something
      window.requestAnimFrame(render);
}
render();
```

## Templating ##

http://net.tutsplus.com/tutorials/javascript-ajax/fun-with-jquery-templating-and-ajax/

```
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>  
<script src="jquery.tmpl.js"></script>  
```

```
<script id="tweets" type="text/x-jquery-tmpl">  
    <li>  
        <img src="${imgSource}" alt="${username}" />  
        <h2> ${username} </h2>  
        <p> ${tweet} </p>  
        {{if geo}}  
        <span> ${geo} </span>  
        {{/if}}  
    </li>  
</script>  
```

```
 $.ajax({  
    type : 'GET',  
    dataType : 'jsonp',  
    url : 'http://search.twitter.com/search.json?q=nettuts',  
    success : function(tweets) {  
       var twitter = $.map(tweets.results, function(obj, index) {  
          return {  
             username : obj.from_user,  
             tweet : obj.text,  
             imgSource : obj.profile_image_url,  
             geo : obj.geo  
          };  
       });  
    }  
});
```

```
<script type="text/x-jquery-tmpl" id="option-template">
      <div class="option"><input type="radio" data-bind="attr: {id: id, name: option_group}, value: id, checked: $item.selected_value"><label data-bind="attr: {for: id}, text: label"></label></div>
    </script>
```

## Elements methodes ##

```

$('a:first').offset();

/*

offset()//  Returns: Object{top,left} // Get the current offset of the first matched element, in pixels, relative to the document.
position()//  Returns: Object{top,left} // Gets the top and left position of an element relative to its offset parent.
scrollTop()//  Returns: Integer // Gets the scroll top offset of the first matched element.
scrollTop(val)//  Returns: jQuery // When a value is passed in, the scroll top offset is set to that value on all matched elements.
scrollLeft()//  Returns: Integer // Gets the scroll left offset of the first matched element.
scrollLeft(val)//  Returns: jQuery // When a value is passed in, the scroll left offset is set to that value on all matched elements.

height()//  Returns: Integer // Get the current computed, pixel, height of the first matched element.
height(val)   //  Returns: jQuery // Set the CSS height of every matched element.
width()//  Returns: Integer // Get the current computed, pixel, width of the first matched element.
width(val)//  Returns: jQuery // Set the CSS width of every matched element.
innerHeight()//  Returns: Integer // Gets the inner height (excludes the border and includes the padding) for the first matched element.
innerWidth()//  Returns: Integer // Gets the inner width (excludes the border and includes the padding) for the first matched element.
outerHeight(margin)//  Returns: Integer // Gets the outer height (includes the border and padding by default) for the first matched element.
outerWidth(margin)//  Returns: Integer // Get the outer width (includes the border and padding by default) for the first matched element.

*/

// To get the width and height of the whole page (document)

var pageWidth = $(document).width();
var pageHeight = $(document).height();

// To get the width and height of the viewport (window)

var viewportWidth = $(window).width();
var viewportHeight = $(window).height();

```

## PARSING XML (IE compatible) ##

```

var xmlParse = function (xml) {
     if ($.browser.msie) {  // IE !!!
         var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");  
         xmlDoc.loadXML(xml);  
         xml = xmlDoc;  
     }
    $(xml).find("article").each(function(i) {
        $('#news').append($(this).find("titre").text());
    });
};

$(document).ready(function(){
    $.ajax({
        type: 'GET',
        url: './xml/parisien.xml',
        cache: true,
        processData: true,
        dataType: ($.browser.msie) ? 'text' : 'xml',
        //error: function(xml) { db('error()'); },
        success: function(xml) { xmlParse(xml); }
    });
});

```

## AJAX AND JSON ##

```

$.getJSON(
    "http://api.flickr.com/services/feeds/photos_public.gne?tags=cat&tagmode=any&format=json&jsoncallback=?",
    function(data){
        $.each(data.items, function(i,item){
            $("<img/>").attr("src", item.media.m).appendTo("#images");
            if ( i == 3 ) return false;
        });
    }
);

// ou encore
$.get(url)
    .fail(function(e) {
        callback(e, null);
    })
    .done(function(data) {
        callback(null, data);
    });

// Pass Parameters Through the GET Method
$("#load_get").click(function(){  
    $("#result")  
        .html("<img src='img/load.gif' alt='loading...' />")  
        .load(loadUrl+' div#content', "language=php&version=5"); // + extract content
});

// Long Polling (recursive AJAX) - An Efficient Server-Push Technique
(function poll(){
    $.ajax({url: "server", success: function(data){
        // Update your dashboard gauge
        salesGauge.setValue(data.value);
    }, dataType: "json", complete: poll, timeout: 30000});
})();

// --------------------------------------------------------------- //
// DISTANT JSON // http://blog.jaysalvat.com/articles/comprendre-jsonp-et-acces-de-donnees-a-distance-en-javascript.php

<?php    
$json = "{ data: 'Plein de donnÃ©es utiles' }"; 

if (isset($_GET['callback'])) echo $_GET['callback'].'('.$json.');'; 
else echo $json; 

?> 
<script>
$(function() { 
    $.ajax({ 
        dataType:'jsonp', 
        url: 'http://www.monsitedistant.com/api.php', 
        data: { param:'hello' },
        beforeSend:function(){
                    core.ajaxing = true;
                    ui.getLoader();
                },
                complete: function(xhr, textStatus) {
                    ui.removeLoader();
                },
                success: function(data, textStatus, xhr) {
                    console.log(data); 
                    core.lastAjaxed = url;
                    $('#content').fadeOut('slow',function(){
                        $(this).html('').append(data.template).fadeIn();
                    });
                    core.ajaxing = false;
                },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log('JSON error :(', XMLHttpRequest, textStatus, errorThrown);
        }
    }); 
});
</script>

// --------------------------------------------------------------- //

var req = $.ajax({
    type: 'POST',
    url: 'some.php',
    cache: false,
    data: 'name=John&location=Boston',
    success: function(msg){
        
        alert( 'Data Saved: ' + msg );
    }
});

//Cancel the Ajax Request ?
req.abort()

$.post('test.php', { name: 'John', time: '2pm' }, function(data){
    alert('Data Loaded: ' + data);
});

$.post('test.php', { func: 'getNameAndTime' }, function(data){
    alert(data.name); // John
    console.log(data.time); //  2pm
}, 'json');

var html = $.ajax({
    url: 'some.php',
    async: false
}).responseText;

$.ajax({
    url: 'page.php',
    processData: false,
    data: [/*create xml document*/],
    success: handleResponse
});

var obj = jQuery.parseJSON('{"name":"Larry King", "age": "5000"}');
alert(obj.name);


// MAPPING COMPLEX JSON 
function youtube(callback) {
    var url = "http://gdata.youtube.com/feeds/api/videos/-/Comedy?v=2&alt=json-in-script&start-index=" + startIndex + "&callback=?";

    jQuery.getJSON(url, function (data) {
        var images = jQuery.map(data.feed.entry, function (item) {
            return {
                title: item.title.$t,
                thumb: item.media$group.media$thumbnail[0].url,
                ytvideoid: item.media$group.yt$videoid.$t,
                videoloader: youtubevideo,
                link: item.link[0].href
            };
        });
        startIndex += images.length;
        callback(images);
    });
}

```

## Somes Functions ... ##

```

// Get URL parameters values

$.extend({
    getUrlVars: function() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) { vars[key] = value; });
        return vars;
    }
});

var name = $.getUrlVars()['name'];


// --------------------------------------------------------------- //
// scale elements to fit box

(function($){
  $.fn.extend({
    fluwi: function(opt){
        var variate = ((opt.variate!= undefined)?opt.variate:0);
        var contWidth = this.outerWidth();
        var boxWidth = opt.minWidth;
        var counted = Math.floor(contWidth/boxWidth);
        var extra = contWidth-boxWidth*counted;
        var eachOne = extra/counted;
        $(opt.boxQuery).css("width", (parseInt(boxWidth)+(eachOne))-variate);
    }
  });
})(jQuery);

// The plugin call code

$('#mydiv').fluwi({
        minWidth: 200, //pixels
        variate: 2, //pixels
        boxQuery: 'li' //class name or div name, or selector for elements that are resizing
});

// MENU
/*
<ul id="menu">
  <li class="menu">Sub 1
    <ul>
      <li>test 1</li>
      <li>test 2</li>
      <li>test 3</li>
      <li>test 4</li>
    </ul>
  </li>
  <li class="menu">Sub 2
    <ul>
      <li>test 1</li>
      <li>test 2</li>
      <li>test 3</li>
      <li>test 4</li>
    </ul>
  </li>
</ul>
*/

// Code

$(document).ready(function() {
  var toggle = function(direction, display) {
    return function() {
      var self = this;
      var ul = $("ul", this);
      if( ul.css("display") == display && !self["block" + direction] ) {
        self["block" + direction] = true;
        ul["slide" + direction]("slow", function() {
          self["block" + direction] = false;
        });
      }
    };
  }
  $("li.menu").hover(toggle("Down", "none"), toggle("Up", "block"));
  $("li.menu ul").hide();
});


// Fetch Links FavIcons
$('.l').hover(
    function(){
        var domaine = $(this).attr('href').split('/')[2].replace(/(\.www)/g, '');
        $(this).html($(this).html()+' <img class="ico" width="16" height="16" src="http://www.google.com/s2/favicons?domain='+domaine+'"/>');
    },
    function(){
        var html = $(this).html().split('<')[0];
        $(this).html(html);
    }
);

```

## Mouse event ##

```

var div = $('div.sc_menu');
var divWidth = div.width();
var ul = $('ul.sc_menu');
var lastLi = ul.find('li:last-child');
var ulPadding = 15;

div.mousemove(function(e){
    var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;
    var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
    div.scrollLeft(left);
});

```

## Gesture (Managing touch event) ##

  * http://plugins.jquery.com/project/jGesture

```

var makeGesture = function() {
    document.onselectstart = function() { return false; }; // ie
    document.onmousedown = function() { return false; }; // mozilla
    $('html').gesture(
        function(gs){
            //db('Gesture : ' + gs.getName() + ' : ' + gs.moves);
            if (gs.moves.length % 5 == 0) {
                if(gs.getName() == 'topleft' || gs.getName() == 'left' || gs.getName() == 'bottomleft') window.api.nextPage();
                if (gs.getName() == 'topright' || gs.getName() == 'right' || gs.getName() == 'bottomright') window.api.prevPage();
            }
        }, {repeat: true, continuesmode: true, mindistance:30}
    );
};

```

## Widget container ##

```

(function($) {
    // Widget container plugin
    $.fn.widgetContainer = function() {
        this.each(function() {
            // Vars
            var wc = $(this);

            // Set events
            wc.find('#add').click(function(e) { if (e) e.preventDefault(); add(wc) });
        });
    }

    // Add a widget to the container
    function add(wc) {
        var widget = $($.fn.widget.template);
        widget
            .appendTo(wc)
            .fadeIn('slow')
            .widget(wc);
    }

    // Widget
    (function() {
        // Widget plugin
        $.fn.widget = function(container) {
            this.each(function() {
                // Vars
                var w = $(this);
                w.parent = container;

                // Set events
                w.find('form').submit(function(e) { if (e) e.preventDefault(); submit(w) });
                w.find('.remove').click(function(e) { if (e) e.preventDefault(); remove(w) });
            });
        }
        $.fn.widget.template = '<div class="widget"><form action="" method="POST"><input type="text" value=""/><input type="submit" value="Action!"/><a href="#" class="remove">Remove</a></form></div>';

        // Remove widget
        function remove(w) {
            w.remove();
        }

        // Submit widget data
        function submit(w) {
            w.css('background', 'red');
            $.post('/', w.find('form').serialize(), function(data) {
                w.find(':text').val((new Date()).toString());
                w.parent.fadeOut();
                setTimeout(function() { w.parent.fadeIn() }, 500);
            });
        }
    })();
})(jQuery);


// Main
$(function() {
    $('.widgetContainer').widgetContainer();
});

```

## Widgets Extends ##

Source : http://www.novius-labs.com/developper-plugin-jquery-fonctionnalites-avancees,24.html

```
(function($) {
    $.widget("ui.bloc", {
        // options par dÃ©faut du widget
        // modifiables Ã  la construction
        // mais aussi aprÃ¨s la construction du widget
        options: {
            title: 'Titre',
            togglable: true, // Variable indiquant si le bloc est ouvrable/fermable
            opened : true // Variable indiquant si le bloc est ouvert
        },

        // Variables internes
        uiBlocContainer: null, // contient l'objet jQuery du container du bloc
        uiBlocTitle: null, // contient l'objet jQuery du titre du bloc
        uiBlocTitleToggle: null, // contient l'objet jQuery du picto dans la barre de titre indiquant l'Ã©tat d'ouverture/fermeture du bloc

        // La fonction _create est appelÃ©e Ã  la construction du widget
        // la variable d'instance this.element contient un objet jQuery
        // contenant l'Ã©lÃ©ment sur lequel porte le widget
        _create: function() {
            // On crÃ©e un container pour notre nouvel Ã©lÃ©ment d'UI
            // On lui ajoute la classe ui-widget qui doit Ãªtre ajoutÃ©e Ã  tout container de widget
            // On lui ajoute Ã©galement la classe ui-widget-content qui doit Ãªtre appliquÃ©e  Ã  tout container de contenu de widget
            // La classe ui-corner-all arrondit les 4 angles de notre bloc
            this.uiBlocContainer = $('<div></div>')
                .addClass('ui-bloc ui-widget ui-widget-content ui-corner-all')
                .insertAfter(this.element);

            // On encapsule notre Ã©lÃ©ment initial dans notre nouveau container
            this.element.addClass('ui-bloc-content').appendTo(this.uiBlocContainer);

            // On ajoute la classe ui-widget-header qui doit Ãªtre ajoutÃ©e Ã  tout Ã©lÃ©ment titre de widget
            // La classe ui-corner-top arrondit les 2 angles suppÃ©rieurs de notre bloc titre
            // L'Ã©lÃ©ment uiBlocTitle est ajoutÃ© au container et non plus Ã  notre Ã©lÃ©ment de base
            this.uiBlocTitle = $('<h5></h5>').addClass('ui-bloc-title ui-widget-header ui-corner-top')
                .prependTo(this.uiBlocContainer);

            // On encapsule un SPAN dans le bloc titre pour y Ã©crire le titre et pouvoir le modifier Ã  posteriori
            $('<span></span>').appendTo(this.uiBlocTitle);

            // On ajoute un SPAN au bloc titre pour le picto indicateur de l'Ã©tat d'ouverture / fermeture
            // Mais on le cache au cas oÃ¹ la fonctionnalitÃ© soit dÃ©sactivÃ©e
            this.uiBlocTitleToggle = $('<span></span>')
                .addClass('ui-bloc-title-toggle ui-icon ui-icon-pin-s')
                .appendTo(this.uiBlocTitle)
                .hide();
        },

        // La fonction _init est appelÃ©e Ã  la construction ET Ã  la rÃ©initialisation du widget
        _init : function() {
            var self = this;

            // On renseigne le texte du titre avec la valeur prÃ©sente dans les options
            self.uiBlocTitle.children('span:first').text(self.options.title);

            // On enlÃ¨ve l'Ã©vÃ©nement click sur le bloc titre
            // En cas de rÃ©initialisation, cela Ã©vite d'ajouter un nouvel Ã©vÃ©nement click
            // Ã  notre titre qui en a dÃ©jÃ  potentiellement un
            self.uiBlocTitle.unbind('click');

            if (self.options.togglable) {
                // On ajoute l'Ã©vÃ©nement click au bloc titre si le bloc est ouvrable / fermable
                self.uiBlocTitle.click(function(event) {
                    // Si le widget est disabled, il ne se passe rien au click
                    if (!self.options.disabled) {
                        self.toggle(event);
                        return false;
                    }
                }).css('cursor', 'pointer'); // On modifie le curseur au survol du titre

                // On affiche le picto indicateur de l'Ã©tat d'ouverture / fermeture
                // prÃ©cÃ©demment crÃ©e dans _create
                self.uiBlocTitleToggle.show();

                if (!self.options.opened) {
                    // Si le bloc est initialisÃ© avec le paramÃ¨tre opened Ã  false, on ferme le bloc
                    self._close();
                } else {
                    // Si le bloc est initialisÃ© avec le paramÃ¨tre opened Ã  true, on ouvre le bloc
                    self._open();
                }
            } else {
                // Le bloc n'est pas togglable
                // On rÃ©initialise le curseur au survol du titre
                self.uiBlocTitle.css('cursor', 'auto');
                // On cache le picto indicateur de l'Ã©tat d'ouverture / fermeture
                self.uiBlocTitleToggle.hide();
                // On ouvre le bloc
                self._open();
            }
        },

        // La fonction destroy ramÃ¨ne l'Ã©lÃ©ment du DOM, sur lequel est basÃ© notre widget,
        // dans l'Ã©tat oÃ¹ il Ã©tait avant la crÃ©ation du widget.
        // Elle dÃ©fait ce que _create a fait
        destroy: function() {
            // On rÃ©affiche l'Ã©lÃ©ment Ã©ventuellement cachÃ©
            // On enlÃ¨ve les classes css propres au widget
            // Et on sort l'Ã©lÃ©ment du container
            this.element.show()
                .removeClass('ui-bloc-content')
                .insertBefore(this.uiBlocContainer);

            // On dÃ©truit le container
            // Ce qui dÃ©truit par ricochet tous les autres Ã©lÃ©ments crÃ©Ã©s par notre widget
            this.uiBlocContainer.remove();

            // On appelle la mÃ©thode originale du framework
            // Elle supprime l'instance du widget qui a Ã©tÃ© stockÃ© en data dans l'Ã©lÃ©ment
            $.Widget.prototype.destroy.apply(this);

            return this;
        },

        // Surcharge de la mÃ©thode _setOption qui est appelÃ©e par la mÃ©thode option
        // qui permet de modifier des options de notre widget
        _setOption: function(key, value){
            var self = this;

            // On appelle la mÃ©thode originale du framework qui modifie le tableau d'options
            $.Widget.prototype._setOption.apply(self, arguments);

            if ($.inArray(key, ['title', 'togglable', 'opened']) != -1) {
                // Si l'option modifiÃ©e est une des 3 options title, togglable, opened
                // On appelle la mÃ©thode d'initialisation
                self._init();
            } else if (key === 'disabled') {
                // L'option disabled a Ã©tÃ© modifiÃ©e
                // On ajoute ou supprime, en fonction du cas, la classe ui-state-disabled au container
                // Dans le framework css de jQuery UI, la classe ui-state-disabled grise un Ã©lÃ©ment
                if (value) {
                    this.uiBlocContainer.addClass('ui-state-disabled');
                } else {
                    this.uiBlocContainer.removeClass('ui-state-disabled');
                }
            }
        },

        toggle : function() {
            var self = this;

            //Si le bloc n'est pas ouvrable/fermable on sort tout de suite
            if (!self.options.togglable) {
                return self;
            }

            if (self.options.opened) {
                // Si l'Ã©vÃ©nement beforeClose retourne false, on arrÃªte la fermeture
                if (false === this._trigger('beforeClose')) {
                    return false;
                }

                self._close();

                // Envoi du signal de fermeture
                // _trigger accepte 3 paramÃ¨tres, les deux derniers Ã©tant optionnels :
                // - le nom de l'Ã©vÃ©nement
                // - l'objet Ã©vÃ©nement
                // - des donnÃ©es additionnelles envoyÃ©es aux fonctions interceptant l'Ã©vÃ©nement
                this._trigger('close');
            } else {
                // Si l'Ã©vÃ©nement beforeOpen retourne false, on arrÃªte l'ouverture
                if (false === this._trigger('beforeOpen')) {
                    return false;
                }

                self._open();

                // Envoi du signal d'ouverture
                this._trigger('open');
            }
            // On inverse la valeur de l'option opened
            self.options.opened = !self.options.opened;

            // On retourne l'instance du plugin pour prÃ©server le chaÃ®nage des fonctions
            return self;
        },

        _close: function() {
            // On doit cacher tous les enfants du container sauf le titre
            this.uiBlocContainer.children().not(this.uiBlocTitle).hide();
            // L'icÃ´ne de la barre de titre devient une tÃªte d'Ã©pingle orientÃ©e vers l'ouest (west, donc vers la gauche)
            this.uiBlocTitleToggle.removeClass('ui-icon-pin-s').addClass('ui-icon-pin-w');
        },

        _open: function() {
            // On doit afficher tous les enfants du container
            this.uiBlocContainer.children().show();
            // L'icÃ´ne de la barre de titre devient une tÃªte d'Ã©pingle orientÃ©e vers le sud (vers le bas)
            this.uiBlocTitleToggle.removeClass('ui-icon-pin-w').addClass('ui-icon-pin-s');
        }
    });
})(jQuery);

```

## Widget with jQuery LOADER ##

http://alexmarandon.com/articles/web_widget_jquery/

```

(function() {

// Localize jQuery variable
var jQuery;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src",
        "http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    script_tag.onload = scriptLoadHandler;
    script_tag.onreadystatechange = function () { // Same thing but for IE
        if (this.readyState == 'complete' || this.readyState == 'loaded') {
            scriptLoadHandler();
        }
    };
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
    jQuery = window.jQuery;
    main();
}

/******** Called once jQuery has loaded ******/
function scriptLoadHandler() {
    // Restore $ and window.jQuery to their previous values and store the
    // new jQuery in our local jQuery variable
    jQuery = window.jQuery.noConflict(true);
    // Call our main function
    main(); 
}

/******** Our main function ********/
function main() { 
    jQuery(document).ready(function($) { 
        /******* Load CSS *******/
        var css_link = $("<link>", { 
            rel: "stylesheet", 
            type: "text/css", 
            href: "style.css" 
        });
        css_link.appendTo('head');          

        /******* Load HTML *******/
        var jsonp_url = "http://alpage.org/cgi-bin/webwidget_tutorial.py?callback=?";
        $.getJSON(jsonp_url, function(data) {
          $('#example-widget-container').html("This data comes from another server: " + data.html);
        });
    });
}

})(); // We call our anonymous function immediately

```

## Code isolation ##

```

// Enclose all our code within an anonymous function and we call that function.
// The variables we create in our functions wonâ€™t interfere with the rest of the
page.

var foo = "Hello World!";
document.write("<p>Before our anonymous function foo means '" + foo + '".</p>');

(function() {
    // The following code will be enclosed within an anonymous function
    var foo = "Goodbye World!";
    document.write("<p>Inside our anonymous function foo means '" + foo + '".</p>');
})(); // We call our anonymous function immediately

document.write("<p>After our anonymous function foo means '" + foo + '".</p>');

```

## REGEX ##

http://www.jquery.info/spip.php?article91

```

// SÃ©lectionne tous les Ã©lÃ©ments dont l'id commence par une voyelle :
$(':regex(id,^[aeiou])');

// SÃ©lectionne tous les divs dont la classe contient un chiffre :
$('div:regex(class,[0-9])');

// SÃ©lectionne toutes les balises script dont la source contient jQuery :
$('script:regex(src,jQuery)');

// Oui, je sais que le dernier exemple peut Ãªtre fait avec les sÃ©lecteur d'attributs CSS3. C'est juste un exemple...

Note : toutes les recherches sont insensibles Ã  la casse ; vous pouvez changer Ã§a en retirant le drapeau "i" dans le plugin.

Ce plugin vous permet aussi d'interroger les styles CSS avec des expressions rÃ©guliÃ¨res, par exemple :
// SÃ©lectionne tous les Ã©lÃ©ments dont la largeur est comprise entre 100 et 300 pixels :
$(':regex(css:width, ^[1-3]\\d{2}px$)');

// SÃ©lectionne tous les divs qui ne sont pas en display: block :
$('div:not(:regex(css:display, ^block$))');

De plus, vous pouvez interroger les chaÃ®nes "data" ajoutÃ©es aux Ã©lÃ©ments au travers de la mÃ©thode "data" de jQuery :
// Ajouter une propriÃ©tÃ© data Ã  toutes les images (c'est juste un exemple) :
$('img').each(function(){
$(this).data('extension', $(this)[0].src.match(/\.(.{1,4})$/)[1]);
});

// SÃ©lectionner toutes les images avec une extension PNG ou JPG :
$('img:regex(data:extension, png|jpg)');

```

## jQUery version 1.4 ##

Parmi les changements et amÃ©liorations apportÃ©es dans la version 1.4 :

  * de nombreuses amÃ©liorations pour les fonctions Ajax et les donnÃ©es manipulÃ©es (sÃ©rialisation, parsing, json),
  * de nouvelles mÃ©thodes pour le parcours des Ã©lÃ©ments (first, last, eq...),
  * une crÃ©ation rapide d'Ã©lÃ©ments avec la fonction jQuery, attributs et Ã©vÃ©nements inclus,
  * des fonctions .css(), .attr() et Ã©quivalentes plus Ã©voluÃ©es (permettant l'usage d'un appel de fonction),
  * des fonctions d'accÃ©lÃ©ration (easing) par propriÃ©tÃ© CSS dans les animations,
  * un appel multiple Ã  .bind() possible, pour plusieurs types d'Ã©vÃ©nements distincts,
  * .proxy() pour s'assurer de la pÃ©rennitÃ© de this dans une fonction,
  * de nouveaux Ã©vÃ©nements : focusin et focusout, Ã©quivalents Ã  focus et blur mais qui remontent dans la hiÃ©rarchie du DOM (qui bubblent)
  * .live() supporte dÃ©sormais tous les Ã©vÃ©nements (Ã  l'exception des cas particuliers ready, blur, et focus),
  * de nouvelles mÃ©thodes : .detach(), .unwrap(),
  * de nouvelles files d'attente avec .delay(), .queue() et .clearQueue(),
  * de nouvelles fonctions de parcours : .index(), .has, .nextUntil(), .prevUntil(), parentsUntil() et des amÃ©liorations pour .add(), .closest(),
  * les callbacks sont possibles sur les fonctions DOM,
  * et bien d'autres perfectionnements...

## jQuery 1.6 RC1 ##

  * La fonction .prop() permet dâ€™obtenir la valeur dâ€™une propriÃ©tÃ© dâ€™un Ã©lÃ©ment du DOM ;
  * La fonction .attr() permet quand Ã  elle dâ€™obtenir la valeur dâ€™un attribut dâ€™un Ã©lÃ©ment sÃ©lectionnÃ© ;
  * Une trÃ¨s grosse amÃ©lioration a Ã©tÃ© apportÃ© Ã  .is(), jusquâ€™Ã  maintenant, vous pouviez vous assurer quâ€™un Ã©lÃ©ment sÃ©lectionnÃ© correspondait bien Ã  un autre sÃ©lecteur. Maintenant vous pouvez aussi le comparer au rÃ©sultat dâ€™une fonction, Ã  un Ã©lÃ©ment sÃ©lectionnÃ© ou encore un objet jQuery ;
  * .undelegate() permet de supprimer tous les gestionnaires dâ€™Ã©vÃ¨nements provenant dâ€™un namespace. Depuis la version 1.4, elle permettait dÃ©jÃ  de les supprimer pour un sÃ©lecteur ;
  * .holdReady() permet dâ€™autoriser ou non le dÃ©clenchement de lâ€™Ã©vÃ¨nement jQueryâ€™s ready, il peut donc agir comme un retardateur permettant de sâ€™assurer que toutes les ressources nÃ©cessaires sont bien lÃ  ;
  * Deferred.always(), Ã  lâ€™Ã©quivalent du finally dans les blocs try/catch, .always() permet de lâ€™exÃ©cution de code que votre objet Deferred soit en Ã©tat rÃ©solu ou rejetÃ©.
  * jQuery.map() permet la crÃ©ation dâ€™un tableau Ã  partir dâ€™un autre ou dâ€™une sÃ©lection dâ€™Ã©lÃ©ments (jusquâ€™Ã  maintenant que depuis un autre tableau). TrÃ¨s pratique pour crÃ©er une liste avec des index ayants un sens plus parlant pour lâ€™accÃ¨s aux donnÃ©es quâ€™une suite numÃ©rique banale ;
  * jQuery.Ajax est dÃ©sormais compatible XHR 2, câ€™est Ã  dire lâ€™utilisation dâ€™Access Control pour envoyer des requÃªtes vers des domaines diffÃ©rents ;
  * jQuery.css() supporte dÃ©sormais les valeurs relatives.
  * ...
  * http://blog.jquery.com/2011/04/26/jquery-1-6-rc-1-released/


## jQuery noConflict() extended ##

  * http://stackoverflow.com/questions/1005600/programatically-include-jquery-in-high-conflict-environment/14983925

```
(function($, window) {
    var version = ($ && typeof($) == 'function' && $().jquery ? ($().jquery).split('.').join('') : 0), // 1.8.1 -> 181
        jBack   = null;
    if (version) console.log('jQuery current version : ', version);
    else         console.log('no jQuery');
    var loaded = function() {
            console.log('loaded()');
            var $ = jQuery.noConflict(true); // LOCAL own jQuery version
            if (jBack)  {
                window.$      = jBack; // Reassign ex-jQuery
                window.jQuery = jBack;
            }
            // OK : now work with OUR new $
            console.log('jQuery new version : ', $().jquery);
        },
        loadJs = function(jsPath) {
            console.log('loadJs()');
            var s = document.createElement('script');
            s.setAttribute('type', 'text/javascript');
            s.setAttribute('src', jsPath);
            s.onload = loaded;
            document.getElementsByTagName('body')[0].appendChild(s);
        };

    if (version) jBack = $;
    if (version < 180) loadJs('http://code.jquery.com/jquery-1.9.1.min.js');
    else loaded();

})((typeof(jQuery) == 'function' ? jQuery : null), window);
```

# LITTLES FUNCTIONS FOR QUICK USE #

```

// SIMPLE DEBUG :)
var db = function() { 'console' in window && console.log.call(console, arguments); };
// Usage :
db('maVar : ', maVar);

// Other one...
var db = function(something) { if (!('console' in window)) return; if (arguments.length > 1) { for (var i=0, length=arguments.length; i<length; i++ ) db(arguments[i]); return; } var info = ''; if (typeof something == 'string' || typeof something == 'number') info += '\t'+something.valueOf(); else if (typeof something == 'boolean') info += '\t'+( something ? 'true' : 'false'); else { for (var key in something) { if (typeof something[key] != 'function') info += '\t'+key+' <'+typeof something[key]+'> '+something[key]+'\n'; } } console.info('db('+typeof something+')'); console.log(info); };

var die = function(mess) { throw(( mess ? mess : "JS says that you killing him softly : Oh my god moonWalker is down...")); };

var trim = function(string) { return string.replace(/^\s+|\s+$/g, ''); };

var escapeURIparam = function(url) {
    // http://stackoverflow.com/questions/75980/best-practice-escape-or-encodeuri-encodeuricomponent/17235463#17235463
    if (encodeURIComponent) url = encodeURIComponent(url);
    else if (encodeURI) url = encodeURI(url);
    else url = escape(url);
    url = url.replace(/\+/g, '%2B'); // Force the replacement of "+"
    return url;
};

var cleanName = function (str) {
    if ($.trim(str) == '') return str;
    str = $.trim(str).toLowerCase();
    var special = ['&', 'O', 'Z', '-', 'o', 'z', 'Y', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '.', ' ', '+', '\''],
        normal = ['et', 'o', 'z', '-', 'o', 'z', 'y', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', '_', '_', '-', '-'];
    for (var i = 0; i < str.length; i++) {
        for (var j = 0; j < special.length; j++) {
            if (str[i] == special[j]) {
                str = str.replace(new RegExp(str[i], 'gi'), normal[j]);
            }
        }
    }
    str = str.replace(/[^a-z0-9_\-]/gi, '_');
    str = str.replace(/[\-]{2,}/gi, '_');
    str = str.replace(/[\_]{2,}/gi, '_');
    return str;
};

var event2key = {'97':'a', '98':'b', '99':'c', '100':'d', '101':'e', '102':'f', '103':'g', '104':'h', '105':'i', '106':'j', '107':'k', '108':'l', '109':'m', '110':'n', '111':'o', '112':'p', '113':'q', '114':'r', '115':'s', '116':'t', '117':'u', '118':'v', '119':'w', '120':'x', '121':'y', '122':'z'};
var pad = function(s) { return (s < 10 ? '0'+s : s); };
var addslashes = function (str) { return (str+'').replace(/([\\"'])/g, "\\$1").replace(/\u0000/g, "\\0"); };
// index.html?name=foo -> var name = getUrlVars()[name]; 
var getUrlVars = function() { var vars = {}; var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) { vars[key] = value; }); return vars; };
// sites['link'].sort($.objSortByTitle);
var objSortByTitle = function (a, b) { var x = a.title.toLowerCase(); var y = b.title.toLowerCase(); return ((x < y) ? -1 : ((x > y) ? 1 : 0)); }; 
// loadJs('http://other.com/other.js'); // For external link
var loadJs = function(src) { var s = document.createElement('script'); s.setAttribute('type', 'text/javascript'); s.setAttribute('src', src); document.getElementsByTagName('head')[0].appendChild(s); };
// getScript('./other.js', function() { ok(); });
var getScript = function(src, callback) { $.ajax({dataType:'script', async:false, cache:true, url:src, success:function(response) { if (callback && typeof callback == 'function') callback(); }}); };

```

## FORM serialize ##

```
$.fn.serializeObject = function() { // Form serialize for POST
        var o = {},
            a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) o[this.name] = [o[this.name]];
                o[this.name].push(this.value || '');
            }
            else o[this.name] = this.value || '';
        });
        return o;
};

// elsewhere...
var formValues = $form.serializeObject();
console.log(formValues);
```

## Element toggle state ##

```
$(document).ready(function() {
    $('ul.form li a').click(
        function(e) {
            e.preventDefault(); // prevent the default action
            e.stopPropagation; // stop the click from bubbling
            $(this).closest('ul').find('.selected').removeClass('selected');
            $(this).parent().addClass('selected');
        });
});
```

## Page auto-refresh ##

```
$(function() {
	var INT = null;
	$(window).scrollTop($(document).height() + 100); // Scroll 2 bottom
	$('#clearLog').on('click', function(event) {
		APP.api(APP.clearLogUrl);
		window.location.reload(true);
	});
	$('#refresh').on('click', function(event) {
		if (localStorage['refresh'] == 'yes') {
			localStorage['refresh'] = 'no';
			if (INT) clearInterval(INT);
		}
		else {
			localStorage['refresh'] = 'yes';
			window.location.reload(true);
		}
	});
	if (localStorage['refresh'] == 'yes') INT = setTimeout(function() {
		window.location.reload(true);
	}, 5000);
});
```


# (NEW) SAMPLE PLUGIN STRUCTURE #


  * http://docs.jquery.com/Plugins/Authoring
  * http://www.queness.com/post/112/a-really-simple-jquery-plugin-tutorial

Workable / Testable jQuery Default Plugin : http://jsfiddle.net/molokoloco/DzYdE/


... Comments or suggests ? http://www.b2bweb.fr/molokoloco/jquery-default-plugin/

```

// Log utilitie
var db = function() {
    'console' in window && console.log.call(console, arguments);
};

// Déclaration d'un nouveau plugin pour Ã©tendre les fonctions ($.fn) de jQuery

(function($) {
    var plugName = 'tooltip'; // Base name
    var methods = {
        init: function(options) {
            options = $.extend({ // Custom arguments
                parent: 'body', // Default
                css: plugName,
            }, options || {});
            
            return this.each(function() { // Iterate current(s) element(s)
                var $this = $(this),
                    data = $this.data(plugName);
                if (data) return; // If the plugin has already been initialized
                
                var $element = $('<div />', { // Create Tooltip Div
                    class: options.css,
                    text: $this.attr('title') // Fetch tooltip text...
                }).appendTo(options.parent).hide();
                
                var stock = {}; // Stock properties
                stock[plugName] = $element; // Stock element or create unik Id...
                stock['options'] = options;
                
                $this
                    .data(plugName, stock)
                    .attr('title', '') // Remove default title
                    .bind('mouseenter.'+plugName, methods.show) // Event + this plugin NameSpace
                    .bind('mouseleave.'+plugName, methods.hide);
                
                $(window).bind('resize.'+plugName, methods.reposition);
                db('data', $this.data(plugName)); // Time to Log in console ;)
            });
        },
        update: function(content) {
            db('update');
        },
        reposition: function() {
            db('reposition');
        },
        show: function(event) {
            var mousex = event.pageX + 20, // Get event X mouse coordinates
                mousey = event.pageY + 20;
            
            var $this = $(this), // Only one link trigger show()
                data = $this.data(plugName); // Fetch data
            
            data[plugName]
                .css({top: mousey+'px', left: mousex+'px'})
                .show();
        },
        hide: function(event) {
            var $this = $(this),
                data = $this.data(plugName);
            data[plugName].hide();
        },
        destroy: function() {
            return this.each(function() {
                var $this = $(this),
                    data = $this.data(plugName);
                
                data[plugName].remove(); // Clear tooltip element
                $(window).unbind('.'+plugName); // clear all events of the plugin namespace
                $this
                    .unbind('.'+plugName) // Remove tooltip event(s)
                    .removeData(plugName); // Clear DOM data
            })
        }
    };
    $.fn[plugName] = function(method) { // Don't touch ;)
        if (methods[method]) return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        else if (typeof method === 'object' || !method) return methods.init.apply(this, arguments);
        else $.error('Method ' + method + ' does not exist on jQuery.'+plugName);
    };
})(jQuery);


// Appel du plugin
$('a#fun').tooltip({ // Init with optional obj of optionals args
    css: 'myTtClass'
});
//$('a#fun').tooltip('update', 'This is the new tooltip content!'); // Call internal methode

$('a#remove').bind('click', function() {
    $('a#fun').tooltip('destroy');
});

```

## 'Highly configurable' mutable plugin boilerplate ##

  * http://coding.smashingmagazine.com/2011/10/11/essential-jquery-plugin-patterns/

```

/*
 * 'Highly configurable' mutable plugin boilerplate
 * Author: @markdalgleish
 * Further changes, comments: @addyosmani
 * Licensed under the MIT license
 */

// Note that with this pattern, as per Alex Sexton's, the plugin logic
// hasn't been nested in a jQuery plugin. Instead, we just use
// jQuery for its instantiation.

;(function( $, window, document, undefined ){

  // our plugin constructor
  var Plugin = function( elem, options ){
      this.elem = elem;
      this.$elem = $(elem);
      this.options = options;

      // This next line takes advantage of HTML5 data attributes
      // to support customization of the plugin on a per-element
      // basis. For example,
      // <div class=item' data-plugin-options='{"message":"Goodbye World!"}'></div>
      this.metadata = this.$elem.data( 'plugin-options' );
    };

  // the plugin prototype
  Plugin.prototype = {
    defaults: {
      message: 'Hello world!'
    },

    init: function() {
      // Introduce defaults that can be extended either
      // globally or using an object literal.
      this.config = $.extend({}, this.defaults, this.options,
      this.metadata);

      // Sample usage:
      // Set the message per instance:
      // $('#elem').plugin({ message: 'Goodbye World!'});
      // or
      // var p = new Plugin(document.getElementById('elem'),
      // { message: 'Goodbye World!'}).init()
      // or, set the global default message:
      // Plugin.defaults.message = 'Goodbye World!'

      this.sampleMethod();
      return this;
    },

    sampleMethod: function() {
      // eg. show the currently configured message
      // console.log(this.config.message);
    }
  }

  Plugin.defaults = Plugin.prototype.defaults;

  $.fn.plugin = function(options) {
    return this.each(function() {
      new Plugin(this, options).init();
    });
  };

  //optional: window.Plugin = Plugin;

})( jQuery, window , document );
```

## jQuery Boilerplate - Plugin Prototype V2 ##

  * http://jqueryboilerplate.com/
  * https://github.com/zenorocha/jquery-boilerplate/wiki/Extending-jQuery-Boilerplate

```
// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = "defaultPluginName",
        defaults = {
            propertyName: "value"
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend( {}, defaults, options );

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function() {
            // Place initialization logic here
            // You already have access to the DOM element and
            // the options via the instance, e.g. this.element
            // and this.options
            // you can add more functions like the one below and
            // call them like so: this.yourOtherFunction(this.element, this.options).
        },

        yourOtherFunction: function(el, options) {
            // some logic
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );


// Usage

$('#elem').defaultPluginName({
  propertyName: 'a custom value'
});
```


## jQuery plugin Boilerplate "Bootstraped" version V3 ##

Plugin design pattern from Twitter Bootstrap
http://twitter.github.io/bootstrap/

```
/* =============================================================
 * jQuery colonizr V0.9.1 - Molokoloco 2013 - Copyleft
 * "In-between titles Multicols paragraphes" (Bootstrap-like plugin)
 * Live fiddle : http://jsfiddle.net/molokoloco/Ra288/
 * Github : https://github.com/molokoloco/FRAMEWORK/blob/master/jquery.plugins/jquery.colonizr.js
            https://github.com/molokoloco/FRAMEWORK/blob/master/jquery.plugins/jquery.colonizr.min.js
 *          https://github.com/molokoloco/FRAMEWORK/blob/master/jquery.plugins/jquery.colonizr.css
 *  Infos : http://www.b2bweb.fr/molokoloco/jquery-colonize-plugin-in-between-titles-multicols-paragraphes-with-css3/
 * ============================================================== */

!function ($) {

    "use strict"; // jshint ;_;

   /* COLONIZR CLASS DEFINITION
    * ========================== */

    function Colonizr(element, options) {
        // Merge user options
        this.options = $.extend(true, {}, $.fn.colonizr.defaults, typeof options == 'object' && options || {});
        // Privates vars
        this.$container = $(element);
        this.wrapper    = '<div class="'+this.options.css+'"/>';
    this.cWidth, this.colHeightRatio, this.intentNextP, this.lineHeight, this.maxHeight;
    this.refresh();
    };

    Colonizr.prototype = {
        
    constructor: Colonizr,
        
        colsExtractor: function (i, e) {
            var $element    = $(e),
                $next       = $element.next(),
                $collection = [],
                jumpNext    = false,
                totalHeight = 0;
            while ($next) {
                if (!$next.is(this.options.take)) {
                    if (!$next.is(this.options.chapters)) jumpNext = true;
                    $next = null; // Break
                }
                else {
                    $collection.push($next);
                    $next = $next.next();
                }
            }
            var estimateHeight = 0;
            if ($collection.length) {
                for (var i = 0, len = $collection.length; i < len; i++) {
                    estimateHeight += $collection[i].outerHeight();
                }
            }
            if ($collection.length && estimateHeight > this.lineHeight) {
                var $wrapper = $(this.wrapper);
                for (var i = 0, len = $collection.length; i < len; i++) {
                    totalHeight += ($collection[i].outerHeight() * this.colHeightRatio); // Futur P height
                    $wrapper.append($collection[i].detach()); // Extract P
                    if ($collection[(i + 1)] && this.maxHeight <= (totalHeight + $collection[(i + 1)].outerHeight())) { // Cut Cols if > screen height
                        $wrapper.insertAfter($element);
                        $element = $wrapper;
                        totalHeight = 0;
                        $wrapper = $(this.wrapper);
                    }
                }
                $wrapper.insertAfter($element); // Append new COL div container
                if (jumpNext) this.colsExtractor(0, $wrapper.next());
            }
            else if (jumpNext) {
                this.intentNextP++; // Max, trois tags vides aprÃ¨s un titre
                if (this.intentNextP < 3 && $element.next()) this.colsExtractor(0, $element.next());
            }
        },
        
        refresh: function () {
            this.cWidth         = this.$container.width();
            this.colHeightRatio = 1;
            this.intentNextP    = 0;
            this.lineHeight     = 0;
            this.maxHeight      = this.options.maxHeight;
            var colWidth        = this.cWidth;
            if (this.options.maxHeight < 1)
                this.maxHeight = Math.max(80, $(window).height() - 60); // (Min/) Max cols height ?            
            var $exists = this.$container.find('.'+this.options.css);
            if ($exists.length) { // Existing this.wrappers ?
                var exists = '';
                $exists.each(function() {
                    var $this = $(this);
                    $($this.html()).insertBefore($this);
                    $this.remove(); 
                });
            }
            var $p = $('<p>A</p>').appendTo(this.$container);
            this.lineHeight = $p.outerHeight();
            this.lineHeight = this.lineHeight * this.options.minLine;
            $p.remove();
            if (this.options.colWidth)
                this.options.colCount = Math.max(1, Math.floor(this.cWidth / this.options.colWidth));
            colWidth = (this.cWidth - ((this.options.marge * 2) * this.options.colCount)) / this.options.colCount;
            this.colHeightRatio = this.cWidth / colWidth;
            this.$container
                .find(this.options.chapters)
                .each($.proxy(this.colsExtractor, this)); // $.wrapAll() || $.nextAll() // :-(
        }
    };

   /* COLONIZR PLUGIN DEFINITION
    * =========================== */

    var old = $.fn.colonizr;

    $.fn.colonizr = function (options) {
        return this.each(function() { // Iterate collections
            var $this = $(this),
        data  = $this.data('colonizr');
        if (!data) $this.data('colonizr', (data = new Colonizr(this, options)));
            if (typeof options == 'string') data[options]();
        });
    };

    $.fn.colonizr.Constructor = Colonizr;

    $.fn.colonizr.defaults = {
        marge:       10,                   // Left/right <p> margin
        colWidth:    null,                 // As in the CSS, choose between COUNT or WIDTH for cols
        colCount:    2,                    // colWidth (px) OR colCount (num)
        chapters:    'h1,h2,h3,h4,h5,h6',  // Between the H1-Hx ()
        take:        'p',                  // Take all the p (ul,quote,..) NEXT() to each chapters
        css:         'multiplecolumns',    // And wrap them with class
        minLine:      2,                   // If less than 3 lines, don't wrap with columns
        maxHeight:    null                 // Max col height will be..
    };

   /* COLONIZR NO CONFLICT
    * ===================== */

    $.fn.colonizr.noConflict = function () {
        $.fn.colonizr = old;
        return this;
    };

   /* COLONIZR DATA-API
    * ================== */

    $(window).on('load', function () {
        $('[data-colonizr="true"]').each(function () {
            var $spy = $(this);
            $spy.colonizr($spy.data());
        })
    });

}(window.jQuery);


/////////////////////////////////////////////////////////////////
// Usage example... /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////


var $container = $('div#container');

$('a#colonize').click(function() {     // Call on click 
    $container.colonizr({              // Use plugin...
        marge:      10,
        colWidth:   180,               // Report CSS "column-width"
        take:       'p,ul',            // Adding UL to the stream...
        css:        'multiplecolumns'  // If you want to change the CSS..
    });
});

var windowTmr = null; // Timeout...
var resizeRefreshEvent = function() {   // Trottle resize...
    windowTmr = null;
    if ($container.data('colonizr'))    // Colonizr was applyed by user click ?
        $container.colonizr('refresh'); //  Refresh cols height...
};

$(window).on('resize', function(event) { // Resize Event
    if (windowTmr) clearTimeout(windowTmr);
    windowTmr = setTimeout(resizeRefreshEvent, 1600); // Trottle resize
});
```