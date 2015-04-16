# Some command line #

  * @username + message
> > directs a twitter at another person, and causes your twitter to save in their "replies" tab.
> > Example: @meangrape I love that song too!

  * D username + message
> > sends a person a private message that goes to their device, and saves in their web archive.
> > Example: d krissy want to pick a Jamba Juice for me while you're there?

  * WHOIS username
> > retrieves the profile information for any public user on Twitter.
> > Example: whois jack

  * GET username
> > retrieves the latest Twitter update posted by the person.
> > Example: get goldman

  * NUDGE username
> > reminds a friend to update by asking what they're doing on your behalf.
> > Example: nudge biz

  * FAV username
> > marks a person's last twitter as a favorite. (hint: reply to any update with FAV to mark it as a favorite if you're receiving it in real time)
> > Example: fav al3x

  * STATS
> > this command returns your number of followers, how many people you're following, and your bio information.

  * INVITE phone number
> > will send an SMS invite to a friend's mobile phone.
> > Example: Invite 415 555 1212


## Some code... ##


  * Get the public timeline in RSS format, unauthenticated: curl http://twitter.com/statuses/public_timeline.rss
  * Get updates from users you follow in XML, authenticated: curl -u username:password http://twitter.com/statuses/friends_timeline.xml
  * See just the headers for that last request: curl --head -u username:password http://twitter.com/statuses/friends_timeline.xml
  * Post a status update and get the resulting status back as JSON: curl -u username:password -d status="your message here" http://twitter.com/statuses/update.json

Learn more about cURL and the API here.
http://www.sakana.fr/blog/2007/03/18/scripting-twitter-with-curl/

## PHP CURL ACCESSOR ##

```

// url qui pointe vers l'action update, en xml ou json
$api_url = 'http://twitter.com/statuses/update.xml';

// l'information de votre compte
$username = 'usr';
$password = 'pwd';
$args = array('status'=>'Mon premier statut par curl');

// initialiser une session cUrl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password );
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // en secondes
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// pour éviter l'erreur HTTP 417 - Expectation Failed
$headers = array('Expect:', 'X-Twitter-Client: ', 'X-Twitter-Client-Version: ', 'X-Twitter-Client-URL: ');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// envoyer le message
$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if( intval( $info['http_code'] ) == 200 ) echo 'Message envoyé';  
else echo 'Erreur HTTP ' . $info['http_code'];  


```

## RESSOURCES ##

See the whole PHP Clean Class here :
http://www.phpclasses.org/browse/package/4216.html

And here a Javascript Framework
http://code.google.com/p/realtime-related-tweets-bar/