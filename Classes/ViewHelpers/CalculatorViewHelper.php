<?php

/**
 * This is a basic calculation view helper
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_Vibeo_ViewHelpers_CalculatorViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    /**
     * Renders some classic dummy content: Lorem Ipsum...
     *
     * @param int $equation The equation
     * @validate $equation IntegerValidator
     * @return Result
     * @author Philippe Moreau
     */
    public function render($equation) {
        eval('$result = '.$equation.';');
        return $result;
    }
}

?>