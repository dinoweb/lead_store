<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/vqmod/vqmod.php');

class myVQMod extends VQMod {
	/**
	 * VQMod::_checkMatch()
	 *
	 * @param string $modFilePath Modification path from a <file> node
	 * @param string $checkFilePath File path
	 * @return bool
	 * @description Checks a modification path against a file path
	 */
	private function _checkMatch($modFilePath, $checkFilePath) {

		$modFilePath = str_replace('\\', '/', $modFilePath);
		$checkFilePath = str_replace('\\', '/', $checkFilePath);



		$modFilePath = preg_replace('/([^*?]+)/e', 'preg_quote("$1", "~")', $modFilePath);
		$modFilePath = preg_replace('/[^*?]+\.shop\//e', '', $modFilePath);
		$modFilePath = preg_replace('/[^*?]*local\//e', '', $modFilePath);

		$checkFilePath = preg_replace('/[^*?]+\.shop\//e', '', $checkFilePath);
		$checkFilePath = preg_replace('/[^*?]*local\//e', '', $checkFilePath);
		$checkFilePath = preg_replace('/[^*?]+upload\//e', '', $checkFilePath);


		$modFilePath = str_replace('*/', '[^/]*/', $modFilePath);

		$return = (bool) preg_match('~^' . $modFilePath . '$~', $checkFilePath);
		return $return;

	}
}
