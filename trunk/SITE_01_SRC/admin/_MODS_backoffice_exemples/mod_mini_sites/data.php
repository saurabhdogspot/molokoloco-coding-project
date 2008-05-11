<?

// -------------------- CATEGORIES --------------------------- //

$R1 = array(
	'table'=>					'mod_mini_sites',
	'titre'=>					'Cat�gorie d\'actualit�',
	'titres'=>					'Cat�gories d\'actualit�',
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
	'filtre'=>					'',
	'ordre'=>					'ordre DESC',
	'miseenavant'=>				'',
	'fixe'=>					'',
	'tips '=>					'',
	'rep'=>						$rep.'mini_sites/',
	'sizeimg'=>					array('mini'=>'72x72', 'medium'=>'330x330', 'bandeau'=>'725x725', 'grand'=>'891x891')
);

$R1_data = array(
	array(
		'name'=>				'id'
	),
	array(
		'name'=>				'ordre',
		'titre'=>				'',
		'sqlType'=>				'int',
		'sqlDefaut'=>			1,
		'nbChar'=>				4,
		'bilingue'=>			'',
		'input'=>				'text',
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
		'index'=>				'1',
		'tips'=>				'',
		'separateur'=>			'',	
	),
	array(
		'name'=>				'actif',
		'titre'=>				'',
		'sqlType'=>				'tinyint',
		'sqlDefaut'=>			1,
		'nbChar'=>				1,
		'bilingue'=>			'',
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
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'une',
		'titre'=>				'A la une',
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
		'unique'=> 				1,
		'action'=>				'',
		'index'=>				1,
		'tips'=>				'Mini site � la une',
		'separateur'=>			'',
	),
	array(
		'name'=>				'titre',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'1',
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
		'name'=>				'sstitre',
		'titre'=>				'Sous-titre',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'1',
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
		'name'=>				'bandeau_fr',
		'titre'=>				'Bandeau mini-site <em>FR</em>',
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
		'tips'=>				'Formats : jpg/gif/png | Largeur fix�e � 891px',
	),
	array(
		'name'=>				'bandeau_uk',
		'titre'=>				'Bandeau mini-site <em>UK</em>',
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
		'index'=>				'',
		'tips'=>				'Formats : jpg/gif/png | Largeur fix�e � 891px',
	),
	array(
		'name'=>				'bandeau_home_fr',
		'titre'=>				'Bandeau home <em>FR</em>',
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
		'index'=>				'',
		'tips'=>				'Formats : jpg/gif/png | Largeur fix�e � 725px',
	),
	array(
		'name'=>				'bandeau_home_uk',
		'titre'=>				'Bandeau home <em>UK</em>',
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
		'index'=>				'',
		'tips'=>				'Formats : jpg/gif/png | Largeur fix�e � 725px',
	),
);
//$C = new SQL($R1); $C->createSQL($R1_data,'1');
//$C = new SQL($R1); $C->addSQL($R1_data);


// -------------------- PRODUITS 1 --------------------------- // 

$R2 = array(
	'table'=>					'mod_mini_sites_articles',
	'titre'=>					'Article',
	'titres'=>					'',
	'genre'=>					'',
	'relation'=>				$R1['table'].':id:titre_fr:mini_site_id',
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
	'filtre'=>					array('actif'=>'1'),
	'ordre'=>					' date DESC ',
	'miseenavant'=>				'',
	'fixe'=>					'',
	'tips '=>					'',
	'rep'=>						$rep.'mini_sites/',
	'sizeimg'=>					array('mini'=>'72x72', 'medium'=>'330x330', 'grand'=>'891x891')
);

$R2_data = array(
	array(name=>'id'),
	array(
		'name'=>				'actif',
		'titre'=>				'',
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
		'unique'=>				'',
		'action'=>				'',
		'index'=>				1,
		'tips'=>				''
	),
	array(
		'name'=>				'mini_site_id',
		'titre'=>				'Mini site',
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
		'name'=>				'date',
		'titre'=>				'Date et heure',
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
		'tips'=>				'Ex. : '.getDateTime()
	),

	array( 
		'name'=>				'titre',
		'titre'=>				'Titre',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'1',
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
		'titre'=>				'Introduction',
		'sqlType'=>				'text',
		'sqlDefaut'=>			'',
		'nbChar'=>				'',
		'bilingue'=>			'1',
		'input'=>				'textarea',
		'valeur'=>				'',
		'titrevaleur'=>			'',
		'wysiwyg'=>				2,
		'resize'=>				'',
		'htmDefaut'=>			'',
		'oblige'=>				'',
		'disable'=>				0,
		'relation'=>			'',
		'inc'=>					'',
		'unique'=>				'',
		'action'=>				'',
		'index'=>				'',
		'tips'=>				'',
	),

	array(
		'name'=>				'auteur',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'',
		'input'=>				'text',
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
		'separateur'=>			'Auteur'
	),
	array(
		'name'=>				'email',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'',
		'input'=>				'text',
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
		'separateur'=>			''
	),
	array(
		'name'=>				'fonction',
		'titre'=>				'',
		'sqlType'=>				'varchar',
		'sqlDefaut'=>			'',
		'nbChar'=>				150,
		'bilingue'=>			'1',
		'input'=>				'text',
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
		'separateur'=>			''
	),

);

//$C = new SQL($R2); $C->createSQL($R2_data,'1');
//$C = new SQL($R2); $C->addSQL($R2_data);

?>