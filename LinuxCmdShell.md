# LINUX with UBUNTU, FEDORA, DEBIAN or whatever you want #

  * http://www.techieblogger.com/2009/10/linux-unix-ubuntu-solaris-cheat-sheets.html
  * http://linuxmanua.blogspot.com/2010/05/top-logiciels-installer-sur-linux_02.html
  * http://www.alsacreations.com/tuto/lire/622-Securite-firewall-iptables.html
  * Exemple config serveur : http://www.dedibox-news.com/sujet-6593-resolu-probleme-ping-domaine-config-bind-apache
  * http://www.cyberciti.biz/tips/top-linux-monitoring-tools.html
  * http://coding.smashingmagazine.com/2012/01/23/introduction-to-linux-commands/


## Node.js ##

**Todo**

  * http://garr.me/blog/running-node-js-and-apache-together-using-mod_proxy/
  * http://fhemberger.github.io/talks/nodejs-in-production/#/cover
  * http://www.kdelemme.com/2014/03/19/how-to-aggregate-data-from-mongodb-with-node-js-and-mongoose/


## COMMAND LINE (CMD, SHELL) ##

```

--- BASIC CMD ---------------------------------------------------------

sudo... !

reboot
init 6 (Restart machine)
locate | grep "img"
cat toto.log | more
nano text.conf
mv -v /home/from.gz  /opt/to.gz
rm -rf /opt/lampp 
cp /etc/network/interfaces /etc/network/interfaces.save
chown molokoloco index.php
chown -R root:root eclipse
chown -R --recursive hairbox.www-data /home/hairbox/*
chmod 605 /var/www/phpinfo.php
chmod -R 755 /var/www/phpinfo.php
chmod u+x proxytunnel-i386-linux // +x //execution
touch /usr/bin/eclipse
echo -e 'auto lo\niface lo inet loopback\n' | sudo tee /etc/network/interfaces
wget ftp://ftp.ovh.net/made-in-ovh/release/patch-all.sh -O patch-all.sh; sh patch-all.sh
adduser toto
cfdisk // Partititon
df -h // espace libre
free // memoire
rm -rf /tmp/*.wrk
ps auxw (processus) // ps -aux (Tous les process)
ps -auxf | sort -nr -k 3 | head -10 // Top 10 process
top // memoire
telnet localhost 80
gconf-editor
glxinfo | grep "direct rendering"
compizconfig-settings-manager
cp cfg ~/.entertainer -R // COPIER VERS /HOME
update-rc.d postfix disable // Désactiver postif au démarrage....
mount tmp/dd /dev/sda3 // Mount disk in rescue mode

# LINK
ln -s /etc/apache2/mods-available/userdir.load /etc/apache2/mods-enabled/userdir.load
ln -s /etc/apache2/sites-available/theatredesdeuxreves.org.conf /etc/apache2/sites-enabled/theatredesdeuxreves.org.conf
bebeserv:/etc/apache2/mods-enabled# ln -s ../mods-available/userdir.load userdir.load

# RECHERCHE
rgrep -i directoryindex -inH /etc/apache2 | grep conf  [Cherche le mot "directoryindex" dans un rep...]
grep localhost /etc/hosts
# Limiter la recherche
cat /var/log/Xorg.0.log | grep '(EE)

# NAVIGATEUR AVEC DROIT ROOT
gksudo nautilus

# EDITEUR AVEC DROIT ROOT
sudo gedit /etc/mysql/my.cnf

# Gnome : Sauvegarder sa configuration
gconftool-2 --dump / > /tmp/ma_conf.xml
# Restaurer sa configuration
gconftool-2 --load=/tmp/ma_conf.xml

# SSH TRANSFERT ... (D'un disque à un autre)
# /root/.ssh/authorized_keys2 ?
# sur le serveur a copier : ssh loginExtern@serveurExtern.com
scp -r root@213.186.46.78:/home/bibliobus/www/ /home/bibliobu/
chown bibliobu.users /home/bibliobu/www/*
chown mysql.mysql /home/mysql/bibliobu/*

Lancez PuTTY
putty -i 
Entrez dans le champs Host Name* entrez l'adresse ip du serveur puis cliquez sur Load**. 


#Connaitre sa version (etch , sarge...)
apt-cache policy
#ou alors
cat /etc/apt/preferences
#ou alors
cat /etc/apt/apt.conf

// Nettoyer la partition /boot

dpkg --get-selections|grep 'linux-image*'|awk '{print $1}'|egrep -v "linux-image-$(uname -r)|linux-image-generic" |while read n;do apt-get -y remove $n;done

--- VI ---------------------------------------------------------

VI (pico, nano)

y = copier la ligne en cour 
p = coller en dessous
	
i = insert text
o = creer une nouvelle ligne
x = efface un caractere
	
esc  = sortie edition
	
: = commande
w = write
q = quitter

--- RACCOURCIS ---------------------------------------------------------

Alt-F2 >> Open soft
Ctrl+Alt+F2 >> virtual console
Alt+PrintScreen+R+E+I+S+U+B > if really freeze

--- UBUNTU NETWORK ---------------------------------------------------------

sudo ifup eth1
sudo ifup --force eth1
sudo ifdown eth1
sudo ifconfig eth1
sudo iwconfig
sudo iwlist scanning
sudo /etc/init.d/networking restart
sudo /etc/init.d/NetworkManager restart
sudo lshw -C network
sudo ip addr show
cat /etc/network/interfaces
> auto lo
> iface lo inet loopback

# explicitly release the old address
sudo /etc/init.d/networking stop
sudo dhclient -r eth1
sudo /etc/init.d/networking start

apt-get install wireshark


dig b2bweb.fr
hostname
netstat
nslookup www.sgmtribe.org sd-15726.dedibox.fr
ping www.sgmtribe.org

// Graphs network
sudo apt-get install ntop

// Check security
nmap -sS -v -sV -p0-65535 www.XXX.com

// iptable, no brute force ?
iptables -A INPUT -i eth0 -p tcp –dport 22 -m state –state NEW -m recent –set –name SSH
iptables -A INPUT -i eth0 -p tcp –dport 22 -m state –state NEW -m recent –update –seconds 60 –hitcount 3 –rttl –name SSH -j DROP

--- XAMP - LAMPP ---------------------------------------------------------

http://doc.ubuntu-fr.org/xampp
http://www.polarion.org/index.php?page=installation&project=subversive
http://www.apachefriends.org/en/xampp-linux.html#381

sudo chmod a+x /opt/lampp/htdocs

sudo lampp start
sudo lampp restart
sudo lampp security
sudo lampp stop
sudo lampp

sudo gedit /opt/lampp/etc/proftpd.conf
sudo gedit /opt/lampp/etc/php.ini
sudo gedit /opt/lampp/etc/httpd.conf
sudo gedit /opt/lampp/etc/extra/httpd-vhosts.conf

```

### TCPdump ###

```
Tcpdump - Detailed Network Traffic Analysis
Simple command that dump traffic on a network. However, you need good understanding of TCP/IP protocol to utilize this tool. For.e.g to display traffic info about DNS, enter:
# tcpdump -i eth1 'udp port 53'

To display all IPv4 HTTP packets to and from port 80, i.e. print only packets that contain data, not, for example, SYN and FIN packets and ACK-only packets, enter:
# tcpdump 'tcp port 80 and (((ip[2:2] - ((ip[0]&0xf)<<2)) - ((tcp[12]&0xf0)>>2)) != 0)'

To display all FTP session to 202.54.1.5, enter:
# tcpdump -i eth1 'dst 202.54.1.5 and (port 21 or 20'
To display all HTTP session to 192.168.1.5:
# tcpdump -ni eth0 'dst 192.168.1.5 and tcp and port http'

```


# APTITUDE / APT-GET (IL FAUT CHOISIR :) #

```

--- APT ---------------------------------------------------------

sudo apt-get install build-essential

sudo apt-get update && apt-get dist-upgrade

apt-get -y --force-yes -f install proftpd

nano /etc/apt/source.list
deb http://packages.dotdeb.org stable all
deb-src http://packages.dotdeb.org stable all
apt-get update

sudo apt-get update
sudo apt-get install linux-restricted-modules-$(uname -r)
sudo apt-get autoremove

sudo apt-get install sun-java5-jre sun-java5-plugin # JAVA (firefox)

sudo apt-get install unrar
unrar e nom_du_fichier.rar

# deb http://ppa.launchpad.net/do-core/ubuntu hardy main
# deb http://ppa.launchpad.net/do-core/ubuntu hardy main
sudo apt-get install firestarter

apt://ubuntustudio-desktop;apt:ubuntustudio-icon-theme;apt:ubuntustudio-look;
apt:ubuntustudio-theme;apt:ubuntustudio-wallpapers;apt:usplash-theme-ubuntustudio

sudo apt-get install python-gobject python-gtk2 python-gst0.10 python-clutter python-pysqlite2 python-cddb python-glade2 python-cairo python-feedparser python-pyinotify python-eyed3 python-pyvorbis python-imaging python-imdbpy python-notify

sudo aptitude remove python-gobject python-gtk2 python-gst0.10 python-clutter python-pysqlite2 python-cddb python-glade2 python-cairo python-feedparser python-pyinotify python-eyed3 python-pyvorbis python-imaging python-imdbpy python-notify

apt://gnome-do

fgl_glxgears # (test)

sudo apt-get install azureus

--- APTITUDE ---------------------------------------------------------

http://qref.sourceforge.net/quick/ch-package.fr.html

aptitude update && aptitude dist-upgrade
#aptitude upgrade

aptitude install nano lynx zip unzip bzip2

aptitude -y --force-yes -f install proftpd

aptitude, la recherche d'un paquet se fait avec "/" puis en tapant une partie du nom et la touche "n" pour voir le match suivant

aptitude purge le-paquet
aptitude clean

dpkg-reconfigure - reconfigure un paquet déjà installé (s'il utilise debconf)
dpkg-source - gère les paquets sources
dpkg-buildpackage - automatise la création d'un paquet
apt-cache - recherche un paquet dans le cache local

aptitude en plein écran accepte des commandes à une touche, généralement en minuscule.

Touche Action
F10 Menu
? Aide (listing complet)
u Mise à jour des informations de l'archive de paquets
+ Marque un paquet pour mise-à-jour ou installation
- Marque un paquet pour suppression (garde la configuration)
_ Marque un paquet pour purge (supprime la configuration)
= Place un paquet en maintien
U Marque tous les paquets qui peuvent être mis à jour
g Téléchargement et installation des paquets sélectionnés
q Sortie de l'écran courant et sauvegarde des changements
x Sortie de l'écran courant sans sauvegarde
Enter Visualisation d'information sur un paquet
C Visualisation des changements d'un paquet
| Change la limite des paquets affichés
/ Recherche la première occurence
\ Répète la dernière recherche

Comme apt-get, aptitude installe les dépendances d'un paquet demandé. aptitude offre aussi une option pour récupérer les paquets qui sont recommandés ou suggérés par un paquet à installer. Vous pouvez changer ce comportement en choisissant
F10 -> Options -> Dependency handling dans le menu.

Autres avantages d'aptitude :

aptitude offre accès à toutes les versions d'un paquet.
aptitude enregistre toutes ses actions dans /var/log/aptitude.
aptitude rend facile le suivi des logiciels obsolètes en les listant dans « Obsolete and Locally Created Packages ».
aptitude inclut un système de recherche puissant pour trouver des paquets particuliers ou limité l'affichage des paquets. Les utilisateurs familiers avec mutt seront rapidement à l'aise, puisque mutt a inspiré la syntaxe des expressions. Voir « SEARCHING, LIMITING, AND EXPRESSIONS » dans /usr/share/doc/aptitude/README.
aptitude en plein écran intègre su et peut être utilisé par un utilisateur normal jusqu'à ce qu'il y ait réellement besoin des privilèges de l'administrateur.

aptitude upgrade (ou apt-get upgrade ou aptitude dist-upgrade ou apt-get dist-upgrade)
    Cela suit la distribution testing et met à jour tous les paquets du système en installant leurs dépendances de testing. [26]
apt-get dselect-upgrade
    Cela suit la distribution testing et met à jour tous les paquets du système avec la sélection de dselect.
aptitude install package/unstable
    Cela installe package de unstable en prenant les dépendances dans testing.
aptitude install -t unstable package
    Cela installe package de unstable en prenant les dépendances aussi dans unstable en mettant Pin-Priority de unstable à 990.
apt-cache policy foo bar ...
    Cela affiche l'état des paquets foo bar ....
aptitude show foo bar ... | less (ou apt-cache show foo bar ... | less)
    Cela affiche l'information sur les paquets foo bar ....
aptitude install foo=2.2.4-1
    Cela installe la version 2.2.4-1 du paquet foo.
aptitude install foo bar-
    Cela installe la paquet foo et supprime le paquet bar.
aptitude remove bar
    Cela supprime le paquet bar mais garde ses fichiers de configuration.
aptitude purge postfix

dpkg-reconfigure --priority=medium package [...]
dpkg-reconfigure --all # reconfigure tous les paquets
dpkg-reconfigure locales # génère de nouvelles locales
dpkg-reconfigure --p=low xserver-xfree86 # reconfigure le serveur X

apt-setup - crée /etc/apt/sources.list
install-mbr - installe un gestionnaire de Master Boot Record
tzconfig - configure le fuseau horaire local
gpmconfig - configure le gestionnaire de souris gpm
eximconfig - configure Exim (MTA)
texconfig - configure teTeX
apacheconfig - configure Apache (httpd)
cvsconfig - configure CVS
sndconfig - configure le système sonore
update-alternatives - configure la commande par défaut ; par exemple, vim pour vi
update-rc.d - gestion des scripts de démarrage System-V
update-menus - système de menus Debian
...

apt-get check # met à jour le cache et vérifie les dépendances
apt-cache search texte # cherche un paquet à partir de "texte"
apt-cache policy paquet # information sur la priorité d'un paquet
apt-cache show -a paquet # affiche la description d'un paquet dans toutes les distributions
apt-cache showpkg paquet # informations de debogage sur un paquet
dpkg --audit|-C # cherche les paquets partiellement installés
dpkg {-s|--status} paquet ... # état et description d'un paquet installé
dpkg -l paquet ... # état du paquet installé (1 ligne)
dpkg -L paquet ... # liste les noms des fichiers installés par le paquet

```

# LAMP FULL INSTALL #

```

*** APACHE ****
aptitude install apache2 apache2-doc
/etc/init.d/apache2 restart

*** PHPMYADMIN ****
# dependance complete LAMP SERVEUR ;)
aptitude install phpmyadmin

*** UTILS ****
aptitude install bind9

#nano /etc/apt/source.list
deb http://debian.home-dn.net/sargepostfix-vda/

apt-get install postfix postfix-mysql

apt-getinstallvsftpd

*** GD ****
aptitude install libtool libjpeg62 libjpeg62-dev libt1-dev libpng2 libfreetype6 libfreetype6-dev xlibs freetype2 xlibs-dev libpng3 libpng3-dev libfontconfig1 libfontconfig1-dev

*** IMAGE MAGICK ****
http://www.ducea.com/2006/12/21/install-imagemagick-557-on-debian/
aptitude install imagemagick

wget ftp://ftp.imagemagick.net/pub/ImageMagick/ImageMagick-5.5.7-36.tar.gz
./compile; make; make install

apt-get build-dep imagemagick

wget #http://ftp.fr.debian.org/debian/pool/main/i/imagemagick/imagemagick_6.2.4.5.dfsg1-1_i386.deb

*** MYSQL ****
aptitude install mysql-client mysql-common mysql-query-browser mysql-query-browser-common mysql-server

aptitude install mysql-server-5.0 mysql-client-5.0

#aptitude install mysql-client mysql-common mysql-navigator mysql-query-browser mysql-query-browser-common mysql-server

mysql -u root
mysql> USE mysql;
mysql> UPDATE user
    -> SET password = PASSWORD('bwZUjkyR')
    -> WHERE user = 'root';
mysql> flush privileges;
exit;

// DEBUG MYSQL (Lecture des fichiers logs binaire)
// http://dev.mysql.com/doc/refman/5.0/en/mysqlbinlog.html

cd /var/log/mysql/
sudo mysqlbinlog mysql-bin.[0-9]*


#Restaurer la base sivitsytem
#Un dump régulier est effectué chaque jour sur les serveurs en V2
#dans /var/backups/sivit sous forme de fichiers compréssés.
#Pour restaurer le dernier dump Mysql de cette base:

1/ Supprimer la base sivitsystem ( DROP )
2/ Creer une base sivitsystem vierge
3/ En console:

vdxxx:cd /var/backups/sivit
vdxxx:/var/backups/sivit# bunzip2 dump-sivitsystem-20070725.sql.bz2
vdxxx:/var/backups/sivit# ls
dump-sivitsystem-20070714.sql.bz2  dump-sivitsystem-20070725.bz2 dump-sivitsystem-20070725.sql
vdxxx:/var/backups/sivit# mysql -uroot -p sivitsystem < dump-sivitsystem-20070725.sql
Enter password: *********

sudo service mysql restart

*** PHP 5 ****
# Php 4 + php5 : http://www.generation-linux.net/article.php3?id_article=2
# Php 4 // aptitude install libapache2-mod-php4 php4-mysql php4-gd php4-cli php4-cgi php4-common php4-curl

apt-get install php5-curl php5-dev php5-gd php5-gmp php5-imap php5-ldap php5-mcrypt php5-mhash php5-ming
ln -s /usr/lib/libming.so.0 libming.so

#aptitude install libcurl3-dev libmcrypt-dev libzzip-dev freetype2 imagemagick expat libmhash-dev libmagic1 libapr0 libexpat1-dev libexpat1 libzzip-0-12 mimedecode mime-support libbz2-dev libgmp3-dev libncurses5-dev ssl-cert libc-client-dev libming-dev
#aptitude install php5 php5-cli php5-cgi php5-dba php5-spl php5-mysql php5-pgsql php5-simplexml php5-sqlite php5-bz2 php5-gd php5-imagick
#???# aptitude install php5-cgi php5-curl php5-imagick php5-json

aptitude search php5
apt-cache search php5

*** WEBMIN ****
#aptitude install webmin/unstable

aptitude install libnet-ssleay-perl libauthen-pam-perl libauthen-pam-perl libio-pty-perl libio-pty-perl libmd5-perl libmd5-perl

cd home/
mkdir download/
cd download/

wget http://heanet.dl.sourceforge.net/sourceforge/webadmin/webmin_1.350_all.deb
dpkg -i webmin_1.350_all.deb
aptitude install webmin/unstable

/etc/webmin/miniserv.conf

/etc/webmin/start

Ca marche ?
https://nsxxxxx.ovh.net:10000/
https://ns2xxxx.ovh.net:10000/file/


sudo /usr/share/webmin/changepass.pl /etc/webmin root votre_mot_de_passe
 
*** APACHE CONF ****
/etc/apache2/apache2.conf

http://www.paradoxal.org/blog/post/2007/06/13/Serveur-Debian-apache

# UserDir is now a module
UserDir public_html
UserDir disabled root

<Directory /home/*/public_html>
        AllowOverride FileInfo AuthConfig Limit
        Options Indexes SymLinksIfOwnerMatch IncludesNoExec
</Directory>

< mod mime ... >
    AddType application/x-httpd-php .php .phtml
    AddType application/x-httpd-php-source .phps


/etc/init.d/apache2 restart


#Apache propose aux utilisateurs du système d'avoir un espace public pour mettre des
documents web en général. Ce répertoire est assez #réstrictif, ce qui est bien, et root
n'y a pas le droit. Le module userdir d'Apache utilise les fichiers de configuration: 
#/etc/apache2/mods-available/userdir.conf et /etc/apache2/mods-available/userdir.load 
Pour que le module fonctionne, il faut créer des #liens symboliques de ces fichiers, 
vers le répertoire /etc/apache2/mods-enable.

#/home/user/public_html. Le répertoire public est ensuite accessible depuis l'url de la machine suivi de ~/user:

 $ su
ln -s /etc/apache2/mods-available/userdir.conf /etc/apache2/mods-enabled/userdir.conf
ln -s /etc/apache2/mods-available/userdir.load /etc/apache2/mods-enabled/userdir.load
/etc/init.d/apache2 reload


Cf. +++ WEBMIN +++

*** USER DIR ****
$ cd /home/giminik/
$ mkdir public_html
$ chmod 755 public_html/
$ chmod o+x ./
$ cd public_html
$ cat > index.php
<?php phpinfo(); ?>
CTRL+D pour fin de fichier

A partir de maintenant, l'espace Web personnel est accessible à partir de l'adresse http://127.0.0.1/~utilisateur/

*** SYSTEM CHECK ****
apt-get clean
aptitude clean

dpkg-reconfigure --all

# dpkg-reconfigure --apacheconfig
# updatedb
# locate httpd


*** FAIL2BAN ***
// http://www.generation-linux.fr/index.php?post/2010/12/27/Securisation-de-son-serveur-%3A-fail2ban

apt-get install fail2ban
cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

# jail.local :
[DEFAULT]
ignoreip = 127.0.0.1
bantime = 3600
findtime = 600
maxretry = 3

[ssh]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log
maxretry = 6

fail2ban-client reload
fail2ban-client status
iptables -L -v 

*** E-MAILS ****
# heu..
http://aide.sivit.fr/index.php?2007/02/01/158-installation-d-un-webmail-sous-debian-squirrelmail
# bug impossible remove sqwebmail
# update-rc.d -f exim4 remove", "reboot", "apt-get install postfix" pis "apt-get install sqwebmail".
/usr/sbin/sendmail -f login@domaine.com ...


aptitude  install uw-imapd

dans /etc/hosts.allow, ajouter une ligne : ALL : nom

aptitude install squirrelmail

/usr/sbin/squirrelmail-configure

cd etc/apache2/ssl/
ln -s usr/share/squirrelmail webmail

# webmin # Exim Monitor # category Servers

aptitude  install cyrus21-pop3d

aptitude install xinetd

/etc/init.d/xinetd reload



aptitude install mailutils mailx


TO CHECKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK !!!!!!!!!!!!!!!!!!!!!!!!!!!!!

*** AWSTATS ****
http://www.henol.fr/article-awstats.html

apt-get install awstats

TO CHECKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK !!!!!!!!!!!!!!!!!!!!!!!!!!!!!


*** FTP ****

aptitude install proftpd (cf. webmin)

# etc/proftpd/proftpd.conf

UseIPv6                on
ServerName            "nsxxxx.OVH.NET - Bienvenue *_*"
ServerAdmin         molokoloco@gmail.com
ServerType            standalone
DeferWelcome        on
MaxLoginAttempts    3
RequireValidShell    no
RootLogin             off
RequireValidShell    no
DeleteAbortedStores on
MultilineRFC2228     on
DefaultServer        on
ShowSymlinks        on
TimeoutNoTransfer     600
TimeoutStalled         600
TimeoutIdle         1200
DisplayLogin        welcome.msg
DisplayFirstChdir   message
ListOptions         "-l"
DenyFilter            \*.*/

<VirtualHost ftp.temp.saintdesprit.net>
    <Limit LOGIN>
        DenyAll
    </Limit>
   
    ServerName              "Casimir FTP service"
    TransferLog             /var/log/proftpd/temp.saintdesprit.net.log
    DefaultRoot             /home/casimir/
    User                    casimir
    Group                   casimir

    #<Anonymous home/casimir>
        #User            casimir
        #Group            casimir
        #UserAlias        anonymous ftp
    #</Anonymous>
</VirtualHost>

<Global>
    DefaultRoot ~
   
    <Directory /home/saintdes/>
        GroupOwner saintdes
        UserOwner saintdes
    </Directory>
    ...
</Global>

```

# APACHE UTILITIES #

```
--- LAMP ---------------------------------------------------------

http://doc.ubuntu-fr.org/lamp

sudo /etc/init.d/apache2 start
/etc/apache2/apache2.conf

/etc/php5/cgi/php.ini

sudo chmod 605 /var/www/phpinfo.php
sudo chmod 755 /var/www/phpinfo.php

tail -f /var/log/apache2/error.log

apt://apache2,apache2-doc,mysql-server,php5,libapache2-mod-php5,php5-mysql,phpmyadmin

PHP command : 		/usr/bin/php
PHP Parser command: 	/usr/bin/php -l -f {0}
Start Apache: 		/etc/init.d/apache2 start
Stop Apache: 		/etc/init.d/apache2 stop
Restart Apache: 	/etc/init.d/apache2 restart
Apache: 		/usr/bin/gksudo
Path to httpd.conf: 	/etc/apache2/httpd.conf
Path to etc/hosts: 	/etc/hosts
Start MySQL: 		/etc/init.d/mysql start
MySQL: 			/usr/bin/gksudo

/etc/init.d/apache2 reload  {start|stop|reload|reload-modules|force-reload|restart}
/etc/init.d/apache2 restart
/etc/init.d/xinetd reload
/etc/init.d/proftpd reload

# MOD AVAILABLE

a2enmod // modules disponibles
a2dismod // modules chargés

a2enmod nom_module // activer le module
a2dismod php4 // désactiver le module

# VIRTUAL HOST

cd /etc/apache2/sites-available

a2ensite mon_repertoire_virtuel // activer ce répertoire virtuel
a2dissite toto.org.conf // désactiver ce répertoire virtuel

# REINSTALL !!!

apt-get remove --purge apache2
puis au pire un rm -rf /etc/apache (mais normalement le dossier est vide)
apt-get install apache2

apres pour verifier si il est lancé :
ps -e (ca te donne tout les processus lancer)

ps -e|grep httpd


Fichier error log
# /usr/local/apache/logs
/var/log/apache2/


etc/mysql mysqlaccess my.conf


# DEPLACEMENT BASE SQL !!
/var/lib/mysql.BACKUP
/home/mysql/

/usr/share/apache2/error/include // error header

# Apache logs :
/var/log/apache2/
# Creation dans /usr/local/apache/logs
# CHECK : /home/log/

http://nsxxxx.ovh.net:10000/syslog/index.cgi

mysql -u root
mysql> USE mysql;
mysql> UPDATE user
    -> SET password = PASSWORD('faG5Xq8A')
    -> WHERE user = 'root';
mysql> flush privileges;

Déconnectez vous avec le commande
exit;
puis reconnectez vous
mysql -u root -p
MySQL vous demande alors votre mot de passe

nsxxxx:/# ps -all
F S UID PID PPID C PRI NI ADDR SZ WCHAN TTY TIME CMD
0 S 0 17581 1 0 85 0 - 1032 wait pts/1 00:00:00 mysqld_safe
nsxxxx:/# kill -9 17581

more

tail -f /var/log/apache2/access.log > /dev/tty11 &
affiche les dernières requêtes au serveur Apache, "en direct" sur la pseudo-console 11 (pour l'activer : alt-F11).
On peut utiliser aussi
less /var/log/apache/access.log puis Shift-F
pour basculer à la fin du fichier en attente de données (Ctrl-C pour finir)

SSL : http://www.coagul.org/article_imprime.php3?id_article=351

==========================================================================================
http://formation.bearstech.com/trac/wiki/GnuLinuxAdminApache

<VirtualHost *>
    ServerName mycompany.com
    RedirectMatch (.*) http://www.mycompany.com$1
</VirtualHost>

<VirtualHost *:80>
 ServerName    secure.example.org
 ServerAdmin   webmaster@example.org
 ServerSignature On

 # we don't need a DocumentRoot for zope only sites
 #DocumentRoot  /var/www/secure.example.org

 CustomLog     /var/log/apache2/secure.example.org-access.log combined
 ErrorLog      /var/log/apache2/secure.example.org-error.log
 LogLevel warn
 <IfModule mod_rewrite.c>
   RewriteEngine On

   # use RewriteLog to debug problems with your rewrite rules
   # disable it after you found the error our your harddisk will be filled *very fast*
   # RewriteLog "/var/log/apache2/rewrite_log"
   # RewriteLogLevel 2

   # Rewrite with redirect moved permanently
   RewriteRule ^/(.*) https://secure.example.org/$1 [R=301, L]
 </IfModule>
</VirtualHost>


logrotate fait l'affaire:

/var/log/apache2/*/*.log {
        weekly
        missingok
        rotate 52
        compress
}

==========================================================================================

SOA - Start Of Authority record identifies who hs authoritative responsinility for this Domain.
NS - NameServer Record maintains an authoritative set of resource records for the Domain.
CNAME - Canonical Name record is used to identify an alias host name.
MX - Records specifu a list of hosts that are configured to receive Mail sent to this Domain Name.
A - Address Record maps an IP Address a Host Name.
PTR - Record allows special Names to point to some other location in the Domain. ( PTR Records are used only in reverse domains IN-ADDR.ARPA )

==========================================================================================
IMAGE MAGICK

/usr/local/bin/

identify -list format
convert rose: rose.png

==========================================================================================

ADMIN EMAILS...

http://nsxxxx.ovh.net/cgi-bin/qmailadmin/
http://nsxxxx.ovh.net/cgi-bin/sqwebmail
http://nsxxxx.ovh.net:10000/qmailadmin/
http://nsxxxx.ovh.net:10000/mailboxes/index.cgi

==========================================================================================

http://guides.ovh.net/QueueQmailFull
http://guides.ovh.net/EmailProblemesEtSolutions
http://guides.ovh.net/InstallQmailAntiSpam
http://guides.ovh.net/QmailAdmin

/var/qmail/queue

/etc/init.d/qmail stop
/etc/init.d/qmail start
tail -f /var/log/qmail/current

cd /dev/queue-repair-0.9.0
ls -l queue

EDIT

http://forum.ovh.com/showthread.php?t=861&page=3
/home/vpopmail/domains/saintdesprit.net/.qmail-default
| /home/vpopmail/bin/vdelivermail '' bounce-no-mailbox
| /home/vpopmail/bin/vdelivermail '' delete

http://guides.ovh.net/InstallQmailAntiSpam
/etc/rc.d/init.d/qmail
/etc/rc.d/init.d/qmail.bak

Update perl.. http://www.cpan.org/authors/id/F/FE/FELICITY/Mail-SpamAssassin-3.1.8.tar.gz


MODULES WEBMIN

Shoutcast
Majordormo
qmail
.htpassword
php.ini
Perl version 5.6.0

==========================================================================================

SSH : ATTENTION CERTIFICAT DESACTIVE (WEBMIN CONF.)

[root@nsxxxx root]# ssh-keygen -t rsa
Generating public/private rsa key pair.
Enter file in which to save the key (/root/.ssh/id_rsa):
Enter passphrase (empty for no passphrase):
Enter same passphrase again:
Your identification has been saved in /root/.ssh/id_rsa.
Your public key has been saved in /root/.ssh/id_rsa.pub.
The key fingerprint is:

==========================================================================================

CRON JOB

-> DANS PUTTY
# c'est prêt, pour l'enclencher il suffit de faire:
crontab ~/etc/crontab.save

# faire ceci (pas avant d'avoir activer ma modif sinon tu la perd) :
crontab -l > ~/etc/crontab.save  (sauve le cron dans un fichier)
pico -w  ~/etc/crontab.save  (cela edite le  fichier, ctrl-x pour sortir)
crontab ~/etc/crontab.save    (rafraîchit le cron en prenant le fichier en question comme donnée)

-> DANS CRON.SAVE
0 0 * * * /usr/local/bin/lynx -dump 'http://www.autogir.fr/admin/maj?action=Update' >/dev/null

// Update images FTP
0 0 * * * /usr/local/bin/lynx -auth=autogir:web -dump 'http://www.autogir.fr/admin/maj/index.php?action=Update' >/dev/null


28 14 * * * /usr/local/bin/php -q /myscript.phtml
6 3 20 4 * /usr/local/bin/php -q /htdocs/www/x.php 

The first cron line above will run myscript.phtml located in your home directory every day at 2:28PM. The second line will run the script x.php from your /htdocs/www/ directory once a year on April 20th at 3:06AM. 
When you explicitly specify the php interpreter /usr/local/bin/php your scripts need not have filenames ending in .php .phtml .php3 .php4. Conversely, if your script filenames do not end in one of those PHP extensions, then you must explicitly use the php interpreter in the command portion of your cron as above.
The -q flag suppresses HTTP header output. As long as your script itself does not send anything to stdout, -q will prevent cron from sending you an email every time the script runs. For example, print and echo send to stdout. Avoid using these functions if you want to prevent cron from sending you email.
If your PHP scripts do have executable permissions like 755 or -rwxr-xr-x and they have one of the PHP filename extensions above, then you do not need to specify the php interpreter in the command portion of your cron line, like this:

5 17 * * 2 /myscript.php
The above cron would run myscript.php in your home directory every Tuesday at 5:05PM.


Last try :)

30 13 * * * root wget -O /dev/null http://toto.com/tv/index.php

```

# UBUNTU (is great !!!) #

```

To check your Ubuntu version, read the /etc/lsb-release file:
#cat /etc/lsb-release

--- ECLIPSE + GNOME MENU ITEM ---------------------------------------------------------

http://flurdy.com/docs/eclipse/install.html

tar xzf wtp-all-in-one-sdk-1.0-linux-gtk.tar.gz
sudo mv eclipse /opt/eclipse cd /opt sudo chown -R root:root eclipse
sudo chmod -R +r eclipse
sudo chmod +x `sudo find eclipse -type d`

# Then create an eclipse executable in your path
sudo touch /usr/bin/eclipse
sudo chmod 755 /usr/bin/eclipse
sudoedit /usr/bin/eclipse

# With this contents
#!/bin/sh
#export MOZILLA_FIVE_HOME="/usr/lib/mozilla/"
export ECLIPSE_HOME="/opt/eclipse"

$ECLIPSE_HOME/eclipse $*

Then create a gnome menu item
sudoedit /usr/share/applications/eclipse.desktop

With this contents
[Desktop Entry]
Encoding=UTF-8
Name=Eclipse
Comment=Eclipse IDE
Exec=eclipse
Icon=/opt/eclipse/icon.xpm
Terminal=false
Type=Application
Categories=GNOME;Application;Development;
StartupNotify=true
Configure

You now have a working eclipse. But run this command first to initialise the set up.
/opt/eclipse/eclipse -clean

Then from here on you can run from the menu item applications/programming/eclipse

/usr/lib/firefox/searchplugins/

--- FLASH ---------------------------------------------------------

Method #1: Install Ubuntu flash 10 Player
Visit this url and grab .deb file. Uninstall old flashplayer 9 ( if installed ):
    $ sudo apt-get remove flashplugin-nonfree
    Now, install Flash 10 (make sure Firefox is not running):
    $ sudo dpkg -i sudo dpkg -i install_flash_player_10_linux.deb
    Start firefox and type about:plugins. You should see list of plugins including Flash 10.

Method #2: Install Flash Player 10 Final in your home directory
If you need to install flash plugin in your home directory, type the following commands. To uninstall type the command:
    $ cd ~/.mozilla
    $ rm flashplayer.xpt libflashplayer.so
    Visit adobe website to grab flash player 10 tar.gz (tar ball). Download and install flash player 10 (please exit any browsers you may have running):
    $ cd /tmp
    $ wget http://fpdownload.macromedia.com/get/flashplayer/current/install_flash_player_10_linux.tar.gz
    $ tar -zxvf install_flash_player_10_linux.tar.gz
    $ cd install_flash_player_10_linux
    $ ./flashplayer-installer

```

--- MOT DE PASSE OUBLIE ? ----------------------------------------------------------

Voici une petite astuce toute simple pour changer le mot de passe de votre Ubuntu si vous l’avez perdu sans passer 3h à tout réinstaller.

  1. Il suffit de redémarrer votre PC et d’appuyer sur la touche ESC (Echap) lors du boot sur Grub
> 2. Ensuite, vous choisissez le boot de type « Recovery Mode«
> 3. Une fois que c’est booté, vous aurez un shell à votre disposition
> 4. Tapez alors la commande « passwd votre\_nom\_d\_utilisateur » en remplçant votre\_nom\_d\_utilisateur par le login que vous utilisez pour vous identifié. SI vous ne vous en souvenez plus, allez faire un « ls /home » pour connaitre les répertoires home présents sur votre Ubuntu qui portent généralement le même nom que le login.
> 5. Entrez ensuite votre mot de passe quand on vous le demande (en tout, 2 fois !)
> 6. Puis redemarrez avec un petit « shutdown -r now«

--- HOW TO ----------------------------------------------------------
http://doc.ubuntu-fr.org/
http://forum.ubuntu-fr.org/

--- ROOT DIR ----------------------------------------------------------
Name	Last modifiedSize	Description

bin/	10-Jan-2008 05:42 	- 	small scripts and tools
ext/	10-Jan-2008 05:42 	- 	hacks and contributions
lib/	13-Apr-2009 18:18 	- 	open-source projects
mus/	16-Oct-2008 07:10 	- 	sheet music and scores
spk/	10-Jan-2008 05:42 	- 	presentations and talks
src/	20-Jan-2009 23:05 	- 	code repositories
tmp/	10-Apr-2009 16:14 	- 	temporary files
txt/	02-Jun-2008 02:38 	- 	essays and research
web/	23-Nov-2008 07:16 	- 	my website and blog
gpg.asc	26-Sep-2007 04:52 	3.1K	my GPG public key

Apache Server at http://doc.ubuntu-fr.org/ Port 80


### /etc/mysql/my.cnf EXAMPLE ###

```
[client]
port		= 3306
socket		= /var/run/mysqld/mysqld.sock

[mysqld_safe]
socket		= /var/run/mysqld/mysqld.sock
nice		= 0
#err-log	= /var/log/mysql/error.log

[mysqld]
user		= mysql
pid-file	= /var/run/mysqld/mysqld.pid
socket = /var/run/mysqld/mysqld.sock
port = 3306
basedir	= /usr
datadir = /home/mysql-data
tmpdir		= /tmp
language	= /usr/share/mysql/english
#long_query_time	= 5
#log-slow-queries	= /var/log/mysql/slow_queries.log
#log-error	= /var/log/mysql/error.log

skip-external-locking
skip-bdb

# Test ###############
skip-slave-start
skip-innodb
skip-name-resolve
######################

key_buffer		= 24M
max_allowed_packet	= 16M
thread_stack		= 128K
thread_cache_size	= 8
myisam-recover	= BACKUP
query_cache_limit	= 1M
query_cache_size	= 16M

# Test ###############
sort_buffer_size = 4M
read_buffer_size = 4M
binlog_cache_size = 2M
table_cache = 128
thread_cache = 256
thread_concurrency = 4
myisam_sort_buffer_size = 1M
tmp_table_size = 12M
max_heap_table_size = 12M
wait_timeout = 200
interactive_timeout = 300
max_connect_errors = 10000
######################

expire_logs_days	= 2
max_binlog_size	= 32M
max_connections 	= 100
bind-address 		= 127.0.0.1

[mysqldump]
quick
quote-names
max_allowed_packet	= 16M

[mysql]

[isamchk]
key_buffer		= 24M
!includedir /etc/mysql/conf.d/
```