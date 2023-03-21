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
include_once(_PS_MODULE_DIR_.'prestahope_items/classes/ClassJavascriptitems.php');

use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class Prestahope_items extends Module
{
    protected $config_form = false;
    public function __construct()
    {
        $this->name = 'prestahope_items';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'venVAUKT';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Product Showcase');
        $this->description = $this->l('The Product Showcase module allows you to easily create visually appealing sections on your home page that highlight your products using a customizable carousel');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }
    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'prestahope_items';
            }
        }
        $tab->class_name = 'AdminAjaxJavascript';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }
    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxJavascript')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }
        return true;
    }
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        return parent::install() &&
        $this->registerHook('displayHome') &&
        $this->createAjaxController() &&
        $this->registerHook('displayBackOfficeHeader') ;
    }
    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }
    public function getContent()
    {
        $output = '';
        $result ='';
        if ((bool)Tools::isSubmit('submitUpdateJavascript')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addJavascript();
            } else {
                $output = $result;
                $output .= $this->renderJavascriptForm();
            }
        }
        if ((bool)Tools::isSubmit('status_Cprestahope_items')) {
            $output .= $this->updateStatusTab("C");
        }
        if ((bool)Tools::isSubmit('status_Tprestahope_items')) {
            $output .= $this->updateStatusTab("T");
        }
        if ((bool)Tools::isSubmit('status_Mprestahope_items')) {
            $output .= $this->updateStatusTab("M");
        }
        if ((bool)Tools::isSubmit('is_aleatior_Cprestahope_items')) {
            $output .= $this->updateAleatoirTab();
        }
        if ((bool)Tools::isSubmit('deleteprestahope_items')) {
            $output .= $this->deleteJavascript();
        }
        if (Tools::getIsset('updateprestahope_items') || Tools::getValue('updateprestahope_items')) {
            $output .= $this->renderJavascriptForm();
        } elseif ((bool)Tools::isSubmit('addprestahope_items')) {
            $output .= $this->renderJavascriptForm();
        } elseif (!$result) {
            $output .= $this->renderJavascriptList();
        }
        return $output;
    }
    private function getPage()
    {
        $res = array();
        $controller = Dispatcher::getControllers(_PS_FRONT_CONTROLLER_DIR_);

        if (is_array($controller)) {
            foreach ($controller as $key => $arr) {
                array_push($res, array('id' => $key, 'name' => $key));
            }
            array_unshift($res, array('id' => 'all', 'name' => 'all'));
        }

        return $res;
    }
    protected function renderJavascriptForm()
    {
        $category = $this->getSelectedCategory(); 
        $category_options = array(
            'id' => 'home_featured_category',
            'selected_categories' => array($category),
        );

        // this Parramtre fror Computer 
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update module') : $this->l('Add module')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title_M',
                        'required' => true,
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status_M',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color of header'),
                        'name' => 'header_color_M',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color of nav items'),
                        'name' => 'bgc_nav_M',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color of nav items'),
                        'name' => 'color_nav_M',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide Navigation Icons'),
                        'name' => 'is_hide_Nav_M',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide View All (Footer)'),
                        'name' => 'is_Hide_View_all_M',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('is_aleatior'),
                        'name' => 'is_aleatior_M',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation Type of icons nav'),
                        'name' => 'Animation_Nav_Icons_M',
                        'required' => true,
                        'options' => array(
                                    'query' => $options = array(
                                                array(
                                                  'id_option' => "Bounce",
                                                  'name' => 'Bounce',    
                                                ),
                                                array(
                                                  'id_option' => "Flash",
                                                  'name' => 'Flash',
                                                ),
                                                array(
                                                    'id_option' => "Pulse",
                                                    'name' => 'Pulse',
                                                  ),
                                                array(
                                                    'id_option' => "shake X",
                                                    'name' => 'shake X',
                                                  ),
                                                array(
                                                    'id_option' => "shake Y",
                                                    'name' => 'shake Y',
                                                  ), 
                                                array(
                                                    'id_option' => "Tada",
                                                    'name' => 'Tada',
                                                  ),
                                                array(
                                                    'id_option' => "Heart beat",
                                                    'name' => 'Heart beat',
                                                  ),     
                                    ),
                                    'id' => 'id_option',
                                    'name' => 'name',
                                   ),
                                ),
                   
                    array(
                        'type' => 'text',
                        'label' => $this->l('speed'),
                        'name' => 'speed_M',
                        'required' => false,
                        'default' => '6000' ,
                        'col' => 2
                    ), 
                    array(
                        'type' => 'text',
                        'label' => $this->l('delay of nav items'),
                        'name' => 'delay_M',
                        'required' => false,
                        'default' => '2000' ,
                        'col' => 2
                    ), 
                    array(
                        'type' => 'text',
                        'label' => $this->l('nbr_product'),
                        'name' => 'nbr_product_M',
                        'default' => '8',
                        'required' => false,
                        'col' => 2
                    ),                   
                    array(
                        'type' => 'text',
                        'label' => $this->l('displayed Products'),
                        'name' => 'size_M',
                        'required' => false,
                        'col' => 2
                    ),

                      
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title_T',
                        'required' => true,
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status_T',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color of Banner'),
                        'name' => 'header_color_T',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color of nav items'),
                        'name' => 'bgc_nav_T',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color of nav items'),
                        'name' => 'color_nav_T',
                        'required' => false,
                        'col' => 2
                    ), 
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide Navigation Icons'),
                        'name' => 'is_hide_Nav_T',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide View All (Footer)'),
                        'name' => 'is_Hide_View_all_T',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('is_aleatior'),
                        'name' => 'is_aleatior_T',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation Type of icons nav'),
                        'name' => 'Animation_Nav_Icons_T',
                        'required' => true,
                        'options' => array(
                                    'query' => $options = array(
                                                array(
                                                  'id_option' => 1,
                                                  'name' => 'Bounce',    
                                                ),
                                                array(
                                                  'id_option' => 2,
                                                  'name' => 'Flash',
                                                ),
                                                array(
                                                    'id_option' => 3,
                                                    'name' => 'Pulse',
                                                  ),
                                                array(
                                                    'id_option' => 4,
                                                    'name' => 'shake X',
                                                  ),
                                                array(
                                                    'id_option' => 5,
                                                    'name' => 'shake Y',
                                                  ), 
                                                array(
                                                    'id_option' => 6,
                                                    'name' => 'Tada',
                                                  ),
                                                array(
                                                    'id_option' => 7,
                                                    'name' => 'Heart beat',
                                                  ),     
                                    ),
                                    'id' => 'id_option',
                                    'name' => 'name',
                                   ),
                            ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('speed'),
                        'name' => 'speed_T',
                        'required' => false,
                        'default' => '6000' ,
                        'col' => 2
                    ), 
                    array(
                        'type' => 'text',
                        'label' => $this->l('delay of nav items'),
                        'name' => 'delay_T',
                        'required' => false,
                        'default' => '2000' ,
                        'col' => 2
                    ), 
                    array(
                        'type' => 'text',
                        'label' => $this->l('nbr_product'),
                        'name' => 'nbr_product_T',
                        'default' => '8',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('displayed Products'),
                        'name' => 'size_T',
                        'required' => false,
                        'col' => 2
                    ),

                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title_C',
                        'required' => true,
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status_C',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color od Banner'),
                        'name' => 'header_color_C',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color of nav items'),
                        'name' => 'bgc_nav_C',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color of nav items'),
                        'name' => 'color_nav_C',
                        'required' => true,
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide Navigation Icons'),
                        'name' => 'is_hide_Nav_C',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('hide View All (Footer)'),
                        'name' => 'is_Hide_View_all_C',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('is_aleatior'),
                        'name' => 'is_aleatior_C',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation Type of icons nav'),
                        'name' => 'Animation_Nav_Icons_C',
                        'required' => true,
                        'options' => array(
                                    'query' => $options = array(
                                                array(
                                                  'id_option' => 1,
                                                  'name' => 'Bounce',    
                                                ),
                                                array(
                                                  'id_option' => 2,
                                                  'name' => 'Flash',
                                                ),
                                                array(
                                                    'id_option' => 3,
                                                    'name' => 'Pulse',
                                                  ),
                                                array(
                                                    'id_option' => 4,
                                                    'name' => 'shake X',
                                                  ),
                                                array(
                                                    'id_option' => 5,
                                                    'name' => 'shake Y',
                                                  ), 
                                                array(
                                                    'id_option' => 6,
                                                    'name' => 'Tada',
                                                  ),
                                                array(
                                                    'id_option' => 7,
                                                    'name' => 'Heart beat',
                                                  ),     
                                    ),
                                    'id' => 'id_option',
                                    'name' => 'name',
                                   ),
                                ),
                    
                    array(
                        'type' => 'text',
                        'label' => $this->l('speed'),
                        'name' => 'speed_C',
                        'required' => false,
                        'default' => '6000' ,
                        'col' => 2
                    ),               
                    array(
                        'type' => 'text',
                        'label' => $this->l('nbr_product'),
                        'name' => 'nbr_product_C',
                        'default' => '8',
                        'required' => false,
                        'col' => 2
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('delay of nav items'),
                        'name' => 'delay_C',
                        'required' => false,
                        'default' => '2000' ,
                        'col' => 2
                    ),   
                    array(
                        'type' => 'text',
                        'label' => $this->l('displayed Products'),
                        'name' => 'size_C',
                        'required' => false,
                        'col' => 2
                    ),

                    array(
                        'type' => 'categories',
                        'tree' => $category_options,
                        'label' => $this->trans('Category from which to pick products to be displayed', [], 'Modules.Featuredproducts.Admin'),
                        'name' => 'Category',
                        'col' => 6
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );
        if ((bool)Tools::getIsset('updateprestahope_items') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassJavascriptitems((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }
        $my_param = 2;
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateJavascript';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigJavascriptFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form));
    }
    protected function getConfigJavascriptFormValues()
    {
        if ((bool)Tools::getIsset('updateprestahope_items') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassJavascriptitems((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassJavascriptitems();
            $tab->title_M = "Titre de section" ;
            $tab->header_color_M = Configuration::get('QUICK_COLOR_SETUP1') ;
            $tab->color_nav_M = Configuration::get('PAGE_BUTTON_ACCENT');
            $tab->bgc_nav_M = Configuration::get('PAGE_BUTTONS_ACCENT_BG') ;
            $tab->delay_M = 2;
            $tab->speed_M = 6;
            $tab->size_M = 2;
            $tab->nbr_product_M = 8;
            $tab->Category_M = 8;
            $tab->Animation_Nav_Icons_M = 4;

            $tab->speed_T = 6;
            $tab->title_T = "Titre de section";
            $tab->header_color_T = Configuration::get('QUICK_COLOR_SETUP1');
            $tab->color_nav_T = Configuration::get('PAGE_BUTTON_ACCENT');
            $tab->bgc_nav_T = Configuration::get('PAGE_BUTTONS_ACCENT_BG');
            $tab->delay_T = 2 ;
            $tab->size_T = 5 ;
            $tab->nbr_product_T = 8 ;
            $tab->Category_T = 8 ;
            $tab->Animation_Nav_Icons_T = 4 ;

            $tab->speed_C = 6 ;
            $tab->title_C = "Titre de section" ;
            $tab->header_color_C = Configuration::get('QUICK_COLOR_SETUP1');
            $tab->color_nav_C = Configuration::get('PAGE_BUTTON_ACCENT');
            $tab->bgc_nav_C = Configuration::get('PAGE_BUTTONS_ACCENT_BG');
            $tab->delay_C = 2 ;
            $tab->size_C = 5 ;
            $tab->nbr_product_C = 8 ;
            $tab->Animation_Nav_Icons_C = 4 ;
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),

            'status_M' => Tools::getValue('status_M', $tab->status_M),
            'title_M' => Tools::getValue('title_M', $tab->title_M),
            'header_color_M' => Tools::getValue('header_color_M', $tab->header_color_M),
            'is_hide_Nav_M' => Tools::getValue('is_hide_Nav_M', $tab->is_hide_Nav_M),
            'Animation_Nav_Icons_M' => Tools::getValue('Animation_Nav_Icons_M', $tab->Animation_Nav_Icons_M),
            'speed_M' => Tools::getValue('speed_M', $tab->speed_M),
            'delay_M' => Tools::getValue('speed_M', $tab->delay_M),
            'color_nav_M' => Tools::getValue('speed_M', $tab->color_nav_M),
            'bgc_nav_M' => Tools::getValue('bgc_nav_M', $tab->bgc_nav_M),
            'delay_M' => Tools::getValue('speed_M', $tab->delay_M),
            'nbr_product_M' => Tools::getValue('nbr_product_M', $tab->nbr_product_M),
            'is_aleatior_M' => Tools::getValue('is_aleatior_M', $tab->is_aleatior_M),
            'is_Hide_View_all_M' => Tools::getValue('is_Hide_View_all_M', $tab->is_Hide_View_all_M),
            'size_M' => Tools::getValue('size_M', $tab->size_M),
            
            'status_T' => Tools::getValue('status_T', $tab->status_T),
            'title_T' => Tools::getValue('title_T', $tab->title_T),
            'header_color_T' => Tools::getValue('header_color_T', $tab->header_color_T),
            'is_hide_Nav_T' => Tools::getValue('is_hide_Nav_T', $tab->is_hide_Nav_T),
            'Animation_Nav_Icons_T' => Tools::getValue('Animation_Nav_Icons_T', $tab->Animation_Nav_Icons_T),
            'speed_T' => Tools::getValue('speed_T', $tab->speed_T),
            'delay_T' => Tools::getValue('speed_M', $tab->delay_T),
            'color_nav_T' => Tools::getValue('speed_M', $tab->color_nav_T),
            'bgc_nav_T' => Tools::getValue('bgc_nav_M', $tab->bgc_nav_T),
            'nbr_product_T' => Tools::getValue('nbr_product_T', $tab->nbr_product_T),
            'is_aleatior_T' => Tools::getValue('is_aleatior_T', $tab->is_aleatior_T),
            'is_Hide_View_all_T' => Tools::getValue('is_Hide_View_all_T', $tab->is_Hide_View_all_T),
            'size_T' => Tools::getValue('size_T', $tab->size_T),
            
            'status_C' => Tools::getValue('status_C', $tab->status_C),
            'title_C' => Tools::getValue('title_C', $tab->title_C),
            'header_color_C' => Tools::getValue('header_color_C', $tab->header_color_C),
            'is_hide_Nav_C' => Tools::getValue('is_hide_Nav_C', $tab->is_hide_Nav_C),
            'Animation_Nav_Icons_C' => Tools::getValue('Animation_Nav_Icons_C', $tab->Animation_Nav_Icons_C),
            'speed_C' => Tools::getValue('speed_C', $tab->speed_C),
            'delay_C' => Tools::getValue('speed_M', $tab->delay_C),
            'color_nav_C' => Tools::getValue('speed_M', $tab->color_nav_C),
            'bgc_nav_C' => Tools::getValue('bgc_nav_M', $tab->bgc_nav_C),
            'nbr_product_C' => Tools::getValue('nbr_product_C', $tab->nbr_product_C),
            'is_aleatior_C' => Tools::getValue('is_aleatior_C', $tab->is_aleatior_C),
            'is_Hide_View_all_C' => Tools::getValue('is_Hide_View_all_C', $tab->is_Hide_View_all_C),
            'size_C' => Tools::getValue('size_C', $tab->size_C),
            'Category' => Tools::getValue('Category', $tab->Category), 
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );
        return $fields_values;
    }

    protected function getSelectedCategory()
    {
        if ((bool)Tools::getIsset('updateprestahope_items') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassJavascriptitems((int)Tools::getValue('id_tab'));
            $Category_id = (int) Tools::getValue('Category', $tab->Category) ;
        } else {
            $Category_id = (int) Context::getContext()->shop->getCategory() ;
        }
        return $Category_id ;
    }
    public function renderJavascriptList()
    {
        if (!$tabs = ClassJavascriptitems::getJavascriptList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'title_C' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'is_aleatior_C' => array(
                'title' => $this->l('is_aleatior'),
                'type' => 'text',
                'active' => 'is_aleatior_C',
                'search' => false,
                'orderby' => false,
            ),
            'size_C' => array(
                'title' => $this->l('size'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'status_C' => array(
                'title' => $this->l('Status C'),
                'type' => 'bool',
                'active' => 'status_C',
                'search' => false,
                'orderby' => false,
            ),
            'status_M' => array(
                'title' => $this->l('Status M'),
                'type' => 'bool',
                'active' => 'status_M',
                'search' => false,
                'orderby' => false,
            ),
            'status_T' => array(
                'title' => $this->l('Status T'),
                'type' => 'bool',
                'active' => 'status_T',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order_C' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            )
        );
        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'prestahope_items';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                .'&configure='.$this->name.'&add'.$this->name
                .'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex
            .'&configure='.$this->name.'&id_shop='.(int)$this->context->shop->id;

        $helper->tpl_vars = array(
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateList($tabs, $fields_list);
    }
    protected function addJavascript()
    {
        $errors = array();
        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassJavascriptitems((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassJavascriptitems();
        }
        $item->id_shop = (int)$this->context->shop->id;

        $item->status_M = (int)Tools::getValue('status_M');
        $item->title_M = Tools::getValue('title_M');
        $item->header_color_M = Tools::getValue('header_color_M');
        $item->bgc_nav_M = Tools::getValue('bgc_nav_M');
        $item->color_nav_M = Tools::getValue('color_nav_M');
        $item->delay_M = Tools::getValue('delay_M');
        $item->is_hide_Nav_M = Tools::getValue('is_hide_Nav_M');
        $item->Animation_Nav_Icons_M = Tools::getValue('Animation_Nav_Icons_M');
        $item->speed_M = Tools::getValue('speed_M');
        $item->nbr_product_M = Tools::getValue('nbr_product_M');
        $item->is_aleatior_M = Tools::getValue('is_aleatior_M');
        $item->is_Hide_View_all_M = Tools::getValue('is_Hide_View_all_M');
        $item->size_M = Tools::getValue('size_M');
        
        $item->status_T = (int)Tools::getValue('status_T');
        $item->title_T = Tools::getValue('title_T');
        $item->header_color_T = Tools::getValue('header_color_T');
        $item->bgc_nav_T = Tools::getValue('bgc_nav_T');
        $item->color_nav_T = Tools::getValue('color_nav_T');
        $item->delay_T = Tools::getValue('delay_T');
        $item->is_hide_Nav_T = Tools::getValue('is_hide_Nav_T');
        $item->Animation_Nav_Icons_T = Tools::getValue('Animation_Nav_Icons_T');
        $item->speed_T = Tools::getValue('speed_T');
        $item->nbr_product_T = Tools::getValue('nbr_product_T');
        $item->is_aleatior_T = Tools::getValue('is_aleatior_T');
        $item->is_Hide_View_all_T = Tools::getValue('is_Hide_View_all_T');
        $item->size_T = Tools::getValue('size_T');
        
        $item->status_C = (int)Tools::getValue('status_C');
        $item->title_C = Tools::getValue('title_C');
        $item->header_color_C = Tools::getValue('header_color_C');
        $item->bgc_nav_C = Tools::getValue('bgc_nav_C');
        $item->color_nav_C = Tools::getValue('color_nav_C');
        $item->delay_C = Tools::getValue('delay_C');
        $item->is_hide_Nav_C = Tools::getValue('is_hide_Nav_C');
        $item->Animation_Nav_Icons_C = Tools::getValue('Animation_Nav_Icons_C');
        $item->speed_C = Tools::getValue('speed_C');
        $item->nbr_product_C = Tools::getValue('nbr_product_C');
        $item->is_aleatior_C = Tools::getValue('is_aleatior_C');
        $item->is_Hide_View_all_C = Tools::getValue('is_Hide_View_all_C');
        $item->size_C = Tools::getValue('size_C');
 
        $item->Category = Tools::getValue('Category');        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }
        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }
            return $this->displayConfirmation($this->l('The item is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }
    protected function preValidateForm()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('title'))) {
            $errors[] = $this->l('The title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title'))) {
            $errors[] = $this->l('Bad title format.');
        }
        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }
    protected function deleteJavascript()
    {
        $tab = new ClassJavascriptitems(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }
    protected function updateStatusTab($Device)
    {
        $tab = new ClassJavascriptitems(Tools::getValue('id_tab'));
        if($Device=="C")
        {
            if ($tab->status_C==1) {
                $tab->status_C=0;
            } else {
                $tab->status_C=1;
            }
        }else if($Device == "T")
        {
            if ($tab->status_T == 1) {
                $tab->status_T = 0;
            } else {
                $tab->status_T = 1;
            }
        }else if($Device == "M")
        {
            if ($tab->status_M == 1) {
                $tab->status_M = 0;
            } else {
                $tab->status_M = 1;
            }
        }
        if (!$tab->update()) {
            return $this->displayError($this->l('The tab status could not be updated.'));
        }
        return $this->displayConfirmation($this->l('The tab status is successfully updated.'));
    } 
    protected function updateAleatoirTab()
    {
        $tab = new ClassJavascriptitems(Tools::getValue('id_tab'));

        if ($tab->is_aleatior_C == 1) {
            $tab->is_aleatior_C = 0;
        } else {
            $tab->is_aleatior_C = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The tab is_aleatior could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The tab is_aleatior is successfully updated.'));
    }
    function get_device_type() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/tablet/i', $user_agent)) {
            return 'tablet';
        } elseif (preg_match('/mobile|android|iphone/i', $user_agent)) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }
    public function hookDisplayHome()
    {
        $javascript_front = new ClassJavascriptitems();
        $Device = $this->get_device_type() ;
        $tabs = $javascript_front->getTopFrontItems($this->id_shop, $Device,true);
        $result = array(); 
        // Loop through the tabs array and call the getProducts function for each item
        foreach ($tabs as $key => $tab) {
            if($Device == "mobile")
            {
                $result[$key]['title'] = $tab['title_M'];
                $result[$key]['Background'] = $tab['header_color_M'];
                $result[$key]['is_hide_Nav'] = $tab['is_hide_Nav_M'];
                $result[$key]['Animation_Nav_Icons'] = $tab['Animation_Nav_Icons_M'];
                $result[$key]['is_Hide_View_all'] = $tab['is_Hide_View_all_M'];
                $nbrProducts = $tab['nbr_product_M']; // Assuming that the nbr_product column name is 'nbr_product'
                $isRandom = $tab['is_aleatior_M']; // Assuming that the is_aleatior column name is 'is_aleatior'     
                $result[$key]['speed'] = $tab['speed_M'];
                $result[$key]['size'] = $tab['size_M'];
                $result[$key]['sizeMobile'] = $tab['size_M'];
                $result[$key]['delay'] = $tab['delay_M'];
                $result[$key]['bgc_nav'] = $tab['bgc_nav_M'];
                $result[$key]['color_nav'] = $tab['color_nav_M'];
            }
            else if($Device == "tablet"){
                $result[$key]['title'] = $tab['title_T'];
                $result[$key]['Background'] = $tab['header_color_T'];
                $result[$key]['is_hide_Nav'] = $tab['is_hide_Nav_T'];
                $result[$key]['Animation_Nav_Icons'] = $tab['Animation_Nav_Icons_T'];
                $result[$key]['is_Hide_View_all'] = $tab['is_Hide_View_all_T'];
                $nbrProducts = $tab['nbr_product_T']; // Assuming that the nbr_product column name is 'nbr_product'
                $isRandom = $tab['is_aleatior_T']; // Assuming that the is_aleatior column name is 'is_aleatior'     
                $result[$key]['speed'] = $tab['speed_T'];
                $result[$key]['size'] = $tab['size_T'];
                $result[$key]['delay'] = $tab['delay_T'];
                $result[$key]['bgc_nav'] = $tab['bgc_nav_T'];
                $result[$key]['color_nav'] = $tab['color_nav_T'];
            }else if($Device == "desktop")
            {
                $result[$key]['title'] = $tab['title_C'];
                $result[$key]['Background'] = $tab['header_color_C'];
                $result[$key]['is_hide_Nav'] = $tab['is_hide_Nav_C'];
                $result[$key]['Animation_Nav_Icons'] = $tab['Animation_Nav_Icons_C'];
                $result[$key]['is_Hide_View_all'] = $tab['is_Hide_View_all_C'];
                $nbrProducts = $tab['nbr_product_C']; // Assuming that the nbr_product column name is 'nbr_product'
                $isRandom = $tab['is_aleatior_C']; // Assuming that the is_aleatior column name is 'is_aleatior'     
                $result[$key]['speed'] = $tab['speed_C'];
                $result[$key]['size'] = $tab['size_C'];
                $result[$key]['delay'] = $tab['delay_C'];
                $result[$key]['bgc_nav'] = $tab['bgc_nav_C'];
                $result[$key]['color_nav'] = $tab['color_nav_C'];
                $result[$key]['sizeMobile'] = $tab['size_M'];
                if($nbrProducts <= $result[$key]['size'])
                {
                    $result[$key]['is_hide_Nav'] = true ;
                }
            }  
            $category = $tab['Category']; // Assuming that the category column name is 'Category'
            $result[$key]['id_tab'] = $tab['id_tab'];
            $result[$key]['UrlAllProducts'] = Context::getContext()->link->getCategoryLink($category);     
            $products = $this->getProducts($category, $nbrProducts, $isRandom);
            $result[$key]['products'] = $products;
        }
        // Pass the $result array to the template
        $this->context->smarty->assign('result', $result);
        // Return the template
        return $this->display($this->_path, '/views/templates/hook/home-page.tpl');
    }
    protected function getProducts($category,$nbrProducts,$random)
    {
        $category = new Category($category);

        $searchProvider = new CategoryProductSearchProvider(
            $this->context->getTranslator(),
            $category
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        if ($nbrProducts < 0) {
            $nbrProducts = 12;
        }

        $query
            ->setResultsPerPage($nbrProducts)
            ->setPage(1)
        ;

        if ($random) {
            $query->setSortOrder(SortOrder::random());
        } else {
            $query->setSortOrder(new SortOrder('product', 'position', 'asc'));
        }

        $result = $searchProvider->runQuery(
            $context,
            $query
        );

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();

        $products_for_template = [];

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxJavascript'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxJavascript'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/javascript_back.js');
        $this->context->controller->addCSS($this->_path.'views/css/javascript_back.css');
    }
}
