<?php
/**
 *
 * NOTICE OF LICENSE
 * This Licence is only valid for one installation, you can sell it to
 * your customer and personalize it, but you can't install more than one
 * Licences, to install more licences buy another licences first.
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    venvaukt
 * @copyright venvaukt
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version 1.0.0
 * @category product
 * Registered Trademark & Property of venvaukt.com
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ClassJavascriptitems extends ObjectModel
{
    // this Parrametre for All Divices
    public $id_tab;
    public $id_shop;
    public $sort_order;
    public $Category;



    // this Parramtre fror Computer 
    public $status_C;
    public $title_C;
    public $header_color_C;
    public $is_hide_Nav_C;
    public $Animation_Nav_Icons_C;
    public $speed_C;
    public $delay_C;
    public $bgc_nav_C;
    public $color_nav_C;
    public $nbr_product_C;
    public $is_aleatior_C;
    public $is_Hide_View_all_C;
    public $size_C;


    // this pramms for Tablette
    public $status_T;
    public $title_T;
    public $header_color_T;
    public $is_hide_Nav_T;
    public $Animation_Nav_Icons_T;
    public $speed_T;
    public $delay_T;
    public $bgc_nav_T;
    public $color_nav_T;
    public $nbr_product_T;
    public $is_aleatior_T;
    public $is_Hide_View_all_T;
    public $size_T;
    

    // this Parrams for Mobile
    public $status_M;
    public $title_M;
    public $header_color_M;
    public $is_hide_Nav_M;
    public $Animation_Nav_Icons_M;
    public $speed_M;
    public $delay_M;
    public $bgc_nav_M;
    public $color_nav_M;
    public $nbr_product_M;
    public $is_aleatior_M;
    public $is_Hide_View_all_M;
    public $size_M;
    

    public static $definition = array(
        'table' => 'prestahope_items',
        'primary' => 'id_tab',
        'multilang' => false,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'Category' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 255),
                       
            'status_C' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'title_C' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'header_color_C' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'is_hide_Nav_C' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'Animation_Nav_Icons_C' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName' , 'size' => 255),
            'speed_C' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 6000 ),
            'delay_C' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 2000 ),
            'bgc_nav_C' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'color_nav_C' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'nbr_product_C' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 8),
            'is_aleatior_C' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'is_Hide_View_all_C' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'size_C' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 12),
                     
            'status_T' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'title_T' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'header_color_T' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'is_hide_Nav_T' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'Animation_Nav_Icons_T' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName' , 'size' => 255),
            'speed_T' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 6000 ),
            'delay_T' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 2000 ),
            'bgc_nav_T' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'color_nav_T' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'nbr_product_T' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 8),
            'is_aleatior_T' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'is_Hide_View_all_T' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'size_T' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 12),
            
            'status_M' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'title_M' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'header_color_M' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'is_hide_Nav_M' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'Animation_Nav_Icons_M' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName' , 'size' => 255),
            'speed_M' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 6000 ),
            'delay_M' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false , 'default' => 2000 ),
            'bgc_nav_M' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'color_nav_M' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'nbr_product_M' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 8),
            'is_aleatior_M' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'is_Hide_View_all_M' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'size_M' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false ,'default' => 12),
        ),
    );
    // this code is just to validate if nbr product is 4 or 6 or 12 . i should add the name of this function in the column size anside of is isunsignedInt

    // public static function validatesize($value)
    // {
    //     $allowedValues = array(4, 6, 12);
    //     if (!in_array($value, $allowedValues)) {
    //         return false;
    //     }
    //     return true;
    // }
    public static function getJavascriptList()
    {
        $sql = 'SELECT bonj.*
                FROM ' . _DB_PREFIX_ . 'prestahope_items bonj
                WHERE bonj.`id_shop` = '.(int)Context::getContext()->shop->id.'
                ORDER BY bonj.`sort_order`';
        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }
        return $result;
    }
    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'prestahope_items`
            WHERE id_shop = '.(int)$id_shop);
        if (!$result) {
            return false;
        }
        foreach ($result as $res) {
            $result = $res['sort_order'];
        }
        $result = $result + 1;

        return $result;
    }
    public function getTopFrontItems($id_shop, $Device ,$only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'prestahope_items bonj
                WHERE bonj.id_shop ='.(int)$id_shop;
        if ($only_active) {
            if($Device == "mobile")
            {
                $sql .= ' AND `status_M` = 1';
            }else if($Device == "tablet")
            {
                $sql .= ' AND `status_T` = 1';
            }else
            {
                $sql .= ' AND `status_C` = 1';
            }
        }
        $sql .= ' ORDER BY `sort_order`';
        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }
        return $result;
    }
}
