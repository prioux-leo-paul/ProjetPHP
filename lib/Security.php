<?php
class Security {
    private static $seed ='qnf1qiojk4';

	public static function hacher($texte_en_clair) {
		$texte_hache = hash('sha256', $texte_en_clair);
		return static::$seed.$texte_hache;
	}
}


?>