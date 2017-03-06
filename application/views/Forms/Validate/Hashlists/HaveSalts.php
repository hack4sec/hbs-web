<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Forms_Validate_Hashlists_HaveSalts extends Forms_Validate_Abstract {
    /**
     * Константы, содержащие ключи ошибок в общем массиве
     *
     * @var string
     */
    const SALTS_ERR_HAS = 'salts_err_has';
    const SALTS_ERR_HAS_NOT = 'salts_err_has_not';

    /**
     * Массив ошибок валидатора
     *
     * @var array
     */
    protected $_messageTemplates = [
        self::SALTS_ERR_HAS => 'L_OTHER_HASHLISTS_IT_ALG_HAS_SALTS',
        self::SALTS_ERR_HAS_NOT => 'L_OTHER_HASHLISTS_IT_ALG_HAS_NOT_SALTS',
    ];

    /**
     * Проверяем нет ли расхождения в наличии соли у этого листа и остальных с тем же
     * алгоритмом
     *
     * @return bool
     */
    public function isValid($value)
    {
        $Hashlists = new Hashlists();
        if ((int)$_POST['have_salts'] && $Hashlists->isThisAlgHasNotSalts($_POST['alg_id'])) {
            $this->_error(self::SALTS_ERR_HAS_NOT);
            return false;
        }
        if (!(int)$_POST['have_salts'] && $Hashlists->isThisAlgHasSalts($_POST['alg_id'])) {
            $this->_error(self::SALTS_ERR_HAS);
            return false;
        }
        return true;
    }
}
