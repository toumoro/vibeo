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
class Tx_Vibeo_Domain_Repository_MediaRepository extends Tx_Extbase_Persistence_Repository {


	public function initializeObject() {	
        $querySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }
	
	
	public function findByUidOrPid($uid = null, $pid = null) {
		$query = $this->createQuery();
		$conditions = array();
		
		if(is_null($uid) && is_null($pid))
			return null;
		
		$conditions[] = $query->in('uid', is_array($uid) ? $uid : array((int) $uid)); 
		$conditions[] = $query->in('pid', is_array($pid) ? $pid : array((int) $pid)); 
		
		$query->matching($query->logicalOr($conditions));
		 	
		return $query->execute();	
	}
}
?>