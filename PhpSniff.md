# Howto #

## Ce programme PHP détecte les changements de chaine TV sur le réseau local ##

Principes :
  * Fonctionne sur linux uniquement
  * Utilise le logiciel tcpdump pour detecter les IP du protocole IGMP qui transite sur le réseau LOCAL
  * Analyse le fichier de log pour détecter les chaines
  * Mise a jour d'un site distant avec l'information de la chaine en cours

# 1 En ligne de commande, avec acces root (su), creer un fichier : sniffer.sh
```
cd /home/votrenomutilisateur/Bureau/
su
touch sniffer.sh
chmod 777 sniffer.sh
gedit sniffer.sh
```

sniffer.sh : Ce script execute tcpdump et ecrit les packets IGMP dans un fichier "packet" sur le bureau...
```
#!/bin/sh
sudo tcpdump -i eth0 ip proto 2 -t -N -q -l | tee /home/votrenomutilisateur/Bureau/packet
```

# 2 Executer ce script
```
sudo sniffer.sh
```

# 3 Créer un fichier PHP (cf. code ci-dessous)
```
touch snifftv.php
sudo gedit /opt/lampp/htdocs/snifftv.php
```

# 4 Commande linux pour le démarrage du serveur local (lampp par exemple)
```
sudo /opt/lampp/lampp start
```

# 5 Ouvrir le fichier PHP dans son navigateur
```
http://localhost/snifftv.php
```

# 6 Zapper sur la TV

# snifftv.php #

Fichier à lancer sur son localhost, dans son navigateur favoris

```

<?php 

// Liste des chaines (d'un operateur cable TV)

/*
	// Pour obtenir cette liste chez votre operateur...
	// Avec TCP dump il faut regarder les IP du réseau local
	su
	sudo tcpdump -i eth0 ip proto 2 -t -N -q -l
	// ...et zapper sur la TV de chaine en chaine pour voir ce qu'il ce passe
*/

$channels = array( 
    1 => '233.136.0.110', 
    2 => '233.136.0.111', 
    3 => '233.136.0.112', 
    4 => '233.136.0.113', 
    5 => '233.136.0.114', 
    6 => '233.136.0.115', 
    7 => '233.136.0.116', 
    8 => '233.136.0.126', 
    9 => '233.136.0.121', 
    10 => '233.136.0.119', 
    11 => '233.136.0.123', 
    12 => '233.136.0.124'
);


// Recherche les nouveaux IP dans le fichier log
$chaineEx = ''; 
function matchIp($line) { // Find channel in IGMP IP sniff, like 233.136.0.129 
    global $channels, $chaineEx; 
    if (empty($line)) return ''; 
    preg_match_all('/233\.136\.0\.[\d]{3}/i', $line, $result); 
    if ($result[0] && $result[0][0]) { 
        if (in_array($result[0][0], $channels)) { 
            $channel = array_search($result[0][0], $channels);
            if ($channel != $chaineEx) { 
                $fp = @fopen('http://www.monsite.net/?action=setChannel&channel='.$channel, 'r'); 
                @fpassthru($fp);
                echo '<br />'; 
                @fclose($fp);
                $chaineEx = $channel;
            } 
        } 
    } 
} 

// Ouvre le fichier log et reste ouvert pour une lecture continue
function getLiveStream($liveStream) {
    $handle = @popen('tail -f '.$liveStream.' 2>&1', 'r'); 
    if ($handle) { 
        while(!feof($handle)) { 
            $buffer = fgets($handle); 
            matchIp($buffer); 
            ob_flush(); 
            flush(); 
        } 
        pclose($handle); 
    } 
    die('<br /><___END___/>'); 
}

// Initialisation
getLiveStream('/home/votrenomutilisateur/Bureau/packet'); 

?>

```

## HOW TO STREAM VIDEOS (FILE or URL) WITH VLC MEDIA PLAYER ##

http://www.videolan.org/doc/streaming-howto/en/ch04.html

Example of cmd.exe commands for VLC :

```

"C:\Program Files\VideoLAN\VLC\vlc" -vvv http://sl.tf1.fr/lci/vod/zapnet/zapnet20080926.mp4 --sout=#transcode{vcodec=mp2v,vb=800,scale=1,acodec=mpga,ab=128,channels=2}:duplicate{dst=std{access=udp,mux=ts,dst=239.192.1.1:1235}}

```

or

```

"C:\Program Files\VideoLAN\VLC\vlc" -vvv "C:\eclipse_project\public\videos\lci\zapnet20080922.mp4" --sout=#transcode{vcodec=mp2v,vb=800,scale=1,acodec=mpga,ab=128,channels=2}:duplicate{dst=std{access=udp,mux=ts,dst=239.192.1.1:1235}}

```

PHP :

```

function cmd($cmd, $escape=FALSE) {
        if ($escape) $cmd = escapeshellarg($cmd);
        //if (!isLocal()) $cmd = str_replace( array('(', ')'), array('\\(', '\\)'), $cmd); // For unix : escape special char
        exec($cmd, $erreur, $fail); // passthru()
        if ($fail) echo implode('. ', $erreur);
}

function startMpg2UdpStream($videoId='', $hostPort='239.192.1.1:1235') {
        $cmd = "\"C:\\Program Files\\VideoLAN\\VLC\\vlc\" \"".$videoId."\" --quiet --sout=#transcode{vcodec=h264,vb=768,scale=0.5,acodec=mpga,ab=96,channels=1}:duplicate{dst=display,dst=std{access=udp,mux=ts,dst=$hostPort}} vlc:quit"; //,
        cmd($cmd);
}


$udp_url = 'C:\\eclipse_project\\demo\\img\\lci\\zapnet20080923.mpg';
$udp_port = (!empty($_GET['udp_port']) ? $_GET['udp_port'] : '239.192.1.1:1235');

startMpg2UdpStream($udp_url, $udp_port);

```

That all folks :)