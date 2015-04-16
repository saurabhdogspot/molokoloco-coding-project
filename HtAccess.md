# .htaccess #

  * Doc here : http://www.askapache.com/htaccess/mod_rewrite-tips-and-tricks.html
  * HTaccess  Generator here : http://cooletips.de/htaccess/
  * HTpasswd Generator : http://www.htaccesstools.com/htpasswd-generator/
  * http://speckyboy.com/2013/01/08/useful-htaccess-snippets-and-hacks/

### URL rewriting ###

http://www.askapache.com/htaccess/crazy-advanced-mod_rewrite-tutorial.html

```
RewriteEngine on
#RewriteBase /

ErrorDocument 404 /404.php

# COMPRESS
#RewriteRule ^css/(.*\.css) cache.php?type=css&files=$1
#RewriteRule ^js/(.*\.js) cache.php?type=javascript&files=$1

# DYN REDIR
RewriteRule ^([a-z,-]+)-r([0-9]+).html(.*)$ index.php?rid=$2$3 [QSA,L]
RewriteRule ^([a-z,-]+)-r([0-9]+).html$ index.php?rid=$2 [L]
RewriteRule ^([a-z,-]+)-r([0-9]+)-a([0-9]+).html$ index.php?rid=$2&article_id=$3$4 [QSA,L]
RewriteRule ^([a-z,-]+)-r([0-9]+)-p([0-9]+).html$ index.php?rid=$2&page=$3$4 [QSA,L]


# Redirecting non www URL to www URL
RewriteCond %{HTTP_HOST} ^seo\.com$ [NC]
RewriteRule (.*) http://www.seo.com/$1 [L,R=301]

# If file not exists condition
RewriteCond %{REQUEST_fileNAME} !-f
RewriteRule ^([^.]+)\.s?html$ /app.php?file=$1 [L,R=301] 



# temp redirect wordpress content feeds to feedburner
<IfModule mod_rewrite.c>
 RewriteEngine on
 RewriteCond %{HTTP_USER_AGENT} !FeedBurner    [NC]
 RewriteCond %{HTTP_USER_AGENT} !FeedValidator [NC]
 RewriteRule ^feed/?([_0-9a-z-]+)?/?$ http://feeds.feedburner.com/WebDesignLedger [R=302,NC,L]
</IfModule>

```

### PHP.ini ###

```
#php_value memory_limit "99M"
#php_value post_max_size "99M" 
#php_value upload_max_filesize "99M"
```

### Restriction d'acces ###

http://httpd.apache.org/docs/2.0/howto/auth.html

1/ en ligne de commande

# htpasswd -c /home/passwd/ficherMdpACreer nomUtilisateur

2/ dans un .htaccess situé dans le répertoire à protéger  (les sous répertoires seront aussi protégés):

```
AuthType Basic
AuthName "Restricted Files"
AuthUserFile /home/passwd/ficherMdpACreer
Require user nomUtilisateur
```

et

```
AuthUserFile /dev/null
AuthGroupFile /dev/null
AuthName "Example Access Control"
AuthType Basic
<LIMIT GET>
order deny,allow
deny from all
allow from xx.xx.xx.xx
</LIMIT>
```

Pour un fichier..

```
<files wp-config.php>
order allow,deny
deny from all
</files>
```

// Holes in some dir ?

/home/user/www/.htaccess

```
AuthName "Restricted Area" 
AuthType Basic 
AuthUserFile /home/passwd/passwords
AuthGroupFile /dev/null 
require valid-user
Order deny,allow
Deny from all
Satisfy Any
```

/home/user/www/open/.htaccess

```
Satisfy Any
Allow from all
```

/home/user/www/open/protect/.htaccess

```
AuthType Basic
AuthName "Restricted Area"
AuthUserFile /home/passwd/passwords
AuthGroupFile /dev/null
require valid-user
Order deny,allow
Deny from all
Satisfy Any
```

### Utilisation avancée avec système de cache ###

http://www.askapache.com/htaccess/speed-up-sites-with-htaccess-caching.html

```

<IfModule mod_headers.c>

	# 1 YEAR
	<FilesMatch "\.(ico|pdf|flv)$">
	Header set Cache-Control "max-age=29030400, public"
	</FilesMatch>
	# 1 WEEK
	<FilesMatch "\.(jpg|jpeg|png|gif|swf)$">
	Header set Cache-Control "max-age=604800, public"
	</FilesMatch>
	# 2 DAYS
	<FilesMatch "\.(xml|txt|css|js)$">
	Header set Cache-Control "max-age=172800, proxy-revalidate"
	</FilesMatch>
	# 1 MIN
	<FilesMatch "\.(html|htm|php)$">
	Header set Cache-Control "max-age=60, private, proxy-revalidate"
	</FilesMatch>

</IfModule>

<IfModule mod_expires.c>

	ExpiresActive On
	ExpiresDefault A86400
	ExpiresByType image/x-icon A2419200
	ExpiresByType image/gif A604800
	ExpiresByType image/png A604800
	ExpiresByType image/jpeg A604800
	ExpiresByType text/css A604800
	ExpiresByType application/x-javascript A604800
	ExpiresByType text/plain A604800
	ExpiresByType application/x-shockwave-flash A604800
	ExpiresByType application/pdf A604800
	ExpiresByType text/html A900
		
	# Set up Cache Control headers
	ExpiresActive On
	# Default - Set http header to expire everything 1 week from last access, set must-revalidate
	expiresdefault A604800
	Header append Cache-Control: "must-revalidate"
	# Apply a customized Cache-Control header to frequently-updated files
	<FilesMatch "^(bulog¦test)\.html$">
		expiresdefault A1
		Header unset Cache-Control:
		Header append Cache-Control: "no-cache, must-revalidate"
	</FilesMatch>
	<FilesMatch "^index\.htm">
		expiresdefault A7200
	</FilesMatch>
	<FilesMatch "^robots\.txt$">
		expiresdefault A7200
	</FilesMatch> 
	
	# Infrequent htaccess file
	<FilesMatch "\.(gif¦jpe?g¦png¦css¦js¦ico¦pdf¦swf¦flv)$">
		expiresdefault A604800
	</FilesMatch> 

	# Frequent htaccess file 
	<FilesMatch "\.(gif¦jpe?g¦png¦css¦js¦ico¦pdf¦swf¦flv)$">
		expiresdefault A604800
		Header set cache-control: "no-cache, public, must-revalidate"
	</FilesMatch> 

</IfModule> 

```

### Systeme de cache ex : http://jqtouch.com/ ###

```

<ifModule mod_gzip.c>
  mod_gzip_on Yes
  mod_gzip_dechunk Yes
  mod_gzip_item_include file \.(html?|txt|css|js|php|pl)$
  mod_gzip_item_include handler ^cgi-script$
  mod_gzip_item_include mime ^text/.*
  mod_gzip_item_include mime ^application/x-javascript.*
  mod_gzip_item_exclude mime ^image/.*
  mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
</ifModule>

<ifModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/x-javascript
</ifModule>

<ifModule mod_expires.c>
  ExpiresActive On
  ExpiresDefault "access plus 1 seconds"
  ExpiresByType text/html "access plus 1 seconds"
  ExpiresByType image/gif "access plus 2592000 seconds"
  ExpiresByType image/jpeg "access plus 2592000 seconds"
  ExpiresByType image/png "access plus 2592000 seconds"
  ExpiresByType text/css "access plus 604800 seconds"
  ExpiresByType text/javascript "access plus 216000 seconds"
  ExpiresByType application/x-javascript "access plus 216000 seconds"
</ifModule>

<ifModule mod_headers.c>
  Header unset ETag
</ifModule>

FileETag None

<ifModule mod_headers.c>
  Header unset Last-Modified
</ifModule>

AddType text/cache-manifest .manifest

```

### Compression gZip ###

```

<IfModule mod_deflate.c>
	DeflateCompressionLevel 3
</IfModule>

<Location />
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/xml
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE image/svg+xml
	AddOutputFilterByType DEFLATE application/xhtml+xml
	AddOutputFilterByType DEFLATE application/xml
	AddOutputFilterByType DEFLATE application/rss+xml
	AddOutputFilterByType DEFLATE application/atom_xml
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE application/x-httpd-php
	
	SetOutputFilter DEFLATE
	
	SetEnvIfNoCase Request_URI \.(?:gif|jpe?g|png|css)$ no-gzip dont-vary
	SetEnvIfNoCase Request_URI \.(?:exe|t?gz|zip|bz2|sit|rar)$ no-gzip dont-vary
	SetEnvIfNoCase Request_URI \.(?:pdf|avi|mov|mp3|mp4|rm)$ no-gzip dont-vary
	
	BrowserMatch ^Mozilla/4 gzip-only-text/html
	BrowserMatch ^Mozilla/4\.0[678] no-gzip
	BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
	
	# Pour les proxies
	Header append Vary User-Agent env=!dont-vary
</Location>

```

### SSL ###
// To check

```

SSLEngine on
SSLCipherSuite ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP:+eNULL
SSLCertificateFile /etc/ssl/certs/apache.crt
SSLCertificateKeyFile /etc/ssl/private/apache.key
SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown downgrade-1.0 force-response-1.0
php_admin_flag safe_mode off

```

[./.htaccess](http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC/.htaccess)

[./cache.php](http://code.google.com/p/molokoloco-coding-project/source/browse/trunk/SITE_01_SRC/cache.php)