{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

{capture assign="productClasses"}
  {if !empty($productClass)}
       {$productClass}
  {else}    
  {/if}
{/capture}
<div class="products container {if !empty($cssClass)} {$cssClass}{/if}">
    {if $productClass == "PopularProducts"}  
        {foreach from=$products item="product" key="position"}
            {if $page.page_name == 'category' && $position==6}
                {hook h='displayCategoriesBanner'}
            {/if}
            {if $position % 4 == 0}<div class="row item col-lg-12" class={$productClass}">{/if}
                {include file="catalog/_partials/miniatures/product.tpl" product=$product position=$position}
            {if $position % 4 == 3 || $position == $products|@count-1}</div>{/if}
        {/foreach}
    {else}
        {foreach from=$products item="product" key="position"}
            {if $page.page_name == 'category' && $position==6}
                {hook h='displayCategoriesBanner'}
            {/if}
            {include file="catalog/_partials/miniatures/product.tpl" product=$product position=$position productClasses=$productClasses}
        {/foreach}
    {/if}
</div>
<script>
  var wishList_Products = JSON.parse(localStorage.getItem("WishListId") || "[]");
  var allPageProducts = document.getElementsByClassName('wishlist-button-add-remove');

  for (let index = 0; index < allPageProducts.length; index++) {
  const element = allPageProducts[index];
  if(wishList_Products.includes(element.attributes["data-productid"].value*1)){
      element.querySelector('.material-icons-outlined').textContent = "favorite"
      element.classList.add("inwishlist");
  }   
  }
  var wishList_Products = JSON.parse(localStorage.getItem("WishListId") || "[]");
  document.getElementById('wishlist-p-count').textContent= wishList_Products.length;
  document.getElementById('wishlist-p-count2').textContent= wishList_Products.length;
  if(wishList_Products.length){
  document.getElementById('wishlist-rubber').classList.remove("hide")
  document.getElementById('wishlist-rubber2').classList.remove("hide")
  }else{
  document.getElementById('wishlist-rubber').classList.add("hide")
  document.getElementById('wishlist-rubber2').classList.add("hide")
  }
  function AddToList(x){
  var wishList_Products = JSON.parse(localStorage.getItem("WishListId") || "[]");
  var queryselect  = "button[data-productid='"+x+"']";  
  var elem = document.querySelectorAll(queryselect)  ;
  if(wishList_Products.includes(x)){
      var index = wishList_Products.indexOf(x);
      if (index !== -1) {
          wishList_Products.splice(index, 1);
          localStorage.setItem("WishListId", JSON.stringify(wishList_Products));
      }
      document.getElementById('wishlist-p-count').textContent= wishList_Products.length;
      document.getElementById('wishlist-p-count2').textContent= wishList_Products.length;
      if(wishList_Products.length){
          document.getElementById('wishlist-rubber').classList.remove("hide")
          document.getElementById('wishlist-rubber2').classList.remove("hide")
      }else{
          document.getElementById('wishlist-rubber').classList.add("hide")
          document.getElementById('wishlist-rubber2').classList.add("hide")
      }
      for (let index = 0; index < elem.length; index++) {
          const element = elem[index];
          element.querySelector('.material-icons-outlined').textContent =  "favorite_border" ;       
          element.classList.remove("inwishlist");
      }
      
  }else{
      wishList_Products.push(x)
      localStorage.setItem("WishListId", JSON.stringify(wishList_Products));
      document.getElementById('wishlist-p-count').textContent= wishList_Products.length;
      document.getElementById('wishlist-p-count2').textContent= wishList_Products.length;
      if(wishList_Products.length){
          document.getElementById('wishlist-rubber').classList.remove("hide")
          document.getElementById('wishlist-rubber2').classList.remove("hide")
      }else{
          document.getElementById('wishlist-rubber').classList.add("hide")
          document.getElementById('wishlist-rubber2').classList.add("hide")
      }
      for (let index = 0; index < elem.length; index++) {
          const element = elem[index];
          element.querySelector('.material-icons-outlined').textContent =  "favorite" ;       
          element.classList.add("inwishlist");
      }
  }
  }
</script>

