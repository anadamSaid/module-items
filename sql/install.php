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

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestahope_items` (
    `id_tab` int(11) NOT NULL AUTO_INCREMENT,
    `id_shop` int(11) NOT NULL DEFAULT \'1\',

    `status_C` tinyint(1) DEFAULT \'0\',
    `title_C` VARCHAR(100),
    `header_color_C` VARCHAR(100),
    `is_hide_Nav_C` tinyint(1) DEFAULT \'0\',
    `Animation_Nav_Icons_C` VARCHAR(100),
    `speed_C` int(11) DEFAULT \'6000\',
    `delay_C` int(11) DEFAULT \'2000\',
    `bgc_nav_C` VARCHAR(100),
    `color_nav_C` VARCHAR(100),
    `nbr_product_C` int(11) DEFAULT \'8\',
    `is_aleatior_C` tinyint(1) DEFAULT \'0\',
    `is_Hide_View_all_C` tinyint(1) DEFAULT \'0\',
    `size_C` int(11) DEFAULT \'12\',

    `status_T` tinyint(1) DEFAULT \'0\',
    `title_T` VARCHAR(100),
    `header_color_T` VARCHAR(100),
    `is_hide_Nav_T` tinyint(1) DEFAULT \'0\',
    `Animation_Nav_Icons_T` VARCHAR(100),
    `speed_T` int(11) DEFAULT \'6000\',
    `delay_T` int(11) DEFAULT \'2000\',
    `bgc_nav_T` VARCHAR(100),
    `color_nav_T` VARCHAR(100),
    `nbr_product_T` int(11) DEFAULT \'8\',
    `is_aleatior_T` tinyint(1) DEFAULT \'0\',
    `is_Hide_View_all_T` tinyint(1) DEFAULT \'0\',
    `size_T` int(11) DEFAULT \'12\',

    `status_M` tinyint(1) DEFAULT \'0\',
    `title_M` VARCHAR(100),
    `header_color_M` VARCHAR(100),
    `is_hide_Nav_M` tinyint(1) DEFAULT \'0\',
    `Animation_Nav_Icons_M` VARCHAR(100),
    `speed_M` int(11) DEFAULT \'6000\',
    `delay_M` int(11) DEFAULT \'2000\',
    `bgc_nav_M` VARCHAR(100),
    `color_nav_M` VARCHAR(100),
    `nbr_product_M` int(11) DEFAULT \'8\',
    `is_aleatior_M` tinyint(1) DEFAULT \'0\',
    `is_Hide_View_all_M` tinyint(1) DEFAULT \'0\',
    `size_M` int(11) DEFAULT \'12\',
      
    `Category` text NOT NULL,
    `sort_order` int(11) NOT NULL,
    PRIMARY KEY (`id_tab`, `id_shop`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
