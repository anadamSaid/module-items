{*
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
*}

{extends file="helpers/list/list_footer.tpl"}
{block name="footer"}
  {if $list_id == 'prestahope_items'}
    <div class="panel-footer">
      <a href="" class="btn btn-default pull-right" onclick="sendBulkAction($(this).closest('form').get(0), 'addprestahope_items'); return false;">
        <i class="process-icon-plus" ></i> <span>{l s='Add new item' mod='prestahope_items'}</span>
      </a>
    </div>
  {/if}
  {$smarty.block.parent}
{/block}
