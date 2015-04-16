# INSTAL ADMIN #

  1. Create a new DB in [phpMyAdmin](http://www.easyphp.org/index.php)
  1. Edit the file `./admin/lib/racine.php` : `$dbase` , `$dbhost`, `$dblogin` (Ligne 75)
  1. With [phpMyAdmin](http://www.easyphp.org/index.php) , import default SQL data `./admin/lib/_SETUP_ADMIN_CMS.SQL` in this base
  1. Open Admin in your browser `http://127.0.0.1/www.site.com/admin/`

# CONFIGURING ADMIN #

  1. **Understanding admin squeleton :**

> All the pages in the admin are build with only three class, three types of view.
> The three class are based on the data description of a module

  * `admin\lib\class\class_admin_liste.php` : Print a view of all elements in a module, list of clients for exemple
  * `admin\lib\class\class_admin_fiche.php` : Print a editing view of an elements in a module, sheet of the clients for exemple
  * `admin\lib\class\class_admin_bdd.php` : Manage action doable to an elements in a module : Add, update, Delete

> This three class are surrounded by an overall header and footer
  * `admin\menu\menu.php` : General header, also build the admin menu
  * `admin\menu\menu_bas.php` : General footer

  1. **Editing the admin configuration file :**

  * `./admin/lib/racine.php` : READ AND EDIT WITH ATTENTION !
  * Remember to emphy the session parameters configuration by decommenting the 74' row : `### $_SESSION[SITE_CONFIG]['WWW'] = NULL;`, before reloading in your browser

  1. **Configuring some admin generals parameters :**

  * Going to `http://127.0.0.1/www.site.com/admin/admin_parametres/` : Edit the look and feel, logo, theme, etc...

# INSTAL THE FIRST MODULE #

  1. For each new module (ex : `./mod_clients/`)  drop it in `./admin/` folder
  1. Edit `./admin/lib/racine.php` : `$adminMenuAdmin` (Ligne 208) , your module appear in the admin menu
  1. Edit the data file for custom fields in `./mod_clients/data.php`
  1. When ready, decomment the last row in `data.php`
  1. Open the module in your browser `http://127.0.0.1/www.site.com/admin/mod_clients/`, the table is created
  1. Comment the last row in `data.php`
  1. Admin your clients ;)

# DEBUGGING #

  1. Global var `$debug = 1;` allow you to print requete
  1. Use en re-use the `db()` fonction, see in your browser what's going on : `db($_SESSION[SITE_CONFIG]);`

# WHAT'S A DATA ? #

Look at the numerous exemples provided in `./admin/_MODS_backoffice_exemples/`

```
// ------------------ DATA TYPE ELEMENT "TABLE" ------------------------------------------------- //

$R1 = array(
	'table'=>				'alertes_email',			// Nom de la table SQL
	'titre'=>				'Texte de e-mail',			// Titre a afficher
	'titres'=>				'Textes des e-mails',			// Si titre au pluriel est particulier
	'genre'=>				'e',									// '' (un) | 'e' (unE)
	'relation'=>				$R1['table'].':id:titre:cat_id', 	// mode "Catégorie" : parent:2 (2 enfants) | tableCat:champValeur:champTitre:champRelation
	'rubrelation'=>				'categories_offres:id:titre:parent_id', // mode "Rubrique"
	'childRel'=>				'categories_offres:categories_offres_produits:produits:cat_id=id:prod_id=id:titre:titre', // mode "Rubrique" (  | 1)
	'rubLevel'=>				'0:0',					// mode "Rubrique"
	'prodLevel'=>				'0:0',					// mode "Rubrique"
	'wherenot'=>				'cat_id < 1',				// Parametre supp. WHERE
	'postbdd'=>				'create_xml.php', 			// Include apres UPDATE BDD
	'preview'=>				$root.'index2.php?goto=actu_une', 	// To check... fonctionne avec "actif", ajoute "&id=33"
	'ifr '=>				'add_file.php', 			// Iframe sur la page LISTE
	'boutonFiche'=>				$boutonPrint, 				// Code html d'un bouton : Cf + haut
	'boutonListe'=>				$boutonPrint,
	'filtre'=>				array('statut'=>'1','type'=>'todo'),	// Filtre d'affichage > "todo" = aucune valeur par defaut
	'ordre'=>				'titre DESC',				// Ordre d'affichae en mode LISTE
	'miseenavant'=>				'sujet_liste',				// Colonne la plus large en mode LISTE
	'fixe'=>				0,					// O (normal) | 1 (pas d'ajout) | 2 (pas de modif)
	'tips '=>				'Une fois que l\'&quot;Actu&quot; est crée, il est possible d\'y attacher des médias', // TIPS sur la page FICHE
	'rep'=>					$rep.'actus/',				// Repertoire ou seront stocker les fichiers et les images
	'sizeimg'=>				array('mini'=>'120x100','medium'=>'240x190','tgrand'=>'520x520xXY') // rep => WIDTH x HEIGHT x RESIZE (ATTENTION optionnel : "tgrand" = valeur particuliere : stock l'image à la racine du rép),

	array('table'=>'matable', 'titre'=>'Actualité'), // Minimum table configuration
);

// ------------------ DATA TYPE ELEMENT "CHAMPS" ------------------------------------------------- //

$R1_data = array(
	array(
		'name'=>			'titre',				// Nom du champs sql, de l'input et, par défaut, titre affiché...
		'titre'=>			'Intilu&eacute;', 			// Le nom du champ par défaut "name" peut être remplacé à l'affichage
		'sqlType'=>			'varchar', 				// float | int | tinyint | varchar | text
		'sqlDefaut'=>			1,					// '' (NULL) | 1 (par defaut a l'insertion) 
		'nbChar'=>			255, 					// Nombre de caractères  : 1-255
		'bilingue'=>			1, 					// Champs en plusieur langues : 0 | 1
		'input'=>			'radio',				// text | textarea | radio | file | checkbox | radio | select | multiselect || '' (hidden en mode FICHE)
		'valeur'=>			array('1','0'), 			// Valeurs des inputs -> radio/select...
		'titrevaleur'=>			array('Oui','Non'), 			// Titre des inputs -> radio/select... : <option value="valeur">titrevaleur</option>
		'wysiwyg'=>			2, 					// Texte avec WYSIWYG 1 2 3 4 5 (style+hauteur dans wisiwg) | longText (hauteur textarea)
		'resize'=>			'XY',					// X, Y ou XY >> force le resize des images, vide par defaut, XY = crop, O = ombres sur PNG to jpg
		'htmDefaut'=>			'',					// '' (normal) | date | datetime | img | fichier | dateMod(modificationMAJ) | couleur | video
		'oblige'=>			1,					// Obligatoire (script vérification du formulaire)
		'disable'=>			1,					// Edition impossible
		'relation'=>			1, 					// 1 (Appartient a une cat) | produits_relation_rea:produits:cat_id=id:prod_id=id:nom-prenom#pid>0' (input multiselect avec htmlDefault)
		'inc'=>				'genres:id:titre', 			// Relation vers une table : tableRel:ChampsVal:ChampsTitre | projet:id:titre:unique:cat_id="'.$cat_id.'"
		'unique'=>			1,					// Si input "radio", cet enregistrement est le seul à pouvoir avoir cette valeur... (à la une)
		'action'=>			'!=:1:==:1:<script>window.open(\'send_mail.php?id='.$id.'\',\'\',\'width=250,height=100\');</script>', // Want fun ?
		'index'=>			1,					// Présence sur page LISTE : 0 | 1 
		'tips'=>			'Liste des <a href="../mod_membres/index.php?mode=fiche&id=\'.$F->V[\'0\'][$this->data[$i][\'name\'].\'_\'.$langue].\'" target="_blank">Profils</a>',													// Infos HTML à afficher sous Le champ (tips cool be with php (eval)
		'separateur'=>			'',					// A mettre dans une data pour séparer les infos suivantes sur la FICHE
	),
	array('name'=>'monchamps', 'sqlDefaut'=>'', 'sqlType'=>'varchar', 'nbChar'=>'100'), // Minimum field configuration
);
```

# DATA EXEMPLE : ACTUALITE #

```

// -------------------- CATEGORIES --------------------------- //

$R1 = array(
	'table'=>					'mod_actualites',
	'titre'=>					'Actualit�',
	'titres'=>					'',
	'genre'=>					'e',
	'relation'=>				'parent:1',
	'rubrelation'=>				'',
	'childRel'=>				'',
	'rubLevel'=>				'',
	'prodLevel'=>				'',
	'wherenot'=>				'',
	'postbdd'=>					'',
	'preview'=>					'',
	'ifr '=>					'',
	'boutonFiche'=>				'',
	'boutonListe'=>				'',
	'filtre'=>					array('statut'=>'todo'),
	'ordre'=>					'date DESC',
	'miseenavant'=>				'',
	'fixe'=>					'',
	'tips '=>					'',
	'rep'=>						$rep.'actualites/',
	'sizeimg'=>					array('mini'=>'150x120','medium'=>'240x190','tgrand'=>'520x520xXY')
);


$R1_data = array(
	array(
		'name'=>				'id'
	),
	array(
		'name'=>				'statut',
		'titre'=>				'',
		'sqlType'=>				'tinyint',
		'sqlDefaut'=>			1,
		'nbChar'=>				1,
		'bilingue'=>			0,
		'input'=>				'radio',
		'valeur'=>				array('1','2','3'),
		'titrevaleur'=>			array('A traiter', 'Valide', 'Non valide'),
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'une',
		'titre'=>				'Actualit&eacute; du mois',
		'sqlType'=>				'tinyint',
		'sqlDefaut'=>			1,
		'nbChar'=>				1,
		'bilingue'=>			0,
		'input'=>				'radio',
		'valeur'=>				array('1','0'),
		'titrevaleur'=>			array('Oui','Non'),
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				1,
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),

	array(
		'name'=>				'date',
		'titre'=>				'Date publication',
		'sqlType'=>				'datetime',
		'sqlDefaut'=>			'',
		'nbChar'=>				'',
		'bilingue'=>			0,
		'input'=>				'text',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'datetime',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				'Ex. : '.getDateTime(),
		'separateur'=>			'',
	),
	array(
		'name'=>				'titre',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			0,
		'input'=>				'text',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'texte',
		'titre'=>				'',
		'sqlType'=>				'text',
		'sqlDefaut'=>			0,
		'nbChar'=>				'',
		'bilingue'=>			0,
		'input'=>				'textarea',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				5,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				'',
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				0,
		'tips'=>				'',
	),
	array(
		'name'=>				'visuel',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				70,
		'bilingue'=>			0,
		'input'=>				'file',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'img',
		'oblige'=>				'',
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				'Formats : jpg/gif/png',
	),
);
//$C = new SQL($R1); $C->createSQL($R1_data,'1');
//$C = new SQL($R1); $C->addSQL($R1_data);


// -------------------- PRODUITS 1 --------------------------- // 
$R2 = array(
	'table'=>					'mod_actualites_commentaires',
	'titre'=>					'Commentaire',
	'titres'=>					'',
	'genre'=>					'',
	'relation'=>				$R1['table'].':id:titre:article_id',
	'rubrelation'=>				'',
	'childRel'=>				'',
	'rubLevel'=>				'',
	'prodLevel'=>				'',
	'wherenot'=>				'',
	'postbdd'=>					'',
	'preview'=>					'',
	'ifr '=>					'',
	'boutonFiche'=>				'',
	'boutonListe'=>				'',
	'filtre'=>					array('statut'=>'todo'),
	'ordre'=>					'date DESC',
	'miseenavant'=>				'statut',
	'fixe'=>					0,
	'tips '=>					'',
	'rep'=>						$rep.'actualites/',
	'sizeimg'=>					array('mini'=>'120x100','medium'=>'240x190','tgrand'=>'520x520xXY')
);
$R2_data = array(
	array(name=>'id'),

	array(
		'name'=>				'statut',
		'titre'=>				'',
		'sqlType'=>				'tinyint',
		'sqlDefaut'=>			1,
		'nbChar'=>				1,
		'bilingue'=>			0,
		'input'=>				'radio',
		'valeur'=>				array('1','2','3'),
		'titrevaleur'=>			array('A traiter', 'Valide', 'Non valide'),
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	
	array(
		'name'=>				'article_id',
		'titre'=>				'Actualité',
		'sqlType'=>				'int',
		'sqlDefaut'=>			1,
		'nbChar'=>				8,
		'bilingue'=>			0,
		'input'=>				'select',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			1,
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'auteur',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			0,
		'input'=>				'text',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'date',
		'titre'=>				'Date publication',
		'sqlType'=>				'datetime',
		'sqlDefaut'=>			'',
		'nbChar'=>				'',
		'bilingue'=>			0,
		'input'=>				'text',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'datetime',
		'oblige'=>				1,
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				'Ex. : '.getDateTime(),
		'separateur'=>			'',
	),
	
	array(
		'name'=>				'texte',
		'titre'=>				'Commentaire',
		'sqlType'=>				'text',
		'sqlDefaut'=>			0,
		'nbChar'=>				'',
		'bilingue'=>			0,
		'input'=>				'textarea',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				0,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				'',
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				0,
		'tips'=>				'',
	),

);
//$C = new SQL($R2); $C->createSQL($R2_data,'1');
//$C = new SQL($R2); $C->addSQL($R2_data);

```

# FONCTIONS LIST #

```
$user_fonctions = Array (
	[0] => isclient
	[1] => islocal
	[2] => db
	[3] => d
	[4] => getdb
	[5] => jsdb
	[6] => getvars
	[7] => dbb
	[8] => myinfo
	[9] => my_var_dump
	[10] => _generateid
	[11] => _my_var_dump_aux
	[12] => _unset_all_var_dump
	[13] => vd
	[14] => vdd
	[15] => cmd
	[16] => navdetect
	[17] => getnav
	[18] => getmycookie
	[19] => setmycookie
	[20] => delmycookie
	[21] => delallmycookie
	[22] => setisoheader
	[23] => setutf8header
	[24] => gpc
	[25] => js
	[26] => goto
	[27] => nocache
	[28] => setcache
	[29] => alert
	[30] => getatt
	[31] => gettag
	[32] => getcss
	[33] => form
	[34] => forme
	[35] => getformrow
	[36] => thisurl
	[37] => thisredir
	[38] => thispage
	[39] => checkref
	[40] => checkaction
	[41] => getip
	[42] => checkip
	[43] => stockip
	[44] => genpass
	[45] => generateid
	[46] => nextid
	[47] => fetchvalue
	[48] => fetchvalues
	[49] => fetchalerte
	[50] => mailto
	[51] => scale
	[52] => reduceimginhtml
	[53] => maskimginhtml
	[54] => genxcode
	[55] => makepage
	[56] => searchdb
	[57] => initsearch
	[58] => check_time
	[59] => getjsswfflv
	[60] => sanitize
	[61] => clean
	[62] => cleanwysiwyg
	[63] => cleanajax
	[64] => cleanname
	[65] => striptags
	[66] => aff
	[67] => affveryclean
	[68] => affcleanname
	[69] => quote
	[70] => squote
	[71] => html
	[72] => html_array
	[73] => htmlbuttags
	[74] => cleanxml
	[75] => affxml
	[76] => cleanrss
	[77] => makename
	[78] => cleantag
	[79] => detectencoding
	[80] => make_iso
	[81] => make_utf
	[82] => makeencoding
	[83] => stringtoregex
	[84] => inarrayregex
	[85] => issetarray
	[86] => strhighlight
	[87] => unhtmlentities
	[88] => bornes
	[89] => pad
	[90] => cleanko
	[91] => makeclickable
	[92] => html2rgb
	[93] => rgb2html
	[94] => ccs
	[95] => cs
	[96] => wrap
	[97] => t
	[98] => s
	[99] => checkmail
	[100] => rdate
	[101] => sqldatetorss
	[102] => datetoarray
	[103] => printdate
	[104] => getdatetime
	[105] => printdatetime
	[106] => relativedate
	[107] => urlrewrite
	[108] => makexml
	[109] => parsearrtorss
	[110] => getrssimage
	[111] => cleanjson
	[112] => getscriptbiarray
	[113] => urltojson
	[114] => getext
	[115] => getfileextension
	[116] => getfiletype
	[117] => getmime
	[118] => fixendpath
	[119] => getfilecontent
	[120] => getfile
	[121] => telecharger
	[122] => createfile
	[123] => writefile
	[124] => createrep
	[125] => copyfile
	[126] => copydirr
	[127] => rmdirr
	[128] => checkuploaderror
	[129] => xmltoarray
	[130] => getchildren
	[131] => q
	[132] => getelementstype
	[133] => parseabstractstring
	[134] => getpages
	[135] => getinputtr
	[136] => cleanserial
	[137] => cleanunserial
	[138] => error_hndl
	[139] => getcmshtml
	[140] => htmlwrap
);
```




http://molokoloco-coding-project.googlecode.com/svn-history/r86/trunk/SITE_01_SRC/admin/lib/_DOC_VIRTUAL_ADMIN.php