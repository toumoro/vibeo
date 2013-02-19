<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Philippe Moreau <philippe.moreau@qcmedia.ca>, Qc Média
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package vibeo
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Vibeo_Controller_MediaController extends Tx_Extbase_MVC_Controller_ActionController {

	static $headerIncluded = false;
	protected $extKey = 'vibeo';
	

	/**
	 * mediaRepository
	 *
	 * @var Tx_Vibeo_Domain_Repository_MediaRepository
	 */
	protected $mediaRepository;

	/**
	 * injectMediaRepository
	 *
	 * @param Tx_Vibeo_Domain_Repository_MediaRepository $mediaRepository
	 * @return void
	 */
	public function injectMediaRepository(Tx_Vibeo_Domain_Repository_MediaRepository $mediaRepository) {
		$this->mediaRepository = $mediaRepository;
	}
	
	/**
	 * Injects the Configuration Manager and is initializing the framework settings
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager Instance of the Configuration Manager
	 * @return void
	 */ 
	/*
	Code taken from "news" and not yet implemented. Used to merge ts and fleform settings and add stdWrap support to configuration.
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
$this->configurationManager = $configurationManager;

		$tsSettings = $this->configurationManager->getConfiguration(
				Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
				'news',
				'news_pi1'
			);
		$originalSettings = $this->configurationManager->getConfiguration(
				Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
			);

			// start override
		if (isset($tsSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$overrideIfEmpty = t3lib_div::trimExplode(',', $tsSettings['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
			foreach ($overrideIfEmpty as $key) {
					// if flexform setting is empty and value is available in TS
				if ((!isset($originalSettings[$key]) || empty($originalSettings[$key]))
						&& isset($tsSettings['settings'][$key])) {
					$originalSettings[$key] = $tsSettings['settings'][$key];
				}
			}
		}
		
		// Use stdWrap for given defined settings
		if (isset($originalSettings['useStdWrap']) && !empty($originalSettings['useStdWrap'])) {
			$typoScriptService = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService');
			$originalSettings = $typoScriptService->convertPlainArrayToTypoScriptArray($originalSettings);
			$stdWrapProperties = t3lib_div::trimExplode(',', $originalSettings['useStdWrap'], TRUE);

			foreach ($stdWrapProperties as $key) {
				if (is_array($originalSettings[$key . '.'])) {
					$originalSettings[$key] = $this->configurationManager->getContentObject()->stdWrap(
							$originalSettings[$key],
							$originalSettings[$key . '.']
					);
				}
			}
		}

		$this->settings = $originalSettings;
	}
	*/

	
	
	/**
	 * Initializes the current action
	 * This function is called automatically by the extbase framework
	 *
	 * @return void
	 */
	public function initializeAction() {
		//Validation. Quick & dirty message but should never appear in production.
		if(!isset($this->settings['includes']))
			return 'Typoscript setup file not included for qm_slider. Please include it somewhere.';
		
		// Width / height fix
		if($this->settings['player']['videoWidth'] <= 0)
			$this->settings['player']['videoWidth'] = $this->settings['player']['defaultVideoWidth'];
		if($this->settings['player']['videoHeight'] <= 0)
			$this->settings['player']['videoHeight'] = $this->settings['player']['defaultVideoHeight'];
			
		// Add headers as necessary
		$this->setHeaders();
	}
 
	
	/*
	* setHeaders
	* Set JS and CSS according to TS settings
	*
	* @return void
	*/
	protected function setHeaders() {
		if(!self::$headerIncluded) {
			if($this->settings['includes']['jquery'])
				$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');

			$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/Vibeo/mediaelement-and-player.min.js"></script>');

			if($this->settings['includes']['jquery-resize'])
				$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/Vibeo/jquery.ba-resize.min.js"></script>');
			if($this->settings['includes']['modernizr'])
				$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/Vibeo/modernizr-2.5.3.js"></script>');
						
			if($this->settings['includes']['css'])
				$this->response->addAdditionalHeaderData('<link rel="stylesheet" href="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/CSS/tx-vibeo.css" />');
				
			$this->response->addAdditionalHeaderData('
				<link rel="stylesheet" href="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/Vibeo/mediaelementplayer.css" />
				<link rel="stylesheet" href="'.t3lib_extMgm::siteRelPath($this->extKey).'Resources/Public/Vibeo/skin-gray.css" />
			');

			self::$headerIncluded = true;
		}
	}
	
	/**
	 * Generate the configuration string for the JS player. {...}
	 *
	 * @return string
	 */
	protected function getJSPlayerConfigurationString() {
		$options = array();
		
		foreach($this->settings['player'] as $param => $value) {
			$value = trim($value);
			
			if($value === '')
				continue;
			if(strpos($value, 'LLL:') === 0) // Language label
				$options[] = $param.': "'. Tx_Extbase_Utility_Localization::translate($value, $this->extKey) .'"';
			else
				$options[] = $param.':'.(is_numeric($value) || $value === 'true' || $value === 'false' || substr($value,0,8) == 'function' || $value[0] === '[' ? $value : '"'.$value.'"');
		}
		
		// Add callback function. Moved to TS
		//$options[] = 'success: function(media, node, player) {tx_vibeo_player_success_callback(media, node, player);}';
		
		return '{'.implode(',', $options).'}';	
	}
	
	
	
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
	
		//$medias = $this->mediaRepository->findAll();
	
		$pid = explode(',', $this->settings['records']['pages']);
		$uid = explode(',', $this->settings['records']['media']);

		$medias = empty($uid) && empty($pid) ? array() : $this->mediaRepository->findByUidOrPid($uid, $pid);
	
		if($this->settings['list']['startWithThumbnails']) {
			unset($this->settings['player']['defaultVideoWidth'],$this->settings['player']['defaultVideoHeight']);
			
			$this->view->assign('finalVideoWidth', $this->settings['player']['videoWidth']);
			$this->view->assign('finalVideoHeight', $this->settings['player']['videoHeight']);
			
			$this->settings['player']['videoWidth'] = round($this->settings['player']['videoWidth'] / 3, 0);
			$this->settings['player']['videoHeight'] = round($this->settings['player']['videoHeight'] / 3, 0);			
		}
		
		$this->view->assign('settings', $this->settings); // Reassign because we changed the settings
		$this->view->assign('medias', $medias);
		$this->view->assign('JSPlayerConfigurationString', $this->getJSPlayerConfigurationString());
		$this->view->assign('extRelativePath', t3lib_extMgm::extRelPath($this->extKey));
	}

	
	
	/**
	 * action show
	 *
	 * @param Tx_Vibeo_Domain_Model_Media $media
	 * @return void
	 */
	public function singleAction() {
	
		$media = new Tx_Vibeo_Domain_Model_Media();
		
		if($this->settings['media']['files'])
			$media->setPath($this->settings['media']['files']);
		if($this->settings['media']['description'])
			$media->setDescription($this->settings['media']['description']);
		if($this->settings['media']['url'])
			$media->setUrl($this->settings['media']['url']);
		if($this->settings['media']['image'])
			$media->setImage($this->settings['media']['image']);
		if($this->settings['media']['track'])
			$media->setTrack($this->settings['media']['track']);
		
		$this->view->assign('settings', $this->settings); // Reassign because we changed the settings
		$this->view->assign('media', $media);
		$this->view->assign('JSPlayerConfigurationString', $this->getJSPlayerConfigurationString());
		$this->view->assign('extRelativePath', t3lib_extMgm::extRelPath($this->extKey));
	}

}
?>
