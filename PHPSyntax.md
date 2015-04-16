Certaines fonctions ci-dessous sont reprises (proprement ;) dans le [framework](http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC#SITE_01_SRC/admin/lib)

# En vrac... #

```

// die(phpinfo());
// var_export(ini_get_all());


@ini_set('magic_quotes_runtime', 0);
@ini_set('memory_limit', '64M');
@set_time_limit(500);
// @ignore_user_abort(true);

@set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/'.PATH_SEPARATOR.'../');
print_r(apache_get_modules());


@ini_set('error_reporting', E_ALL & ~E_NOTICE);
@ini_set('display_errors','Off');
@ini_set('log_errors','On');
@ini_set('error_log','/home/example.com/logs/php_error.log');

// @ini_set('track_errors', '1'); ### echo $php_errormsg;

$selfPageName = basename($_SERVER['PHP_SELF']);
$selfPageQuery = (!empty($_SERVER['QUERY_STRING']) ? $selfPageName.'?'.$_SERVER['QUERY_STRING'] : $selfPageName );
$selfDir = $_SERVER['REQUEST_URI'];
$host = $_SERVER['HTTP_HOST'];
$hostIp = $_SERVER['SERVER_ADDR'];
$isLocal = ($hostIp == '127.0.0.1' ? true : false);


// -------------------------------------------------------------------------------------------------------- //
// Avoid JSONP security breach // http://www.metaltoad.com/blog/using-jsonp-safely

function generate_jsonp($data) {
  if (preg_match('/\W/', $_GET['callback'])) {
    // if $_GET['callback'] contains a non-word character,
    // this could be an XSS attack.
    header('HTTP/1.1 400 Bad Request');
    exit();
  }
  header('Content-type: application/javascript; charset=utf-8');
  print sprintf('%s(%s);', $_GET['callback'], json_encode($data));
}

// -------------------------------------------------------------------------------------------------------- //

function object2array($object) {
    $return = NULL;   
    if (is_array($object)) {
        foreach($object as $key => $value) $return[$key] = object2array($value);
    }
    else {
        $var = get_object_vars($object);
        if ($var) foreach($var as $key => $value) $return[$key] = ($key && !$value) ? NULL : object2array($value);
        else return $object;
    }
    return $return;
}

// -------------------------------------------------------------------------------------------------------- //

function bdd2sqlite() {
	global $sqliteBaseRootDir;
	global $sqliteBddBasePath;
	global $wwwRoot;
	global $MondadoryDayBefore;
	global $exportDate;
	global $sqliteEmissionsBasePath;
	
	boostPhpLimit();

	// -------------------------- LET's GO -------------------------- //
	if (is_file($sqliteBddBasePath)) unlink($sqliteBddBasePath);
	
	$LITE = new PDO('sqlite:'.$sqliteBddBasePath); // Init SQLite
	$LITE->exec((string)file_get_contents($wwwRoot.'php_manager/SQL/setup_sqlite_bdd_config.txt')); // Create new EPG tables schemes
	$LITE->exec((string)file_get_contents($wwwRoot.'php_manager/SQL/setup_sqlite_bdd_chaines.txt'));
	$LITE->exec((string)file_get_contents($wwwRoot.'php_manager/SQL/setup_sqlite_bdd_genres.txt'));
	$LITE->exec((string)file_get_contents($wwwRoot.'php_manager/SQL/setup_sqlite_bdd_emission.txt')); // Create new EPG tables schemes
	
	function addMySlashes($v) { // Protect fields // Check for utf8 for iphone ?
		return str_replace("'", "''", $v);
	}
	
	$Q = new Q();
	foreach(array('epg_config', 'epg_chaines', 'epg_genres', 'epg_sous_genres') as $table) {
		$Q->QUERY("SELECT * FROM $table ORDER BY id DESC");
		$sqliteInsert = '';
		foreach($Q->V as $V) {
			$valueArr = array_map('addMySlashes', array_values($V));
			$sqliteInsert .= "INSERT INTO ".$table." ('".implode("','", array_keys($V))."') VALUES ('".implode("','", $valueArr)."');";
		}
		$LITE->exec(utf8_encode(substr($sqliteInsert, 0, -1)));
		if ((int)$LITE->errorCode() > 0 || count($LITE->errorInfo()) > 1) {
			eko('<h1 class="error">Error with MySQLite ('.(string)$LITE->errorCode().' : '.implode(' - ', $LITE->errorInfo()).')</h1>');
		}
		else eko('SQLite creation of table '.$table.' : Ok<br />');
	}
	
	// CRON FOR UPDATE IS 3:00 AM
	// getDateTimeOf(0, 0, 0, date("m"),date("d")+1, date("Y")) // +$MondadoryDayBefore
	$Q = new Q("SELECT * FROM epg_emissions WHERE ( TO_DAYS(diffusion)=TO_DAYS(NOW()) OR TO_DAYS(diffusion_fin)=TO_DAYS(NOW()) ) ORDER BY id"); // LIMIT 200
	$sqliteInsert = array();
	$i = 0;
	foreach($Q->V as $V) {
		$valueArr = array_map('addMySlashes', array_values($V));
		$sqliteInsert[] = "INSERT INTO epg_emissions ('".implode("','", array_keys($V))."') VALUES ('".implode("','", $valueArr)."')";
		$i++;
	}
	if (count($sqliteInsert) < 1) {
		eko('<h1 class="error">No emissions for this date</h1>');
	}
	else {
		$LITE->exec(utf8_encode(implode(';', $sqliteInsert)));
		if ((int)$LITE->errorCode() > 0 || count($LITE->errorInfo()) > 1) {
			eko('<h1 class="error">Error with MySQLite ('.(string)$LITE->errorCode().' : '.implode(' - ', $LITE->errorInfo()).')</h1>');
		}
		else eko('SQLite creation of table emissions : Ok<br />');
	}
	
	eko('SQLite creation of table BDD All (<strong>'.$i.'</strong> emissions added)<br />'); //LITE->lastInsertId()
	
	
	$zipFile = $sqliteBddBasePath.'.zip';
	if (is_file($zipFile)) @unlink($zipFile);
	
	$zip = new ZipArchive();
	if ($zip->open($zipFile, ZIPARCHIVE::CREATE) !== TRUE) eko("Cannot open <$filename>");
	$zip->addfile($sqliteBddBasePath, basename($sqliteBddBasePath));
	$zip->close();
	
	eko('BDD All is zipped again<br />');

	unBoostPhpLimit();
}

// -------------------------------------------------------------------------------------------------------- //

hose of you with PHP 5 don't have to come up with these wild functions to scan a directory recursively: the SPL can do it.

<?php

$dir_iterator = new RecursiveDirectoryIterator("/path");
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
// could use CHILD_FIRST if you so wish

foreach ($iterator as $file) {
    echo $file, "\n";
}

?>

Not to mention the fact that $file will be an SplFileInfo class, so you can do powerful stuff really easily:

<?php

$size = 0;
foreach ($iterator as $file) {
    if ($file->isFile()) {
        echo substr($file->getPathname(), 27) . ": " . $file->getSize() . " B; modified " . date("Y-m-d", $file->getMTime()) . "\n";
        $size += $file->getSize();
    }
}

echo "\nTotal file size: ", $size, " bytes\n";

?>

\Luna\luna.msstyles: 4190352 B; modified 2008-04-13
\Luna\Shell\Homestead\shellstyle.dll: 362496 B; modified 2006-02-28
\Luna\Shell\Metallic\shellstyle.dll: 362496 B; modified 2006-02-28
\Luna\Shell\NormalColor\shellstyle.dll: 361472 B; modified 2006-02-28
\Luna.theme: 1222 B; modified 2006-02-28
\Windows Classic.theme: 3025 B; modified 2006-02-28

Total file size: 5281063 bytes

// -------------------------------------------------------------------------------------------------------- //
// http://thinkvitamin.com/dev/exception-handling-in-php5/

class BigNumberException extends Exception { }
class FavouriteNumberException extends Exception { }
 
function takeTwoNumbers($a, $b) {
    if($a > 15 || $b > 15) {
        throw new BigNumberException('Keep it simple with smaller numbers');
    } elseif($a != 3 && $b != 3) {
        throw new FavouriteNumberException('But three is my favourite number!');
    } else {
        return $a + $b;
    }
}
 
try {
    echo takeTwoNumbers(3,9) . "\n";
    echo takeTwoNumbers(4,16) . "\n";
    echo takeTwoNumbers(7,5) . "\n";
} catch(BigNumberException $e) {
    echo "Big Number: " . $e->getMessage() . "\n";
} catch(FavouriteNumberException $e) {
    echo "Favourite Number: " . $e->getMessage() . "\n";
} catch(Exception $e) {
    echo $e->getMessage() . "\n";
}

// -------------------------------------------------------------------------------------------------------- //

highlight_file(__FILE__);

function afficher_code_php() {
    if (isset($_GET['source'])) {
        echo '<p><a href="',$_SERVER['PHP_SELF'],'">Retour</a></p>';
        echo '<p>Ceci est le code php du fichier :</p>';
        $page = highlight_file($_SERVER['SCRIPT_FILENAME'], TRUE);
        $page = str_replace(
          array('<code>','/code>','&nbsp;','</font>','<font color="'),
          array('<pre style="padding:1em;border:2px solid black;overflow:scroll">','/pre>',' ','</span>','<span style="color:'),$page);
        echo $page;
        echo '<p><a href="',$_SERVER['PHP_SELF'],'">Retour</a></p>';
        echo '</body></html>';
        exit;
    }
}

<a href="view-source:http://monsite.com/<?=$_SERVER['PHP_SELF']?>">Source html</a>

// -------------------------------------------------------------------------------------------------------- //

if (function_exists('curl_init')) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: text/xml,application/xml,application/xhtml+xml,
		text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
		'Accept-Language: fr-fr,fr;q=0.7,en-us;q=0.5,en;q=0.3',
		'Accept-Charset: utf-8;q=0.7,*;q=0.7',
		'Keep-Alive: 800'));
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)' );
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_VERBOSE, false);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
	curl_setopt($ch, CURLOPT_TIMEOUT, 8);
	curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 480);
	$result = curl_exec ($ch);
	curl_close ($ch);
}
else $result = file_get_contents($url);


// -------------------------------------------------------------------------------------------------------- //

$xmlEpgUrl = $xmlTodayDir.$fileName;
$xmlEpgString = file_get_contents($xmlEpgUrl);
$xmlEpgString = str_replace(array('PCCAD_CD:','PCCAD_st:','PCCAD_TV:'), array(), $xmlEpgString); // Clean Nasty Random NameSpace :-/

$X = @simplexml_load_string($xmlEpgString); // CORE XML FUNCTION
//$namespaces = $X->getDocNamespaces();
//$X->registerXPathNamespace('__empty_ns', $namespaces['']);

if (!$X) {
	$infos .= 'Error parsing XML file ! ('.$xmlEpgUrl.')<br />';
	continue;
}

$channelEpgId = (string)$X->ServiceTable->Service['serviceID'];
$channelEpgName = (string)$X->ServiceTable->Service->Name;

if (!$channelEpgId) {
	$infos .= 'Error with XML file ! ('.$xmlEpgUrl.')<br />';
	continue;
}

foreach($X->xpath('//ContentLocationTable/TVContentLocation') as $TVContentLocation) {
	$contentID = (string)$TVContentLocation['contentID'];
	$DiffusionTitle = (string)$TVContentLocation->DiffusionTitle;
}

// EN VRAC.... // SIMPLE XML

$xml['xmlns'] = ''; 
simplexml_load_file($file_xml, 'SimpleXMLElement',LIBXML_NOCDATA); 
echo $xml->asXML();

foreach($produits -> produit[0] ->attributes() as $a => $b) {  

// convert string from utf-8 to iso8859-1
$horoscope = iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $horoscope );

// EN VRAC XPATH >>>> http://fr.wikipedia.org/wiki/XPath

$xml->xpath('/a/b/c');
$xml->xpath("/rss/channel/item/content:encoded/text()");
$v = $row->xpath('//field[@name="id"]'); 
$xml->xpath("//adressname[contains(.,'Ci')]");
$data = $xml->xpath("//adressname[contains(.,'Ci') and not(./text()=preceding-sibling::adressname/text())]");

// -------------------------------------------------------------------------------------------------------- //

// Here is a nice little script for monitoring your http access log.

$handle = popen("tail -f /etc/httpd/logs/access.log 2>&1", 'r');
while(!feof($handle)) {
    $buffer = fgets($handle);
    echo "$buffer<br/>\n";
    ob_flush();
    flush();
}
pclose($handle);


// -------------------------------------------------------------------------------------------------------- //

PHP intègre depuis sa version 5 un client SOAP. Toutes les fonctions permettant d'effectuer une telle requête sont déjà à notre portée. Il ne reste plus qu'à les appeler.

Tout d'abord, créons un nouvel objet, qui prendra comme paramètre le endpoint à requêter :

$client = new soapclient("http://monendpoint.com/soap");

Si vous passez une telle url dans votre navigateur, elle est sensée vous retourner notre élément WSDL. On peut alors, par exemple, demander à voir a liste des méthodes disponibles :

<pre>var_dump($client->__getFunctions());</pre>

Une fois ceci fait, il ne reste plus qu'à appeler la méthode souhaitée :

$response = $client->GetList('macleAPI');

Les méthodes en questions prennent comme paramètres ceux définis par le WSDL. Il ne reste plus qu'à traiter le contenu récupéré qui est au format JSON, ce qui se traite alors de manière extrêmement simple en PHP.

Et voilà, le tour est joué. Il ne reste plus qu'à vous amuser avec votre API.

http://romain.typepad.fr/mon_weblog/2010/03/api-mon-amour-épisode-3-réaliser-une-requête-soapwsdl-via-http.html

// -------------------------------------------------------------------------------------------------------- //

function cmd($cmd, $escape=FALSE) {
        if ($escape) $cmd = escapeshellarg($cmd); // to check
        if (!isWindow()) $cmd = str_replace( array('(', ')'), array('\\(', '\\)'), $cmd);
        exec($cmd, $output, $exit);
        return implode('\n', $output);
}

PHP waits for cmd to quit before continuing.
There are several workarounds mentioned in the comments of the PHP documentation of exec. Here is a summary of those methods, by order of preference.

Start background process using the WScript.Shell object

    If your on a local window machine... you can start the process using the Run method of the WScript.Shell object, which is built-in to Windows. By varying the second parameter, you can make the window hidden, visible, minimized, etc. By setting the third parameter to false, Run does not wait for the process to finish executing. This code only works on Windows.

    $WshShell = new COM("WScript.Shell");
    $oExec = $WshShell->Run("cmd /C dir /S %windir%", 0, false);

    // start Notepad.exe minimized in the background:
    $oExec = $WshShell->Run("notepad.exe", 7, false);

    // start a shell command invisible in the background:
    $oExec = $WshShell->Run("cmd /C dir /S %windir%", 0, false);

    // start MSPaint maximized and wait for you to close it before continuing the script:
    $oExec = $WshShell->Run("mspaint.exe", 3, true);

    0 Hides the window and activates another window.
    1 Activates and displays a window. If the window is minimized or maximized, the system restores it to its original size and position. An application should specify this flag when displaying the window for the first time.
    2 Activates the window and displays it as a minimized window.
    3 Activates the window and displays it as a maximized window.
    4 Displays a window in its most recent size and position. The active window remains active.
    5 Activates the window and displays it in its current size and position.
    6 Minimizes the specified window and activates the next top-level window in the Z order.
    7 Displays the window as a minimized window. The active window remains active.
    8 Displays the window in its current state. The active window remains active.
    9 Activates and displays the window. If the window is minimized or maximized, the system restores it to its original size and position. An application should specify this flag when restoring a minimized window.
    10 Sets the show-state based on the state of the program that started the application.


Start background process using popen and pclose

    This code should work on Linux and Windows. 
    pclose(popen("start \"bla\" \"" . $exe . "\" " . escapeshellarg($args), "r")); 

    <?php
    $commandString = 'start /b c:\\programToRun.exe -attachment "c:\\temp\file1.txt"';
    pclose(popen($commandString, 'r'));
    ?>

Start background process with psexec

    This method requires installing the freeware pstools from sysinternals:
    exec("psexec -d blah.bat"); 
Start process without a window
    This is not really for background processes, but worth mentioning. Use the windows start command with /B switch to hide the window.
    exec('start /B "window_name" "path to your exe"',$output,$return); 


--------------------------------------------------------------------------------------------------------

WITH CACHE FOR PAGE

# 'Expires' in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

# Always modified
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

# HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

# HTTP/1.0
header("Pragma: no-cache");

WITHOUT CACHE :

header("Expires: ".gmdate("D, d M Y H:i:s", time()+315360000)." GMT");
header("Cache-Control: max-age=315360000");



--------------------------------------------------------------------------------------------------------
/*
<tv>
	<channel id="TMC1.kazer.org">
		<display-name>TMC</display-name>
	</channel>
	...
	...
</tv>
*/

@set_time_limit(999);

$i = 0;
$xml = new XMLReader();
$xml->open($file_xml);
while($xml->read()){
	if ($xml->nodeType == XMLREADER::ELEMENT && $xml->localName == 'channel') {

		// Extract XML value 
		if ($xml->hasAttributes) {
			while($xml->moveToNextAttribute()) {
				switch($xml->name) {
					case 'id' : $channelId = $xml->value; break;
				}
			}
		}
		
		$channel = new SimpleXMLElement('<channel>'.$xml->readInnerXML().'</channel>');
		$name = 'display-name';
		$title = utf8_decode($channel->$name);

		/* DO what you have to do */
		
		$i++;
		if ($i % 100 == 0) flush();
	}
}
$xml->close();

--------------------------------------------------------------------------------------------------------


$nom_fichier = '_colonnes.php';
$fichier = trim(file_get_contents($nom_fichier));
/*$fichier = preg_replace("/^<\?(php)?/", '', $fichier);
$fichier = preg_replace("/\?>$/", '', $fichier);*/
$fichier = substr($fichier,2,-2);

$b64 = base64_encode($fichier);
$tr = strtr($b64, 'ABC','CAB');
$enc  = "\$__c='".$tr."';\$__s=strtr(\$__c,\"CAB\",\"ABC\");";
$enc .= '$__d=strrev("edoced_46esab");eval(\'$__x=$__d("$__s");\');eval($__x);db($__x);';

db($enc);
--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------
memcache : distributed memory object caching system, generic in nature, but intended for use in speeding up dynamic web applications by alleviating mySQL load and speed PHP access
http://www.danga.com/memcached/
--------------------------------------------------------------------------------------------------------
<?php
session_start();
output_add_rewrite_var('var', 'value');

echo '<a href="file.php">link</a>';
ob_flush();

output_reset_rewrite_vars();
echo '<a href="file.php">link</a>';
?>

L'exemple ci-dessus va afficher :

<a href="file.php?PHPSESSID=xxx&var=value">link</a>
<a href="file.php">link</a>

// ----------------

session_start();
if(!isset($_SESSION['foo'])) $_SESSION['foo'] = 'bar'; 
echo $_SESSION['foo'];
 
Les données de session sont protégées en écriture : cela signifie qu'un seul script à la fois sera en mesure de les modifier.  Ce comportement peut ralentir l'exécution de requêtes simultanées (avec les frames ou Ajax par exemple), l'enregistrement de la session sera retardé en attendant que le ou les autre(s) script(s) soi(en)t terminé(s). Pour limiter cette attente, vous pouvez appeler explicitement la fonction session_write_close() (ou son alias session_commit())

Si on utilise un cookie, la durée de vie d'une session dépendra de la durée de vie d'un cookie. Cette durée est définie à l'aide de la directive session.cookie_lifetime. Si cette valeur vaut 0, alors le cookie sera maintenu par le navigateur tant que ce dernier ne sera pas fermé par l'utilisateur
La durée de vie des données sur le serveur est définie par la directive session.gc_maxlifetime

// Durée de vie de la session (Time To Live)

$ttl = 3600; // Une heure, en secondes
$local_sessions_save_path = ini_get('session.save_path').'/monsiteweb';
     
session_set_cookie_params($ttl);
ini_set('session.gc_maxlifetime', $ttl);
ini_set('session.save_path', $local_sessions_save_path);

session_start();


--------------------------------------------------------------------------------------------------------
conversion minuscules/majuscules des chaînes accentuées pose un problème si on emploie strtoupper: en fonction des paramètres locaux de la machine, ils restent en minuscule.
solution: employez mb_strtoupper()  qui utilise l'unicode (et passe donc sur la majorité des systèmes).
--------------------------------------------------------------------------------------------------------
RANDOM ROW :)
$B =& new Q("SELECT * FROM mod_ec_blogs WHERE actif=1 ");
$B->V[0] = $B->V[rand(0, (count($B->V)-1))];
--------------------------------------------------------------------------------------------------------
Cette vulnérabilité permet par exemple d’outrepasser le contrôle
d’authentification. Si un attaquant saisit le login admin’# dans l’écran
de connexion, le mot de passe ne sera pas vérifié et le site considérera
que l’utilisateur admin est connecté.
--------------------------------------------------------------------------------------------------------

function phpWrapper($string) {
    ob_start();
    //$content = str_replace('<'.'?php','<'.'?',$content);
    //eval('?'.'>'.trim($content).'<'.'?');
       eval("$string[2];");
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function eval_html($string) {
    return preg_replace_callback("/(<\?php|<\?)(.*?)\?>/si", "phpWrapper", $string);
}
// $content = file_get_contents('feedback.php');
$content = phpWrapper($content);
      
--------------------------------------------------------------------------------------------------------
Ceci est une copié éhontée de http://virginie.mathey.co.uk/index.php?2...urs-en-php parce que je ne tient pas à perdre ce tutorial
Tout développeur sait qu'après l'écriture des attributs d'une classe vient la fastidieuse tâche de rédaction des accesseurs. Alors, plutôt que de perdre son temps à faire un get et un set par attribut pourquoi ne pas simuler les accesseurs et en écrire seulement deux génériques ?
Pour ce faire, il faut connaître la méthode __call de PHP. Cette dernière permet d'attraper tout appel à une méthode inexistante.
L'exemple de code suivant permet d'accèder aux attributs lastname, firstname et age en simulant les get et set correpondant:
La class utils qui simule les accesseurs:
Code PHP :
abstract class utils
{
        public function __call( $_method, $_attributes )
        {
                $prefix = substr( $_method, 0, 3 );
                $suffix = substr( $_method, 4 );
                $c_attributes = count( $_attributes );
             
                if( property_exists( $this, $suffix ) )
                {
                        if( $prefix == 'set' && $c_attributes )
                        {
                                return $this->set( $suffix, $_attributes[0] );
                        }
                        if( $prefix == 'get' && !$c_attributes )
                        {
                                return $this->get( $suffix );
                        }
                }
             
                else
                {
                        trigger_error( "The method ". $_method ." does not exist",
                                                E_USER_ERROR );
                }
        }
}
La classe possèdant les attributs:
Code PHP :
require 'utils.php'
class user extends utils
{
        // Attributs
        protected $lastname;
        protected $firstname;
        protected $age;
        // Get et Set génériques
        public function get( $_v )
        {
                return $this->$_v;
        }
        public function set( $_v, $_a )
        {
                $this->$_v = $_a;
        }
}
Création d'un objet et accès aux attributs (appel des accesseurs simulés):
Code PHP :
// Création d'un objet user
$paul = new user();
// Affectation des attributs
$paul->set_lastname( "dupont" );
$paul->set_firstname( "arnaud" );
$paul->set_age( 25 );
// Lecture des attributs
echo "Nom: " . $paul->get_lastname() . "
";
echo "Prénom: " . $paul->get_firstname() . "
";
echo "Age: " . $paul->get_age() . "
";
--------------------------------------------------------------------------------------------------------
ALPHABET

for ($i='a';$i!='aa';$i++) {
        echo strtoupper($i);
}

--------------------------------------------------------------------------------------------------------
SIMPLE TABLE

$col = '3';
$i = 0;
$html = '<table>';
foreach($arr_gal as $myImg) {
    if ($i == 0) $html .= '<tr>'; // FIRST LIGNE
    else if ($i % $col == 0) $html .= '</tr><tr>'; // INTER-LIGNE
 
    $html .= '<td><a href="'.$myImg['link'].'" target="_blank"><img src="'.$myImg['img'].'" border="0" /></a></td>'; // width="70" height="50"
 
    if (($i+1) == count($arr_gal)) {
        $i++;
        while($i % $col != 0) {
            $html .= '<td bgcolor="#F4F4F4">&nbsp;</td>';
            $i++;
        }
        $html .= '</tr>';
    }
    $i++;
}
$html .= '</table>';

--------------------------------------------------------------------------------------------------------
SIMPLE SWITCH DIFFERENT TYPE/GENRE/CAT...

$type_ex = '';
foreach ($R->V as $u=>$V) {

    if ($V['type'] != $type_ex) {  
        // ENTETE
    }

    // HERE THE ROW

    if ($R->V[($u+1)]['type'] != $V['type']) {
        // FOOTER
    }
    $type_ex = $V['type'];

}

--------------------------------------------------------------------------------------------------------

class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}


//image should be a file path to the image you just uploaded, and moved.
$image = $target_path;
$thumb = new SimpleImage();
$thumb->load($image);
$width = 50;
$height = 50;
$thumb->resize($width,$height);
$thumb->save($thumbDirectory . $newImageName); 

--------------------------------------------------------------------------------------------------------
ini_set('default_socket_timeout',    120); 
$a = file_get_contents("http://abcxyz.com");
$this->html .= eval(file_get_contents($this->data[$i]['inc']));
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreatefrompng("images/button1.png");
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagestring($im, 3, $px, 9, $string, $orange);
imagepng($im);
imagedestroy($im);
--------------------------------------------------------------------------------------------------------
CALENDRIER
--------------------------------------------------------------------------------------------------------
<?php
  $sel_date = isset($_REQUEST['sel_date']) ? $_REQUEST['sel_date'] : time();
  if( isset($_POST['hrs']) ){
     $t = getdate($sel_date);
     $sel_date = mktime($_POST['hrs'], $_POST['mins'], $t['seconds'], $t['mon'], $t['mday'], $t['year']);
  }
  $t = getdate($sel_date);
  $start_date = mktime($t['hours'], $t['minutes'], $t['seconds'], $t['mon'], 1, $t['year']);
  $start_date -= 86400 * date('w', $start_date);
 
  $prev_year = mktime($t['hours'], $t['minutes'], $t['seconds'], $t['mon'], $t['mday'], $t['year'] - 1);
  $prev_month = mktime($t['hours'], $t['minutes'], $t['seconds'], $t['mon'] - 1, $t['mday'], $t['year']);
  $next_year = mktime($t['hours'], $t['minutes'], $t['seconds'], $t['mon'], $t['mday'], $t['year'] + 1);
  $next_month = mktime($t['hours'], $t['minutes'], $t['seconds'], $t['mon'] + 1, $t['mday'], $t['year']);
?>
<form method="post">
<table width="180" border="0" cellspacing="1"
  style="border: 1px solid black; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; text-align: center">
  <tr>
    <td width="14%" bgcolor="#66FF99">
       <a href="?sel_date=<?= $prev_year ?>" style="text-decoration: none" title="Prevous Year">&lt;&lt;</a></td>
    <td width="14%" bgcolor="#66FF99">
       <a href="?sel_date=<?= $prev_month ?>" style="text-decoration: none" title="Prevous Month">&lt;</a></td>
    <td colspan="3" bgcolor="#66FF99">
       <?= date('M Y', $sel_date) ?>
    </td>
    <td width="14%" bgcolor="#66FF99">
       <a href="?sel_date=<?= $next_month ?>" style="text-decoration: none" title="Next Month">&gt;</a></td>
    <td width="14%" bgcolor="#66FF99">
       <a href="?sel_date=<?= $next_year ?>" style="text-decoration: none" title="Next Year">&gt;&gt;</a></td>
  </tr>
  <tr>
    <td bgcolor="#0099FF">Sun</td>
    <td bgcolor="#0099FF">Mon</td>
    <td width="14%" bgcolor="#0099FF">Tue</td>
    <td width="14%" bgcolor="#0099FF">Wed</td>
    <td width="14%" bgcolor="#0099FF">Thu</td>
    <td bgcolor="#0099FF">Fri</td>
    <td bgcolor="#0099FF">Sat</td>
  </tr>
  <?php
     $day = 1;
     for($i = $start_date; $day <= 42; $i+=86400, $day++){
        if( $day % 7 == 1 ) echo "<tr>\n";     
        if( $t['mon'] == date('n', $i ) )
           if( $i == $sel_date )
              echo ' <td bgcolor="gold">'. date('j', $i) ."</td>\n";
           else
              echo ' <td><a href="?sel_date='. $i .'" style="text-decoration: none">'. date('j', $i) ."</a></td>\n";
        else
           echo ' <td ><a href="?sel_date='. $i .'" style="text-decoration: none"><font  color="silver">'. date('j', $i) ."</font></a></td>\n";             
        if( $day % 7 == 0 )  echo "</tr>\n";
     }
  ?>
  <tr>
    <td colspan="7" align="left" bgcolor="silver">Time:
    <select name="hrs" onChange="document.forms[0].submit()">
    <?php
       for($i = 0; $i < 24; $i++)
          echo '   <option '. (date('G', $sel_date)==$i ? 'selected':'') .'>'. sprintf('%02d', $i) ."</option>\n";
    ?>
    </select>:
    <select name="mins" onChange="document.forms[0].submit()">
    <?php
        for($i = 0; $i < 60; $i++)
           echo '   <option '. (date('i', $sel_date)==$i ? 'selected':'') .'>'. sprintf('%02d', $i) ."</option>\n";
    ?>
    </select> hrs
    <input type="hidden" name="sel_date" value="<?= $sel_date ?>"> 
    </td>
  </tr>
</table>
</form>
--------------------------------------------------------------------------------------------------------
PAGINATION
--------------------------------------------------------------------------------------------------------
$page = ( !empty($_GET['page']) ? intval($_GET['page']) : 1 );
$offset = 6;
// How many ?
                $I =& new Q(" SELECT id FROM indices_p WHERE actif='1' AND type='0' ");
                //if (count($I->V) < 1) alert('Aucun indice photo n\'est accessible, désolé','back');
             
                $total = count($I->V);
                $nbpage = ceil($total/$offset);
                if ($page > $nbpage) $page = 1;
                $pageHtml = $startPageHtml = $endPageHtml = '';
                if ($nbpage > 1) {
                    if ($page > 1) $startPageHtml = '<a href="voir_photo.php?page='.($page-1).'" title="Page précédante" class="fleche">&lt;</a>';
                    for ($p=1; $p<=$nbpage; $p++) {
                        $pageHtml .= ' '.($page!=$p?'<a href="voir_photo.php?page='.$p.'">':'<span class="on">').$p.($page!=$p?'</a>':'</span>');
                        if ($p<=($nbpage-1)) $pageHtml .= ' - ';
                    }
                    if ($page < $nbpage) $endPageHtml = '<a href="voir_photo.php?page='.($page+1).'" title="Page suivante" class="lien_pagination">&gt;</a>';
                    else $endPageHtml = '&nbsp;';
                }
         
                // FETCH ALL LISTE...
                if ($page > 1) $debut = ($page-1) * $offset;
                else $debut = 0;
             
                $I =& new Q(" SELECT * FROM indices_p WHERE actif='1' AND type='0' ORDER BY date DESC LIMIT $debut,$offset ");
                //if (count($I->V) < 1) alert('Aucun indice photo n\'est accessible, désolé','back');
----------------------
$cat_id = '4';
$debut = ( isset($_GET['debut']) && intval($_GET['debut']) > 0 ? $_GET['debut'] : 0);
$offset = 2;
                <h1><span>les réactions</span></h1><?
                $S =& new Q(" SELECT * FROM commentaires WHERE actif='1' AND cat_id='$cat_id' ORDER BY date ASC LIMIT $debut,$offset ");
                if (count($S->V) < 1) {
                    ?><div class="reaction" style="padding-top:0px;">                 
                    <br />
                    <br />
                    <h2 align="center">Pas de réaction pour le moment</h2><br />
                    <br />
                    </div><?
                }
                else {
                    for($i=0; $i<count($S->V); $i++) {
                        ?><div class="reaction" style="<?=($i%2==0?'padding-top:0px;':'background-color:#e2d8c5;');?>">                 
                        <h2><?=printDateTime($S->V[$i]['date'],2);?></h2>
                        <h3><?=aff($S->V[$i]['titre']);?></h3>
                        <p><?=aff($S->V[$i]['commentaire']);?></p>
                        <h4><?=aff($S->V[$i]['nom']);?></h4>
                        </div><?
                    }
                }
                ?><div class="pied_reaction"><?
                if ($debut > 0) { ?><a href="indice.php?cat_id=<?=$cat_id;?>&debut=<?=($debut-$offset);?>" class="prec">précédent</a><? }
                $debut += $offset;
                $S =& new Q(" SELECT * FROM commentaires WHERE actif='1' AND cat_id='$cat_id' ORDER BY date ASC LIMIT $debut,$offset ");
                if (count($S->V) > 0) { ?><a href="indice.php?cat_id=<?=$cat_id;?>&debut=<?=$debut;?>" class="suiv">suivant</a><? } ?> 
                </div>
--------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------
NOTE ON MAGIC METHODS:

    * Magic methods are the members functions that is available to all the instance of class
    * Magic methods always starts with “__”. Eg. __construct
    * All magic methods needs to be declared as public
    * To use magic method they should be defined within the class or program scope

Various Magic Methods used in PHP 5 are:

    * __construct()
    * __destruct()
    * __set()
    * __get()
    * __call()
    * __toString()
    * __sleep()
    * __wakeup()
    * __isset()
    * __unset()
    * __autoload()
    * __clone()


__construct()
This methods gets called whenever an object of a class is instantiated. This method is a part of Object Oriented Programming concept in PHP 5. To know more about this methods refer PHP 5 Tutorial - __construct Method.


__destruct()
This methods gets called whenever an object of a class is destroyed or object goes out of scope. This method is a part of Object Oriented Programming concept in PHP 5. To know more about this methods refer PHP 5 Tutorial - __destruct Method.


__set()
This methods get automatically called whenever you assigns data to a undefined attributes of an class in PHP 5. To know more about this method refer PHP 5 Tutorial - __set() magic method.


__get()
This methods get automatically called when you try to retrieves the data of undefined attributes of an class in PHP 5. To know more about this method refer PHP 5 Tutorial - __get() magic method.


__call()
This methods get automatically called you call and undefined methods of an class in PHP 5. To know more about this method refer PHP 5 Tutorial - __call() magic method.


__toString()
This method is called whenever an class object is treated as string and is echo or print(). This methods is very useful if you want to check the object methods and attributes. To know more on this method refer PHP 5 Tutorial - __toString magic method.


__sleep()
This methods gets called when you serialize the object in PHP 5. With this method call we can define the way how the data object will be stored. To know more on this method refer PHP 5 Tutorial - __sleep magic method.


__wakeup()
This methods gets called when the object is about to be unserialized in PHP 5. With this method call we can do necessary initial operation before starting operation on the received data object. To know more on this method refer PHP 5 Tutorial - __wakeup magic method.


__isset()
This methods get automatically called whenever you try to check the existence of the undeclared attributes of the class using isset function of PHP. To know more about this method refer PHP 5 Tutorial - __isset() magic method.


__unset()
This methods get automatically called whenever you try to check the destroy or clear an undeclared attributes of the class using unset function of PHP. To know more about this method refer PHP 5 Tutorial - __unset() magic method.


__autoload()
This methods get automatically called whenever you try to load an object of class which resides in separate file and you have not included those files using include,require and include_once. To use this method it is mandatory to the PHP filename as that of the class name because this methods accepts the class name as the argument. To know more about this method refer PHP 5 Tutorial - __autoload() magic method.


__clone()
PHP5 has introduced clone method which creates an duplicate copy of the object. __clone methods automatically get called whenever you try to call clone methods in PHP 5. This operator does not creates a reference copy. To know more about this method refer PHP5 Tutorial - __clone() magic method.


--------------------------------------------------------------------------------------------------------

master.pdf?type=1
Sur un serveur Apache, ouvrir le fichier httpd.conf (../Apache2/conf/httpd.conf)
Recherchez le mot "AddType" (Ctrl + F)
Ajoutez à la suite de AddType application/x-httpd-php .php les lignes suivantes :
AddType application/x-httpd-php .js
AddType application/x-httpd-php .jpg
AddType application/x-httpd-php .pdf
Enregistrez le fichier et redémarrez votre serveur apache.
Sur votre serveur, créez le fichier master.pdf :
<?php
header('Content-type: application/pdf');
if ($_GET['type'] == 1){
readfile('original_1.pdf');
}elseif ($_GET['type'] == 2){
readfile('original_2.pdf');
}
?>
Vous pouvez tester en allant sur /master.pdf?type=1, vous n'aurez pas le même contenu que si vous allez sur /master.pdf?type=2
Il faut bien entendu placer 2 fichiers PHP nommés original_1.pdf et original_2.pdf
Mise en garde : Faites bien attention aux extensions que vous déclarez car si vous permettez à des utilisateurs d'uploader des fichiers sur le serveur. Ayez bien en tête que les fichiers pourront s'exécuter comme des scripts PHP
--------------------------------------------------------------------------------------------------------
http://www.phpriot.com/d/articles/client-side/sortable-lists-with-php-and-ajax/index.html
GOOGLE HACK
MP3
{-inurl:(htm|html|php) intitle:"index of" +"last modified" +"parent directory" +description +size +(wma|mp3) "AEIOU"}
intitle:index.of "mp3" +"Daft Punk" -htm -html -php -asp "Last Modified"
________________________________________________________________________
Le tableau a 420 lignes, et consomme 326 ko, mais réclame jusqu'à 5 Mo de mémoire!
Une solution équivalente avec var_export permet de réduire le coût à 1,2 Mo, mais sacrifie la lisibilité du code.
Une autre solution basée sur serialize réduit encore le coût mémoire à 900 ko, mais ralentit le script.
________________________________________________________________________
Take image from http:// and write it..
$file = join('',file('http://www.google.com/intl/fr_ALL/images/logo.gif'));  
writeFile($wwwRoot.'temp/logo.gif',$file);
________________________________________________________________________
<VirtualHost 127.0.0.1>
    ServerAdmin webmaster@saintdesprit.org
    ServerName localhost.saintdesprit.org
    ServerAlias molokoloco.localhost.saintdesprit.org
    ServerAlias dummy.localhost.saintdesprit.org
    DocumentRoot "c:/www/www.saintdesprit.wordpress.org/"
 
    <Directory "c:/www/www.saintdesprit.wordpress.org">
        Options Indexes MultiViews FollowSymLinks
        AllowOverride FileInfo Options
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
<VirtualHost 127.0.0.1>
    ServerAdmin webmaster@saintdesprit.org
    ServerName www
    DocumentRoot "c:/www/"
</VirtualHost>
________________________________________________________________________
// SORT ARRAY ////////////////
$people = array();
$people[0]['id'] = 3;
$people[0]['name'] = "Zave";
$people[1]['id'] = 2;
$people[1]['name'] = "Alex";
$people[2]['id'] = 1;
$people[2]['name'] = "Chris";
function cmp($a, $b) {
    if ($a == $b) return 0;
    return ($a > $b) ? +1 : -1; // strcmp($a['name'], $b['name'])
}
uasort($people, "cmp"); // uasort : preserve key
db($people);
// EXTRACT /////////////////
$taille = "grand";
$var_array = array(
    "couleur" => "bleu",
    "taille"  => "moyen",
    "forme"   => "sphere"
);
extract($var_array, EXTR_PREFIX_SAME, "wddx");
echo "$couleur, $taille, $forme, $wddx_taille\n";
>>> bleu, grand, sphere, moyen
La variable $taille n'a pas été réécrite, car on avait spécifié le paramètre EXTR_PREFIX_SAME, qui a permis la création de $wddx_taille. Si EXTR_SKIP avait été utilisée, alors $wddx_taille n'aurait pas été créé. Avec EXTR_OVERWRITE, $taille aurait pris la valeur "moyen", et avec EXTR_PREFIX_ALL, les variables créées seraient $wddx_couleur, $wddx_taille et $wddx_forme
// don't ever call this file directly!
if( strpos( $_SERVER["REQUEST_URI"], 'index-install.php' ) ) {
    header( "Location: index.php" );
    die();
}

________________________________________________________________________
<?
/*
 socketJpeg.php
 2007 by Sascha Tayefeh
 This script
 1. Opens a socket to a server
 2. Sends a GET-request
 3. Reads the header
 4. Sends a jpeg-header to your browser
 5. Sends the jpeg to your server
*/
$server="www.ilenvo.de";
$pic ="/kunden/sascha/pb/blog/1170195444-viper.jpg";
$fp = fsockopen($server, 80, $errno, $errstr, 30);
if (!$fp) {
   echo "$errstr ($errno)<br />\n";
} else {
   $out = "GET $pic HTTP/1.1\r\n";
   $out .= "Host: $server\r\n";
   $out .= "Connection: Close\r\n\r\n";
   fwrite($fp, $out);
   $img="";
   $fill=0;
   while (!feof($fp)) {
      /*
      $buffer = fgets($fp, 1024);
      echo strlen($buffer)." - ".$buffer;
      echo "<br>";
      */
      /* Comment this for printing the header */
      if($fill==0)
      {
     $buffer = fgets($fp, 1024);
     if (strlen($buffer)==2) $fill=1;
      } else if($fill==1)
      {
     $img.=fgets($fp, 1096);
      }
      /**/
   }
   fclose($fp);
   $len=strlen($img);
   header('Content-type: image/jpeg');
   header("Content-Length: $len");
   echo $img;
}
?>
________________________________________________________________________
session_start();
@print_r($_SESSION["zip"]); echo "<br><br>";
// Ajout d'un fichier au zip virtuel
if(!empty($_GET["addfile"])) {
   $_SESSION["zip"][] = $_GET["addfile"];
   $_SESSION["zip"] = array_unique($_SESSION["zip"]); // dédoublonne
   header("Location: ".$_SERVER["PHP_SELF"]);
}
// Téléchargement du zip
if(!empty($_GET["dwnzip"])) {
   include("zip.lib.php");
   $zipfile = new zipfile();
   foreach($_SESSION["zip"] as $value)
      if(file_exists($value))
         $zipfile -> addFile(implode("",file($value)),basename($value));
   header("content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=selection.zip");
   flush();
   print $zipfile -> file();
   exit();
}
// Vider le zip
if(!empty($_GET["videzip"])) {
   unset($_SESSION["zip"]);
   header("Location: ".$_SERVER["PHP_SELF"]);
}
// Affichage du directory
$rep = "./";
$dir = opendir($rep);
while($f = readdir($dir))
   if(is_file($rep.$f))
      echo "<a href='?addfile=".$rep.$f."' title='Zip this file'>".$f."</a><br>";
closedir($dir);
?>
<br><a href="?dwnzip=ok">Télécharger le zip (<?echo @sizeof($_SESSION["zip"])?> fichiers)</a>
- <a href="?videzip=ok">Vider le zip</a>

________________________________________________________________________

$files = glob('*.{php,txt}', GLOB_BRACE);  
print_r($files);  

// output looks like: 
# Array 
# ( 
#     [0] => phptest.php 
#     [1] => pi.php 
#     [2] => post_output.php 
#     [3] => test.php 
#     [4] => log.txt 
#     [5] => test.txt 
# )

________________________________________________________________________

# // generate unique string  
# echo uniqid();

________________________________________________________________________

// When you use register_shutdown_function(), your code will execute no matter why the // script has stopped running:

$start_time = microtime(true);  
   
register_shutdown_function('my_shutdown');  
  
// do some stuff  

function my_shutdown() {  
     global $start_time;  
   
     echo "execution took: ".(microtime(true) - $start_time)." seconds.";  
}  
________________________________________________________________________

XML OUTPUT INPUT XML OUTPUT INPUT XML OUTPUT INPUT XML OUTPUT INPUT
    // PHP GENERATE XML //////////////////////////////////////////////////
 
    $G = new SQL('');
    $XML = $G->XML_DataOutput("
        SELECT id,titre,texte,miniature,
        CONCAT('".$WWW."galeries.php?galerie_id=',id) url
        FROM galeries
        WHERE membre_id='$membre_id' AND actif='1'
        ORDER BY ordre ASC, id DESC
    ",array('galeries','galerie'));
    $dir = './'.$_SESSION['MEMBRE']['url'].'/';
    writeFile($dir,'galeries_list.xml',$XML);
 
    // XML ////////////////////////////////////////////////////////
 
    <?xml version="1.0" encoding="UTF-8"?>
    <galeries>
        <galerie>
            <id><![CDATA[11]]></id>
            <titre><![CDATA[sqfdqfq]]></titre>
            <texte><![CDATA[]]></texte>
            <miniature><![CDATA[070220152107_arbre.jpg]]></miniature>
            <url><![CDATA[http://localhost/www.saintdesprit2.net/galeries.php?galerie_id=11]]></url>
        </galerie>
 
    // XML TO PHP TO HTML ////////////////////////////////////////////////////////
 
    $data = GetXMLTree('./'.$_SESSION['MEMBRE']['url'].'/tags_list.xml');
    if (count($data) > 0) {
        foreach ($data['mots']['mot'] as $motSel) {
            echo '<option value="MOT_ID_'.affXml($motSel['id']).'">- '.affXml($motSel['titre']).'</option>
            ';
        }
    }
 
________________________________________________________________________
PHP RESERVED KEYWORDS
and  or  xor  __FILE__  exception (PHP 5)
__LINE__  array()  as  break  case
class  const  continue  declare  default
die()  do  echo()  else  elseif
empty()  enddeclare  endfor  endforeach  endif
endswitch  endwhile  eval  exit()  extends
for  foreach  function  global  if
include()  include_once()  isset()  list()  new
print()  require()  require_once()  return()  static
switch  unset()  use  var  while
__FUNCTION__  __CLASS__  __METHOD__  final (PHP 5)  php_user_filter (PHP 5)
interface (PHP 5)  implements (PHP 5)  extends  public (PHP 5)  private (PHP 5)
protected (PHP 5)  abstract (PHP 5)  clone (PHP 5)  try (PHP 5)  catch (PHP 5)
throw (PHP 5)  cfunction (PHP 4 uniquement)  old_function (PHP 4 uniquement)  this (PHP 5 uniquement)
________________________________________________________________________
DESTROY cookies
$cookiesSet = array_keys($_COOKIE);
for ($x=0;$x<count($cookiesSet);$x++) setcookie($cookiesSet[$x],"",time()-1);
________________________________________________________________________
Apply fonction to ARRAY
$motsArr = explode(',',$galerie_mots);
function cleanMotArr($m) { return trim($m); }
$motsArr = array_map("cleanMotArr", $motsArr);

________________________________________________________________________

if (isset($albus))  $albert = $albus;
else                $albert = NULL;
// is equivalent to:
$albert = @$albus;
// A better solution is to assign the variable by reference, which will not trigger any notice
$albert =& $albus
________________________________________________________________________     
RECHERCHE
if (navigator.appVersion.indexOf("Mac") != -1) whom.encoding = "multipart/form-data";
str_replace('_',' ',preg_replace("|[_0-9]{13}|",'','mails-_050802171336.txt'))
 
 
list ($j, $m, $a) = split ('[/.-]', $data['ANNONCE']['REFERENCES']['DATE']);
$delai = (($a = emailAdmin('nbjour')) > 0 ? $a : 30);
if ($j > 0 && $m > 0 && $a > 0) $datecampagne = date("Ymd",mktime(0,0,0,$m,($j+$delai),$a));
________________________________________________________________________
.HTACCESS
   1. <IfModule mod_gzip.c>
   2.   mod_gzip_on Yes
   3.   mod_gzip_item_exclude         file       \.(js|css)$
   4.   mod_gzip_item_exclude         file       \.gz$
   5.   mod_gzip_item_exclude         file       \.zip$
   6.   mod_gzip_item_exclude         mime       ^image/
   7. </IfModule>
Il suffit donc de spécifier explicitement, pour les objets qui induisent le scintillement, une durée de vie suffisante. Ainsi IE6 ne se croit plus obligé de rafraichir son cache à propos d'objets apparaissant encore valides. Nous proposons le paramétrage Http suivant :
Cache-Control : max-age=A36000
La durée de vie de l'objet transporté dans un message Http comportant cette entête sera de 36 000 secondes soit 10 heures. Le scintillement disparaît, et le navigateur n'ira plus chercher l'objet sur le serveur pendant 10 heures. On peut bien entendu allonger ce délai de manière à ce que des visites successives étalées sur quelques jours ne nécessitent pas le rapatriement des images.
Nous donnons ci-dessous le paramétrage Apache qui convient pour obtenir l'entête Http que nous avons proposé :
ExpiresActive On
ExpiresByType image/gif A36000
ExpiresByType image/jpeg A36000
ExpiresByType image/png A36000
ExpiresByType application/x-javascript A36000
ExpiresByType text/css A36000
Voici les conditions à remplir pour le fonctionnement de ce paramètrage :
    * Apache a chargé le module mod_expires.
    * Les différents types utilisés (image/gif, image/jpeg...) sont bien définis par ailleurs.
    * Chaque objet provoquant le scintillement est de l'un des types pour lesquels l'expiration est définie.
A noter qu'il est possible de forcer la mise en cache pour toute nature d'objet, et notamment c'est bien utile, pour les scripts et les feuilles de style.

# ErrorDocument-------------------------------------------

#404  - Not Found  
    ErrorDocument 404 http://www.ingelinks.com
#301 - Moved Permanently
    ErrorDocument 301 http://www.ingelinks.com
#302 - Moved Temporarily
    ErrorDocument 301 http://www.ingelinks.com

# URL REWRITING

1/ .htaccess
    #------Test UrlRewriting--------------------
    # seulement a,…z et –
    RewriteRule  ^([a-z,-]+)\.html$   blog.php [L]
    #------Test avec repertoire
    RewriteRule ^([a-z,-]+)/([a-z,-]+)\.html$ blog.php?imgroot=../ [L]
2/ Déclaration variables À déclarer dans la page:
    $imgroot = isset($_GET["imgroot"]) ? $_GET["imgroot"] : "";
3/ Modification chemin vers css, images, js
    <img src="<?=$imgroot;?>blog_fichiers/logo.gif" ….>


RewriteEngine on
RewriteBase /
 
# Section Domaine
RewriteCond %{HTTP_HOST} !^www\.eggdrop\.fr$
RewriteRule ^(.*) http://www.eggdrop.fr/$1 [QSA,L,R=301]
 
# Redirection d'ancien répertoire
RewriteRule ^forum/(.*)$ board/ [L,R=301]
 
# SEO forum
RewriteRule ^index.html$ index.php [L,NE]
RewriteRule ^board/(.*)-t-([0-9]+).html(.*)$ board/showthread.php?tid=$2$3 [QSA,L]
RewriteRule ^board/(.*)-t-([0-9]+)-([0-9]+).html$ board/showthread.php?tid=$2&page=$3 [QSA,L]
RewriteRule ^board/(.*)-f-([0-9]+).html(.*)$ board/forumdisplay.php?fid=$2$3 [QSA,L]
RewriteRule ^board/(.*)-f-([0-9]+)-([a-z]+)(-|-[a-z]+)-([0-9]+)-([0-9]+).html(.*)$ board/forumdisplay.php?fid=$2&sortby=$3&order=$4&datecut=$5&page=$6$7 [L]
RewriteRule ^board/(.*)-a-([0-9]+).html$ board/announcements.php?aid=$2 [L]
 
# URL rewriting général
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?title=$1 [L,QSA]


php_value memory_limit "16M"
php_value post_max_size "16M"
php_value upload_max_filesize "16M"
ErrorDocument 404 /erreur404.php



# REDIR VISITORS...

RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http://www.danslaprairie.fr/.*$ [NC]
RewriteRule ^(.*)$ http://www.danslaprairie.fr/ [R=301,L]



[L]    Celui-ci vous semble familier, comme nous l’avons vu dans notre précédent exemple. Il mérite toutefois une précision. Lorsque le module de réécriture est actif, les règles sont lues séquentiellement et l’URL est comparée ligne à ligne avec le premier argument de celles-ci jusqu’à la dernière.
Si une réécriture est effectuée, c’est la forme réécrite qui sera utilisée en entrée pour les règles suivantes.
Le flag [L] permet de sortir prématurément de la boucle.
Un autre exemple serait, en début d’une liste de règles :
    Nous introduisons ici un nouveau concept, à savoir un second argument vide (ou presque, car il consiste en un seul caractère « - » ) . Cette règle particulière implique qu’il n’y a pas de réécriture, l’URL étant passée sans modification aucune. Elle signale au serveur Apache de passer toutes les URL d’images gif ou jpg sans réécriture, ni traitement successif.
   
[R=code]    Dans ces deux formes une redirection est effectuée.
Si l’argument code n’est pas précisé, une redirection 302 (déplacé temporairement) est effectuée. Si vous souhaitez faire savoir au navigateur/robot qu’une page a été remplacée définitivement, utiliser le code 301 comme dans :
RewriteRule ^ancien\.html$ http://domaine.tld/nouveau.html [R=301,L]
Dans ce cas précis, une réécriture "externe" s’impose (utilisation de http://...)
    Vous voyez ci-dessus que nous avons combiné deux flags en les séparant par une virgule.

[F]    Forbidden - interdit. Retourne un code 403, par exemple :
RewriteRule ^secret.html$ - [F]
( pas de réécriture vu le deuxième argument - )

[NC]    NoCase, ou « insensible à la casse ». La règle suivante :
RewriteRule  ^script\.php$  programme.php  [NC,L]
S’appliquera aussi bien à script .php, SCRIPT.PHP ou ScRiPt .PhP

[G]    Gone. Cette page n’existe plus et retourne une entête http 410

[N]    Force l’analyse et l’exécution de toutes les règles en repartant du début de la liste. Ici encore, comme expliqué plus haut ([L]), c’est l’URL modifiée après exécution de la dernière règle qui est utilisée en entrée, et non l’URL originelle. Attention aux boucles infinies !!

[C]    Chain, chaînage avec la ou les règles suivantes jusqu’à la première règle ne se terminant pas par [C]
Apache interprète ce flag comme suit : s’il y a réécriture (la règle est vérifiée), la règle suivante est exécutée avec la chaîne réécrite en entrée.
Si la règle ne se vérifie pas, toutes les règles qui suivent jusqu’à la première ne comportant pas le flag [C] ne sont pas appliquées.

[QSA]    Query String Append. Rajoute le QUERY_STRING à la fin de l’expression, après la réécriture. A réserver pour la dernière règle de réécriture. Utilisée le plus souvent avec le flag [L], comme dans [QSA,L]



POU LES FICHIER HTML :

<base href="http://www.votresite.tld/repertoire/" >




________________________________________________________________________

#ROBOTS.TXT

User-agent: *
Disallow: /



________________________________________________________________________
CACHE
    Pour simplifier, on placera les fonctions dans deux fichiers à part, appelés avec la directive include() : lancer_cache.php et finir_cache.php.
   1. <?php
   2. $dossier_cache = '../cache/';
   3. $secondes_cache = 60*60*12; // 12 heures
   4.
   5. $url_cache = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   6. $fichier_cache = $dossier_cache . md5($url_cache) . '.cache';
   7.
   8. $fichier_cache_existe = ( @file_exists($fichier_cache) ) ? @filemtime($fichier_cache) : 0;
   9.
  10. if ($fichier_cache_existe > time() - $secondes_cache ) {
  11.   @readfile($fichier_cache);
  12.   exit();
  13.   }
  14. ob_start();
  15. ?>
    On voit que le début du script vérifie la présence du fichier et sa validité, et le cas échéant lance la procédure de mise en tampon, ob_start(). Après cela, la page se déroule comme prévu, et se termine par finir_cache.php :
   1. <?php
   2. $pointeur = @fopen($fichier_cache, 'w');
   3. @fwrite($pointeur, ob_get_contents());
   4. @fclose($pointeur);
   5. ob_end_flush();
   6. ?>
   Si l'on atteint finir_cache.php, c'est que le cache n'a pas été affiché et qu'un nouveau cache tampon a été créé. Il nous faut donc ouvrir un accès fichier, y placer le contenu du tampon, fermer le fichier... et envoyer le contenu du tampon vers le navigateur. Pendant les douze prochaines heures, c'est ce fichier cache qui sera envoyé au navigateur, économisant ainsi de nombreux accès inutiles au compilateur PHP et à la base MySQL.

_______________________________________________________________________________________

<?php
$nav = get_browser();
if (!$nav->frames) {
  ?>Votre navigateur ne supporte pas l'usage de frames<?
  }
if (!nav->cookies) {
  ?>Votre navigateur ne supporte pas l'usage de cookies<?
  }
if (!$nav->javascript) {
  ?>Votre navigateur ne supporte pas l'usage de JavaScript<?
  }
?>
____________________________________________________________
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam auctor erat vel est. Fusce elit nisl, tempor convallis, aliquam non, auctor tempus, orci. Nullam suscipit arcu quis lorem lobortis malesuada. Donec odio. Vestibulum erat libero, ultrices viverra, nonummy ut, fermentum ac, odio. Donec diam. Mauris et ligula eu est consequat interdum. Fusce mattis nibh non elit. Mauris a felis. Cras pulvinar magna. Cras interdum, ante nec lacinia tristique, velit felis iaculis tellus, varius consequat purus tortor eu neque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam interdum elementum ipsum. Vestibulum quis lacus. Suspendisse bibendum ipsum euismod purus. Ut ac augue. Praesent pharetra neque sed sem. Sed ac est. Praesent imperdiet consectetuer lacus.

Pellentesque eleifend laoreet nunc. Donec iaculis sem sed risus pellentesque rutrum. Integer in tortor. Phasellus aliquam, justo ut vulputate blandit, libero orci adipiscing turpis, sed tincidunt purus urna non nulla. Donec ut nisi. In auctor malesuada enim. Curabitur mattis suscipit felis. Mauris volutpat dui eget odio. In hac habitasse platea dictumst. Pellentesque dolor. In et leo elementum quam molestie faucibus.
____________________________________________________________
 
MAGIK TAILLE THUMB MINI (CARRE)
$TabTaille = explode('x',$taille);
$wantedwidth = $TabTaille[0];
$wantedheight = $TabTaille[1];
//echo ("wantedwidth = $wantedwidth || wantedheight = $wantedheight<br>");
if (intval($wantedwidth) <= 120) { $option = ' -contrast -contrast '; } // Plus de contraste si petite image...
$imagehw = getimagesize($file_img);
$width = $imagehw[0];
$height = $imagehw[1];
//echo ("width = $width || height = $height<br>");
$wantedwidth = $width < $wantedwidth ? $width : $wantedwidth;
$wantedheight = $height < $wantedheight ? $height : $wantedheight;
if ($width < $height) { $taille = $wantedwidth.'x'.$height; }
else { $taille = $height.'x'.$wantedheight; }
____________________________________________________________
 
------------------------------------------------------------------------
<?xml verion="1.0" encoding="utf-8" ?>
<?xml-stylesheet type="text/css" href="/maFeuilleCSS.css" ?>
<racine>
  <balise />
  ...
</racine>
 
racine {
background: white;
}
balise {
font-size: 36px;
}
 ____________________________________________________________
class calculator {
    var $c;
    function addition($a, $b) {
        $this->c = $a + $b;
        return $this->c;
    }
    function subtraction($a, $b) {
        $this->c = $a - $b;
        return $this->c;
    }
    function multiplication($a, $b) {
        $this->c = $a * $b;
        return $this->c;
    }
    function division($a, $b) {
        $this->c = $a / $b;
        return $this->c;
    }
}
$cc = new calculator;
echo $cc->addition(20, 10)."<br>";
// CLASS LIRE ARTICLE FROM ACTU...........................................................................................................
function lire_article($id)  {
    $sql = "SELECT id, titre, contenu, auteur, datepub FROM articles WHERE id = '$id' ";
    $rsql = mysql_query($sql);
    if (mysql_num_rows($rsql) == 0) {
      $this->id = -1;
      }
    else {
      $this->id = mysql_result($rsql, 0, "id");
      $this->titre = mysql_result($rsql, 0, "titre");
      $this->contenu = mysql_result($rsql, 0, "contenu");
      $this->auteur = mysql_result($rsql, 0, "auteur");
      $this->datepub = mysql_result($rsql, 0, "datepub");
      }
}
...
$monArticle = new article();
$monArticle->lire_article(5);
...
?>
Titre: "<? $monArticle->titre;?>"<br>
Contenu: "<? $monArticle->contenu;?>"<br>
?>
 ____________________________________________________________
<?  // SCAN DIR
//in this example, we'll say the directory is "images"
$list = scandir("images");
$i = 0;
$num = count($list);
while($i < $num){
print "<a href=\"images/$list[$i]\">$list[$i]</a><br />";
$i++;
}
?>
That will print all the files in the "images" directory linked to the files.
 ____________________________________________________________
if (!is_dir($galerie_dir)) { mkdir($galerie_dir, 0755); chmod($galerie_dir, 0777); }
if(Table_Exists("users") == false) {
    $images = "create table " . $User_Name . "_images (" .
            "id int primary key auto_increment, " .
            "file_name tinytext, " .
            "caption tinytext, " .
            "bytes blob)";
    @mysql_query($images);
}
$url = $PHP_SELF.'?'.str_replace('&login=NOLOGIN','',$HTTP_SERVER_VARS['QUERY_STRING']);
 ____________________________________________________________
 
 // RECUPERER AUTOMATIQUEMENT TOUS LES CHAMPS D'UNE TABLE
$requete=mysql_db_query("mabase","SELECT * FROM matable WHERE nom='toto'",$db_link);
$nb_champs = mysql_num_fields($requete);
$i=0;
while($i<$nb_champs)  {
    $nom_champs=mysql_field_name($requete,$i);
    $$nom_champs=mysql_result($requete,0,$nom_champs);
    $i++;
}
// DATE FRANCAISE
function datefr($jj, $mm, $aaaa)
  {
  $userDate = mktime(0,0,0,$mm,$jj,$aaaa);
  $jours = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
  $mois = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
  return $jours[date("w", $userDate)] . " " . $jj . " " .   $mois[date("n", $userDate)] . " " . $aaaa;
  }
<? echo "Nous sommes le " . datefr(date(d),date(m),date(Y)); ?>
// http://developpeur.journaldunet.com/tutoriel/php/010927php_fasttemplate.shtml
$A = new SQL($R1);
$A->LireSql(array('id')," password='$password' AND LOWER(titre)=('$login') AND actif='1' LIMIT 1 ");
             
____________________________________________________________
setcookie("connect", "1", time()+60*60*24*30); // 30 jours
isset($_COOKIE['connect'])
____________________________________________________________
FLASH SPECIAL CHAR
€‚ƒ„…†‡ˆ‰Š‹ŒŽ‘’“”•–—˜™š›œžŸ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýÿ
(!checkdnsrr ($domaine, "MX")) {
echo "<center>Ce domaine(<b><i>$domaine</i></b>) n'est pas valide.</center>";
array_push($errors, "mail");
ini_set('error_reporting', E_ALL);
 
chr(9)  --> TABULATION
chr(10)  --> new line
chr(13)  --> carriage return
http://www.lookuptables.com/
 
if (strpos($texte1,'[img]') !== false) { $texte1 = str_replace("[img]",$img,$texte1); }
// verif if a fonction exist...
if (!function_exists("imagecreatetruecolor")) { die ("Probleme de creation GD"); }
// ----------- ARRAY -----------------------------------//
PRINT ARRAY :
$t = array();
print_r($t);
function impair($var) {
   return ($var % 2 == 1);
}
function pair($var) {
   return ($var % 2 == 0);
}
$array1 = array ("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
print_r(array_filter($array1, "impair"));
// to delete all empty strings from an array:
$arr = array_diff($arr, array(''));
foreach($array as $key => $value) { }
$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
$key = array_search('blue', $array); // $key = 2;
echo $key;
if($key===FALSE){ echo "FALSE"; }
else{ echo "TRUE"; }
// ----------- FIN ARRAY -----------------------------------//
$SsTotal = round($SsTotal,2);
$TabSsTotal = explode('.',$SsTotal);
$SsTotal = $TabSsTotal[0].'.'.str_pad($TabSsTotal[1],2,'00');
echo $SsTotal;
$input = "Alien";
str_pad($input, 10);                      // affiche "Alien    "
str_pad($input, 10, "-=", STR_PAD_LEFT);  // affiche "-=-=-Alien"
str_pad($input, 10, "_", STR_PAD_BOTH);  // affiche "__Alien___"
str_pad($input, 6 , "___");              // affiche "Alien_"
If you would like to convert tabs to spaces, you could use the code:
str_replace("\t", "    ", $text);
list($a,$m,$j) = explode('-',$cmddate);
show_source // Génère la syntaxe colorisée d'un fichier PHP
basename() //  Sépare le nom du fichier et le nom du dossier
dirname() retourne le nom du dossier qui contient le fichier ou dossier path.
sleep(10); // stoppe pour 10 secondes
addslashes()  Ajoute des anti-slashes devant les caractères spéciaux $res = addslashes("L'a"); L\'a
stripslashes()  Retire les anti-slashes devant les caractères spéciaux. $res = stripslashes("L\'a"); L'a
dechex()  Retourne la valeur Hexadécimale d'un nombre (ici 2548). $res = dechex("2548"); 9f4
ceil() Retourne le nombre entier supérieur ici (12,1). $res = ceil("12.1"); * 13
float round ( float val [, int precision])
echo floor(4.3);  // 4
round() retourne la valeur arrondie de val à la précision precision (nombre de chiffres après la virgule).
echo round(3.4);        // 3
echo round(3.5);        // 4
echo round(3.6);        // 4
echo round(3.6, 0);      // 4
echo round(1.95583, 2);  // 1.96
echo round(1241757, -3); // 1242000
 
strip_tags() retourne la chaîne str après avoir supprimé toutes les balises PHP et HTML du code.
$texte=strip_tags($texte,"<b><i>"); // tout sauf b et i ...
chunk_split() Permet de scinder une chaîne en plusieurs morceaux. $res = chunk_split("DGDFEF","2","-"); DG-DF-EF-
htmlentities() Remplace les caractères par leur équivalent HTML (si ils existent).
$res = htmlentities("&"); &amp;
$texte="gérer les caractères";
html_entity_decode(Aff($var),ENT_NOQUOTES,'ISO-8859-15')
> faire l'inverse
function unhtmlentities($string){
   $trans_tbl = get_html_translation_table(HTML_ENTITIES);
   $trans_tbl = array_flip($trans_tbl);
   return strtr($string, $trans_tbl);
}
htmlspecialchars() Vous pouvez utiliser l'une des constantes suivantes :
ENT_COMPAT, la constante par défaut, va convertir les guillemets doubles, et ignorer les guillemets simples;
ENT_QUOTES va convertir les guillemets doubles et les guillemets simples;
ENT_NOQUOTES va ignorer les guillemets doubles et les guillemets simples.
"&" (et commercial) devient "&amp;"
""" (guillemets doubles) devient "&quot;" lorsque ENT_NOQUOTES n'est pas utilisé.
"'" (single quote) devient "&#039;" uniquement lorsque ENT_QUOTES est utilisé.
"<" (supérieur à) devient "&lt;"
">" (inférieur à) devient "&gt;"
strstr() Recherche le premier caractère 'p' dans la chaîne et affiche le reste de la chaîne y compris le 'p'. $res = strstr("webmaster@phpdebutant.com", "p"); phpdebutant.com
strlen() Retourne la longueur de la chaîne $res = strlen("lachainedecaracteres"); 20
strtolower() Passe tous les caractères en minuscules. $res = strtolower("LA CHAINE dE caRActERes"); la chaine de caracteres
strtoupper() Passe tous les caractères en MAJUSCULES. $res = strtoupper("LA CHAINE dE caRActERes"); LA CHAINE DE CARACTERES
str_replace() Remplace un caractère par un autre dans une chaîne. Tiens compte de la casse. $res = str_replace("a","o","Lalala"); Lololo
trim() Efface les espaces blancs (\n, \r, etc)  au début et à la fin d'une chaîne (pas au milieu). $res = trim("  Salut le monde   "); Salut le monde
ucfirst() Met la première lettre de chaque chaîne en Majuscule. $res = ucfirst("salut le monde. ca va ?"); Salut le monde. ca va ?
ucwords() Met la première lettre de chaque mot d'une chaîne en Majuscule. $res = ucwords("salut le monde"); Salut Le Monde
strpos() Recherche la position du premier caractères trouvé. Retourne le nombre de caractères placés avant lui (ici 4). $res =
strpos("abcdef","e"); 4
ereg() Recherche si une chaîne de caractère est contenue dans une autre (ex. recherche si "ABCDE" contient "BCD"). if(ereg("BCD","ABCDEF"))
{echo "oui";} else {echo "non";} oui
nl2br -- Insère des retours à la ligne HTML à chaque nouvelle ligne. string nl2br ( string string). nl2br retourne string apràs avoir inséré '<br />' devant toutes les nouvelles lignes.
if (strlen($emissionImgName) > 8) { $emissionImgName = substr($emissionImgName, 0, 8).'...'; }
explode()
EXEMPLE : $pizza  = "pièce1 pièce2 pièce3 pièce4 pièce5 pièce6";
$pieces = explode(" ", $pizza);
echo $pieces[0]; // pièce1
echo $pieces[1]; // pièce2
$array = array('nom', 'email', 'telephone');
$comma_separated = implode(",", $array);
echo $comma_separated; // nom,email,telephone
 if(substr($Filename, -3, 3) == "jpg") {   //its a jpeg }
 
 $date_fin = substr($Produits[date_fin],6).'/'.substr($Produits[date_fin],4,-2).'/'.substr($Produits[date_fin],0,4);
 
$rest = substr("abcdef", 1);    // retourne "bcdef"
$rest = substr("abcdef", 1, 3); // retourne "bcd"
$rest = substr("abcdef", 0, 4); // retourne "abcd"
$rest = substr("abcdef", 0, 8); // retourne "abcdef"
$string = 'abcdef';
echo $string{0};                // retourne a
echo $string{3};                // retourne d
$rest = substr("abcdef", -1);    // retourne "f"
$rest = substr("abcdef", -2);    // retourne "ef"
$rest = substr("abcdef", -3, 1); // retourne "d"
$rest = substr("abcdef", 0, -1);  // retourne "abcde"
$rest = substr("abcdef", 2, -1);  // retourne "cde"
$rest = substr("abcdef", 4, -4);  // retourne ""
$rest = substr("abcdef", -3, -1); // retourne "de"
 while(isset($values[$i])) { }
 
die(header('Location: index2.php?goto=espace')); // Reset
header("Refresh: $sec; url=http://www.php.net");
 ____________________________________________________________
<?
foreach ($_SESSION['Tab_lo'] as $key => $TabSelect_ca) {
    $type_idSelect = $_SESSION['Tab_type_lo'][$key];
    if ($type_idSelect == $type_id && $TabSelect_ca == $g_lo) { $Deja = 1; break; }
}
?>
 ____________________________________________________________
 
 echo date("d/m/Y",mktime(0,0,0,date("m"),date("d")+3,date("Y")));  // DATE DANS 3 JOURS
 
_____________________________________________________________
HIDE EMAIL IN SOURCE
<script type="text/javascript"><!--
var E = "ptellier[ARO]tellier.fr"; var Xx = new RegExp("[ARO]", "i"); E = E.replace(Xx, "@");
document.write('<a href="mailto:'+E+'?subject=Visiteur Site Tellier">'+E+'</a>'); //-->
</script>
_____________________________________________________________
<?php
// Pour cet exemple nous supposerons que PHP_VERSION => 4.1.0
$variable = $_GET['variable'];
$nom = 'phpdeb';
// affichage de la variable demandée par le visiteur
if($variable == 'nom'){
    echo $$variable;
}
// ce qui affiche 'phpdeb'
?>
___________________________________________________________
<script language="Javascript1.2">
<!--
_editor_url = "../admin/lib/htmlarea/"; // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
    document.write('<scr'+'ipt'+' language="Javascript1.2" type="text/JavaScript"'>);
    document.write(' </scr' + 'ipt>');
}
//-->
</script>
_____________________________________________________________
$a == $b Equal TRUE if $a is equal to $b.
$a === $b Identical TRUE if $a is equal to $b, and they are of the same type. (PHP 4 only)
$a != $b Not equal TRUE if $a is not equal to $b.
$a <> $b Not equal TRUE if $a is not equal to $b.
$a !== $b Not identical TRUE if $a is not equal to $b, or they are not of the same type. (PHP 4 only)
$a < $b Less than TRUE if $a is strictly less than $b.
$a > $b Greater than TRUE if $a is strictly greater than $b.
$a <= $b Less than or equal to TRUE if $a is less than or equal to $b.
$a >= $b Greater than or equal to TRUE if $a is greater than or equal to $b.
_____________________________________________________________
&& (et) $a && $b $a et $b retournent TRUE
AND (et) $a and $b $a et $b retournent TRUE *
|| (ou) $a || $b $a ou $b retourne TRUE
OR (ou) $a or $b $a ou $b retourne TRUE *
XOR (ou exclusif) $a xor $b $a ou $b (exclusivement) retourne TRUE
! (faux) ! $a $a retourne FALSE
_____________________________________________________________
if (!file_exists($filedir)) { mkdir($filedir,0777); }
else { @chmod($filedir,0777); }
_____________________________________________________________
<?php
session_start();
session_register("nom_variable");
echo $HTTP_SESSION_VARS["nom_variable"];
$Session_ID = session_id();
$nom_session = session_name();
$adresse = 'http://www.site.com/doc.html';
$lien = 'Le prochain document';
print_f('<a href="%s?%s=%s">%s</a>', $adresse_url, $nom_session, $Session_ID, $lien);
echo '<a href="' . $adresse_url . SID . '">' . $lien . '</a>'
/* affichent <a href="http://www.site.com/doc.html?PHPSESSID=7edf48ca359ee24dbc5b3f6ed2557e90">Le prochain document</a> */
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date du passé
// Vous voulez afficher un pdf
header('Content-type: application/pdf');
// Il sera nommé downloaded.pdf
header('Content-Disposition: attachment; filename="downloaded.pdf"');
// Le source du PDF original.pdf
readfile('original.pdf');
// redirection automatique
header("Location:" . "$adresse . "?" . SID);
Si la directive de compilation --enable-trans-sid est activée, il sera possible de ne pas ajouter l'identifiant de session à l'adresse URL pointée. Pour savoir si cela est le cas, il suffit de rechercher la directive dans la page résultant de la fonction phpinfo ou sinon de modifier l'option de configuration session.use_trans_sid dans php.ini.
[Session]
session.use_trans_sid = 1Par défaut, PHP tente de passer par les cookies pour sauvegarder l'identifiant de session dans le cas où le client les accepterait. Pour éviter cela, il suffit de désactiver l'option de configuration session.use_cookies dans le fichier php.ini.
[Session]
session.use_cookies = 0; désactive la gestion des sessions par cookieDans la situation ou il serait nécessaire d'utiliser les cookies, il est impératif de doubler les moyens de conservation du SID.
<?
session_start();
$nom = $cNom;
$prenom = $cPrenom;
$email = $cEmail;
session_register("nom");
session_register("prenom");
session_register("email");
header("Location: session.php?" . session_name() . "=" . session_id());
?>
<!-- Fichier : session.php -->
<?
session_start();
?>
<html>
<body>
<?
echo("<u>Identifiant de session :</u> <b>"
                  . session_id() . "</b><br>");
echo("<u>Nom de la session :</u> <b>"
                  . session_name() . "</b><br><br>");
echo("<u>Nom :</u> <b>". $nom . "</b><br>");
echo("<u>Prénom :</u> <b>" . $prenom . "</b><br>");
echo("<u>eMail :</u> <b>" . $email . "</b><br>");
?>
</body>
</html>
<?
session_destroy();
?>
_____________________________________________________________
true | false = session_start();
initialise les données d'une session.
true | false = session_destroy();
détruit les données d'une session en cours.
$chaine = session_name([$chaine]);
retourne ou affecte le nom de la session en cours.
$chaine = session_module_name([$chaine]);
retourne ou affecte le nom du module en cours de la session actuelle.
$chaine = session_save_path([$chaine]);
retourne ou affecte le chemin de sauvegarde de la session en cours.
$chaine = session_id([$chaine]);
retourne ou affecte l'identifiant de la session en cours.
true | false = session_register("nom_variable", ..., "nom_variableN");
enregistre une ou plusieurs variables dans la session en cours.
true | false = session_unregister("nom_variable");
supprime une variable dans la session en cours.
session_unset();
supprime la totalité des variables de la session en cours.
true | false = session_is_registered("nom_variable");
vérifie si une variable a été enregistrée dans la session en cours.
$tableau = session_get_cookie_params();
retourne un tableau associatif contenant les paramètres du cookie (clés : lifetime, path, domain) de la session en cours.
session_set_cookie_params($duree, $chemin, $domaine);
définit les paramètres du cookie (durée de vie, chemin d'accès, domaine d'accès) de la session en cours.
true | false = session_decode($chaine);
décode les données de session à partir d'une chaîne de caractères fournie.
true | false = session_encode();
encode les données de session dans une chaîne de caractères.
session_set_save_handler($ouverture, $fermeture,
$lecture, $ecriture, $destruction, $duree);
définit les fonctions à utiliser pour la gestion du stockage des sessions.
$chaine = session_cache_limiter([$parametre]);
retourne ou spécifie le limiteur de cache. Le paramètre peut prendre la valeur nocache désactivant la mise en cache côté client, public le permettant ainsi que private mais en imposant des restrictions.
session_end();
enregistre les données de la session en cours et la termine.
session_readonly();
lit les variables de la session en cours en lecture seule.
_____________________________________________________________
upload_max_filesize integer
La taille maximale d'un fichier chargé sur le serveur. La valeur est en octets. Par défaut, elle est de 2 méga-octets.
It reads a directory for a particular file type (.mp3) and then lists the files and their sizes.
In this case, I wanted to put some special mp3s in a directory and be able to add to the list easily without changing the webpage.
<?php
   //$imagedir is the absolute path to the directory wherein you wish to store special mp3s
   //example: $imagedir = "/usr/local/www/data/user/dir";
 
   $imagedir = "C:/Windows/User/Dir"; //current directory
 
   $i = 1;
 
   if ($handle = opendir("$imagedir")) {
       while (false !== ($file = readdir($handle))) {
           //strncmp returns < 0 if arg1 is less, >0 if more, 0 if equal
           $extension = substr($file, -4, 4);
           if ($file != "." && $file != ".." && ($extension == ".mp3")) {
               echo($i++.".&nbsp;&nbsp; <a href=\"$file\">$file (".fsize($file).")</a><br>");
           }
       }
       closedir($handle);
   }else{
       echo("<br>Directory could not be opened.<br>");
   }
function fsize($file) {
 
   // Does the file exist?
   if(is_file($imagedir.$file)){
    
       //Setup some common file size measurements.
       $kb=1024;
       $mb=1048576;
       $gb=1073741824;
       $tb=1099511627776;
    
       //Get the file size in bytes.
       $size = filesize($file);
    
       //Format file size
    
       if($size < $kb) {
       return $size." B";
       }
       else if($size < $mb) {
       return round($size/$kb,2)." KB";
       }
       else if($size < $gb) {
       return round($size/$mb,2)." MB";
       }
       else if($size < $tb) {
       return round($size/$gb,2)." GB";
       }
       else {
       return round($size/$tb,2)." TB";
       }
   }
}
?>
________________________________________________________________
<?php //counts all files and folders on your whole server..
function direcho($path) {
    global $filetotal, $fullsize, $totaldirs;
    if ($dir = opendir($path)) {
        while (false !== ($file = readdir($dir))) {
            if (is_dir($path."/".$file)) {                    // if it's a dir, check it's contents too
                if ($file != '.' && $file != '..') {            // but dont go recursive on '.' and '..'
                    echo '<li><b>' . $file . '</b></li><ul>';
                    direcho($path."/".$file);
                    echo '</ul>';
                    $totaldirs++;
                }
            }
            else {                      //if it's not a dir, just output.
                $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $filesize = $tab . '(' . filesize ($path.'/'.$file) . ' kb)';
                echo '<li>' . $file . $filesize . '</li>';
                $fullsize = $fullsize + filesize ($path.'/'.$file);
                $filetotal++;
            }
        }
        closedir($dir);
    }
}
direcho('.');
$fullsize = round($fullsize / 1024 / 1024, 2);
echo"<br><br>
<b>Total files</b> - $filetotal files<br>
<b>Total dirs</b> - $totaldirs directories<br>
<b>Total size</b> - $fullsize MB<br>
";
?>
_____________________________________________________________
[align=center]<a href="javascript:void();" onClick="MM_openBrWindow('http://www.saintdesprit.net/tania/casus_beli','','status=yes,width=403,height=403')"><img src="http://www.saintdesprit.net/images/galeries/casus_tania.jpg" alt="Lancer le diaporama" border="0" class="forumline"></a>
Casus Beli[/align]
_____________________________________________________________
« Démarrer », « Programmes », « Invite de commandes ».
tapez : C:\>ipconfig puis entrée.
Taper ipconfig /renew pour forcer le mise à jour de l ’adresse IP
_____________________________________________________________
 Devparadise.com > Technoweb > Programmation > JavaScript  > Roll-over sonore
Technoweb
 
_____________________________________________________________
///////////////////////////////////////////////////////////////////////
$sql = "SELECT
                pseudo,
                commentaire
             
        FROM
                Culbeni_Comments
        ORDER BY
                id*0+RAND() DESC
        LIMIT
                0, 1";
// did we get a result?
    if( $result2 = $db->sql_query($sql) )
        {
           //$template->assign_block_vars('CITATIONS_row', array());
           if ( $db->sql_numrows($result2) > 0 )
           {
           while ($row = $db->sql_fetchrow($result2))
               {
                 
                    $template->assign_block_vars('CITATIONS_row', array(
                            'PSEUDO' => $row['pseudo'],
                            'COMMENTAIRE' => $row['commentaire'],
                            )
                    );
               }
           }
$db->sql_freeresult($result2);
}
///////////////////////////////////////////////////////////////////////
_____________________________________________________________
>a - "am" (matin) ou "pm" (après-midi)
>A - "AM" (matin) ou "PM" (après-midi)
>B - Heure Internet Swatch
>d - Jour du mois, sur deux chiffres (éventuellement avec un zéro) : "01" à "31"
>D - Jour de la semaine, en trois lettres (et en anglais) : par exemple "Fri" (pour Vendredi)
>F - Mois, textuel, version longue; en anglais, i.e. "January" (pour Janvier)
>g - Heure, au format 12h, sans les zéros initiaux i.e. "1" à "12"
>G - Heure, au format 24h, sans les zéros initiaux i.e. "0" à "23"
>h - Heure, au format 12h, "01" à "12"
>H - heure, au format 24h, "00" à "23"
>i - Minutes; "00" à "59"
>I (i majuscule) - "1" si l'heure d'été est activée, "0" si l'heure d'hiver .
>j - Jour du mois sans les zéros initiaux: "1" à "31"
>l - ('L' minuscule) - Jour de la semaine, textuel, version longue; en anglais, i.e. "Friday" (pour Vendredi)
>L - Booléen pour savoir si l'année est bissextile ("1") ou pas ("0")
>m - Mois; i.e. "01" à "12"
>M - Mois, en trois lettres (et en anglais) : par exemple "Apr" (pour Avril)
>n - Mois sans les zéros initiaux; i.e. "1" à "12"
>O - Différence d'heures avec l'heure de Greenwich, exprimée en heures; i.e. "+0200"
>r - Format de date RFC 822; i.e. "Thu, 21 Dec 2000 16:01:07 +0200" (ajouté en PHP 4.0.4)
>s - Secondes; i.e. "00" à "59"
>S - Suffixe ordinal d'un nombre, en anglais, sur deux lettres : i.e. "th", "nd"
>t - Nombre de jours dans le mois donné, i.e. "28" à "31"
>T - Fuseau horaire de la machine ; i.e. "MET"
>U - Secondes depuis une époque
>w - Jour de la semaine, numérique, i.e. "0" (Dimanche) to "6" (Samedi)
>W - Numéro de semaine dans l'année ISO-8601 : les semaines commencent le lundi (ajouté en PHP 4.1.0)
>Y - Année, 4 chiffres; i.e. "1999"
>y - Année, 2 chiffres; i.e. "99"
>z - Jour de l'année; i.e. "0" à "365"
>Z - Décalage horaire en secondes (i.e. "-43200" à "43200")
_____________________________________________________________
<script language="JavaScript">
<!--
if ((navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.indexOf("Mac") == -1 &&   navigator.appVersion.indexOf("3.1") == -1) || (navigator.plugins && navigator.plugins["Shockwave Flash"]) || navigator.plugins["Shockwave Flash 2.0"]) {document.write('est intallé');}
else {document.write('n\'est pas installé');}
// -->
</script>
_____________________________________________________________
<?php
echo $_SERVER['PHP_SELF'];
?>
_____________________________________________________________
<a href="index.html" onMouseOver="return domTT_true(domTT_activate(event, 'caption', 'Help', 'content', 'This is a link with a tooltip', 'status', 'Link'));">click me</a>
_____________________________________________________________
http://www.shell.ca/main_f.html http://www.ooshop.fr/ http://www.telemarket.fr/
_____________________________________________________________
Clipping pour une image :
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<title>DHTML for the WWW | Setting the Visible Area of An Element (Clipping)</title>
</head>
<style type="text/css">
.clipInHalf {
position: absolute;
clip: rect(15 350 195 50);
top: 0px;
left: 0px;
}
</style>
<body>
ssdt
<div class="clipInHalf"> <img src="31.jpg" width="640" height="480" align="left">
</div>
</body>
</html>
_____________________________________________________________
_____________________________________________________________
_____________________________________________________________
<?php
  mysql_connect($host,$user,$password);
  $result = mysql_db_query("database","select * from table");
  while($row = mysql_fetch_array($result)) {
    echo $row["user_id"];
    echo $row["fullname"];
  }
  mysql_free_result($result);
?>
;
_____________________________________________________________
_____________________________________________________________
<?PHP
if ($var == "") { include("sommaire.php"); }
else {$var = $var.".php";
{if (file_exists($var)) { include($var); }
else {include ("404.php"); }
}
}
?>
____________________________________________________________
PAD decimales padding centimes
$Tvaleur = explode('.',$moy_value);
$moy_value = intval($Tvaleur[0]).'.';
$cent = intval($Tvaleur[1]);
switch($crit_type) {
    case '2' : $moy_value .= str_pad( substr($cent,0,1) ,1,'0'); break; // 1 Décimale
    case '3' : $moy_value .= str_pad( substr($cent,0,2) ,2,'0'); break;
    case '4' : $moy_value .= str_pad( substr($cent,0,3) ,3,'0'); break;
    case '5' : $moy_value .= str_pad( substr($cent,0,4) ,4,'0'); break;
    case '6' : $moy_value .= str_pad( substr($cent,0,5) ,5,'0'); break; // 5 Décimales
}

-------------------------------------------------------------------------------

$path = explode('/',$_SERVER['PHP_SELF']);
$self = $path[(count($path)-1)];
<form action="<?=$self.'?'.str_replace('&action=Inscription','',$_SERVER['QUERY_STRING']);?>&action=Inscription" ...>
 
PHP_SELF /identifiant/info.php
HTTP_SERVER_VARS["PATH"] /usr/local/bin:/usr/bin:/bin
HTTP_SERVER_VARS["CTK_ERROR_DOCUMENT"] 404.html
HTTP_SERVER_VARS["DOCUMENT_ROOT"] /www
HTTP_SERVER_VARS["HTTP_ACCEPT"] image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, application/vnd.ms-powerpoint, application/vnd.ms-excel, application/msword, */*
HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"] gzip, deflate
HTTP_SERVER_VARS["HTTP_ACCEPT_LANGUAGE"] fr
HTTP_SERVER_VARS["HTTP_REFERER"] http://www.google.fr/search?hl=fr&q=%24HTTP_SERVER_VARS&meta=
$strReferer = explode(".", $_SERVER['HTTP_REFERER']); // turns the HTTP_REFERER into an array. seperates it by using a fullstop
echo "you have just came from" . $strReferer[1];
HTTP_SERVER_VARS["HTTP_USER_AGENT"] Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)
HTTP_SERVER_VARS["REDIRECT_STATUS"] 200
HTTP_SERVER_VARS["REDIRECT_URL"] /identifiant/info.php
HTTP_SERVER_VARS["REMOTE_ADDR"] 192.168.40.20
HTTP_SERVER_VARS["REMOTE_PORT"] 56527
HTTP_SERVER_VARS["SCRIPT_URI"] http://chez.tiscali.fr/identifiant/info.php
HTTP_SERVER_VARS["SCRIPT_URL"] /identifiant/info.php
HTTP_SERVER_VARS["SERVER_ADMIN"] webmaster@chez-adm.com
HTTP_SERVER_VARS["SERVER_SOFTWARE"] Apache/1.3.19 (Unix)
HTTP_SERVER_VARS["VIRTUAL_DOMAIN"] 10
HTTP_SERVER_VARS["GATEWAY_INTERFACE"] CGI/1.1
HTTP_SERVER_VARS["SERVER_PROTOCOL"] HTTP/1.0
HTTP_SERVER_VARS["REQUEST_METHOD"] GET
HTTP_SERVER_VARS["QUERY_STRING"]
$HTTP_SERVER_VARS["REQUEST_URI"] /identifiant/info.php
$url = $HTTP_SERVER_VARS["QUERY_STRING"]; echo $url; ... apres le ?ddd=ddd&dddd=tttt
SELF =========>
<? echo str_replace('?'.$HTTP_SERVER_VARS["QUERY_STRING"],'',$HTTP_SERVER_VARS["REQUEST_URI"]); ?>
HTTP_SERVER_VARS["PATH_INFO"] /identifiant/info.php
HTTP_SERVER_VARS["PATH_TRANSLATED"] /www/info.php
HTTP_SERVER_VARS["USER_NAME"] identifiant
HTTP_SERVER_VARS["PHP_SELF"] /identifiant/info.php
HTTP_SERVER_VARS["argv"] Array()
HTTP_SERVER_VARS["argc"] 0
HTTP_ENV_VARS["PATH"] /usr/local/bin:/usr/bin:/bin
HTTP_ENV_VARS["CTK_ERROR_DOCUMENT"] 404.html
HTTP_ENV_VARS["DOCUMENT_ROOT"] /www
HTTP_ENV_VARS["HTTP_ACCEPT"] image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, application/vnd.ms-powerpoint, application/vnd.ms-excel, application/msword, */*
HTTP_ENV_VARS["HTTP_ACCEPT_ENCODING"] gzip, deflate
HTTP_ENV_VARS["HTTP_ACCEPT_LANGUAGE"] fr
HTTP_ENV_VARS["HTTP_REFERER"] http://www.google.fr/search?hl=fr&q=%24HTTP_SERVER_VARS&meta=
HTTP_ENV_VARS["HTTP_USER_AGENT"] Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)
HTTP_ENV_VARS["REDIRECT_STATUS"] 200
HTTP_ENV_VARS["REDIRECT_URL"] /identifiant/info.php
HTTP_ENV_VARS["REMOTE_ADDR"] 192.168.40.20
HTTP_ENV_VARS["REMOTE_PORT"] 56527
HTTP_ENV_VARS["SCRIPT_URI"] http://chez.tiscali.fr/identifiant/info.php
HTTP_ENV_VARS["SCRIPT_URL"] /identifiant/info.php
HTTP_ENV_VARS["SERVER_ADMIN"] webmaster@chez-adm.com
HTTP_ENV_VARS["SERVER_SOFTWARE"] Apache/1.3.19 (Unix)
HTTP_ENV_VARS["VIRTUAL_DOMAIN"] 10
HTTP_ENV_VARS["GATEWAY_INTERFACE"] CGI/1.1
HTTP_ENV_VARS["SERVER_PROTOCOL"] HTTP/1.0
HTTP_ENV_VARS["REQUEST_METHOD"] GET
HTTP_ENV_VARS["QUERY_STRING"]
HTTP_ENV_VARS["REQUEST_URI"] /identifiant/info.php
HTTP_ENV_VARS["PATH_INFO"] /identifiant/info.php
HTTP_ENV_VARS["PATH_TRANSLATED"] /www/info.php
HTTP_ENV_VARS["USER_NAME"] identifiant
________________________________________________________________________________________________
MIME TYPE
Et maintenant le fichier "mime.ini" :
[textes]
txt = text/plain
htm = text/html
html = text/html
css = text/css
[images]
png = image/png
gif = image/gif
jpg = image/jpeg
jpeg = image/jpeg
bmp = image/bmp
tif = image/tiff
[archives]
bz2 = application/x-bzip
gz = application/x-gzip
tar = application/x-tar
zip = application/zip
[audio]
aif = audio/aiff
aiff = audio/aiff
mid = audio/mid
midi = audio/mid
mp3 = audio/mpeg
ogg = audio/ogg
wav = audio/wav
wma = audio/x-ms-wma
[video]
asf = video/x-ms-asf
asx = video/x-ms-asf
avi = video/avi
mpg = video/mpeg
mpeg = video/mpeg
wmv = video/x-ms-wmv
wmx = video/x-ms-wmx
[xml]
xml = text/xml
xsl = text/xsl
[microsoft]
doc = application/msword
rtf = application/msword
xls = application/excel
pps = application/vnd.ms-powerpoint
ppt = application/vnd.ms-powerpoint
[adobe]
pdf = application/pdf
ai = application/postscript
eps = application/postscript
psd = image/psd
[macromedia]
swf = application/x-shockwave-flash
[real]
ra = audio/vnd.rn-realaudio
ram = audio/x-pn-realaudio
rm = application/vnd.rn-realmedia
rv = video/vnd.rn-realvideo
[autres]
exe = application/x-msdownload
pls = audio/scpls
m3u = audio/x-mpegurl
____________________________________________________________________________________________________
// Upload temp "file"
if ($HTTP_POST_FILES['file']['name'] != '') {
    include ('../admin/lib/util.php');
    $doc_file_nom = $HTTP_POST_FILES['file']['name'];
    $ext = getFileExtension($doc_file_nom);
    // Clean name
    $doc_file_nom = cleanName(strtolower(str_replace('.'.$ext,'',$doc_file_nom)));
    strlen($doc_file_nom) > 40 ? $doc_file_nom = substr($doc_file_nom, 0, 40) : '';
    $doc_file_nom = $doc_file_nom.'.'.$ext;
    // New dir...
    $doc_file_dir = './PJ/'.$doc_file_nom;
    if (is_uploaded_file($HTTP_POST_FILES['file']['tmp_name'])) {
        if (!move_uploaded_file($HTTP_POST_FILES['file']['tmp_name'], $doc_file_dir)){
            echo '<script language="JavaScript">
            alert("Problème lors de l\'upload du fichier '.$doc_file_nom.'");
            history.back();
            </script>';
            unlink($HTTP_POST_FILES['file']['tmp_name']);
            die();
        }
    }
}
// Librairie Mail
include ('class_mail.php');
// Let's go
$mailobj = new MIMEMail();
$mailobj->From($Email, 'Visiteur'); // $mailobj->ReplyTo('replyto@myhost.com');
$mailobj->To($To);
$mailobj->Subject($subject);
$mailobj->setHeader('X-Mailer', 'PHP/MIMEMail');
$mailobj->MessageStream($body);
if ($HTTP_POST_FILES['file']['name'] != '') { $mailobj->AttachFile($doc_file_dir); }
$mailobj->Send();
die('<meta http-equiv=refresh content=0;URL='.$redirection.'>');
____________________________________________________________________________________________________
MANAGE SIMPLE EMAIL................................................
<?  include_once("../menu/menu.php"); ?>
<?
// Get Action
$action = $HTTP_GET_VARS['action'];
if ($action == "Update") {
    $email = Clean($HTTP_POST_VARS['email']);
    mysql_query("UPDATE param SET email='$email' WHERE id='1' ",$connexion) or die(mysql_error($connexion));
    $info = 'modif';
}
/* // Create table...
mysql_query("CREATE TABLE param (
  id int(1) NOT NULL auto_increment,
  email varchar(150) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
",$connexion) or die(mysql_error($connexion));
mysql_query("INSERT INTO param VALUES (1, 'jguezennec@proxitek.com');",$connexion) or die(mysql_error($connexion));
*/
?>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="borCote">
<tr>
<td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="23" nowrap class="table-titre">Email Admin. </td>
<td width="67%" class="table-titre2">&nbsp;</td>
</tr>
<tr>
<td height="23" align="center" nowrap class="bgTableauPcP2">&nbsp;Param&egrave;tre de contact &nbsp;<img src="../images/flech_show.png" width="14" height="14" align="absmiddle">&nbsp;</td>
<td align="center" class="bgTableauPcP22">&nbsp;</td>
</tr>
<tr align="center">
<td colspan="2" class="bgTableauPcP"><?php
if ($info != '') { include("../lib/actions_infos.php"); }
?></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
<tr>
<td align="center"><table  border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="tablebor" >
<form action="index.php?action=Update" method="post" enctype="multipart/form-data" name="F1">
<script language="JavaScript" type="text/JavaScript">
<!--
function verif(mydoc) {
    if (mydoc.email.value == "") {
        alert("Veuillez entrer un email !");
        mydoc.email.focus();
    }
    else if (mydoc.email.value.indexOf('@') == -1 || mydoc.email.value.indexOf('.') == -1  || mydoc.email.length < 7) {
        alert("Erreur dans l'email !");
        mydoc.email.focus();
    }
    else { mydoc.submit(); }
}
//-->
</script>
<tr>
<td height="25" align="center" nowrap class="table-sstitre">Email pour la r&eacute;ception des contacts</td>
</tr>
<tr>
  <td width="90%" align="center" class="table-ligne1"><? // Get email
$Sql = mysql_query("SELECT email FROM param WHERE id='1' ",$connexion) or die(mysql_error($connexion));
$Param = mysql_fetch_array($Sql);
$email = $Param[email]; ?>
<input name="email" type="text" value="<? echo $email; ?>" size="50" maxlength="150"></td>
</tr>
<tr>
<td align="center" nowrap class="table-bas"><table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="1"><img src="../images/images/button_01.png" width="15" height="18"></td>
<td nowrap background="../images/images/button_02.png"><a href="Javascript:Javascript:verif(document.F1);" class="menu">VALIDER</a></td>
<td width="1"><img src="../images/images/button_04.png" width="7" height="18"></td>
</tr>
</table></td>
</tr>
</form>
</table></td>
</tr>
</table></td>
</tr>
</table>
<? if($Resultat) { mysql_free_result($Resultat); } ?>
<? include_once("../menu/menu_bas.php"); ?>
____________________________________
<?
// BEAUTIFULL READ REPERTOIRE DIR
Function GetDirsList( $BasDir, $MaxDeep, &$Arr, $DirRegEx = "" )
{
 // Contrôler répertoire source
 $BasDir = DelCarIf( $BasDir, "/" );
 if( ! is_dir( $BasDir ) ) return "";
 //
 // Premier passage (pour trier à la fin du traitement)
 $bFirstPass = FALSE;
 //
 // Création du tableau de résultats
 if( ! is_array( $Arr ) ) {
  $Arr = array();
  $bFirstPass = TRUE;
 }
 //
 // Scanner répertoire source
 $BasDir .= "/";
 if ( ! ( $d = dir( $BasDir ) ) ) return "";
 while( $f = $d->read() ) {
  if ( $f == "" || $f == "." || $f == ".." ) continue;
  if ( ! is_dir( $BasDir . $f ) ) continue;
  if ( $DirRegEx != "" && ! ereg( $DirRegEx, $f ) ) continue;
  $Arr[] = $BasDir . $f . "/";
  //
  // Appel récursif
  if ( $MaxDeep != 0 ) {
   GetDirsList( $BasDir . $f, $MaxDeep - 1, $Arr, $DirRegEx );
  }
 }
 $d->Close();
 if( $bFirstPass ) ASort( $Arr );
 return TRUE;
}
// BEAUTIFULL READ REPERTOIRE DIR
$Rep = array();
$Dir = './../../fr/archives/';
if ($handle = opendir($Dir)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != '.' && $file != '..') {
            $Rep[] = $file;
            $t = stat($Dir.$file);
            $Dating[] = date("YmdHis",$t['9']);
       }
    }
    array_multisort($Dating,SORT_NUMERIC, SORT_DESC,$Rep);
    natcasesort($Rep);
    closedir($handle);
    for ($i=0; $i<count($Rep); $i++) {
        $link = $Dir.str_replace(' ','%20',$Rep[$i]).'/';
        $t = stat($Dir.$Rep[$i]);
        $out[] = '<a href="'.$link.'" target="_blank">'.$Rep[$i].'</a> : ';
        $date[] = 'Modifié le '.date("d/m/Y @ H:i:s",$t['9']);
        // : Modifié le '.date("d/m/Y @ H:i:s",filemtime($link));
    }
    clearstatcache();
}
?>
<table width="400" align="center" cellpadding="5" cellspacing="0" class="tablebor">
<tr>
<td width="20%" nowrap class="texte"><?
for ($i=0; $i<count($out); $i++) { echo '<li><b>'.$out[$i].'</b></li>'; }
?></td>
<td class="texte" nowrap><?
for ($i=0; $i<count($date); $i++) { echo $date[$i].'<br/>'; }
?></td>
</tr>
</table>
____________________________________
 
 GESTION FICHIER CSV...
 
$fichier = "questionnaire3.csv";
$fic = fopen($fichier, 'rb');
echo "<table border='1'>\n";
for ($ligne = fgetcsv($fic, 1024); !feof($fic); $ligne = fgetcsv($fic, 1024)) {
  echo "<tr>";
  $j = sizeof($ligne);
  for ($i = 0; $i < $j; $i++) {
    echo "<td>$ligne[$i]</td>";
    }
  echo "</tr>";
  }
echo "</table>\n";
____________________________________
VISITOR REFERER
<?php
$referants = "reffichier.html";
if ( isset($HTTP_REFERER)
  && ($HTTP_REFERER != "")
  && ($HTTP_REFERER != "bookmarks") )
  {
  $ref_court = preg_replace("/http:\/\//","", $HTTP_REFERER);
  $ref_court = preg_replace("/\/.*/", "", $ref_court);
  if ( ($ref_court != "monsite.com")
    && ($ref_court != "www.monsite.com")
    && ($ref_court != "bookmarks") )
    {
    $ref_long = preg_replace("/&/", "&", $HTTP_REFERER);
    $reffichier = fopen($referants,'a');
    fwrite($reffichier, "<a href=\"$ref_long\">$ref_court</a><br>\n");
    fclose($reffichier);
    }
  }
if (file_exists($referants))
  {
  $refarray = file($referants);
  $refarray = array_reverse($refarray);
  for ($i=0; $i<=10; $i++)
    {
    echo $refarray[$i];
    }
  }
?>
________________________________________________________________________
Referencement Var
function calculs(&$add)  {
  $add = $add + 1;
  if ($add == 0)
    return "gagné!";
  else
    return "perdu!";
}
$a = -1;
echo calculs($a); // affiche "gagné!"
echo $a; => 0
________________________________________________________________________
ob_start(); // Start Buffer
...
...
if (intval($_SESSION['user_id'] > 0) {
    ob_end_flush();
    //echo ob_get_contents();
    //ob_end_clean();
}
else {
    ob_end_clean();
    die('<meta http-equiv=refresh content=0;URL=./index.php>'); // Reset
}________________________________________________________________________
Placer le contenu d'un fichier HTML dans une chaîne
On utilise pour cela les fonctions file() et join(). La première place le contenu d'un fichier dans un tableau, la seconde joint toutes les entrées de ce tableau.
$fichier="http://developpeurs.journaldunet.com";
$contenu=join("",file($fichier));
$contenu = strip_tags($contenu);
$contenu = strtolower($contenu);
$contenu = htmlspecialchars($contenu, ENT_QUOTES);
________________________________________________________________________
Bonne écriture
<?php if ($unTableau) : ?>
  <table
    <th>
      <th>Titre</th>
    </th>
    <?php foreach ($unTableau as $uneValeur) : ?>
      <tr>
        <td><?=$uneValeur?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
--------------------------------------
il est préférable d'utilise les virgules de echo plutôt que de concaténer texte et variable.
Concatenation : echo 'Je m'appelle ' .$prenom. ' ' .$nom. '.';
Virgules : echo 'Je m'appelle ', $prenom, ' ', $nom, '.';
La raison est simple : la concaténation crée en mémoire une nouvelle chaîne, tandis que la virgule, une spécificité peu connue de echo, affichera simplement les valeurs les unes derrières les autres
--------------------------------------
foreach ($gains as $mois => $gain) {
  echo "<tr bgcolor='#".( ($i++ % 2 == 0) ? 'dddddd' : 'eeeeee' )."'><td>$mois</td><td align='right'>$gain</td></tr>";
  $i++;
}
--------------------------------------
(($this->N = count($X))  > 1) or die("Not enough data, number of values : ".$this->N."\n");
<?=$erreur == "pasDeMail" ? "<b>Vous devez choisir un mail</b>" : "Envoyer ce mail à " ;?>
 
join(', ',$listeDesMails)
________________________________________________________________________
Ce script affiche le code HTML indenté, et liste les balises qui n'ont pas été fermées.
 
function show_html($chaine){
 // le deuxieme argument sert a indiquer l'indentation
  // la valeur par defaut est recommandee
  if (func_num_args() == 2) { $ident = func_get_arg(1);}
  else { $indent = " ";}
 
  // ce tableau sert au comptage des balises ouvrante/fermante
  $suivi = array();
  // ce tableau contient les balises ouvrante/fermante
  $tags = array( 'html', 'head', 'script', 'noscript', 'div',
  'center', 'table', 'td', 'tr', 'select', 'map',
  'iframe', 'body', 'title', 'font', 'form', 'left',
  'abbrev', 'acronym', 'textarea', 'author',
  'blockquote', 'code', 'dl', 'dd', 'dt', 'option',
  'em', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'li', 'noframes',
  'note', 'ul', 'ol', 'pre', 'tt', 'layer' );
  // ce tableau contient les balises qui seront laissées dans le corps du texte
  $tagsi = array('a', 'b', 'address', 'i', 'u', 'blink', 'applet',
  'embed', 'sub', 'sup');
  // toutes les autres balises sont ramenees en debut de ligne.
 
  // traitement des javascript.
  // on les ignore, pour ne pas les chambouler
  preg_match_all("/(<script.*?>.*?<\/script>)/is", $chaine, $js);
  $chaine = preg_replace("/(<script.*?>.*?<\/script>)/is",
"<ici_un_script js>", $chaine, $js);
  preg_match_all("/(<noscript.*?>.*?<\/noscript>)/is", $chaine,
$njs);
  $chaine = preg_replace("/(<noscript.*?>.*?<\/noscript>)/is",
"<ici_un_script njs>", $chaine, $njs);
  $njs = $njs[0];
  $js = $js[0];
 
  // preparation des lignes
  $chaine = preg_replace("/\n/", "", $chaine);
  $chaine = preg_replace("/\n\s*/", "\n", $chaine);
  $chaine = preg_replace("/(<.*?>)/", "\n\\1\n", $chaine);
  $chaine = preg_replace("/\n\n/", "\n", $chaine);
  $chaine = preg_replace("/\n\s*/", "\n", $chaine);
 
  $lignes = explode("\n", $chaine);
  $retour = "";
  $i = 0;
  foreach ($lignes as $l){
  $r = "";
  // si c'est une balise
  if (ereg("^<.*>$", $l)){
  // obtention du tag
  if (ereg(' ', $l)){
  $tag = substr($l, 1, strpos($l, ' ')-1);
  $reste = htmlspecialchars(strstr(substr($l, 0, -1), ' '));
  } else {
  $tag = substr($l, 1, -1);
  $reste = "";
  }
  $tag = strtolower($tag);
 
  // etude des ouvrant/fermants
  if (ereg('^/', $tag)){
  // cas d'une balise fermante
  if (in_array( substr($tag, 1), $tagsi)){
  // cas d'une balise fermante a ignorer
  if ((substr($retour, -1) == "\n") && ($i > 0)){
  $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>";
  } else if (in_array(substr($tag, 1), $tags)){
  // cas d'une balise fermante reconnue
  $i--;
  @$suivi[substr($tag, 1)]--;
  $r .= "\n";
  if ($i>0) { $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>\n";
  } else {
  // une balise inconnue
  if ((substr($retour, -1) == "\n") && ($i > 0)){
  $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>";
  }
  } else {
  // cas des balises ouvrantes
  if (in_array($tag, $tags)){
  // cas d'une balise ouvrante reconnue
  $r .= "\n";
  if ($i>0) { $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>\n";
  $i++;
  @$suivi[$tag]++;
  } else if (in_array($tag, $tagsi)){
  if ((substr($retour, -1) == "\n") && ($i > 0)){
  $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>";
  } else if ($tag == "ici_un_script") {
  // cas d'une balise ouvrante a ignorer
  $reste = substr($reste, 1);
  $script = htmlspecialchars(array_shift($$reste));
  $r .= str_repeat("$indent", $i).preg_replace("/\n\s*/",
"\n".str_repeat("$indent", $i+1), $script)."\n";
  $r = preg_replace("/\n$indent(.*?)\n$/", "\n\\1\n", $r);
  } else {
  // cas d'une balise inconnue
  $r .= "\n";
  if ($i>0) { $r .= str_repeat("$indent", $i);}
  $r .= "<<b><font
color=blue>$tag</font></b>$reste>\n";
  }
  }
  } else {
  // si c'est du texte brut
  if ((substr($retour, -1) == "\n") && ($i > 0)){
  $r .= str_repeat("$indent", $i);}
  $r .= htmlspecialchars($l);
  }
  $retour .= $r;
  }
 
 // toilettage final
  $retour = preg_replace("/\n( )+\n/", "\n", $retour);
  $retour = preg_replace("/\n+/", "\n", $retour);
  $retour = preg_replace("/\n+/", "\n", $retour);
  $retour = preg_replace("/<<b><font
color=blue>!--<\/font><\/b>(.*?)-->/i", "<font
color=\"green\"><b><--\\1--></b></font>", $retour);
  $retour = preg_replace("/>( )+/", ">", $retour);
  // cas des commentaires
  $retour = preg_replace("/"(.*?)"/is", ""<font
color=red>\\1</font>"" , $retour);
 
  // la page elle meme
  $out = "<html><body><pre>";
  $out .= $retour;
  $out .= "</pre><hr>";
  // bilan des balises qui ne sont pas suffisamment utilisees
  while(list($cle, $val) = each($suivi)){
  if ($val > 0) {
  $out .= "<<b>$cle</b>> manque $val fois<br>\n";
  } else if ($val < 0) {
  $out .= "<<b>$cle</b>> est ".abs($val)." fois en
trop<br>\n";
  }
  }
  // on retourne le tout pour affichage
  return $out."</body></html>\n";
}
________________________________________________________________________
function liste_alpha($url , $var){
 // $url = page à pointer
 // $var = nom de la variable passée en get
 
  $n = 'a';
  echo "<a href=\"".$url."?".$var."=".$n."\">". strtoupper($n)."</a>\n";
  for($i=0; $i<25; $i++) {
  $l = ++$n;
  echo "<a href=\"".$url."?".$var."=".$l."\">". strtoupper($n)."</a>\n";
  }
 
}
________________________________________________________________________
Existence d'une table MySQL
function mysql_table_exists($table , $db){
 $tables= mysql_list_tables($db);
 while (list ($temp)=mysql_fetch_array ($tables)) { if($temp == $table) { return 1;
} }
 return 0;
}
________________________________________________________________________
function backup($host , $login , $password , $chemin , $nom_fichier , $db){
 // liste les tables
 
  function get_list_tables ($db){
  $i = 0;
  $nbtab = mysql_list_tables ($db);
 
  while ($i < mysql_num_rows ($nbtab)){
  $tb_names[$i] = mysql_tablename ($nbtab, $i);
  $i++;
  }
  return $tb_names;
  }
 
 // recuperation des donnees se trouvant dans les tables
 
  function get_table_data ($table, $fd){
  $tableau = array ();
  $j = 0;
  $resultat = mysql_query ("select * from $table");
 
  if ($resultat == FALSE){
  return "La requete dans la table '".$table."' a echoue.<br>";
  }
 
  else{
 
  while ($valeurs = mysql_fetch_row ($resultat))
  {
  ecrire_ligne ($valeurs, $table, $fd);
  }
  return $valeurs;
  }
  }
 
 // recuperation de la structure de la table
 
  function get_table_structure ($struct, $fd){
  $requete = mysql_query ("show create table $struct");
 
  if ($requete == FALSE){
  return "la recuperation de la structure '".$struct."' a
echoue.<br>";
  }
 
  else{
  $structure = mysql_fetch_row ($requete);
  $ligne = 0;
  return $structure[1];
  }
  }
 
 // integre la structure dans un fichier
 
  function put_struct_into_file ($structure, $nom_table, $fd){
  $struct = "#\n# Structure de la table ".$nom_table."\n#\n\n";
  $struct .= $structure;
  $struct .= "\n\n";
  $ecriture = gzwrite ($fd, $struct, strlen ($struct));
 
  if ($ecriture == 0){
  return "erreur lors de l'ecriture de la strucuture dans le fichier
de sauvgarde.";
  }
 
  else{
  return $fd;
  }
  }
 
 // integre les donnees dans un fichier
 
  function put_data_into_file ($donnees, $nom_table, $fd){
  $lignes = 0;
  $infos = "#\n# donnees de la table ".$nom_table ."\n#\n\n";
  gzwrite ($fd, $infos, strlen ($infos));
 
  while (isset ($donnees[$lignes])){
  $appel_fonction = ecrire_ligne($donnees[$lignes], $nom_table, $fd);
  $lignes++;
  }
  return $fd;
  }
 
  function ecrire_ligne ($donnees, $nom_table, $fd){
  $case = 1;
  $debut = "INSERT INTO '".$nom_table."' VALUES ('".$donnees[0]."'";
  gzwrite ($fd, $debut, strlen ($debut));
 
  while (isset ($donnees[$case])){
  gzwrite ($fd, ", '".$donnees[$case]."'", strlen (",
'".$donnees[$case]."'"));
  $case++;
  }
  $fin = ");\n\n\n";
  gzwrite ($fd, $fin, strlen ($fin));
  }
 //debut du backup
 
  $emplacement = $chemin."/".$nom_fichier;
 
  if (!isset ($chemin) || !is_dir ($chemin)){
  return "$chemin n'est pas un repertoire ou n'existe pas.";
  }
 
  elseif (file_exists ($nom_fichier)){
  return "Impossible de faire la sauvegarde, le fichier $nom_fichier
existe deja.";
  }
 
  else{
  $connec = mysql_connect($host, $login, $password);
  mysql_select_db($db, $connec);
  $list = get_list_tables ($db);
  $tab = 0;
  $fd = gzopen ($emplacement, "a");
 
  while (isset ($list[$tab])){
  $structure = get_table_structure ($list[$tab], $fd);
  $backup = put_struct_into_file ($structure, $list[$tab], $fd);
  $query = get_table_data ($list[$tab], $fd);
  $backup_suite = put_data_into_file ($query, $list[$tab], $fd);
  $tab++;
  }
  gzclose ($fd);
  mysql_close ($connec);
  print "Sauvegarde reussie.";
}
 
------------------------------------------------------------------------------
function backup(){
 // Mise en place des différentes variables du jour
 $dateofday = date("d-m-Y", time());
 $directory = "$dateofday\\";
 $basedir = "C:\\";
 $name = "Backup_". date("d-m-Y", time()).".sql";
 
 // Seulement si la sauvegarde n'a pas été faite
 if(! file_exists("$dateofday\\")){
 // Récupère le chemin d'install de mysql
  $req = mysql_query("SHOW VARIABLES LIKE 'basedir';");
  $var = mysql_fetch_array($req);
 // Construit la ligne de commande pour le dump
  $cmd = "\"".$var[1]."bin\\mysqldump.exe\" --databases $cfgDBName --opt
> $basedir$name";
 // Crée le répertoire du jour
  mkdir ($directory, 0777);
 // Exécute la commande et copie le fichier dans le repertoire du jour
  passthru($cmd);
  copy($basedir.$name, $directory.$name);
 // Efface la source de la copie
  unlink($basedir.$name);
 // Ouvre le fichier .sql créé précédemment
  $fp = fopen($directory.$name, "r");
 // Lis le contenu du fichier et le compresse en gz
  $contents = fread($fp, filesize ($directory.$name));
 
  $zp = gzopen($directory.$name.'.gz', "w9");
 
  gzwrite($zp, $contents);
 // Ferme tous les pointeurs
  gzclose($zp);
 
  fclose($fp);
 // Efface le fichier .sql
  unlink($directory.$name);
 }
 
}
 
________________________________________________________________________
TEMPLATE
Modèles multiples
Nous reprenons ici l'exemple précédent:
include "class.FastTemplate.php3";
$tpl = new FastTemplate("../templates");
$tpl->define(array(
    "myTemplate" => "myTemplate.html"
    "tableau" => "tableau.html",
    "lignes" => "lignes.html"
));
mysql_connect (localhost, root, passwd);
mysql_select_db (essai);
$requete_sql = mysql_query ("SELECT num_client FROM donnees");
if ($donnees = mysql_fetch_array($requete_sql)) {
    do {
        $num_client = $donnees["num_client"];
        $tpl->assign("NUMCLIENT", $num_client);
        $tpl->parse(LIGNES, ".lignes");
    } while ($donnees = mysql_fetch_array($requete_sql));
    $tpl->parse(TABLEAU, "tableau");
    $tpl->parse(MAIN, "myTemplate");
    $tpl->FastPrint();
}
else {
    print("Erreur");
}
Le modèle de page "lignes.html" ressemblera à:
<tr>
    <td>
    {NUMCLIENT}
    </td>
</tr>
Le . devant "colonnes" dans l'instruction:
$tpl->parse(LIGNES, ".lignes");
indique une concaténation: on obtiendra une série de cellules de tableau HTML. Ces cellules sont ensuite placées dans un tableau défini par le modèle de page "tableau.html":
<table>
    {LIGNES}
</table>
Enfin, ce tableau sera placé au sein de la page HTML principale, définie par le modèle "myTemplate.html:"
<html>
<body>
<p>
    Liste des numéros clients:
    {TABLEAU}
</p>
</body>
</HTML>
Complément
Certaines versions de FastTemplate nécessite, avec PHP4, la modication d'une ligne au sein de la fonction parse_template():
$template = ereg_replace("\{$key\}","$val","$template");
<?
class FastTemplate {
________________________________________________________________________
<?php
/*
CREATE TABLE `delicieux` (
`id` INT NOT NULL AUTO_INCREMENT ,
`url` VARCHAR( 255 ) NOT NULL ,
`titre` VARCHAR( 255 ) NOT NULL ,
`desc` TEXT,
`mots` VARCHAR( 255 ) NOT NULL ,
`date` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `mots` )
);
*/
$conn = mysql_connect("localhost", "root", "")
  or die("Impossible de se connecter");
$db = mysql_select_db("test", $conn)
  or die(mysql_error());
$table = "delicieux";
function afficherFormulaire() {
  ?>
  <form method="post" action="">
    <input type="hidden" name="creer" value="oui">
   <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td>URL</td>
     <td>
      <input type="text" name="url" size="75" maxlength="255">
     </td>
    </tr>
    <tr>
     <td>Titre</td>
     <td>
      <input type="text" name="titre" size="75" maxlength="255">
     </td>
    </tr>
    <tr>
     <td>Commentaire</td>
     <td>
      <textarea name="desc" cols="75" rows="3"></textarea>
     </td>
    </tr>
    <tr>
     <td>Mots-clefs</td>
     <td>
      <input type="text" name="mots" size="75" maxlength="255">
     </td>
    </tr>
    <tr>
     <td>
      <input type="submit" name="Submit" value="Envoyer">
     </td>
     <td>&nbsp;</td>
    </tr>
   </table>
  </form>
  <?php
  }
function afficherMots() {
  $mots = array();
  $motsdavant = array();
  $req = "SELECT mots FROM delicieux;";
  $res = mysql_query($req);
  while ($row = mysql_fetch_array($res)) {
    $leMot = split(" ", $row['mots']);
    $motdavant = array_merge($mots);
    $mots = array_merge($motdavant, $leMot);
    }
//  natcasesort($mots);
  $unique = array_unique($mots);
  $nombre = array_count_values($mots);
  echo '<div class="mots">';
  foreach ($unique as $mot) {
    $i = $nombre[$mot];
    echo "$i <a href='index.php?m=$mot'>$mot</a><br/> ";
    }
  if (isset($_REQUEST['m'])) {
    echo '<a href=" index.php">Retour</a>';
    }
  echo '</div>';
  }
function separerMots($chaine) {
    $liens = '';
    $mots = explode(' ', $chaine);
    foreach ($mots as $mot) {
      $liens .= "<a href='index.php?m=$mot'>$mot</a> ";
      }
    return $liens;
  }
function afficherLiens() {
  $req = 'SELECT * FROM delicieux ';
  $req.= 'WHERE 1 GROUP BY datation DESC;';
  $res = mysql_query($req);
  echo '<div class="liens">';
  afficherMots();
  while ($row = mysql_fetch_array($res)) {
    echo "<p><a href='$row[1]'>$row[2]</a><br/>";  // Le titre et son URL
    echo !empty($row[3]) ? $row[3].'<br/>':null;                       // La description
    echo "<small>dans " . separerMots($row[4]) . ", le $row[5]</small></p>";
    }
  echo '</div>';
  }
function afficherLiensPourMot($mot) {
  $req = 'SELECT * FROM delicieux ';
  $req.= 'WHERE mots LIKE "%'.$mot.'%" GROUP BY datation DESC;';
  $res = mysql_query($req);
  echo '<div class="liens">';
  afficherMots();
  while ($row = mysql_fetch_array($res)) {
    echo "<p><a href='$row[1]'>$row[2]</a><br/>";  // Le titre et son URL
    echo $row[3].'<br/>';                       // La description
    echo "<small>dans ";
    echo separerMots($row[4]);
    echo ", le $row[5]</small></p>";
    }
  echo '</div>';
  }
function enregistrerUrl($url, $titre, $desc, $mots) {
  $date = date("Y-m-d h:i:s");
  $req = "INSERT INTO delicieux (id, url, titre, description, mots, datation) ";
  $req .= "VALUES ('', '$url', '$titre', '$desc', '$mots', '$date');";
  if (mysql_query($req))
    {
    ?>Lien correctement ajoué. <a href="index.php">En ajouter un autre</a>.<?
    }
  else
    {
    ?>Raté!<?
    }
  }
function affichage() {
  if (
    (isset($_REQUEST['creer']) && $_REQUEST['creer'] == 'oui')
    && (isset($_REQUEST['url']) && !empty($_REQUEST['url']) )
    && (isset($_REQUEST['titre']) && !empty($_REQUEST['titre']) )
    && (isset($_REQUEST['desc']) )
    && (isset($_REQUEST['mots']) && !empty($_REQUEST['mots']) )
    )
    {
    enregistrerUrl($_REQUEST['url'], $_REQUEST['titre'], $_REQUEST['desc'], $_REQUEST['mots']);
    afficherLiens();
    }
  elseif (isset($_REQUEST['m']) && !empty($_REQUEST['m']) ) {
    afficherLiensPourMot($_REQUEST['m']);
    }
  else
    {
    afficherFormulaire();
    afficherLiens();
    }
  }
 
?>
________________________________________________________________________
<? DOWNLOAD FILE
// LE FICHIER
$MyMedia = './../'.$Rub_7_rep.$Documents[fichier];
// PROCESS
$file = basename($MyMedia);
$size = filesize($MyMedia);
$ext = getFileExtension($Documents[fichier]);
switch ($ext) { //$mime = mime_content_type($MyMedia);
    case "pdf": $mime = 'application/pdf'; break;
    case "exe": $mime = 'application/octet-stream'; break;
    case "zip": $mime = 'application/zip'; break;
    case "doc": $mime = 'application/msword'; break;
    case "xls": $mime = 'application/vnd.ms-excel'; break;
    case "csv": $mime = 'text/x-comma-separated-values'; break;
    case "xlm": $mime = 'text/xml'; break;
    case "ppt": $mime = 'application/vnd.ms-powerpoint'; break;
    case "gif": $mime = 'image/gif'; break;
    case "png": $mime = 'image/png'; break;
    case "jpeg": $mime = 'image/jpg'; break;
    case "jpg": $mime = 'image/jpg'; break;
    case "mp3": $mime = 'audio/mpeg'; break;
    case "wav": $mime = 'audio/x-wav'; break;
    case "mpg": $mime = 'video/mpeg'; break;
    case "mov": $mime = 'video/quicktime'; break;
    case "avi": $mime = 'video/x-msvideo'; break;
    case 'txt' : $mime = 'text/plain'; break;
    default : $mime = 'application/force-download'; break;
}
// DOWNLOAD IT
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: $mime");
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="'.$file.'";');
header("Content-Transfer-Encoding: binary");
header("Content-Length: $size");
readfile($MyMedia);
exit(); ?>
________________________________________________________________________
UPLOAD IMAGE WITH GD GRAPHICS
//APPEL FONCTION
    $file_img = $HTTP_POST_FILES['file_img']['tmp_name'];
    $file_nom = $HTTP_POST_FILES['file_img']['name'];
    $error = $HTTP_POST_FILES['file_img']['error'];
 
    $Img_taille = getimagesize($file_img);
    $path = '../../'.$Rub_5_rep; // grand
    $img = UploadImage($file_img,$file_nom,$Img_taille,$path,'420','420',$error);
    $path2 = '../../'.$Rub_5_rep.$RepMedium; // med
    $img = UploadImage($file_img,$file_nom,$Img_taille,$path2,'142','142',$error);
    $path3 = '../../'.$Rub_5_rep.$RepMini; // mini
    $img = UploadImage($file_img,$file_nom,$Img_taille,$path3,'70','50',$error);
 
// FONCTION
// RETAILLE IMAGE ---------------------------------------------
function image_createThumb($src,$dest,$maxWidth,$maxHeight,$quality,$ext,$imgform_size) {
    if (gd_version() < 1) { return false; }
    if (file_exists($src) && isset($dest)) {
        /// path info
        $destInfo = pathinfo($dest);
        // image src size
        $srcSize = $imgform_size;
        if ($srcSize[0] > 1 || $srcSize[1] > 1) $srcRatio = $srcSize[0]/$srcSize[1]; // width/height ratio
        else $srcRatio = 1;
        $destRatio = $maxWidth/$maxHeight;
        if ($destRatio > $srcRatio) {
            $destSize[1] = $maxHeight;
            $destSize[0] = $maxHeight*$srcRatio;
        }
        else {
            $destSize[0] = $maxWidth;
            $destSize[1] = $maxWidth/$srcRatio;
        }
        if (gd_version() >= 2) { // true color image, with anti-aliasing
            $destImage = @imagecreatetruecolor($destSize[0],$destSize[1]) or die ("Pb. GD (imagecreatetruecolor)");
            @imageantialias($destImage,true) or die ("Pb. GD (imageantialias)");
        }
        else {
            $destImage = @imagecreate($destSize[0],$destSize[1]) or die ("Pb. GD (imagecreate)");
        }
     
        //if (function_exists("imagecreatefromjpeg"))  {} else { die ("Impossible d'utiliser GD (imagecreatefromjpeg)"); }
        switch ($srcSize[2]) {
            case 1: $srcImage = imagecreatefromgif($src); break;
            case 2: $srcImage = imagecreatefromjpeg($src); break;
            case 3: $srcImage = imagecreatefrompng($src); break;
            default: return false; break;
        }
     
        if (gd_version() >= 2) @imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],$srcSize[0],$srcSize[1]) or die ("Pb. GD (imagecopyresampled)");
        else @imagecopyresized($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],$srcSize[0],$srcSize[1]);// or die ("Pb. GD (imagecopyresized)");
        switch ($srcSize[2]) { // generating image
            case 1: //imagegif($destImage,$dest); break;
            case 2: imagejpeg($destImage,$dest,$quality); break;
            case 3: imagepng($destImage,$dest);  break;
            default: return false; break;
        }
        return true;
    }
    else return false;
}
// UPLOAD IMAGE ---------------------------------------------
function UploadImage($imgform,$imgform_name,$imgform_size,$img_dir,$maxWidth,$maxHeight,$erreur) {
    switch($erreur) { // Erreur ??
        case 0: // ok ?
        break;
        case 1: //php.ini
            $error_mess = "Le fichier IMAGE que vous avez sélectionné est trop volumineux";
            @unlink($imgform);
            echo '<script language="JavaScript"> alert("'.$error_mess.'"); history.back();</script>';
            die(); break;
        case 2: // html form
            $error_mess = "Le fichier IMAGE que vous avez sélectionné est trop volumineux";
            @unlink($imgform);
            echo '<script language="JavaScript"> alert("'.$error_mess.'");  history.back();</script>';
            die(); break;
        case 3:
            $error_mess = "Erreur lors du chargement FTP : Fichier IMAGE partiellement mis en ligne.";
            @unlink($imgform);
            echo '<script language="JavaScript"> alert("'.$error_mess.'");  history.back();</script>';
            die(); break;
        case 4: break; // mysql_error($connexion)_mess = "Aucun fichier de sélectionné...";
        default:
            $error_mess = "Problème inconnu lors de la mise en ligne du fichier IMAGE";
            @unlink($imgform);
            echo '<script language="JavaScript"> alert("'.$error_mess.'");  history.back();</script>';
            die(); break;
    }
    if ($imgform != '' || $imgform == 'none') {
        $ext = getFileExtension($imgform_name);
        if ($ext!="jpg" && $ext!="png" && $ext!="gif") { // verification de l'extension
            @unlink($file_img);
            echo '<script language="JavaScript">
            alert("Image avec extension .jpg, .jpeg, .gif ou .png SEULEMENT ['.$ext.' <> '.$imgform_name.']");
            history.back();
            </script>';
            die();
        }
        // PREPARATION DU NOM
        $imgform_name = cleanName(str_replace('.'.$ext,'',$imgform_name));
        if (strlen($imgform_name) > 25) { $imgform_name = substr($imgform_name, 0, 25); }
        $img_indexName = $imgform_name.'_'.date("YmdHi").'.'.$ext;
        $newFile = $img_dir.$img_indexName;
        // DEPLACE LE FICHIER DANS SON REPERTOIRE
        if (is_uploaded_file($imgform)) {
            if (!copy($imgform,$newFile)) {
                @unlink($imgform);
                echo '<script language="JavaScript">
                alert("Problème lors de l\'upload : '.$newFile.' - $imgform : '.$imgform.'");
                history.back();
                </script>';
                die();
            }
            if ($imgform_size[0] > $maxWidth || $imgform_size[1] > $maxHeight) {
                if (!image_createThumb($newFile,$newFile,$maxWidth,$maxHeight,'75',$ext,$imgform_size)) {
                    @unlink($imgform);
                    @unlink($newFile);
                    echo '<script language="JavaScript">
                    alert("Erreur lors du redimensionnement automatique");
                    history.back();
                    </script>';
                    die();
                }
            }
            return($img_indexName);
        }
        else {
            @unlink($imgform);
            echo '<script language="JavaScript">
            alert("Problème lors de l\'upload : '.$newFile.' - $imgform : '.$imgform.'");
            history.back();
            </script>';
            die();
        }
    }
}
/* entity to unicode decimal value */
function entity_to_decimal_value($string){
    static $entities_dec = false;
    if (!is_array($entities_dec)) {
        $entities_named       = array("&nbsp;","&iexcl;","&cent;","&pound;","&curren;","&yen;","&brvbar;","&sect;","&uml;","&copy;","&ordf;","&laquo;","&not;","&shy;","&reg;","&macr;","&deg;","&plusmn;","&sup2;","&sup3;","&acute;","&micro;","&para;","&middot;","&cedil;","&sup1;","&ordm;","&raquo;","&frac14;","&frac12;","&frac34;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&ETH;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&times;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&Yacute;","&THORN;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&eth;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yacute;","&thorn;","&yuml;","&fnof;","&Alpha;","&Beta;","&Gamma;","&Delta;","&Epsilon;","&Zeta;","&Eta;","&Theta;","&Iota;","&Kappa;","&Lambda;","&Mu;","&Nu;","&Xi;","&Omicron;","&Pi;","&Rho;","&Sigma;","&Tau;","&Upsilon;","&Phi;","&Chi;","&Psi;","&Omega;","&alpha;","&beta;","&gamma;","&delta;","&epsilon;","&zeta;","&eta;","&theta;","&iota;","&kappa;","&lambda;","&mu;","&nu;","&xi;","&omicron;","&pi;","&rho;","&sigmaf;","&sigma;","&tau;","&upsilon;","&phi;","&chi;","&psi;","&omega;","&thetasym;","&upsih;","&piv;","&bull;","&hellip;","&prime;","&Prime;","&oline;","&frasl;","&weierp;","&image;","&real;","&trade;","&alefsym;","&larr;","&uarr;","&rarr;","&darr;","&harr;","&crarr;","&lArr;","&uArr;","&rArr;","&dArr;","&hArr;","&forall;","&part;","&exist;","&empty;","&nabla;","&isin;","&notin;","&ni;","&prod;","&sum;","&minus;","&lowast;","&radic;","&prop;","&infin;","&ang;","&and;","&or;","&cap;","&cup;","&int;","&there4;","&sim;","&cong;","&asymp;","&ne;","&equiv;","&le;","&ge;","&sub;","&sup;","&nsub;","&sube;","&supe;","&oplus;","&otimes;","&perp;","&sdot;","&lceil;","&rceil;","&lfloor;","&rfloor;","&lang;","&rang;","&loz;","&spades;","&clubs;","&hearts;","&diams;","&quot;","&amp;","&lt;","&gt;","&OElig;","&oelig;","&Scaron;","&scaron;","&Yuml;","&circ;","&tilde;","&ensp;","&emsp;","&thinsp;","&zwnj;","&zwj;","&lrm;","&rlm;","&ndash;","&mdash;","&lsquo;","&rsquo;","&sbquo;","&ldquo;","&rdquo;","&bdquo;","&dagger;","&Dagger;","&permil;","&lsaquo;","&rsaquo;","&euro;","&apos;");
        $entities_decimal     = array("&#160;","&#161;","&#162;","&#163;","&#164;","&#165;","&#166;","&#167;","&#168;","&#169;","&#170;","&#171;","&#172;","&#173;","&#174;","&#175;","&#176;","&#177;","&#178;","&#179;","&#180;","&#181;","&#182;","&#183;","&#184;","&#185;","&#186;","&#187;","&#188;","&#189;","&#190;","&#191;","&#192;","&#193;","&#194;","&#195;","&#196;","&#197;","&#198;","&#199;","&#200;","&#201;","&#202;","&#203;","&#204;","&#205;","&#206;","&#207;","&#208;","&#209;","&#210;","&#211;","&#212;","&#213;","&#214;","&#215;","&#216;","&#217;","&#218;","&#219;","&#220;","&#221;","&#222;","&#223;","&#224;","&#225;","&#226;","&#227;","&#228;","&#229;","&#230;","&#231;","&#232;","&#233;","&#234;","&#235;","&#236;","&#237;","&#238;","&#239;","&#240;","&#241;","&#242;","&#243;","&#244;","&#245;","&#246;","&#247;","&#248;","&#249;","&#250;","&#251;","&#252;","&#253;","&#254;","&#255;","&#402;","&#913;","&#914;","&#915;","&#916;","&#917;","&#918;","&#919;","&#920;","&#921;","&#922;","&#923;","&#924;","&#925;","&#926;","&#927;","&#928;","&#929;","&#931;","&#932;","&#933;","&#934;","&#935;","&#936;","&#937;","&#945;","&#946;","&#947;","&#948;","&#949;","&#950;","&#951;","&#952;","&#953;","&#954;","&#955;","&#956;","&#957;","&#958;","&#959;","&#960;","&#961;","&#962;","&#963;","&#964;","&#965;","&#966;","&#967;","&#968;","&#969;","&#977;","&#978;","&#982;","&#8226;","&#8230;","&#8242;","&#8243;","&#8254;","&#8260;","&#8472;","&#8465;","&#8476;","&#8482;","&#8501;","&#8592;","&#8593;","&#8594;","&#8595;","&#8596;","&#8629;","&#8656;","&#8657;","&#8658;","&#8659;","&#8660;","&#8704;","&#8706;","&#8707;","&#8709;","&#8711;","&#8712;","&#8713;","&#8715;","&#8719;","&#8721;","&#8722;","&#8727;","&#8730;","&#8733;","&#8734;","&#8736;","&#8743;","&#8744;","&#8745;","&#8746;","&#8747;","&#8756;","&#8764;","&#8773;","&#8776;","&#8800;","&#8801;","&#8804;","&#8805;","&#8834;","&#8835;","&#8836;","&#8838;","&#8839;","&#8853;","&#8855;","&#8869;","&#8901;","&#8968;","&#8969;","&#8970;","&#8971;","&#9001;","&#9002;","&#9674;","&#9824;","&#9827;","&#9829;","&#9830;","&#34;","&#38;","&#60;","&#62;","&#338;","&#339;","&#352;","&#353;","&#376;","&#710;","&#732;","&#8194;","&#8195;","&#8201;","&#8204;","&#8205;","&#8206;","&#8207;","&#8211;","&#8212;","&#8216;","&#8217;","&#8218;","&#8220;","&#8221;","&#8222;","&#8224;","&#8225;","&#8240;","&#8249;","&#8250;","&#8364;","&#39;");
        if (function_exists('array_combine'))
            $entities_dec=array_combine($entities_named,$entities_decimal);
        else {
            $i=0;
            foreach ($entities_named as $_entities_named) $entities_dec[$_entities_named]=$entities_decimal[$i++];
        }
    }
    return preg_replace( "/&[A-Za-z]+;/", " ", strtr($string,$entities_dec) );
}
________________________________________________________________
Table des matières
array_change_key_case -- Change la casse des clés du tableau
array_chunk -- Sépare un tableau en tableaux de taille inférieure
array_combine -- Crée un tableau à partir de deux autres tableaux
array_count_values -- Compte le nombre de valeurs dans un tableau
array_diff_assoc -- Calcule la différence de deux tableaux, en prenant en compte les clés
array_diff_key -- Calcule la différence de deux tableaux en utilisant les clés pour comparaison
array_diff_uassoc -- Calcule la différence entre deux tableaux associatifs, à l'aide d'une fonction utilisateur
array_diff_ukey -- Calcule la différence entre deux tableaux en utilisant une fonction de callback sur les clés pour comparaison
array_diff -- Calcule la différence entre deux tableaux
array_fill_keys -- Remplit un tableau avec des valeurs, en spécifiant les clés
array_fill -- Remplit un tableau avec une même valeur
array_filter -- Filtre les éléments d'un tableau
array_flip --  Remplace les clés par les valeurs, et les valeurs par les clés
array_intersect_assoc -- Calcule l'intersection de deux tableaux avec des tests sur les index
array_intersect_key -- Calcule l'intersection de deux tableaux en utilisant les clés pour comparaison
array_intersect_uassoc -- Calcule l'intersection de deux tableaux avec des tests sur les index, compare les index en utilisant une fonction de callback
array_intersect_ukey -- Calcule l'intersection de deux tableaux en utilisant une fonction de callback sur les clés pour comparaison
array_intersect -- Calcule l'intersection de tableaux
array_key_exists -- Vérifie si une clé existe dans un tableau
array_keys -- Retourne toutes les clés d'un tableau
array_map -- Applique une fonction sur les éléments d'un tableau
array_merge_recursive -- Combine plusieurs tableaux ensemble, récursivement
array_merge -- Fusionne un ou plusieurs tableaux
array_multisort -- Trie multi-dimensionnel de tableaux
array_pad -- Complète un tableau avec une valeur jusqu'à la longueur spécifiée
array_pop -- Dépile un élément de la fin d'un tableau
array_product -- Calcule le produit des valeurs du tableau
array_push -- Empile un ou plusieurs éléments à la fin d'un tableau
array_rand -- Prend une ou plusieurs valeurs, au hasard dans un tableau
array_reduce -- Réduit itérativement un tableau
array_reverse -- Inverse l'ordre des éléments d'un tableau
array_search -- Recherche dans un tableau la clé associée à une valeur
array_shift -- Dépile un élément au début d'un tableau
array_slice -- Extrait une portion de tableau
array_splice -- Efface et remplace une portion de tableau
array_sum -- Calcule la somme des valeurs du tableau
array_udiff_assoc -- Calcule la différence entre des tableaux avec vérification des index, compare les données avec une fonction de callback
array_udiff_uassoc -- Calcule la différence de deux tableaux associatifs, compare les données et les index avec une fonction de callback
array_udiff -- Calcule la différence entre deux tableaux en utilisant une fonction callback
array_uintersect_assoc -- Calcule l'intersection de deux tableaux avec des tests sur l'index, compare les donnée en utilisant une fonction de callback
array_uintersect_uassoc -- Calcule l'intersection de deux tableaux avec des tests sur l'index, compare les données et les indexes des deux tableaux en utilisant une fonction de callback
array_uintersect -- Calcule l'intersection de deux tableaux, compare les données en utilisant une fonction de callback
array_unique -- Dédoublonne un tableau
array_unshift -- Empile un ou plusieurs éléments au début d'un tableau
array_values -- Retourne les valeurs d'un tableau
array_walk_recursive -- Applique une fonction utilisateur récursivement à chaque membre du tableau
array_walk -- Exécute une fonction sur chacun des éléments d'un tableau
array -- Crée un tableau
arsort -- Trie un tableau en ordre inverse
asort -- Trie un tableau et conserve l'association des index
compact -- Crée un tableau à partir de variables et de leur valeur
count -- Compte le nombre d'éléments d'un tableau ou le nombre de propriétés d'un objet
current -- Retourne l'élément courant du tableau
each -- Retourne chaque paire clé/valeur d'un tableau
end -- Positionne le pointeur de tableau en fin de tableau
extract -- Importe les variables dans la table des symboles
in_array -- Indique si une valeur appartient à un tableau
key -- Retourne une clé d'un tableau associatif
krsort -- Trie un tableau en sens inverse et suivant les clés
ksort -- Trie un tableau suivant les clés
list -- Transforme une liste de variables en tableau
natcasesort -- Trie un tableau avec l'algorithme à "ordre naturel" insensible à la casse
natsort -- Trie un tableau avec l'algorithme à "ordre naturel"
next -- Avance le pointeur interne d'un tableau
pos -- Alias de current()
prev -- Recule le pointeur courant de tableau
range -- Crée un tableau contenant un intervalle d'éléments
reset -- Remet le pointeur interne de tableau au début
rsort -- Trie un tableau en ordre inverse
shuffle -- Mélange les éléments d'un tableau
sizeof -- Alias de count()
sort -- Trie un tableau
uasort -- Trie un tableau en utilisant une fonction de callback
uksort -- Trie un tableau par ses clés en utilisant une fonction de callback
usort -- Trie un tableau en utilisant une fonction de comparaison
_________________________________________________________________________________________________________
conn_id = ftp_connect("www.yoursite.com");
$login_result = ftp_login($conn_id, "username", "password");
if ((!$conn_id) || (!$login_result)) {
echo "FTP connection has failed!";
exit;
} else {
echo "Connected";
}
// get the file
$local = fopen("local.txt","w");
$result = ftp_fget($conn_id, $local,"httpdocs/trlog.txt", FTP_BINARY);
// check upload status
if (!$result) {
echo "FTP download has failed!";
} else {
echo "Downloaded ";
}
// close the FTP stream
ftp_close($conn_id);
SLIDE SHOW JAVASCRIPT  ////////////////////////////////////////////////////////////////////////////////
<? $tempo = 3000; ?>
<body onLoad="gohigh();">
<?
include('../admin/miseenavant_par/data.php');
$D = new SQL($R2);
$D->LireSql('*'," media!='' ORDER BY ordre DESC ");
$c = 0;
for ($k=0; $k<$D->nb; $k++) {
    if ($D->V[$k]['media'] != '' && file_exists('../'.$R2['rep'].$medium.$D->V[$k]['media'])) {
        $script .= 'Zimg_id[\''.$c.'\']="'.$D->V[$k]['id'].'";Zimg_source[\''.$c.'\']="'.$D->V[$k]['media'].'";Zimg_titre[\''.$c.'\']="'.addslashes(Aff($D->V[$k]['titre'])).'";
';
        $c++;
    }
}
if ($D->nb > 1) {
    ?><script language="javascript" type="text/javascript">
    <!-- CODING : molokoloco@saintdesprit.net // Proxitek 2005 CopyLeft //>
 
    // Some vars....
    Zimg_id = new Array();
    Zimg_source = new Array();
    Zimg_titre = new Array();
 
    // From php....
    <?=$script;?>
 
    // Some vars....
    var letempo,current,nextimg,t;
    var z = Zimg_id.length-1;
 
    // DIAPORAMA....
    function imgaff() {
        if (document.getElementById) {
            if (window.t) clearTimeout(window.t);
            setOpacity(1);
            current = parseInt(document.Slide.idnext.value);
            if (current >= z) nextimg = 0;
            else nextimg = current+1;
            document.Slide.idnext.value = nextimg;
            document.Slide.id.value = Zimg_id[current];
            document.getElementById('img').src = "<?='../'.$R2['rep'].$medium;?>"+Zimg_source[current];
            document.getElementById('linkImg').href = Zimg_titre[current] || 'javascript:void(0)';
            document.getElementById('linkImg').title = Zimg_titre[current] || '';
            document.Slide.trans.value = 1;
            t = setTimeout("gohigh();", 300);
         
            Next = new Image();
            if (nextimg < z) Next.src = "<?='../'.$R2['rep'].$medium;?>"+Zimg_source[nextimg];
            else Next.src = "<?='../'.$R2['rep'].$medium;?>"+Zimg_source[1];
        }
        else alert("Pour profiter pleinement de l'expérience proposé par ce site, téléchargez la dernière version de votre navigateur");
    }
    function setOpacity(trans) {
        obj = document.getElementById('img');
        if (obj.style.filter) obj.style.filter = "alpha(opacity:"+trans+")";
        else if (obj.style.KHTMLOpacity) obj.style.KHTMLOpacity = parseFloat(trans)/100;
        else if (obj.style.MozOpacity) obj.style.MozOpacity = parseFloat(trans)/100;
        else if (obj.style.opacity) obj.style.opacity = parseFloat(trans)/100;
    }
    function gohigh() {
        trans = parseInt(document.Slide.trans.value);
        if (trans < 100) {
            trans += 10;
            setOpacity(trans);
            document.Slide.trans.value = trans;
            t = setTimeout("gohigh()", 20);
        }
        else {
            letempo = parseInt(document.Slide.letempo.value);
            t = setTimeout("godown();", letempo);
        }
    }
    function godown() {
        trans = parseInt(document.Slide.trans.value);
        if (trans > 0) {
            trans -= 10;
            setOpacity(trans);
            document.Slide.trans.value = trans;
            t = setTimeout("godown();", 20);
        } else { imgaff(); }
    }
    -->
    </script><?
} else { ?><script language="javascript" type="text/javascript">
    function gohigh() {
        void(0);
    }
    -->
    </script><?
} ?><a href="javascript:void(0);" title="" id="linkImg" name="linkImg"><img src="<?=($D->V[0]['media']!=''?'../'.$R2['rep'].$medium.$D->V[0]['media']:'../images/common/pix.gif');?>" id="img" name="img" border="0" style="filter:alpha(opacity=1);-moz-opacity:.1;opacity:.1;"></a>
<form name="Slide"><input type="hidden" name="idnext" id="idnext" value="1"><input type="hidden" name="id" id="id" value="0"><input type="hidden" name="trans" id="trans" value="1"><input type="hidden" name="letempo" id="letempo" value="<?=$tempo;?>"></form>
//________________________________________________________________________
<form action="freelance.php?action=send" method="POST" enctype="multipart/form-data" id="F1" name="F1" onKeyPress="kH();">
<script language="JavaScript" type="text/JavaScript">
<!--
function kH(e) { // Submit with Enter Key...
    var K = window.event ? window.event.keyCode : e.which;
    if (K == "13") V1();
}
function V1() { // Verif formulaire
    whom = document.F1;
    var error = "";
    if (whom.nom.value == "") error += "\n- Vérifiez le nom";
    if (whom.prenom.value == "") error += "\n- Vérifiez le champ prenom";
    if (whom.adr.value == "") error += "\n- Vérifiez le champ Adresse";
    if (whom.cp.value == "") error += "\n- Vérifiez le champ Code postal";
    if (whom.ville.value == "") error += "\n- Vérifiez le champ ville";
    if (whom.pays.value == "") error += "\n- Vérifiez le champ pays";
    if (whom.email.value.indexOf('@') == -1 || whom.email.value.indexOf('.') == -1  || whom.email.length < 7) error += "\n- Vérifiez le champ E-mail";
    if (error != "") alert(error);
    else whom.submit();
}
//-->
</script>
//________________________________________________________________________
// SIMPLE TABLE WITH IMAGE OF A DIRECTORY ////////////////////////////////////////////////////////////////////////////////
ex. http://serveur/images.php?repertoire=BARONVILLE/SITE/imgs/galerie/mini/&col=5
<table width="701" bg bgcolor="000000" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="699" align="center" valign="top">
<table width="699" bg bgcolor="ffffff" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top"><table width="5%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top"><?
$repertoire = 'hiphop_images/';
$col = '14';
function getFile($rep) {
    $files = array();
    if ($handle = opendir($rep)) {
        while (false !== ($file = readdir($handle))) { if (is_file($rep.$file) && (strpos($file,'.jpg')!==false || strpos($file,'.jpeg')!==false || strpos($file,'.gif')!==false || strpos($file,'.png')!==false) ) $files[] = $file; }
        natcasesort($files); reset($files); closedir($handle);
        return $files;
    }
} 
$files = getFile($repertoire);
for ($i=0; $i<count($files); $i++) {
    if ($i == 0) echo '<tr>'; // FIRST LIGNE
    else if ($i % $col == 0) { // FIN LIGNE
        echo '</tr>
        <tr>';
    }
    echo '<td><a href="'.$repertoire.$files[$i].'" target="_blank"><img src="'.$repertoire.$files[$i].'" border="0" /></a></td>';
    if ($i == count($files)-1) echo '</tr>'; // LAST LIGNE
}
?></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
//________________________________________________________________________
<table width="100%" border="0" cellspacing="0" cellpadding="0"><?
$col = '5';
$C = new SQL('produits');
$C->LireSql(array('*')," actif='1' AND prix > '0' AND ordre_une > '0' ORDER BY ordre_une ASC");
for ($i=0; $i<$C->nb; $i++)  {
    $id_select = $C->V[$i]['id'];
    $S = new SQL('categories_produits'); // FIND PATH CATEGORIES
    $S->LireSql(array('cat_id')," prod_id='$id_select' LIMIT 1 ");
    $sscat_id_select = $S->V[0]['cat_id'];
    $S = new SQL('categories'); // FIND PATH CATEGORIES
    $S->LireSql(array('parent_id')," id='$sscat_id_select' LIMIT 1 ");
    $cat_id_select = $S->V[0]['parent_id']; 
 
    if ($i == 0) echo '<tr>'; // FIRST LIGNE
    else if ($i % $col == 0) echo '</tr><tr>'; // INTER-LIGNE
    ?><td width="<?=(100/$col);?>%" valign="top" class="arial10"><a href="index.php?goto=liste&cat_id=<?=$cat_id_select;?>&sscat_id=<?=$sscat_id_select;?>"><? if ($C->V[$i]['visuel'] != '' && file_exists('../imgs/catalogue/medium/'.$C->V[$i]['visuel'])) { ?><img src="../imgs/catalogue/medium/<?=$C->V[$i]['visuel'];?>" border="0" class="borgris"><br /><? } ?></a><?=CS(Aff($C->V[$i]['nom']),55);?></td><?
 
    if (($i+1)==$C->nb) echo '</tr>'; // LAST LIGNE
}
?></table>




```