_TODO ... CLEAN NOTES & ADD CSS3 BETTER SUPPORT !!!_


# CSS TIPS #

  * http://www.smashingmagazine.com/2009/10/05/mastering-css-coding-getting-started/
  * [CSS 3 Cheat Sheet](http://media.smashingmagazine.com/wp-content/uploads/images/css3-cheat-sheet/css3-cheat-sheet.pdf)
  * [HTML 5 Visual Cheat Sheet](http://www.box.net/shared/8qnxj922oc)
  * CSS selectors http://net.tutsplus.com/tutorials/html-css-techniques/the-30-css-selectors-you-must-memorize/
  * Shapes Of CSS http://css-tricks.com/examples/ShapesOfCSS/
  * http://www.impressivewebs.com/css3-click-chart/
  * Infinite pattern http://designfestival.com/the-cicada-principle-and-why-it-matters-to-web-designers/
  * boxShadows http://www.viget.com/uploads/file/boxshadows/
  * http://tympanus.net/codrops/2012/10/25/kick-start-your-project-a-collection-of-handy-css-snippets/ [New](New.md)
  * http://tympanus.net/Tutorials/BasicReadyToUseCSSStyles/ [New](New.md)


```
/* Select only h1s that contain a 'data-text' attribute */
h1[data-text] {
	position: relative;
        color: red;
}

h1[data-text]::after {
	content: attr(data-text);
	z-index: 2;
	color: green;
	position: absolute;
	left: 0;
	-webkit-mask-image: -webkit-gradient(
		linear,
		left top, left bottom,
		from(rgba(0,0,0,1)),
		color-stop(40%, rgba(0,0,0,0))
	);

```

Animate with ONE keyframe...
http://lea.verou.me/2012/12/animations-with-one-keyframe/

```
/* Pounding heart animation */
@keyframes pound {
	to { transform: scale(1.4); }
}
.heart {
	display: inline-block;
	font-size: 150px;
	color: #e00;
	animation: pound .25s infinite alternate;
	transform-origin: center;
}
body { text-align: center; }
```

## KEYFRAME 3D ##

  * http://jsfiddle.net/molokoloco/yx6LG/

```

/*
    Credit to : http://www.the-art-of-web.com/css/3d-transforms/
*/

.stage {
    margin: 2em;
    padding-left:180px;
    height: 160px;
    background:rgba(0,0,0,0.1);
    -webkit-perspective: 1500px;
    -moz-perspective: 1500px;
}

@-webkit-keyframes spinner {
    from {
        -webkit-transform: rotateY(0deg);
    }
    to {
        -webkit-transform: rotateY(-360deg);
    }
}
@-moz-keyframes spinner {
    from {
        -moz-transform: rotateY(0deg);
    }
    to {
        -moz-transform: rotateY(-360deg);
    }
}

.spinner {
    -webkit-animation-name: spinner;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-duration: 6s;
    -webkit-transform-style: preserve-3d;
    -webkit-transform-origin: 180px 0 0;
    
    -moz-animation-name: spinner;
    -moz-animation-timing-function: linear;
    -moz-animation-iteration-count: infinite;
    -moz-animation-duration: 6s;
    -moz-transform-style: preserve-3d;
    -moz-transform-origin: 180px 0 0;
}

.spinner:hover {
    -webkit-animation-play-state: paused;
    -moz-animation-play-state: paused;
}

.spinner img {
    position: absolute;
    border: 1px solid #ccc;
    background: rgba(255,255,255,0.8);
    -webkit-box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
    -moz-box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
}

```

## CSS3 Button ##
  * http://codepen.io/chriscoyier/pen/jIpCv

```
.button {
  text-decoration: none;
  color: white;
  padding: 10px;
  text-transform: uppercase;
  display: inline-block;
  text-shadow: -2px 2px 0 rgba(black, 0.2);
  font-weight: bold;
  padding-right: 50px;
  border-radius:10px;
  margin: 10px;
  &.blue {
    @include background(linear-gradient(
       top, #a2d3e9, #7abedf
    ));
    box-shadow:
      -1px 0px 1px #6fadcb, 0px 1px 1px #54809d,
      -2px 1px 1px #6fadcb, -1px 2px 1px #54809d,
      -3px 2px 1px #6fadcb, -2px 3px 1px #54809d,
      -4px 3px 1px #6fadcb, -3px 4px 1px #54809d,
      -5px 4px 1px #6fadcb, -4px 5px 1px #54809d,
      -6px 5px 1px #6fadcb,
      
      -6px 7px  0 rgba(black, 0.05),
      -5px 8px  0 rgba(black, 0.05),
      -3px 9px  0 rgba(black, 0.04),
      -2px 10px 0 rgba(black, 0.04),
      -1px 11px 0 rgba(black, 0.03),
       0px 12px 0 rgba(black, 0.03),
       1px 13px 0 rgba(black, 0.02),
       2px 14px 0 rgba(black, 0.02),
       3px 15px 0 rgba(black, 0.01),
       4px 16px 0 rgba(black, 0.01),
       5px 17px 0 rgba(black, 0.01),
       6px 18px 0 rgba(black, 0.01),
    
    inset 0 4px 5px -2px rgba(white, 0.5),
    inset 0 1px 0 0 rgba(black, 0.3);
    
  }
  &.yellow {
    @include background(linear-gradient(
       top, #f2d851, #ecc92b
    ));
    color: black;
    text-shadow: -2px 2px 0 rgba(white, 0.3);
    box-shadow:
      -1px 0px 1px #d9b826, 0px 1px 1px #b1961d,
      -2px 1px 1px #d9b826, -1px 2px 1px #b1961d,
      -3px 2px 1px #d9b826, -2px 3px 1px #b1961d,
      -4px 3px 1px #d9b826, -3px 4px 1px #b1961d,
      -5px 4px 1px #d9b826, -4px 5px 1px #b1961d,
      -6px 5px 1px #d9b826,
      
      -6px 7px  0 rgba(black, 0.05),
      -5px 8px  0 rgba(black, 0.05),
      -3px 9px  0 rgba(black, 0.04),
      -2px 10px 0 rgba(black, 0.04),
      -1px 11px 0 rgba(black, 0.03),
       0px 12px 0 rgba(black, 0.03),
       1px 13px 0 rgba(black, 0.02),
       2px 14px 0 rgba(black, 0.02),
       3px 15px 0 rgba(black, 0.01),
       4px 16px 0 rgba(black, 0.01),
       5px 17px 0 rgba(black, 0.01),
       6px 18px 0 rgba(black, 0.01),
    
       inset 0 4px 5px -2px rgba(white, 0.5),
       inset 0 1px 0 0 rgba(black, 0.3);
     &:after, &:before {
        background: black; 
     }
     &:after {
    @include filter(drop-shadow(-2px 0 0 rgba(white, 0.4))); 
     }
     &:before {
      @include filter(drop-shadow(0 -2px 0 rgba(white, 0.35)));  
    }
    .arrow {
       @include filter(drop-shadow(-2px 0 0 rgba(white, 0.4))); 
    }
  }
  @include transition(all 0.1s linear);
  @include transform(translateZ(0));
  &:active {
    box-shadow: none;
    @include transform(translate3d(
       -6px, 6px, 0
    ));
  }
  .arrow {
    @include filter(drop-shadow(-2px 0 0 rgba(black, 0.2))); 
  }
  &:after {
    @include filter(drop-shadow(-2px 0 0 rgba(black, 0.2))); 
  }
  &:after, &:before {
    position: absolute;
    content: " ";
    right: 15px;
    top: 14px;
    width: 6px;
    height: 18px;
    background: white;
    @include transform(rotate(-45deg));
    display: block;
    z-index:2;
  }
  &:before {
    height: 14px;
    top: 26px;
    right: 16px;
    z-index:3;
    @include transform(rotate(-137deg));
    @include filter(drop-shadow(0 -2px 0 rgba(black, 0.15))); 
  }
  /*
  Kinda replicates keyline but looks dumb.
  @include filter(
    drop-shadow(0 1px 0 rgba(blue, 0.2))
    drop-shadow(0 -1px 0 rgba(blue, 0.2))
  );
  */
}

body {
  padding: 50px;
}
```

WEBkit Filters...

```
/*Filter styles*/
.saturate {-webkit-filter: saturate(3);}
.grayscale {-webkit-filter: grayscale(100%);}
.contrast {-webkit-filter: contrast(160%);}
.brightness {-webkit-filter: brightness(0.25);}
.blur {-webkit-filter: blur(3px);}
.invert {-webkit-filter: invert(100%);}
.sepia {-webkit-filter: sepia(100%);}
.huerotate {-webkit-filter: hue-rotate(180deg);}
.opacity {-webkit-filter: opacity(50%);}
```

```

body {
    font-size : 62.5%;
    marging : 1em; /* = 10px */
}

img.center {  
 margin: 0 auto;  
 display: block; /*--Since IMG is an inline element--*/  
} 

h1.verticalCenter {  
 font-size: 3em;  
 height: 100px;  
 line-height: 100px;  
}

div.alwaysdownright { position:fixed; bottom:5px; right:5px; display:block; padding:3px; }

.verticalHorizontalCenteredBox {  
 width: 600px; /*--Specify Width--*/  
 height: 300px; /*--Specify Height--*/  
 position: absolute; /*--Set positioning to absolute--*/  
 top: 50%; /*--Set top coordinate to 50%--*/  
 left: 50%; /*--Set left coordinate to 50%--*/  
 margin: -150px 0 0 -300px; /*--Set negative top/left margin--*/  
}

ul.product_checklist {  
 list-style: none; /*--Takes out the default bullets--*/  
 margin: 0;  
 padding: 0;  
}

ul.product_checklist li {  
 padding: 5px 5px 5px 25px; /*--Adds padding around each item--*/  
 margin: 0;  
 background: url(icon_checklist.gif) no-repeat left center; /*--Adds a bullet icon as a background image--*/  
} 

h1 {  
background: url(home_h1.gif) no-repeat;  
text-indent: -99999px;  
}

```

--

```

/* <input type="button" class="new-aqua" value="Login"/> */

input[type=button].new-aqua {
  width: 155px;
  height: 35px;
  background: #cde;
  border: 2px solid #ccc;
  border-color: #8ba2c1 #5890bf #4f93ca #768fa5;
  font: 600 16px/1 Lucida Sans, Verdana, sans-serif;
  color: #fff;
  text-shadow: rgba(10, 10, 10, 0.5) 1px 2px 2px;
  text-align: center;
  vertical-align: middle;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  border-radius: 16px; -moz-border-radius: 16px; -webkit-border-radius: 16px;
  box-shadow: 0 10px 16px rgba(66, 140, 240, 0.5), inset 0 -8px 12px 0 #6bf, inset 0 -8px 0 8px #48c, inset 0 -35px 15px -10px #7ad;
  -moz-box-shadow: 0 10px 16px rgba(66, 140, 240, 0.5), inset 0 -8px 12px 0 #6bf, inset 0 -8px 0 8px #48c, inset 0 -35px 15px -10px #7ad;
  -webkit-box-shadow: 0 10px 16px rgba(66, 140, 240, 0.5), inset 0 -8px 12px 0 #6bf, inset 0 -8px 0 8px #48c, inset 0 -35px 15px -10px #7ad;
}
.new-aqua:hover {
  text-shadow: rgb(255, 255, 255) 0px 0px 5px;
}


div.xbutton {
	-moz-border-radius:3px 3px 3px 3px;
	-moz-box-shadow:0 0 2px rgba(255, 255, 255, 0.4) inset, 0 4px 6px rgba(255, 255, 255, 0.4) inset, 0 11px 0 -2px rgba(255, 255, 255, 0.2) inset, 0 13px 8px rgba(0, 0, 0, 0.3) inset, 0 1px 0 rgba(0, 0, 0, 0.2);
	-moz-user-focus:normal;
	-moz-user-select:none;
	border:1px solid rgba(0, 0, 0, 0.6);
	height:18px;
	width:300px;
}

```

--

```

@font-face {
	font-family: 'FanwoodRegular';
	src: url('../fonts/Fanwood-webfont.eot');
	src: url('../fonts/Fanwood-webfont.eot?iefix') format('eot'),
	     url('../fonts/Fanwood-webfont.woff') format('woff'),
	     url('../fonts/Fanwood-webfont.ttf') format('truetype'),
	     url('../fonts/Fanwood-webfont.svg#webfontVVl9NZdu') format('svg');
	font-weight: normal;
	font-style: normal;
}

opacity : 0.7;
-moz-opacity : 0.7; 
filter : alpha(opacity=70); 

padding-bottom: expression(this.scrollWidth > this.offsetWidth ? 15 : 0);

// http://www.lrbabe.com/sdoms/borderImage/

.border-image-example {
  -webkit-border-image: url(border-image.jpg) 45 20 45 30 repeat;
  -moz-border-image: url(border-image.jpg) 45 20 45 30 repeat;
  border-image: url(border-image.jpg) 45 20 45 30 repeat;
}

image-rendering: optimizeQuality; /* Gecko */
-ms-interpolation-mode: bicubic; /* IE */

```

--

```

h1 { position: relative; }
h1:hover { color: transparent; }

h1:hover:after {
	content: attr(data-hover-response);
	color: black;
	position: absolute;
	left: 0;
}

<h1 data-hover-response="I Said Don't Touch Me!">Don't Touch Me</h1>

```

--

```
/* Sizing with rem
// http://snook.ca/archives/html_and_css/font-size-with-rem

CSS3 introduces a few new units, including the rem unit, which stands for "root em". If this hasn't put you to sleep yet, then let's look at how rem works.

The em unit is relative to the font-size of the parent, which causes the compounding issue. The rem unit is relative to the root—or the html—element. That means that we can define a single font size on the html element and define all rem units to be a percentage of that. */

html { font-size: 62.5%; } 
body { font-size: 1.4rem; } /* =14px */
h1   { font-size: 2.4rem; } /* =24px */


```

--

```
/* 3D TEXT */

h1 {
  text-shadow: 0 1px 0 #ccc, 
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 0 5px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);
}

h1.shinny { 
	color: #fff;
	-webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 1)), to(rgba(0, 0, 0, 0.3)));
	-moz-mask-image: -moz-linear-gradient(top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0.3));
}
```

--

```

html {
        background: url(images/bg.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}

// IS EQUAL TO

img.bg {
        /* Set rules to fill background */
        min-height: 100%;
        min-width: 1024px;

        /* Set up proportionate scaling */
        width: 100%;
        height: auto;

        /* Set up positioning */
        position: fixed;
        top: 0;
        left: 0;
}

@media screen and (max-width: 1024px) { /* Specific to this particular image */
        img.bg {
                left: 50%;
                margin-left: -512px;   /* 50% */
        }
}

// IS EQUAL TO

// <div id="bg">
        // <img src="images/bg.jpg" alt="">
// </div>

#bg {
        position:fixed;
        top:-50%;
        left:-50%;
        width:200%;
        height:200%;
}
#bg img {
        position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;
        min-width:50%;
        min-height:50%;
}

```

```
body {
  background-image: url("image.png");
  background-position: top left;
  background-size: 95% 95%;
  background-repeat: no-repeat;
  background-attachment: scroll;
  background-origin: padding-box;
  background-clip: content-box;
  background-color: #333};
}
```

  * http://coding.smashingmagazine.com/2011/01/12/guidelines-for-responsive-web-design/

```
/* Smartphones (portrait and landscape) ----------- */
@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px) {
/* Styles */
}

/* Smartphones (landscape) ----------- */
@media only screen
and (min-width : 321px) {
/* Styles */
}

/* Smartphones (portrait) ----------- */
@media only screen
and (max-width : 320px) {
/* Styles */
}

```

--

```

-moz-box-shadow: inset 1px 1px 10px #888;
-moz-box-shadow: 0px 20px 10px -10px #888;
-moz-box-shadow: 0 0 20px black, 20px 15px 30px yellow, -20px 15px 30px lime, -20px -15px 30px blue, 20px -15px 30px red;
-moz-box-shadow: inset 5px 5px 0 rgba(0, 0, 0, .5);

-moz-box-shadow: 1px 1px 10px #00f;
-webkit-box-shadow: 1px 1px 10px #00f;
box-shadow: 1px 1px 10px #00f;

border-radius:4px;
-moz-border-radius:4px;
-webkit-border-radius:4px;

text-shadow:#1395B8 1px 1px 3px; 

```

--

```

transition: all 1s ease-in-out;
	-webkit-transition: all 1s ease-in-out;
	-moz-transition: all 1s ease-in-out;
	-o-transition: all 1s ease-in-out;

transform: skew(30deg, 15deg) translate(10px, 0px) rotate(-30deg);
	-webkit-transform: skew(30deg, 15deg) translate(10px, 0px) rotate(-30deg);
	-moz-transform: skew(30deg, 15deg) translate(10px, 0px) rotate(-30deg);
	-o-transform: skew(30deg, 15deg) translate(10px, 0px) rotate(-30deg);


-webkit-border-radius: 10px;
-webkit-box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
text-shadow: 3px 3px 1px rgba(0,0,0,0.3);
-webkit-box-reflect: below 5px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(0.5, transparent), to(white));
-webkit-text-stroke: 2px #006600;
-webkit-transform: rotateZ(15deg);


div {
  animation-name: 'diagonal-slide';
  animation-duration: 5s;
  animation-iteration-count: 10;
}

@keyframes 'diagonal-slide' {
  from {
    left: 0;
    top: 0;
  }
  to {
    left: 100px;
    top: 100px;
  }
}

```

--

```

#infinity {
    position: relative;
    width: 212px;
    height: 100px;
}

#infinity:before,
#infinity:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 60px;
    height: 60px;    
    border: 20px solid red;
    -moz-border-radius: 50px 50px 0 50px;
         border-radius: 50px 50px 0 50px;
    -webkit-transform: rotate(-45deg);
       -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
         -o-transform: rotate(-45deg);
            transform: rotate(-45deg);
}

#infinity:after {
    left: auto;
    right: 0;
    -moz-border-radius: 50px 50px 50px 0;
         border-radius: 50px 50px 50px 0;
    -webkit-transform:rotate(45deg);
       -moz-transform:rotate(45deg);
        -ms-transform:rotate(45deg);
         -o-transform:rotate(45deg);
            transform:rotate(45deg);
}	

```

--

```

#box {
	/* Just a box */
	width: 500px;
	height: 500px;
	
	/* Rounded corners */
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;

	border: 2px solid white;
	
	/* Multiple border colors in Gecko */
	-moz-border-top-colors: #292929 white;
	-moz-border-right-colors: #292929 white;
	-moz-border-bottom-colors: #292929 white;
	-moz-border-left-colors: #292929 white;

	/* Compensate for Webkit. Not as nice, but works. */
	-webkit-box-shadow: 0 -1px 2px #292929;

	/* Background subtle gradient, with fallback to solid color */
	background: #e3e3e3;
	background: -moz-linear-gradient(top, #a4a4a4, #e3e3e3);
	background: -webkit-gradient(linear, left top, left bottom, from(#a4a4a4), to(#e3e3e3));

	/* Polish */
	word-wrap: break-word;
	overflow:hidden;
}

p.text-overflow {
      width: 200px; /* à modifier selon vos besoins */
      overflow: hidden;
      -o-text-overflow: ellipsis; /* pour Opera 9 */
      text-overflow: ellipsis; /* ajoute ... apres la coupure, pour le reste du monde */
}

table {
      width: 600px; /* à adapter selon vos contraintes */
      table-layout: fixed; /* non breaking long link */
}


.container {
   min-height: 10em;
   display: table-cell;
   vertical-align: middle;
}

```

## Selector Hacks ##

```

/* IE 6 and below */
* html #uno  { color: red }

/* IE 7 and below */
*:first-child+html #dos { color: red }
 
/* IE 7 and modern browsers */
html>body #tres { color: red }

/* Modern browsers (not IE 7) */
html>/**/body #cuatro { color: red }

/* Opera 9.27 and below */
html:first-child #cinco { color: red }

/* Safari */
html[xmlns*=""] body:last-child #seis { color: red }
 
/*safari 3+, chrome 1+, opera9+, ff 3.5+ */
body:nth-of-type(1) #siete { color: red }

/* safari 3+, chrome 1+, opera9+, ff 3.5+ */
body:first-of-type #ocho {  color: red }

/* saf3, chrome1+ */
@media screen and (-webkit-min-device-pixel-ratio:0) {
 #diez  { background: #FFDECE; border: 2px solid #ff0000  }
}

/***** Attribute Hacks ******/

/* ie6 and below */
#once { _color:blue }
 
/* ie7 and below */
#doce { *color: blue } /* or #color:blue */

```

--

```

IE BG PNG TRANSPARENCY
/* HACK png transparent sur IE en background */

background-image:url(../images/common/h_contenu2.png) !important;
background-image:url(no-image);
filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop src='images/common/h_contenu2.png');
background-repeat:no-repeat;

```

--

```
a.warning {
      cursor:url(.././themes/original/img/error.ico), default;
}

#q, .tc input[type=text] { width:540px; }

<q><a href="http://www.wikipedia.org/wiki/Wiki"><span class="tool">Wikipedia!
<span class="tip">Wikipedia! on Wiki<br/>http://www.wikipedia.org/wiki/Wiki</span></span></a></q>


/* css/tooltip.css -- fancy tooltips */

span.tool {
  position: relative;   /* this is key */
  cursor: help;
}
 
span.tool span.tip {
  display: none;        /* so is this */
}

/* tooltip will display on :hover event */
 
span.tool:hover span.tip {
  display: block;
  z-index: 100;
  position: absolute;
  top: 2.5em;
  left: 0;
  width: auto;
  line-height: 1.2em;
  padding: 3px 7px 4px 6px;
  border: 1px solid #336;
  background-color: #f7f7ee;
  font-family: arial, helvetica, sans-serif;
  font-size: 12px;
  font-weight: normal;
  color: #000;
  text-align: left;
}

#content span.tool::after {
  padding-left: 2px;            /* eye candy */
  content: url(/img/bubble.gif);
}
```

## No Print ##

```

.noprint {
    display : none;
}
* {
    background-color: white !important;
    background-image: none !important;
}
p a:link, p a:active, p a:visited, p a:hover  {
    color : #36EA00;
    text-decoration:underline;
}
p a:link:after, a:visited:after {
  content: " (" attr(href) ") ";
  font-size: 80%;
}
h1, h2, h3, h4, h5, h6 {
    page-break-after: avoid;
}

/* Neutralize styling: Elements we want to clean out entirely: */

html, body, form, fieldset {
    margin: 0;
    padding: 0;
    font: 100%/120% Verdana, Arial, Helvetica, sans-serif;
}

/* Neutralize styling: Elements with a vertical margin: */
h1, h2, h3, h4, h5, h6, p, pre,
blockquote, ul, ol, dl, address {
    margin: 1em 0;
    padding: 0;
}

/* Apply left margin: Only to the few elements that need it: */
li, dd, blockquote {
    margin-left: 1em;
}

/* Miscellaneous conveniences: */
form label {
    cursor: pointer;
}
fieldset {
    border: none;
}

/* Form field text-scaling */
input, select, textarea {
    font-size: 100%;
}
```

--

```

.clipInHalf {
    position: absolute;
    clip: rect(15 350 195 50);
    top: 0px;
    left: 0px;
}

<fieldset>
<legend>TIPS</legend>

table { background-color:#FFF; border: 1px solid #3366FF; border-collapse: separate; }
th { background-color:#3366FF; color:#FFCC66; }
tr:hover>td { background-color:#B9CFFF; }

```

--

```

position:relative is very important. The children of this <div> are absolutely positioned.
Absolutely positioned elements are positioned relative to the nearest positioned ancestor.
Since we want them to be positioned relative to the diagram itself, we have to make it positioned.
By setting position:relative without specifying an offset, it will become positioned without being moved.


content: "Your browser supports content"

q { quotes: '"' '"' }

    [quotes] specifies what form the quotes of the open-quote and close-quote values of the content property should take. Not supported by IE.
   
orphans: <integer>
widows: <integer>
These two properties are used primarily in paged media to control line breaks by specifying the number of lines in a paragraph that should be left at the top (widows) or bottom (orphans) of a page.
About.com

table-layout: (auto | fixed)
According to Quackit.com The CSS table-layout property allows you to fix the table layout so that the table renders much faster

```

--

```

.pullquote {
    width: 20%;
    float:right;
    font-size:125%;
    line-height:140%;
    margin:10px;
    background: url(closequote.gif) no-repeat bottom right !important;
    background /**/:url(); /* removing quote graphic in IE5+ */
    padding:0px 25px 5px 0px;
}
.pullquote:first-letter {
    background: url(openquote.gif) no-repeat left top !important;
    padding:5px 2px 10px 35px!important;
    padding /**/:0px;     /* resetting padding in IE5+ */
    background /**/: url(); /* removing quote graphic in IE5+ */
}

<blockquote class="pullquote">The most impressive thing about read em!</blockquote>
       
       
```

## The CSS that's required to position the footer ##

```

/*  */

body {
    margin:0px;
    padding:0px;
    width:100%;
    height:100%;
    text-align:center;
}
#header, #content {
    margin-left: auto;
    margin-right: auto;
    width: 888px;
    text-align:left;
}


html {
    height: 100%;
}
body {
    height: 100%;
}
#nonFooter {
    position: relative;
    min-height: 100%;
}
* html #nonFooter {
    height: 100%;
}
#footer {
    position: relative;
    margin: -7.5em auto 0 auto;
}

/* A CSS hack that only applies to IE -- specifies a different height for the footer */

* html #footer {
    margin-top: -7.4em;
}


<div id="page">
    <div id="nonFooter"> Page </div>
</div>
<div id="footer"> TOTO </div>
```

## Shadow Image ##

```


.img-shadow {
  clear: both;
  float:left;
  background: url(/d/cssdropshadows/img/shadowAlpha.png) no-repeat bottom right !important;
  background: url(/d/cssdropshadows/img/shadow.gif) no-repeat bottom right;
  margin: 20px 0 0 17px !important;
  margin: 20px 0 0 8px;
}

.img-shadow img {
  display: block;
  position: relative;
  background-color: #fff;
  border: 1px solid #a9a9a9;
  margin: -6px 6px 6px -6px;
  padding: 4px;
  width: 154px;
  height: 203px;
}

.p-shadow {
  clear: both;
  width: 90%;
  float:left;
  background: url(/d/cssdropshadows/img/shadowAlpha.png) no-repeat bottom right !important;
  background: url(/d/cssdropshadows/img/shadow.gif) no-repeat bottom right;
  margin: 10px 0 0 10px !important;
  margin: 10px 0 0 5px;
}

.p-shadow div {
  background: none !important;
  background: url(/d/cssdropshadows/img/shadow2.gif) no-repeat left top;
  padding: 0 !important;
  padding: 0 6px 6px 0;
}

.p-shadow p {
  color: #777;
  background-color: #fff;
  font: italic 1em georgia, serif;
  border: 1px solid #a9a9a9;
  padding: 4px;
  margin: -6px 6px 6px -6px !important;
  margin: 0;
}


<div class="p-shadow"><div><p style="font-size: 1.3em;">The rain in Spain falls mainly on the plain.</p></div></div>

<br style="clear:both;" />
```

## SHADOW ##

```


.dropshadow2{
    float:left;
    clear:left;
    background: url(images/shadowAlpha.png) no-repeat bottom right !important;
    background: url(images/shadow.gif) no-repeat bottom right;
    margin: 10px 0 10px 10px !important;
    margin: 10px 0 10px 5px;
    width: 500px;
    padding: 0px;
}
.innerbox{
    position:relative;
    bottom:6px;
    right: 6px;
    border: 1px solid #999999;
    padding:4px;
    margin: 0px 0px 0px 0px;
}
.innerbox{
    /* IE5 hack */
    \margin: 0px 0px -3px 0px;
    ma\rgin:  0px 0px 0px 0px;
}
.innerbox p{       
    font-size:14px;
    margin: 3px;
}


<div class="dropshadow2">
    <div class="innerbox">
    <h4>Test 2</h4>
      <p>This has two wrapping div's. one for the shadow, and one for the border.</p>
    </div>
</div>

```

## Sticky Footer http://ryanfait.com ##

```

* {
	margin: 0;
}
html, body {
	height: 100%;
}
.wrapper {
	min-height: 100%;
	height: auto !important;
	height: 100%;
	margin: 0 auto -142px; /* the bottom margin is the negative value of the footer's height */
}
.footer, .push {
	height: 142px; /* .push must be the same height as .footer */
}

```

## Round BOX ##

```

#xsnazzy h1, #xsnazzy h2, #xsnazzy p {margin:0 10px; letter-spacing:1px;}
#xsnazzy h1 {font-size:2.5em; color:#fff;}
#xsnazzy h2 {font-size:2em;color:#06a; border:0;}
#xsnazzy p {padding-bottom:0.5em;}
#xsnazzy h2 {padding-top:0.5em;}
#xsnazzy {background: transparent; margin:1em;}

.xtop, .xbottom {display:block; background:transparent; font-size:1px;}
.xb1, .xb2, .xb3, .xb4 {display:block; overflow:hidden;}
.xb1, .xb2, .xb3 {height:1px;}
.xb2, .xb3, .xb4 {background:#ccc; border-left:1px solid #08c; border-right:1px solid #08c;}
.xb1 {margin:0 5px; background:#08c;}
.xb2 {margin:0 3px; border-width:0 2px;}
.xb3 {margin:0 2px;}
.xb4 {height:2px; margin:0 1px;}

.xboxcontent {display:block; background:#ccc; border:0 solid #08c; border-width:0 1px;}

<div id="xsnazzy">
<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
<div class="xboxcontent">
<h1>Snazzy Borders</h1>
<p>Based on Nifty Corners By Alessandro Fulciniti<br />http://pro.html.it/esempio/nifty/</p>

<h2>Rounded borders without images</h2>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
  euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim
  ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl
  ut aliquip ex ea commodo consequat.</p>
<p>Duis autem vel eum iriure dolor in hendrerit
  in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
  facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent
  luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
</div>
<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
</div>

```

## STARTING ./STYLES.CSS ##

```

@charset "utf-8";
/* CSS Document */

body {
	background:#FFFFFF;
	color:#4C4C4C;
	font-family: Arial, Verdana, Sans-Serif;
	font-size:62.5%;
	margin:0;
	padding:0;
	text-align:center;
}

```

## STRUCTURE ##

```
#page {
	border:1px solid #000;
	margin:20px auto;
	padding:0;
	width:978px;
	position:relative;
}

#page_int {
	margin:0;
	padding:12px;
	text-align:left;
	background:#E6E6E6;
}
#page_interieur {
	background:#FFFFFF;
	min-height:978px;
}

#header {
	margin:0;
	padding:0;
}

#content {
	font-size:1.2em;
	margin:14px 14px 0 14px;
}

#maincontent {
	float:left;
	height:inherit;
	width:614px;
}

#navigation {
	float:right;
	width:300px;
}
			

#footer {
	background:url(../images/images/bb.png) no-repeat bottom;
	border:none;
	clear:both;
	height:63px;
	margin:0;
	padding:0;
	width:962px;
}

```

--POLICES

```

h1, h2, h3, h4 {
	color:#CCC;
	font-weight:bold;
	margin:0;
	padding:0;
}
h1 {
	font-size:18px;
	text-transform:uppercase;
}
h2 { font-size:16px; }
h3 { font-size:14px; }
h4 { font-size:1em; font-weight:normal; }

hr {
	border:none;
	border-top:1px solid #CCC;
	height:0;
	margin:0 0 5px 0;
	padding:0;
}

cite, blockquote {
	font-style: italic;
	color:#666666;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:1em;
	margin:0;
	padding:0;
}

blockquote {
	margin:10px 0;
}

p {
	margin:0;
	padding:0;
	font-size:1.1em;
	text-align:justify;
}

a, a:visited, a:active {
	color:#333333;
	text-decoration:none;
}
a:hover {
	color:#999999;
}

.auteur {
	font-size:0.9em;
	font-weight:bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	letter-spacing:-1px;
}


```

## DEFAULT FOR SOME TAGS ##

```
a img {
	border:none;
}
a img.bor, .bor {
	border:1px solid #E4E4E4;
}
img.right {
	display:inline;
	margin:0 0 2px 7px;
	padding:4px;
	float:right;
}
img.left {
	display:inline;
	margin:0 7px 2px 0;
	padding:4px;
	float:left;
}
img.miniature_liste {
	float:left;
}

```

## LISTES ##

```

ul, blockquote {
	margin:Opx;
	padding:0;
}
li {
	list-style-position:inside;
	margin:0 0 0 10px;
}

ul.site {
	margin:0;
	padding:0;
}
ul.site li {
	display:block;
	float:left;
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
	margin:0;
	padding:0;
}
ul.site li a {
	border:1px solid #E4E4E4;
	display:block;
	height:65px;
	margin:2px;
	overflow:hidden;
	text-indent:-9999px;
	width:80px;
}

```

## UTILITIES 1 ##

```


.centered {
	display:block;
	margin-left:auto;
	margin-right:auto;
}
.center {
	text-align:center;
}
.right {
	float:right;
}
.left {
	float:left;
}
.middle {
	vertical-align:middle;
}
.clear {
	clear:both;
	display:block;
	width:100%;
	height:0;
}
.breaker {
	clear:both;
	display:block;
	height:0;
}
.spacer {
	clear:both;
	display:block;
	height:14px;
}
.spacermini {
	display:block;
	height:6px;
}

.zoomIn {
	cursor:url(../images/zoomin.cur),  pointer;
}
.zoomOut {
	cursor:url(../images/zoomout.cur),  pointer;
}

.marg10 {
	margin:10px;
}
.pad10 {
	padding:10px;
}
```

## FORMULAIRE ##

```


form {
	display:inline;
	margin:0;
	padding:0;
}
label {
	cursor:pointer;
	margin:0 10px 3px 0;
}
input, textarea, select, .inputStyle {
	background-color:#FFF;
	border:1px solid #999999;
	color:#333333;
	font-family: Arial, Helvetica, sans-serif;
	font-size:1em;
	margin:0;
	padding:2px;
}
fieldset {
	border:1px dashed #FFCE00;
	margin:0;
	padding:6px;
}
input {
	height:16px;
	vertical-align:bottom;
}
select {
	height:18px;
	margin-bottom:-1px;
	margin-top:1px;
	vertical-align:bottom;
	width:auto;
}
textarea, select {}
input.file {
	height:20px;
}
input.recherche {
	background:#FFF url(../images/nav/rech.png) no-repeat left;
	padding-left:20px;
}
input.button, a.button {
	background-color:#EBFDE5;
	border:1px solid #999999;
	color:#999999;
	cursor:pointer;
	font-size:1em;
	font-weight:bold;
	letter-spacing:1px;
	line-height:5px;
	margin:0;
	padding:2px 6px;
	vertical-align:middle;
}
a:hover.button {
	background-color:#FFF;
}
.divMiniForm input.radio, .divMiniForm input.checkbox, input.radio, input.checkbox {
	background:none;
	border:none;
	color:#00AAEA;
	height:14px;
	margin:0;
	padding:0;
	width:14px;
}
form input.input_error, form textarea.area_error, form select.select_error {
	border:1px solid #996600;
}
.divError {
	display:inline;
	padding-left:10px;
	vertical-align:bottom;
	line-height:1em;
}
.form_error_ico {
	vertical-align:bottom;
	cursor:help;
}


```

## NEWSPAPER FONTS STYLE ##

```
--- PARAGRAPH CODE ---
h1 {
	font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
	font-style: italic;
	color: #424242;
}
a {
	font-style: normal;
	font-variant: small-caps;
	text-decoration: none;
	color: #afafaf;
	font-size: 14px;
}
p:first-letter{
	text-transform: uppercase;
}
p {
	color: #424242;
	font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
	letter-spacing:0.1em;
	text-align:center;
	margin: 40px auto;
	text-transform: lowercase;
	line-height: 145%;
	font-size: 14pt;
	font-variant: small-caps;
}

--- HEADLINE ---
.head {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size:24px;
	margin-top: 5px; margin-bottom: 0px;
	text-align: center;
	font-weight: normal;
	color: #222;
}
.subhead {
	font-family: "Lucida Grande", Tahoma;
	font-size: 10px;
	font-weight: lighter;
	font-variant: normal;
	text-transform: uppercase;
	color: #666666;
	margin-top: 10px;
	text-align: center!important;
	letter-spacing: 0.3em;
}

```

http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC/css/styles.css