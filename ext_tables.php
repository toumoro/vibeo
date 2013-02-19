<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Plugin
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Vibeomedialist',
	'Vibeo media list'
);
//t3lib_div::loadTCA('tt_content');
$pluginSignature = strtolower(t3lib_div::underscoredToUpperCamelCase($_EXTKEY)) . '_vibeomedialist';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_vibeomedialist.xml');

// Add to list of new content elements
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'][$pluginSignature . '_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'Resources/Private/PHP/class.vibeo_vibeomedialist_wizicon.php';
}


// Plugin
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Vibeosinglemedia',
	'Vibeo single media'
);
//t3lib_div::loadTCA('tt_content');
$pluginSignature = strtolower(t3lib_div::underscoredToUpperCamelCase($_EXTKEY)) . '_vibeosinglemedia';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_vibeosinglemedia.xml');

// Add to list of new content elements
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'][$pluginSignature . '_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'Resources/Private/PHP/class.vibeo_vibeosinglemedia_wizicon.php';
}

/*
t3lib_extMgm::addPlugin(array(
	'LLL:EXT:vibeo/locallang_db.xml:tt_content.list_type_pi1',
	$pluginSignature,
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');
*/
//t3lib_extMgm::addPlugin(array($pluginSignature, $pluginSignature), 'list_type');



// TS
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Vibéo accessible HTML5 media player - Based on MediaElement.js');

// TCA
t3lib_extMgm::addLLrefForTCAdescr('tx_vibeo_domain_model_media', 'EXT:vibeo/Resources/Private/Language/locallang_csh_tx_vibeo_domain_model_media.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_vibeo_domain_model_media');
$TCA['tx_vibeo_domain_model_media'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vibeo/Resources/Private/Language/locallang_db.xml:tx_vibeo_domain_model_media',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,subtitle,author,description,path,url,image,track,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Media.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vibeo_domain_model_media.gif'
	),
);


?>