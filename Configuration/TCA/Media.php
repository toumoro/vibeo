<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_vibeo_domain_model_media'] = array(
	'ctrl' => $TCA['tx_vibeo_domain_model_media']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, author, description, path, url, image, track',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtitle, author, description, path, url, image, track,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_vibeo_domain_model_media',
				'foreign_table_where' => 'AND tx_vibeo_domain_model_media.pid=###CURRENT_PID### AND tx_vibeo_domain_model_media.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'subtitle' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.subtitle',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'author' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.author',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext[]',
		),
		'path' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.path',
			'config' => array(
				'type' => 'input',
				'size' => '50',
				'max' => '256',
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
						'params' => array(
							'allowedExtensions' => 'MP4, WEBM, OGG, MPEG, M4V, OGV, MOV, RTMP, AAC, MP1, MP2, MP3, MPG, M4A, OGA, WAV, FLV, WMV',
							'blindLinkOptions' => 'page,folder,mail,url',
						)
					),
				),
				'softref' => 'typolink',
				//'max_size' =>
			),
		),
		'url' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.image',
			'config' => array(
				'type' => 'input',
				'size' => '50',
				'max' => '256',
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
						'params' => array(
							'allowedExtensions' => 'JPG,JPEG,PNG,BMP,GIF',
							'blindLinkOptions' => 'page,folder,mail,url',
						)
					),
				),
				'softref' => 'typolink',
				//'max_size' =>
			),
		),
		'track' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media.track',
			'config' => array(
				'type' => 'input',
				'size' => '50',
				'max' => '256',
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
						'params' => array(
							'allowedExtensions' => 'VTT, TTML, SRT, TXT, CSV, XML',
							'blindLinkOptions' => 'page,folder,mail,url',
						)
					),
				),
				'softref' => 'typolink',
				//'max_size' =>
			),
		),
	),
);

?>