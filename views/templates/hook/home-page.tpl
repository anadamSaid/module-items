
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
{foreach from=$result key=key item=tab} 
    <section class="featured-products clearfix mt-3" id="PrestahopItem_{$tab.id_tab}">
        <div #swiperRef="" class="swiper">
        <div class="products-section-title container_ttl">
        <h2 class="h2 products-section-title text-capitalize">
             {$tab.title}
        </h2>
        {if !$tab.is_hide_Nav}
            <div class="Move_Products">
                <div class="swiper-button-prev" id="prev_btn_{$tab.id_tab}"></div>
                <div class="swiper-button-next" id="next_btn_{$tab.id_tab}"></div>
            </div>
        {/if}
        </div>
           {include file="./product/sample_tamplate.tpl" products=$tab.products cssClass="owl-carousel" productClass="" }
        </div>
        {if !$tab.is_Hide_View_all}
            <div class="seemore">
                <a class="all-product-link float-xs-left float-md-right h4" href="{$tab.UrlAllProducts}">
                    <span>{l s='View all' d='Shop.Theme.Catalog'}</span><i class="material-icons">&#xE315;</i>
                </a>
            </div>
        {/if}
    </section>
{/foreach}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script defer type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" ></script>
<script>
$(document).ready(() => {
    {foreach from=$result key=key item=tab}
        var owlCarrosel_{$tab.id_tab} = $('#PrestahopItem_{$tab.id_tab} .owl-carousel');
        owlCarrosel_{$tab.id_tab}.owlCarousel({
            loop: false,
            margin:10,
            nav:false,
            autoplay: true,
            rewind: true,
            autoplayHoverPause: true,
            slideSpeed: 0,
            // autoplayTimeout: 1000, 
            responsive:{
                    {assign var="item" value=0}
                    {assign var="value" value=0}
                    {for $foo=0 to $tab.size}
                        {$value}:{
                        items:{$item}
                        },
                        {assign var="item" value=$item+1}
                        {assign var="value" value=$value+220}
                    {/for}          
                }
        });
        {if !$tab.is_hide_Nav}
            $('#next_btn_{$tab.id_tab}').click(function() {
            owlCarrosel_{$tab.id_tab}.trigger('next.owl.carousel');
            });
            $('#prev_btn_{$tab.id_tab}').click(function() {
                owlCarrosel_{$tab.id_tab}.trigger('prev.owl.carousel');
            }); 
        {/if}
        owlCarrosel_{$tab.id_tab}.on('changed.owl.carousel', function(event) {
                var currentItem = event.item.index+{$tab.size};
                var totalItems = event.item.count;
                console.log(totalItems);
                console.log(currentItem);
                // Disable next button if on last item
                if (currentItem >= totalItems) {
                    document.querySelector("#next_btn_{$tab.id_tab}").classList.add("swiper-button-disabled");

                } else {
                document.querySelector("#next_btn_{$tab.id_tab}").classList.remove("swiper-button-disabled");
                }
                // Disable prev button if on first item
                if (currentItem <= 5) {
                    document.querySelector("#prev_btn_{$tab.id_tab}").classList.add("swiper-button-disabled");
                } else {
                    document.querySelector("#prev_btn_{$tab.id_tab}").classList.remove("swiper-button-disabled");
                }
        });
        
    {/foreach}
});
</script> 
<style>
@-webkit-keyframes bounce {
        0% {
                transform: scale(1,1) translate(0px, 0px);
          }
        30%{
                transform: scale(1,0.8) translate(0px, 2px); 
        }
        75%{
                transform: scale(1,1.1) translate(0px, -10px); 
        }
        100% {
                transform: scale(1,1) translate(0px, 0px);
        }
}
@-webkit-keyframes pulse {
  0% {
    transform: scale(0.9) ;
  }
  70% {
    transform: scale(1) ;
    box-shadow: 0 0 0 5px var(--page-hover);
  }
    100% {
    transform: scale(0.9) ;
    box-shadow: 0 0 0 0 var(--page-hover);
  }
}
@keyframes shakeX {
	10%, 90% {
    transform: translate3d(-1px, 0, 0);
  }
  20%, 80% {
    transform: translate3d(2px, 0, 0);
  }
  30%, 50%, 70% {
    transform: translate3d(-4px, 0, 0);
  }
  40%, 60% {
    transform: translate3d(4px, 0, 0);
  }
}
@keyframes shakeY {
	10%, 90% {
    transform: translate3d(0, -1px, 0);
  }
  20%, 80% {
    transform: translate3d(0, 2px, 0);
  }
  30%, 50%, 70% {
    transform: translate3d(0, -4px, 0);
  }
  40%, 60% {
    transform: translate3d(0, 4px, 0);
  }
}
@keyframes beat{
	to { transform: scale(1.1); }
}
@keyframes tada {  
  0% {
    transform: scaleZ(1);
   }
   10%, 20% {
    transform: scale3d(.9,.9,.9) rotate3d(0,0,1,-3deg);
   }
   30%, 50%, 70%, 90% {
    transform: scale3d(1.1,1.1,1.1) rotate3d(0,0,1,3deg);
   }
   40%, 60%, 80% {
    transform: scale3d(1.1,1.1,1.1) rotate3d(0,0,1,-3deg);
    }
    40%, 60%, 80% {
    transform: scale3d(1.1,1.1,1.1) rotate3d(0,0,1,-3deg);
    }
}
@keyframes flash {
   0%{
      opacity: 1;
   }
   25%{
      opacity: 0;
   }
   50%{
      opacity: 0;
   }
   100%{
      opacity: 1;
   }
}
{foreach from=$result key=key item=tab}

#PrestahopItem_{$tab.id_tab} .owl-stage
{
    transition-duration: {$tab.speed*1000}ms !important;
}
#PrestahopItem_{$tab.id_tab} .container_ttl , #PrestahopItem_{$tab.id_tab} .container_ttl h2
{
    background: {$tab.Background} !important;
}
#PrestahopItem_{$tab.id_tab} .Move_Products
{
    {if $tab.Animation_Nav_Icons == 1  }   
    animation: bounce 1s infinite !important;
    {else if $tab.Animation_Nav_Icons == 2 }
        animation: flash 1s infinite !important;
    {else if $tab.Animation_Nav_Icons == 3 }
        animation: pulse 1s infinite !important;
    {else if $tab.Animation_Nav_Icons == 4 }
        animation: shakeX 0.82s infinite !important;
    {else if $tab.Animation_Nav_Icons == 5 }
        animation: shakeY 0.82s infinite !important;
    {else if $tab.Animation_Nav_Icons == 6 }
        animation: tada 1s infinite !important;
    {else if $tab.Animation_Nav_Icons == 7 }
        animation: beat 0.5s infinite !important;
    {/if}
    animation-duration: {$tab.delay}s !important;
} ;
#prev_btn_{$tab.id_tab}:after , #next_btn_{$tab.id_tab}:after 
{
  background: {$tab.bgc_nav};
  color: {$tab.color_nav};
}
#next_btn_{$tab.id_tab}:after , #prev_btn_{$tab.id_tab}:after
{
  background:{$tab.bgc_nav};
  color: {$tab.color_nav};
}
{if  $tab.sizeMobile == 2}
@media only screen and (max-width: 600px) {
  #PrestahopItem_{$tab.id_tab} .owl-item
  {
      width: 150px !important;
  }
  #PrestahopItem_{$tab.id_tab} .product-miniature .thumbnail-top {
    height: 174px;
  }
}
{/if}
{/foreach}
</style>
