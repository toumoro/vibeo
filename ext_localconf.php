<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Vibeomedialist',
	array( // Cacheable controller actions
		'Media' => 'list',
	),
	// non-cacheable actions
	array(
		'Media' => '',
	)
	//,Tx_Extbase_Utility_Extension::PLUGIN_TYPE_CONTENT_ELEMENT // Type: Tx_Extbase_Utility_Extension::PLUGIN_TYPE_PLUGIN (default) or Tx_Extbase_Utility_Extension::PLUGIN_TYPE_CONTENT_ELEMENT 
);


Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Vibeosinglemedia',
	array( // Cacheable controller actions
		'Media' => 'single',
	),
	// non-cacheable actions
	array(
		'Media' => '',
	)
	//,Tx_Extbase_Utility_Extension::PLUGIN_TYPE_CONTENT_ELEMENT // Type: Tx_Extbase_Utility_Extension::PLUGIN_TYPE_PLUGIN (default) or Tx_Extbase_Utility_Extension::PLUGIN_TYPE_CONTENT_ELEMENT 
);

?>