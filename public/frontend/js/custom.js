(function ($) {
    'use strict';
    /*Product Details*/
    

})(jQuery);

$( document ).ready(function() {


    // var productDetails = function () {
    //     $('.product-image-slider').slick({
    //         slidesToShow: 1,
    //         slidesToScroll: 1,
    //         arrows: false,
    //         fade: false,
    //         asNavFor: '.slider-nav-thumbnails',
    //     });

    //     $('.slider-nav-thumbnails').slick({
    //         slidesToShow: 5,
    //         slidesToScroll: 1,
    //         asNavFor: '.product-image-slider',
    //         dots: false,
    //         focusOnSelect: true,
    //         prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-angle-left"></i></button>',
    //         nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-angle-right"></i></button>'
    //     });

    //     // Remove active class from all thumbnail slides
    //     $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');

    //     // Set active class to first thumbnail slides
    //     $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');

    //     // On before slide change match active thumbnail to current slide
    //     $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
    //         var mySlideNumber = nextSlide;
    //         $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
    //         $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');
    //     });

    //     $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
    //         var img = $(slick.$slides[nextSlide]).find("img");
    //         $('.zoomWindowContainer,.zoomContainer').remove();
    //         $(img).elevateZoom({
    //             zoomType: "inner",
    //             cursor: "crosshair",
    //             zoomWindowFadeIn: 500,
    //             zoomWindowFadeOut: 750
    //         });
    //     });
    //     //Elevate Zoom
    //     if ( $(".product-image-slider").length ) {
    //         $('.product-image-slider .slick-active img').elevateZoom({
    //             zoomType: "inner",
    //             cursor: "crosshair",
    //             zoomWindowFadeIn: 500,
    //             zoomWindowFadeOut: 750
    //         });
    //     }
    //     //Filter color/Size
    //     // $('.list-filter').each(function () {
    //     //     $(this).find('a').on('click', function (event) {
    //     //         event.preventDefault();
    //     //         $(this).parent().siblings().removeClass('active');
    //     //         $(this).parent().toggleClass('active');
    //     //         $(this).parents('.attr-detail').find('.current-size').text($(this).text());
    //     //         $(this).parents('.attr-detail').find('.current-color').text($(this).attr('data-color'));
    //     //     });
    //     // });
    //     //Qty Up-Down
    //     $('.product-detail').find('.detail-qty').each(function () {
    //         var qtyval = parseInt($(this).find('.qty-val').text(), 10);
    //         // $('.qty-up').on('click', function (event) {
    //         //     event.preventDefault();

    //         //     qtyval = qtyval + 1;
    //         //     var stock = $(this).attr('data-stock');
    //         //     if(stock != null && stock != '' && qtyval > stock ){
    //         //         qtyval = stock;
    //         //     }
    //         //     $(this).prev().text(qtyval);
    //         // });
    //         // $('.qty-down').on('click', function (event) {
    //         //     event.preventDefault();
    //         //     qtyval = qtyval - 1;
    //         //     if (qtyval > 1) {
    //         //         $(this).next().text(qtyval);
    //         //     } else {
    //         //         qtyval = 1;
    //         //         $(this).next().text(qtyval);
    //         //     }
    //         // });
    //     });

    //     $('.dropdown-menu .cart_list').on('click', function (event) {
    //         event.stopPropagation();
    //     });
    // };
    /* WOW active */
    // new WOW().init();

    //Load functions
    //$(document).ready(function () {
        // productDetails();
    //});

    

    cartCount();

    function cartCount(){
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/cart-details",
            success: function (response) {
                $('.cart-count').html(response.count);
                //$('.cart-total').html(response.totalAmount);
                $('.cart-products-cont').html(response.details);

                //simple bar
                // var myElement = document.getElementsByClassName('cart-products-cont');
                // new SimpleBar(myElement, {
                //     autoHide: false,
                //     classNames: {
                //     // defaults
                //     content: "simplebar-content",
                //     scrollContent: "simplebar-scroll-content",
                //     scrollbar: "simplebar-scrollbar",
                //     track: "simplebar-track"
                //     }
                // });

                $('.cart-total').html(response.total);
                //console.log(response)
            }
        });
    }

    wishlistCount();

    function wishlistCount(){
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/wishlist-details",
            success: function (response) {
                $('.wishlist-count').html(response.count);
            }
        });
    }

//   $('body').on('click', '.add-to-wishlist', function () {
//     var that = $(this);
//     var key = that.attr('data-key');
//     var isPage = that.hasClass('wishlist__remove');

//     if(that.hasClass("added")){
//         $.ajax({
//             type: "POST",
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             url: site_url + "/remove-wishlist",
//             data: {key: key},
//             success: function (response) {
//                 if(response.result){
//                     that.removeClass("added");
//                     that.find("span").html('Add to wishlist');
//                     if(isPage){
//                         location.reload();
//                     }
//                 }
//             },
//             complete: function(xhr, textStatus) {
//                 // console.log(response);
//                 if(xhr.status == 401){
//                     window.location.href = site_url + "/login";
//                 }
//             }
//         });
//     }else{
//         $.ajax({
//             type: "POST",
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             url: site_url + "/add-wishlist",
//             data: {key: key},
//             success: function (response) {
//                 if(response.result){
//                     that.addClass("added");
//                     that.find("span").html('Added in wishlist');
//                 }
//             },
//             complete: function(xhr, textStatus) {
//                 // console.log(response);
//                 if(xhr.status == 401){
//                     window.location.href = site_url + "/login";
//                 }
//             }
//         });
//     }

//     return false;

// })


$('body').on('click', '.add-cart', function () {
    var that = $(this);
    var key = that.attr('data-key');
    var page = that.attr('data-page');
    //var isWishlist = that.hasClass('wishlist-cart');
    //var quantity = $('#quantity').find('input').val();
    $('#attribute-selected-error').text('');

    if(that.hasClass('disabled')){
        console.log('disabled');
        $('#attribute-selected-error').text('Select Pack');
        return false;
    }

    var quantity = that.closest('.detail-info').find('.qty-val').val();

    

    if(typeof quantity === 'undefined' || quantity == '' || quantity == null){
        quantity = 1;
    }

    quantity = parseInt(quantity);

    var attribute = null;
    if($('#attribute_id').length > 0){
        attribute = $('#attribute_id').val();
    }

    if(page == 'wishlist'){
        attribute = that.attr('data-attribute');
    }
    

    $('.loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/add-cart",
        data: {key: key, quantity: quantity, attribute:attribute, page:page},
        success: function (response) {
            $('.loader').addClass('d-none');
            cartCount();

            if(response.result){
                renderCartButtonsHtml('add', that, page, response.update_html, response.wishlistCount);
                toastr.success(response.message,'Success');

                updateCouponHtml(response.coupon_error, response.coupon_code);
                
                return false;
            }else{
                toastr.error(response.message,'Error');
            }
            
        },
        complete: function(xhr, textStatus) {
            //$('.loader').addClass('d-none');
            // console.log(response);
            if(xhr.status == 401){
                window.location.href = site_url + "/login";
            }
        }
    });
    return false;

})


function renderCartButtonsHtml(event, that, page, update_html = null, wishlistCount = null){
    
    if(event == 'add'){
        
        if(page == 'list'){
            // that.attr('aria-label', (update_html != null) ? update_html : 'Remove From Cart');
            // that.text( (update_html != null) ? update_html : 'Remove from cart');
            // that.addClass('delete-cart').removeClass('add-cart');
            that.find('i').addClass('fi-rs-trash').removeClass('fi-rs-shopping-bag-add');
            
        }
        if(page == 'detail'){
            // that.addClass('delete-cart').removeClass('add-cart');
            // that.text( (update_html != null) ? update_html : 'Remove from cart');
            // $('.detail-qty').addClass('d-none');

            if($('.remove-service, .add-service').length > 0){
                $('.remove-service, .add-service').prop('disabled',false);
            }
        }
        if(page == 'wishlist'){

            if(wishlistCount > 0){
                that.closest('tr').remove();
            }else{
                that.closest('.wishlist-table').after('<p class="my-3 text-center"> Wishlist is Empty</p>');
                that.closest('.wishlist-table').remove();
            }
            $('.wishlist-count').html(wishlistCount);

            // that.addClass('delete-cart').removeClass('add-cart');
            // that.text('Remove from cart');
            // $('.detail-qty').addClass('d-none');
        }
    }



    if(event == 'delete'){
        if(page == 'list'){
            // that.attr('aria-label',  (update_html != null) ? update_html : 'Add to Cart');
            that.text( (update_html != null) ? update_html : 'Add to Cart');
            that.addClass('add-cart').removeClass('delete-cart');
            that.find('i').addClass('fi-rs-shopping-bag-add').removeClass('fi-rs-trash');
          }
          if(page == 'detail'){
            that.addClass('add-cart').removeClass('delete-cart');
            that.text( (update_html != null) ? update_html : 'Add to cart');
            that.closest('.product-detail').find('.detail-qty').removeClass('d-none');
            that.closest('.product-detail').find('.qty-val').val(1);

            if($('.remove-service, .add-service').length > 0){
                $('.remove-service, .add-service').prop('disabled',true);
                $('.service').text('Add Service');
                $('.service').removeClass('remove-service').addClass('add-service');

                $('.addon').text('Add Addon');
                $('.addon').removeClass('remove-addon').addClass('add-addon');

            }
          }
    }
}



$('body').on('click', '.delete-cart', function () {
    var that = $(this);
    //var ID = that.closest('.cart-item').find('input[type=hidden]').val();
    var key = that.attr('data-key');
    var page = that.attr('data-page');
        
    var attribute = null;
    if(that.closest('tr').find('[name="product_attribute"]').length > 0){
        attribute = that.closest('tr').find('[name="product_attribute"]').val();
    }

    if (that.attr('data-attribute')) {
        attribute = that.attr('data-attribute');
    }

    if($('#attribute_id').length > 0){
        attribute = $('#attribute_id').val();
    }

    // alert(attribute);
    // return false;

    $('.loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/delete-cart",
        data: {key: key, attribute: attribute},
        success: function (response) {
            //$('.loader').addClass('d-none');
            //location.reload();

            $('.loader').addClass('d-none');
            cartCount();

            if(response.result){
              
                renderCartButtonsHtml('delete', that, page, response.update_html, null);
                updateCouponHtml(response.coupon_error, response.coupon_code);
              

              if($('#checkout-section').length > 0 && $('#products-section').length > 0 ){
                    if(response.count == 0){
                        location.reload();
                    }
                    $('#checkout-section').html(response.checkoutHtml)
                    $('#products-section').html(response.productsHtml)

                }   

               if (window.location.pathname.includes('/checkout')) {
    location.reload();
}
                
              toastr.success(response.message,'Success');
              return false;
            }else{
                toastr.error(response.message,'Error');
            }
        }
    });
    return false;

});


$('body').on('click', '.empty-cart', function () {
    // alert('a')
    // return false;
    var that = $(this);
    $('.loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/empty-cart",
        success: function (response) {
            //$('.loader').addClass('d-none');
            //location.reload();

            $('.loader').addClass('d-none');
            cartCount();

            if(response.result){
                location.reload();
                //toastr.success(response.message,'Success');
            }else{
                toastr.error(response.message,'Error');
            }
            return false;
        }
    });
    return false;

});

$('body').on('click', '.change-qty', function () {
    
    var that = $(this);

    var quantity = parseInt(that.closest('.detail-qty').find('.qty-val').val(), 10);
    
    if(that.hasClass('qty-up')){
            
        var stock = that.attr('data-stock');
        if(quantity == stock){
            return false;
        }
        quantity = quantity + 1;
        if(stock != null && stock != '' && quantity > stock ){
            quantity = stock;
        }            
    }

    if(that.hasClass('qty-down')){ 
        if(quantity <= 1){
            return false;
        }
        quantity = quantity - 1;
        if(quantity < 1 ){
            quantity = 1;
        }
    }

    that.closest('.detail-qty').find('.qty-val').val(quantity)

    return false;

})


$('body').on('focusout', '.product-qty-val', function () {
    var that = $(this);
    var quantity = parseInt(that.val(), 10);
    var stock = that.closest('.detail-qty').find('.qty-up.change-qty').attr('data-stock');
    
    if(quantity <= 0 ){
        quantity = 1;
        that.val(quantity)
    }

    if(stock != null && stock != '' && quantity > stock ){
        quantity = stock;
        that.val(quantity)
    }  
    return false;
});

$('body').on('focusout', '.update-cart-input', function () {
    var that = $(this);
    // alert('a');

    var key = that.closest('.detail-qty').find('.update-cart').attr('data-key');
    
    var quantity = parseInt(that.val(), 10);
    var stock = that.closest('.detail-qty').find('.qty-up.update-cart').attr('data-stock');
    
    if(quantity <= 0 ){
        quantity = 1;
        that.val(quantity)
    }

    if(stock != null && stock != '' && quantity > stock ){
        quantity = stock;
        that.val(quantity)
    }  

    var attribute = null;
    if(that.closest('tr').find('[name="product_attribute"]').length > 0){
        attribute = that.closest('tr').find('[name="product_attribute"]').val();
    }


    that.prop('disabled',false);
    $('.loader').removeClass('d-none');

    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/update-cart",
        data: {key: key, quantity: quantity, attribute: attribute},
        success: function (response) {
            //$('.loader').addClass('d-none');
            $('.loader').addClass('d-none');
            that.prop('disabled',false);
            cartCount();

            if(response.result){
                toastr.success(response.message,'Success');
                if($('#checkout-section').length > 0 && $('#products-section').length > 0 ){
                    $('#checkout-section').html(response.checkoutHtml)
                    $('#products-section').html(response.productsHtml)
                }
            }else{
                toastr.error(response.message,'Error');
            }
            return false;
        }
    });

});

$('body').on('click', '.update-cart', function () {
        var that = $(this);

        if(that.is(":disabled")){
            console.log('disabled');
            return false;
        }

        var key = that.attr('data-key');
        var quantity = parseInt(that.closest('.detail-qty').find('.qty-val').val(), 10);


        var attribute = null;
        if(that.closest('tr').find('[name="product_attribute"]').length > 0){
            attribute = that.closest('tr').find('[name="product_attribute"]').val();
        }


        if(that.hasClass('qty-up')){
            
            var stock = that.attr('data-stock');
            if(quantity == stock){
                return false;
            }
            quantity = quantity + 1;
            if(stock != null && stock != '' && quantity > stock ){
                quantity = stock;
            }            
        }

        if(that.hasClass('qty-down')){ 
            if(quantity <= 1){
                return false;
            }
            quantity = quantity - 1;
            if(quantity < 1 ){
                quantity = 1;
            }
        }
        
        
        
        
        

        that.prop('disabled', true);
        //return false;

        $('.loader').removeClass('d-none');
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/update-cart",
            data: {key: key, quantity: quantity, attribute: attribute},
            success: function (response) {
                //$('.loader').addClass('d-none');
                $('.loader').addClass('d-none');
                that.prop('disabled',false);
                cartCount();

                if(response.result){
                    toastr.success(response.message,'Success');
                    that.closest('.detail-qty').find('.qty-val').val(quantity);
                    if($('#checkout-section').length > 0 && $('#products-section').length > 0 ){
                        $('#checkout-section').html(response.checkoutHtml)
                        $('#products-section').html(response.productsHtml)
                    }
                }else{
                    toastr.error(response.message,'Error');
                }
                return false;
            }
        });
        return false;

});


$('body').on('click', '.add-wishlist', function (e) {
    // alert('a')
    // return false;

    var that = $(this);
    var key = that.attr('data-key');

    if(that.hasClass('disabled')){
        return false;
    }
   
    var attribute = null;
    if($('#attribute_id').length > 0){
        attribute = $('#attribute_id').val();
    }
    

    $('.loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/add-wishlist",
        data: {key: key,attribute:attribute},
        success: function (response) {
            $('.loader').addClass('d-none');
            

            if(response.result){
             
                if(that.hasClass('active')){
                    that.removeClass('active');
                    // that.attr('aria-label','Add to Wishlist');
                }else{
                    that.addClass('active');
                    // that.attr('aria-label','Remove from Wishlist');
                }
                
                $('.wishlist-count').html(response.count);
             
              toastr.success(response.message,'Success');
              return false;
            }else{
                toastr.error(response.message,'Error');
            }
            
        },
        complete: function(xhr, textStatus) {
            //$('.loader').addClass('d-none');
            // console.log(response);
            if(xhr.status == 401){
                window.location.href = site_url + "/login";
            }
        }
    });
    return false;
});

$('body').on('click', '.remove-wishlist', function (e) {
    // alert('a')
    // return false;

    var that = $(this);
    var key = that.attr('data-key');
    var attribute = that.attr('data-attribute');

    if(that.hasClass('disabled')){
        return false;
    }

    $('.loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/remove-wishlist",
        data: {key: key, attribute:attribute},
        success: function (response) {
            $('.loader').addClass('d-none');
            if(response.result){
                if(response.count > 0){
                    that.closest('tr').remove();
                }else{
                    that.closest('.wishlist-table').after('<p class="my-3 text-center"> Wishlist is Empty</p>');
                    that.closest('.wishlist-table').remove();
                }
                $('.wishlist-count').html(response.count);
                toastr.success(response.message,'Success');
                return false;
            }else{
                toastr.error(response.message,'Error');
            }
            
        },
        complete: function(xhr, textStatus) {
            //$('.loader').addClass('d-none');
            // console.log(response);
            if(xhr.status == 401){
                window.location.href = site_url + "/login";
            }
        }
    });
    return false;
});

    var selectedClass = 'active';

    $('body').on('click','.attribute-option', function(){
        //alert('a')
        var that = $(this);
        
        $('#attribute-selected-error').text('');

        if(that.closest('li').hasClass('non-available')){
            $('.attributes').find('.attribute-select').find('.attribute-option').closest('li').removeClass('non-available')
            $('.attributes').find('.attribute-select').find('.attribute-option').closest('li').removeClass(selectedClass)
        }

        that.closest('.attribute-select').find('.attribute-option').closest('li').removeClass(selectedClass);
        that.closest('li').addClass(selectedClass);


        var selectedValues = {};
        var slug = $('#slug').val();
        that.closest('.attributes').find('.attribute-select').each(function(){
            var attributeCurrent = $(this).closest('.attribute-select').attr('data-attribute')
            var attributeCurrentValue = $(this).find('li.'+selectedClass).find('.attribute-option').attr('data-id')
            if(typeof attributeCurrentValue !== 'undefined'){
                selectedValues[attributeCurrent] = attributeCurrentValue
            }
        })
        console.log(selectedValues)
        $('.loader').removeClass('d-none');
        $.ajax({
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/select-attribute",
            data: {selectedValues:selectedValues, slug:slug},
            success: function (response) {
                //$('.attributes').find('option').prop('disabled', true)
                $('.loader').addClass('d-none');

                if(Object.keys(response.attributes).length > 0){
                    $('.attributes').find('.attribute-select').find('.attribute-option').closest('li').addClass('non-available')
                
                    $.each(response.attributes, function (i) {
                        //alert(i)
                        $.each(response.attributes[i], function (key, val) {
                            //alert(val);
                            //$('.attributes').find('select[data-attribute="' + i + '"]').each(function(key, val){
                                //console.log(response.attributes[i][key])
                                //var tt = $('.attributes').find('select[data-attribute="' + i + '"]').find(response.attributes[i][key])
                               $('.attributes').find('.attribute-select[data-attribute="' + i + '"]').find('.attribute-option[data-id="'+response.attributes[i][key]+'"]').closest('li').removeClass('non-available')

                            //})
                        });
                    });
                }
                
                that.closest('.detail-info').find('.qty-val').val(1);
                

                if(response.result){
                    if(response.stock > 0){
                        $('.price').text(response.price);
                        if(response.old_price){
                            $('.old-price').text(response.old_price);
                        }else{
                            $('.old-price').text('');
                        }

                        enableCartWishButtons();

                        if(response.already_in_wishlist){
                            $('.add-wishlist').addClass('active');
                            // $('.add-wishlist').attr('aria-label','Remove from Wishlist');
                        }else{
                            $('.add-wishlist').removeClass('active');
                            // $('.add-wishlist').attr('aria-label','Add to Wishlist');
                        }

                        // if(response.already_in_cart){
                        //     renderCartButtonsHtml('add', $('.add-cart'), 'detail', null, null);
                        //     //$('.remove-service, .add-service').prop('disabled',false);
                        // }else{
                        //     renderCartButtonsHtml('delete', $('.product-detail').find('.delete-cart'), 'detail', null, null);
                        // }

                        renderCartButtonsHtml('delete', $('.product-detail').find('.delete-cart'), 'detail', null, null);

                        // $('#add_to_cart').prop('disabled', false)
                        // $('#add_to_cart').removeClass('disabled')

                        $('.availability').removeClass('d-none')
                        // $('.availability').find('.availability-count').text(response.stock);

                        if(response.stock > 0){
                            $('.availability-cont').html('<p class="mb-0 text-success">In Stock</p>');
                        }else{
                            $('.availability-cont').html('<p class="mb-0 text-danger">Out of Stock</p>');
                        }

                        $('#current_stock').val(response.stock)
                        $('#attribute_id').val(response.attribute_id);


                        that.closest('.detail-info').find('.qty-up').attr('data-stock',response.stock);

                        if(response.sku_value != null){
                            $('.product-sku').text(response.sku_value);
                        }
                        


                        if(response.image != null){
                            $('.product-image').attr('src',response.image);
                            $('.product-image-thumb').attr('src',response.image);
                        }
                        if(response.hover_image != null){
                            $('.product-image-hover').attr('src',response.hover_image);
                            $('.product-image-thumb-hover').attr('src',response.hover_image);
                        }


                        if(response.image != null || response.hover_image != null){
                            $('.product-image-slider').slick('unslick'); /* ONLY remove the classes and handlers added on initialize */
                            $('.slider-nav-thumbnails').slick('unslick'); /* ONLY remove the classes and handlers added on initialize */
                            //$('.my-slide').remove(); /* Remove current slides elements, in case that you want to show new slides. */
                            $('.zoomContainer').remove();
                            productDetails();
                        }
                        
                        // if(response.image != null || response.hover_image != null){
                        //     $('.product-image-slider').slick('setPosition');
                        //     $('.slider-nav-thumbnails').slick('setPosition');

                        //     $('.product-image-slider .slick-active img').elevateZoom({
                        //         zoomType: "inner",
                        //         cursor: "crosshair",
                        //         zoomWindowFadeIn: 500,
                        //         zoomWindowFadeOut: 750
                        //     });
                        // }
                        
                        
                        // if(response.stock < response.threshold){
                        //     $('.stock-message').html('<p class="text-danger">Only '+response.stock+' left in stock<p>');
                        // }else{
                        //     $('.stock-message').html('');
                        // }

                        if($('.services-cont').length > 0 && response.services.length > 0){
                            $(".services-cont").find('.service').each(function () {
                                if ($.inArray($(this).attr('data-service'), response.services) != -1){
                                    //alert('a')
                                    $('.remove-service, .add-service').prop('disabled',false);
                                    $('.service').text('Remove Service');
                                    $('.service').removeClass('add-service').addClass('remove-service');
                                }else{
                                    //alert('b')
                                    $('.remove-service, .add-service').prop('disabled',true);
                                    $('.service').text('Add Service');
                                    $('.service').removeClass('remove-service').addClass('add-service');
                                }
                            })
                        }









                    }else{

                        disableCartWishButtons();

                        if($('.add-wishlist').hasClass('active')){
                            $('.add-wishlist').removeClass('active');
                            // $('.add-wishlist').attr('aria-label','Add to Wishlist');
                        }

                        $('.stock-message').html('<p class="text-danger">Out of Stock<p>');
                    }
                    
                    
                }else{
                    //$('#main_price').html('$0.00');
                    renderCartButtonsHtml('delete', $('.product-detail').find('.delete-cart'), 'detail', null, null);

                    disableCartWishButtons();

                    $('.add-wishlist').removeClass('active');
                    // $('.add-wishlist').attr('aria-label','Add to Wishlist');

                    $('.product-sku').text('');

                }
                // if (data.errors) {
                //     for (var error in data.errors) {
                //         dangerNotification(data.errors[error]);
                //     }
                // } else {
                //     if ($this.hasClass("subscription-form")) {
                //         $(".close-popup").click();
                //     }
                //     successNotification(data);
                //     $this.find("input[name=email]").val("");
                // }
                // submit_btn.find(".fa-spin").addClass("d-none");
                // $this.find("input[name=email]").prop("readonly", false);
                // submit_btn.prop("disabled", false);
            },
        });
        return false;
    })

    function enableCartWishButtons(){
        $('.add-cart').prop('disabled', false);
        $('.add-cart').removeClass('disabled');
        
        $('.add-wishlist').prop('disabled', false);
        $('.add-wishlist').removeClass('disabled');
    }

    function disableCartWishButtons(){
        $('.add-cart').prop('disabled', true);
        $('.add-cart').addClass('disabled');

        $('.add-wishlist').prop('disabled', true);
        $('.add-wishlist').addClass('disabled');
    }



    $('body').on('click', '.add-addon', function () {
        var that = $(this);
        alert('addon');
        return false;
    
    })

    $('body').on('click', '.add-service', function () {
        var that = $(this);
        // alert('service');
        // return false;
        
        var key = that.attr('data-key');
        var service = that.attr('data-service');

        var attribute = null;
        if($('#attribute_id').length > 0){
            attribute = $('#attribute_id').val();
        }
        
    
        // if(typeof quantity === 'undefined' || quantity == '' || quantity == null){
        //     quantity = 1;
        // }
        // quantity = parseInt(quantity);
            
    
        $('.loader').removeClass('d-none');
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/add-service",
            data: {key: key, attribute:attribute, service: service},
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                if(response.result){
                    that.removeClass('add-service').addClass('remove-service');
                    that.text('Remove Service');
                    if($('#checkout-section').length > 0){
                        $('#checkout-section').html(response.checkoutHtml)
                    }
                    toastr.success(response.message,'Success');
                    return false;
                }else{
                    toastr.error(response.message,'Error');
                }
                
            },
            complete: function(xhr, textStatus) {
                //$('.loader').addClass('d-none');
                // console.log(response);
                if(xhr.status == 401){
                    window.location.href = site_url + "/login";
                }
            }
        });
        return false;
    
    })

    $('body').on('click', '.remove-service', function () {
        var that = $(this);
        var key = that.attr('data-key');
        var service = that.attr('data-service');

        var attribute = null;
        if($('#attribute_id').length > 0){
            attribute = $('#attribute_id').val();
        }
    
        $('.loader').removeClass('d-none');
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/remove-service",
            data: {key: key, attribute:attribute, service: service},
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                if(response.result){
                    that.removeClass('remove-service').addClass('add-service');
                    that.text('Add Service');
                    toastr.success(response.message,'Success');
                    if($('#checkout-section').length > 0){
                        $('#checkout-section').html(response.checkoutHtml)
                    }
                    return false;
                }else{
                    toastr.error(response.message,'Error');
                }
                
            },
            complete: function(xhr, textStatus) {
                //$('.loader').addClass('d-none');
                // console.log(response);
                if(xhr.status == 401){
                    window.location.href = site_url + "/login";
                }
            }
        });
        return false;
    
    })
    

    $('body').on('click', '.change-address', function (e) {
        var that = $(this);
        var type = that.attr('data-type');
        //alert(type)
        $('#changeAddressModal').find('.address-type').css('text-transform', 'capitalize');
        $('#changeAddressModal').find('.address-type').text(type+' ');
        $('#changeAddressModal').find('.addresses').html('<p class="text-center my-4">Loading...</p>');
        $('#changeAddressModal').modal('show');

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/fetch-addresses",
            data: {type:type},
            success: function (response) {
                console.log(response)
                if(response.result){
                    $('#changeAddressModal').find('.addresses').html(response.html);
                }
                
            }
        });

        return false;        
    })

    $('body').on('click', '.select-address', function (e) {
        var that = $(this);
        var type = that.attr('data-type');
        var key = that.attr('data-key');

        // alert(type);
        // alert(key);
        // return false;

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/select-address",
            data: {type:type, key:key},
            success: function (response) {
                console.log(response)
                // if(response.result){
                    $('#address-section').html(response.address_html);
                    $('#pricing-section').html(response.price_html);
                    $('#place-order-section').html(response.place_order_html);
                    
                    if($('#local-pickup').is(":checked")){
                        $('#shipping-user-address').addClass('d-none');
                    }

                    $('#changeAddressModal').modal('hide');
                    toastr.success(response.message,'Success');
                //     $('#changeAddressModal').find('.addresses').html(html);
                // }
                
            }
        });

        return false;        
    })

    
    $('body').on('click', '.set-default-address', function (e) {
        var that = $(this);
        var key = that.attr('data-key');
        var isDefault = that.attr('data-is-default');

        if(isDefault == 1){
            return false;
        }
        // alert(key);
        // return false;

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/set-default-address",
            data: {key:key},
            success: function (response) { 
                if(response.result){
                    $('.set-default-address').html('Set Default');
                    $('.set-default-address').attr('data-is-default',0);

                    that.html('Default');
                    that.attr('data-is-default',1);

                    toastr.success(response.message,'Success');
                //     $('#changeAddressModal').find('.addresses').html(html);
                }
                
            }
        });

        return false;        
    })

    if($('.tab-select.active').length > 0){
        tabSelectProducts($('.tab-select.active').attr('data-category'));
    }
    

    $('body').on('click', '.tab-select', function (e) {
        var that = $(this);
        var category = that.attr('data-category');
        tabSelectProducts(category);
        $('.tab-select').removeClass('active');
        that.addClass('active');
    });

    function tabSelectProducts(category){
        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/tab-products",
            data: {category:category},
            success: function (response) { 
                if(response.result){
                    $('#tab-products').html(response.html)
                 }
            }
        });
        return false;
    }


    var searchXhr = null;
    var searchDebounceTimer = null;

    function smartSearchSource(query, syncResults, asyncResults) {
        clearTimeout(searchDebounceTimer);
        if (searchXhr && searchXhr.readyState !== 4) {
            searchXhr.abort();
        }
        searchDebounceTimer = setTimeout(function() {
            searchXhr = $.ajax({
                type: 'GET',
                url: site_url + '/ajax-products-search',
                data: { query: query },
                cache: false,
                success: function(response) {
                    asyncResults((response || []).slice(0, 5));
                },
                error: function(jqXhr) {
                    if (jqXhr.statusText !== 'abort') {
                        asyncResults([]);
                    }
                }
            });
        }, 200);
    }

    $('[data-smart-search]').typeahead({
        hint: false,
        highlight: true,
        minLength: 1
    }, {
        name: 'smart_search',
        limit: 50,
        display: 'name',
        source: smartSearchSource,
        templates: {
            empty: [
                '<div class="empty-message">',
                'No Record Found !',
                '</div>'
            ].join('\n'),
            suggestion: function(data) {
                return '<a class="searchItemWrap" href="' + data.link + '" target="_blank"><div class="image-section"><img src="' + data.image + '" alt="Prduct Image" /></div><div class="description-section"><div class="fullWidth"><h1>' + data.name + '</h1><p> '+ data.price + '</p></div></div></div><div class="clearfix"></div></a>';
            },
            footer: [
                '<div class="searchItemWrap searchTrigger text-center"><div class="empty-message"><a href="'+site_url+'/products" target="_blank">View All</a></div></div>'
            ]
        },
    }).on('typeahead:asyncrequest', function() {
        $('.search-loader').show();
    })
    .on('typeahead:asyncreceive typeahead:asynccancel', function() {
        $('.search-loader').hide();
    });
    
    $(document).on('click', '.searchTrigger', function(e) {
        e.preventDefault();
        $(this).closest('form.search-form').submit();
        // $('.absSearchBtn').click();
        //$('#search-btn-m').click();
    });

    $('[data-smart-search]').bind('typeahead:select', function() {
        $('.absSearchBtn').click();
    });
    // colors
    if ($('.showAllTrigger').length>0) {
        $('.showAllTrigger').on('click', function (e) {
            e.preventDefault();
            $('.modifiedColors').toggleClass('shownAllColors');                          
        });
    }
   


    function addFiltersToUrl( ignore = null){
        
        var countFilters = 0;
        var keyword = '';
        var categories = [];
        var colors = [];
        var brands = [];
        var minprice = '';
        var maxprice = '';

        
        if(ignore != "keyword"){
            if($('#keyword').val() != "" ||  $('#keyword').val() != null) {countFilters++;}
            keyword = $('#keyword').val();
        }

        if(ignore != "categories"){
            if($("#filters").find('.category:checked').length > 0 ) {countFilters++;}
            $("#filters").find('.category:checked').each(function () {
                categories.push($(this).val());
            });

            $("#categories-modal-list").find('.category-modal:checked').each(function () {
                categories.push($(this).val());
            });
            var categories = [...new Set(categories)];
        }

        if(ignore != "colors"){
            if($("#filters").find('.color:checked').length > 0 ) {countFilters++;}
            // $("#filters").find('.color.active').each(function () {
            //     colors.push($(this).attr('data-color'));
            // });
            $("#filters").find('.color:checked').each(function () {
                colors.push($(this).val());
            });
        }
        
        
        if(ignore != "brands"){
            if($("#filters").find('.brand:checked').length > 0 ) {countFilters++;}
            $("#filters").find('.brand:checked').each(function () {
                brands.push($(this).val());
            });

            $("#brands-modal-list").find('.brand-modal:checked').each(function () {
                brands.push($(this).val());
            });
            var brands = [...new Set(brands)];
            // console.log(brands);
            // return false;
        }


        if(ignore != "price"){
            if($("#min-amount").val() != null || $("#max-amount").val() != null) {countFilters++;}
            minprice = $("#min-amount").val();
            maxprice = $("#max-amount").val();
            //prices.push({'min': $("#min-amount").val(), 'max': $("#max-amount").val()});
        }

        // console.log(minprice)
        // console.log(maxprice)
        // console.log(colors)
        // return false;

        var sort = $(".sort option:selected").val();

        sort = (typeof sort !== 'undefined' ) ? sort : '';

        
        const params = new URLSearchParams({
            keyword: keyword,
            categories: categories,
            colors: colors,
            brands: brands,
            sort: sort,
            minprice: minprice,
            maxprice: maxprice,
        });

        let keysForDel = [];
        params.forEach((value, key) => {
        if (value == '') {
            keysForDel.push(key);
        }
        });
        keysForDel.forEach(key => {
            params.delete(key);
        });
        const str = params.toString();
        $('.filters-button__counter').html(countFilters)
        
        if(str.length > 0){
            //var rootPathname = window.location.pathname.split('/')[1]
            var rootPathname = window.location.pathname
            // console.log(window.location)
            // console.log(rootPathname)
            //window.location.href = window.location.pathname+"?"+str;
            window.location.href = window.location.origin + rootPathname+"?"+str;
        }else{
            window.location.href = window.location.pathname;
        }
       
    }

    // $("#filter").on('click', function(){
    //     addFiltersToUrl();
    // })

    $("body").on('click', '#keyword-search', function(){
        addFiltersToUrl();
        return false;
    })

    $(".category").on('change', function(){
        var that = $(this);
        // alert(that.val());
        var val = that.val();
        if(that.is(":checked")){
            $('#categories-modal-list').find('.category-modal[value="'+val+'"]').prop('checked', true);
        }else{
            $('#categories-modal-list').find('.category-modal[value="'+val+'"]').prop('checked', false);
        }
        addFiltersToUrl();
    });

    $(".category-modal").on('change', function(){
        var that = $(this);
        // alert(that.val());
        var val = that.val();
        if(that.is(":checked")){
            $('#filters').find('.category[value="'+val+'"]').prop('checked', true);
        }else{
            $('#filters').find('.category[value="'+val+'"]').prop('checked', false);
        }
    });
    

    $(".brand").on('change', function(){
        var that = $(this);
        // alert(that.val());
        var val = that.val();
        if(that.is(":checked")){
            $('#brands-modal-list').find('.brand-modal[value="'+val+'"]').prop('checked', true);
        }else{
            $('#brands-modal-list').find('.brand-modal[value="'+val+'"]').prop('checked', false);
        }
        addFiltersToUrl();
    });

    $(".brand-modal").on('change', function(){
        var that = $(this);
        // alert(that.val());
        var val = that.val();
        if(that.is(":checked")){
            $('#filters').find('.brand[value="'+val+'"]').prop('checked', true);
        }else{
            $('#filters').find('.brand[value="'+val+'"]').prop('checked', false);
        }
    });

    $("#select-categories").on('click', function(){
        addFiltersToUrl();
    })

    $("#select-brands").on('click', function(){
        addFiltersToUrl();
    })

    

    $("body").on('click', '#filters .color', function(){
        $(this).toggleClass('active');
        addFiltersToUrl();
    })

    $("body").on('change', '.sort', function(){
        // setSortValue($(this))
        addFiltersToUrl();
    })

    
    $("body").on('click', '#set-price-range', function(){
        addFiltersToUrl();
        return false;
    })

    

     /*---------------------
        Price range
    --------------------- */
    var sliderrange = $('#slider-range');
    var amountprice = $('#amount');
    $(function() {

        var minVal = parseInt(sliderrange.attr('data-min'));
        var maxVal = parseInt(sliderrange.attr('data-max'));

        var minValSelected = parseInt(sliderrange.attr('data-min-selected'));
        var maxValSelected = parseInt(sliderrange.attr('data-max-selected'));

        sliderrange.slider({
            range: true,
            min: minVal,
            max: maxVal,
            values: [minValSelected, maxValSelected],
            slide: function(event, ui) {
                amountprice.val(site_currency + ui.values[0] + " - "+site_currency + ui.values[1]);
                $('#min-amount').val(ui.values[0]);
                $('#max-amount').val(ui.values[1]);
                
            },
            // change: function( event, ui ) {
            //     addFiltersToUrl();
            // }
        });
        amountprice.val(site_currency + sliderrange.slider("values", 0) +
            " - "+site_currency + sliderrange.slider("values", 1));
    });



    var urlParams = new URLSearchParams(window.location.search);
    var keyword = urlParams.getAll('keyword').toString();
    var categoriesUrlArray = urlParams.getAll('categories').toString().split(",");
    var colorsUrlArray = urlParams.getAll('colors').toString().split(",");
    var brandUrlArray = urlParams.getAll('brands').toString().split(",");
    var sortUrl = urlParams.getAll('sort').toString();

    $("#filters").find('#keyword').val(keyword);

    $("#filters").find('.category').each(function () {
        var valueCategory = $(this).val();
        
        if ($.inArray(valueCategory, categoriesUrlArray) != -1){
            console.log($(this))
            $(this).prop('checked', true)
        }
    });

    
    $("#categories-modal-list").find('.category-modal').each(function () {
        var valueCategory = $(this).val();
        
        if ($.inArray(valueCategory, categoriesUrlArray) != -1){
            console.log($(this))
            $(this).prop('checked', true)
        }
    });

    $("#filters").find('.color').each(function () {
        // var valueColor = $(this).attr('data-color');
        var valueColor = $(this).val();
        if ($.inArray(valueColor, colorsUrlArray) != -1){
            $(this).prop('checked', true)
            // $(this).addClass('active')
        }
    });

    $("#filters").find('.brand').each(function () {
        var valueBrand = $(this).val();        
        if ($.inArray(valueBrand, brandUrlArray) != -1){
            $(this).prop('checked', true)
        }
    });

    $("#filters").find('.brand-modal').each(function () {
        var valueBrand = $(this).val();        
        if ($.inArray(valueBrand, brandUrlArray) != -1){
            $(this).prop('checked', true)
        }
    });


    
    // $(".sort").val(sortUrl).change();
    if(typeof sortUrl != 'undefined' && sortUrl != ''){
        $(".sort").val(sortUrl);
    }
    

    // $(".sort").each(function () {
        
    //     var valueSort = $(this).attr('data-value');        
    //     if (valueSort == sortUrl){
    //         // setSortValue($(this))
    //     }
    // });
    
    // function setSortValue(that){
    //     $('.sort').removeClass('active');
    //     that.addClass('active');
    //     $('#sort-value').text(that.text())
    // }


    
    
    $("body").on('change', '#differentaddress', function(){
        showShippingFields(true);
    })

    showShippingFields(true);
    function showShippingFields(pageLoad = null){
        if($('#differentaddress').is(":checked")){
            $('#collapseAddress').addClass('d-none');
            $('#collapseAddress').find('input,select').prop('disabled', true);
            $('#collapseAddress').find('input:not(.optional), select:not(.optional)').prop('required', false);
        }else{
            $('#collapseAddress').removeClass('d-none');
            $('#collapseAddress').find('input,select').prop('disabled', false);
            $('#collapseAddress').find('input:not(.optional), select:not(.optional)').prop('required', true);
        }
        if(!pageLoad){
            resetAddressValidation();
        }
    }


    $("body").on('click', '#apply-coupon', function(){
        var that = $(this);
        var code = $('#coupon-code').val();
        var stateCode ='';
        
        if($('#coupon-code').val() == "" || $('#coupon-code').val() == null){
            $('#coupon-code').addClass('is-invalid')
            $('#coupon-message').html('<p class="text-danger">Please enter the coupon code.</p>');
            return false;
        }
        // else{
        //     $('#coupon-code').removeClass('is-invalid')
        //     $('#coupon-message').html('')
        // }

        $('#coupon-code').removeClass('is-invalid');
        $('#coupon-message').html('');

        if($("#state").length > 0){
            stateCode = $("#state").val();
        }

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/apply-coupon",
            data: {code: code, state_code : stateCode},
            success: function (response) {

                if(response.result){
                    //$('#coupon-message').html('<p class="text-success">'+response.message+'</p>');
                    toastr.success(response.message,'Success');

                    applyCouponHtml(code);

                    $('#checkout-section').html(response.checkoutHtml);
                    $('#pricing-section').html(response.price_html);
                }else{
                    $('#coupon-message').html('<p class="text-danger">'+response.message+'</p>');
                }
                
                console.log(response)
            }
        });
        return false;
        
    })

    
    function updateCouponHtml(message, code){
        // if(message != '' && code != '' && $('#coupon-message').length > 0){
        if(message != '' && code != ''){
            removeCouponHtml();
            $('#coupon-message').html('<p class="text-danger">'+message+'</p>');
            $('#coupon-code').val(code);
        }
    }


    function applyCouponHtml(code){
        $('#coupon-cont').html('<div class="coupon-applied">\
                                    <span class="coupon-applied-icon"><i class="fas fa-tag"></i></span>\
                                    <span class="coupon-applied-body">\
                                        <span class="coupon-applied-code">'+code+'</span>\
                                        <span class="coupon-applied-label">Coupon applied</span>\
                                    </span>\
                                    <button type="button" class="coupon-applied-remove" id="remove-coupon" data-code="'+code+'">\
                                        <i class="fas fa-xmark"></i> Remove\
                                    </button>\
                                </div>');
    }

    function removeCouponHtml(){
        $('#coupon-cont').html('<h4 class="checkout-voucher-title mb-3">Have a coupon?</h4>\
                                <div class="d-flex align-items-center">\
                                    <input type="text" placeholder="Enter Your Coupon" class="theme-input w-100" name="Coupon" id="coupon-code">\
                                    <button type="submit" class="btn btn-secondary flex-shrink-0" id="apply-coupon">Apply Coupon</button>\
                                </div>\
                                <div id="coupon-message"></div>');
    }


    $("body").on('click', '#remove-coupon', function(){
        var that = $(this);        
        var code = that.attr('data-code');
        var stateCode ='';
        
        if(code == "" || code == null){
            return false;
        }
        if($("#state").length > 0){
            stateCode = $("#state").val();
        }
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/remove-coupon",
            data: {code: code, state_code : stateCode},
            success: function (response) {

                if(response.result){
                    //$('#coupon-message').html('<p class="text-success">'+response.message+'</p>');
                    toastr.success(response.message,'Success');

                    // $('#coupon-cont').html('<div class="form-row row justify-content-center">\
                    //     <div class="form-group col-lg-6">\
                    //         <input class="font-medium form-control" name="Coupon" id="coupon-code" placeholder="Enter Your Coupon">\
                    //         <div id="coupon-message"></div>\
                    //     </div>\
                    //     <div class="form-group col-lg-6">\
                    //         <button class="btn  btn-sm" id="apply-coupon"><i class="fi-rs-label mr-10"></i>Apply</button>\
                    //     </div>\
                    // </div>');
                    removeCouponHtml();
                                    
                    $('#checkout-section').html(response.checkoutHtml);
                    $('#pricing-section').html(response.price_html);
                    //location.reload();
                }else{
                    $('#coupon-message').html('<p class="text-danger">'+response.message+'</p>');
                }
                
                console.log(response)
            }
        });
        return false;
        
    })

    

    $("body").on('click', '#subscribe', function(){
        var that = $(this);
        
        var email = $('#subscribe-email').val();
        $('#subscribe-message').html('');
        
        if(email == "" || email == null){
            $('#subscribe-message').html('<p class="text-danger">Please enter an email address</p>');
            return false;
        }

        if(!validateEmail(email)){
            $('#subscribe-message').html('<p class="text-danger">Please enter a valid email address</p>');
            return false;
        }


        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/subscribe",
            data: {email: email},
            success: function (response) {
                if(response.result){
                    //$('#coupon-message').html('<p class="text-success">'+response.message+'</p>');
                    toastr.success(response.message,'Success');
                    $('#subscribe-email').val('');
                    $('#subscribe-message').html('<p class="text-white">'+response.message+'</p>');
                }else{
                    $('#subscribe-message').html('<p class="text-danger">'+response.message+'</p>');
                }
            },

            error: function(jqXhr, json, errorThrown){// this are default for ajax errors 
                console.log(jqXhr)
                console.log(json)
                console.log(errorThrown)
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function (index, value) {
                    errorsHtml += value + '</br>';
                });
                $('#subscribe-message').html('<p class="text-danger">'+errorsHtml+'</p>');
            
            }
        });
        return false;
        
    })


    

    $('body').on('click', '#add-address-modal', function (e) {
        $('#changeAddressModal').modal('hide');
        setTimeout(() => {
            $('#addressModal').modal('show');    
        }, 400);
        return false;
    })

    
    $('body').on('click', '#save-address', function (e) {
        var that = $(this)
        var modalBody = $('#addressModal').find('.modal-body');

        modalBody.find('input').removeClass('is-invalid');
        modalBody.find('.invalid-feedback').remove();

        var flag = true;
        flag = validateEmptyFields(modalBody);
        
        if(!flag){
            return false;
        }

        var emailObj = modalBody.find('input[name="email"]');
        //var email = emailObj.val();
        flag = validateEmailFormat(emailObj);

        if(!flag){
            return false;
        }

        var first_name = modalBody.find('input[name="first_name"]').val();
        var last_name = modalBody.find('input[name="last_name"]').val();
        var company_name = modalBody.find('input[name="company_name"]').val();
        var email = modalBody.find('input[name="email"]').val();
        var phone = modalBody.find('input[name="phone"]').val();
        var address_line_1 = modalBody.find('input[name="address_line_1"]').val();
        var address_line_2 = modalBody.find('input[name="address_line_2"]').val();
        var street = modalBody.find('input[name="street"]').val();
        var city = modalBody.find('input[name="city"]').val();
        var state = modalBody.find('select[name="state"]').val();
        var country = modalBody.find('select[name="country"]').val();
        var postal = modalBody.find('input[name="postal"]').val();
        var id = modalBody.find('input[name="id"]').val();
        

        that.prop("disabled", true);
        that.prepend('<i class="fas fa-spinner fa-spin mr-2"></i>');

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/address",
            data: {first_name: first_name, last_name: last_name, company_name: company_name, phone: phone, email: email, address_line_1: address_line_1, address_line_2: address_line_2, street: street, city: city, state: state, country: country, postal: postal, id: id},
            success: function (response) { 
                if(response.result){
                    location.reload();
                    $('#address-section').html(response.address_html);
                    $('#pricing-section').html(response.price_html);
                    //$('#place-order-section').html(response.place_order_html);
                    
                    if($('#local-pickup').is(":checked")){
                        $('#shipping-user-address').addClass('d-none');
                    }
                    $('#addressModal').modal('hide');
                    // if($('.place-order-cont').length > 0){
                    //     $('.place-order-cont').html('<input type="submit" class="btn btn-primary btn-md rounded w-100" value="Place Order" />');
                    // }
                    // if($('.place-enquiry-cont').length > 0){
                    //     $('.place-enquiry-cont').html('<input type="submit" class="btn btn-primary btn-md rounded w-100" value="Place Enquiry" />');
                    // }
                    toastr.success(response.message,'Success');
                    modalBody.find('input').val('');
                    location.reload();

                }else{
                    toastr.error(response.message,'Error');
                }

                return false;
                
            },
            error: function(xhr, textStatus) {
                if(xhr.status == 422){
                    var responseText = $.parseJSON(xhr.responseText);
                    validateAfterCall(responseText, modalBody);
                }
                return false;
            },
            complete: function(xhr, textStatus) {
                //$('.loader').addClass('d-none');
                // console.log(response);
                
                that.prop("disabled", false);
                that.find('i').remove();
                
                if(xhr.status == 401){
                    window.location.href = site_url + "/login";
                }
            }
        });



        return false;
    })


    function refreshPricingSection(){
        $('.loader').removeClass('d-none');

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/refresh-pricing",
            // data: {state: state},
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                $('#pricing-section').html(response.html);
            }
        });
    }

    function printErrorMsg (msg) {
        console.log('msg=>',msg)
        // .replace(/ /g,'_')


        // $(".print-error-msg").find("ul").html('');
        // $(".print-error-msg").css('display','block');
        // $.each( msg, function( key, value ) {
        //     $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        // });
    }

    function validateEmptyFields(parentBody){
        var flag = true;
        parentBody.find('input,textarea,select').each(function(){
            //console.log($(this))
            if($(this).prop('required') && ($(this).val() == '' || $(this).val() == null)){
                $(this).addClass('is-invalid');
                var name = $(this).attr('name');
                name = name.replace(/_/g, ' ');
                $(this).after('<div class="invalid-feedback">The '+name+' field is required.    </div>');
                flag = false;
            } else {
                $(this).removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();
            }
        });
        return flag;
    }

    function validateEmailFormat(emailObj){
        var flag = true;
        var email = emailObj.val();
        if(!validateEmail(email)){
            emailObj.addClass('is-invalid');
            emailObj.after('<div class="invalid-feedback">The valid email address is required.</div>');
            flag = false;
        }else{
            emailObj.removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
        }
        return flag;
    }

    function validateAfterCall(responseText, form){
        if(!$.isEmptyObject(responseText.errors)){
            //printErrorMsg(responseText.errors);
            form.find('input,textarea,select').each(function(){
                var key = $(this).attr('name');
                if(key in responseText.errors){
                    form.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').addClass('is-invalid');
                    form.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').after('<div class="invalid-feedback">'+ responseText.errors[key] +'</div>');
                } else {

                }
            });
        }
    }

    $('body').on('click', '.edit-address-modal', function (e) {
        var that = $(this);
        $('#changeAddressModal').modal('hide');
        setTimeout(() => {

            var key = that.attr('data-key');
            $.ajax({
                type: "GET",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: site_url + "/address/"+ key,
                success: function (response) {
                    console.log(response)

                    if(response.result){

                        var modalBody = $('#addressModal').find('.modal-body');

                        modalBody.find('input[name="first_name"]').val(response.address.first_name);
                        modalBody.find('input[name="last_name"]').val(response.address.last_name);
                        modalBody.find('input[name="company_name"]').val(response.address.company_name);
                        modalBody.find('input[name="email"]').val(response.address.email);
                        modalBody.find('input[name="phone"]').val(response.address.phone);
                        modalBody.find('input[name="address_line_1"]').val(response.address.address_line_1);
                        modalBody.find('input[name="address_line_2"]').val(response.address.address_line_2);
                        modalBody.find('input[name="street"]').val(response.address.street);
                        modalBody.find('input[name="city"]').val(response.address.city);
                        modalBody.find('select[name="country"]').val(response.address.country);
                        // modalBody.find('input[name="state"]').val(response.address.state);
                        // modalBody.find('select[name="state"]').attr('data-selected-state', response.address.state);
                        modalBody.find('select[name="state"]').val(response.address.state);
                        
                        modalBody.find('input[name="postal"]').val(response.address.postal);
                        modalBody.find('input[name="id"]').val(key);

                        $('#addressModal').modal('show');
                    }
    
                    return false;
                    
                },
                complete: function(xhr, textStatus) {
                    //$('.loader').addClass('d-none');
                    // console.log(response);
                    if(xhr.status == 401){
                        window.location.href = site_url + "/login";
                    }
                }
            });


                
        }, 100);
        
    })

    $(document).on('hidden.bs.modal','#addressModal', function () {
        $('#addressModal').find('.modal-body').find('input,select[name="state"]').val('');
            //alert('a');
    });
  

    
    $('body').on('click', '#submit-review', function (e) {
        var that = $(this)
        var form = $('#commentForm');

        form.find('input,textarea').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        var flag = true;
        flag = validateEmptyFields(form);
        

        var emailObj = form.find('input[name="email"]');
        //var email = emailObj.val();
        flag = validateEmailFormat(emailObj);


        if(!flag){
            return false;
        }

        var rating = 5;
        var key = that.attr('data-key');
        var review = form.find('textarea[name="review"]').val();
        var name = form.find('input[name="name"]').val();
        var email = form.find('input[name="email"]').val();

        // alert(rating)
        // alert(key)
        // alert(review)
        // alert(name)
        // alert(email)

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/review",
            data: {rating: rating, review: review, name: name, email: email, key:key},
            success: function (response) {
                console.log(response)
                if(response.result){
                    $('#reviews').html(response.html);
                    toastr.success(response.message,'Success');
                    form.find('input,textarea').val('');
                }else{
                    toastr.error(response.message,'Error');
                }

                return false;
                
            },
            error: function(xhr, textStatus) {
                if(xhr.status == 422){
                    var responseText = $.parseJSON(xhr.responseText);
                    validateAfterCall(responseText, form);
                }
                return false;
            },
            complete: function(xhr, textStatus) {
                //$('.loader').addClass('d-none');
                // console.log(response);
                
                that.prop("disabled", false);
                that.find('i').remove();
                
                if(xhr.status == 401){
                    window.location.href = site_url + "/login";
                }
            }
        });


        return false;
    })

    
    $('body').on('click', '#verify-email', function (e) {
        var that = $(this);
        $('.loader').removeClass('d-none');
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/email/verification-notification",
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                if(response.result){
                    if(response.html_message){
                        that.closest('.alert').html(response.html_message)
                    }
                    toastr.success(response.message,'Success');
                }else{
                    toastr.error(response.message,'Error');
                }

                return false;
                
            },
            error: function(xhr, textStatus) {
               return false;
            },
            complete: function(xhr, textStatus) {
                if(xhr.status == 401){
                    window.location.href = site_url + "/login";
                }
            }
        });


        return false;
    });


    

    

    $('body').on('change', '#order-type', function (e) {
        customerGST();
    })

    customerGST();
    function customerGST(){
        var orderType = $('#order-type').find(":selected").val();
        if(orderType == 'Distributor' || orderType == 'Commercial'){
            $('input[name="customer_gst"]').closest('.form-group').removeClass('d-none');
            $('input[name="customer_gst"]').prop('disabled', false);
        }else{
            $('input[name="customer_gst"]').closest('.form-group').addClass('d-none');
            $('input[name="customer_gst"]').prop('disabled', true);
        }
    }



    $('.gallery-view').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        }
    });

    // $('#testimonials').owlCarousel({
    //     loop: true,
    //     margin: 30,
    //     nav: true,
    //     dots: false,
    //     autoplay: true,
    //     autoplayHoverPause: true,
    //     responsive: {
    //         0: {
    //             items: 1
    //         },
    //         768: {
    //             items: 2
    //         },
    //         1000: {
    //             items: 2
    //         }
    //     },
    //     navText: ["<i class='bx bx-chevron-left'></i>", "<i class='bx bx-chevron-right'></i>"],
    // })


    
    $('body').on('change', '#local-pickup', function (e) {
        localPickup();
    })

    localPickup();
    function localPickup(){
        if($('#local-pickup').length > 0){
            var total = $('#total').attr('data-value');
            var shipping = $('#shipping').attr('data-value');
            total = parseFloat(total);
            shipping = parseFloat(shipping);
            // alert(total)
            // alert(site_currency)
            // alert(shipping)
            if($('#local-pickup').is(":checked")){
                //alert('checked');
                $('#total').text(site_currency+''+ priceFormat(total - shipping));
                $('#shipping').closest('tr').addClass('d-none');

                if($('#differentaddress').is(":checked")){
                    $('#differentaddress').prop('checked', true);
                    showShippingFields();
                }
                $('#differentaddress').closest('.form-group').removeClass('d-none');
                
                $('#shipping-user-address').removeClass('d-none');

            }else{
                //alert('Not checked');
                $('#total').text(site_currency+''+ priceFormat(total));
                $('#shipping').closest('tr').removeClass('d-none');

                $('#differentaddress').closest('.form-group').addClass('d-none');

                $('#shipping-user-address').addClass('d-none');
            }
        }
    }



    $('body').on('change', '#country', function (e) {
        var that = $(this);
        getStates(that, $('#state'));
    })

    getStates($('#country'), $('#state'));

    $('body').on('change', '#country-billing', function (e) {
        var that = $(this);
        getStates(that, $('#state-billing'));
    })

    getStates($('#country-billing'), $('#state-billing'));

    function getStates(countryObj, stateObj){
        var country = countryObj.find(":selected").val();
        if(country == '' || country == null){
            stateObj.val('')
            return false;
        }
        // alert(country)
        $('.loader').removeClass('d-none');

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/get-states",
            data: {country: country},
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                if(response.result){
                    stateObj.html(response.html);
                    var selectedState = stateObj.attr('data-selected-state');
                    // alert(selectedState)
                    if(typeof selectedState !== 'undefined' && selectedState != '' && $("#state option[value='" + selectedState + "']").length > 0){
                        stateObj.val(selectedState)
                    }
                    return false;
                }else{
                    toastr.error(response.message,'Error');
                }
                
            }
        });
    }


    function resetAddressValidation(){
        var total = $('#total').attr('data-value');
        var shipping = $('#shipping').attr('data-value');
        total = parseFloat(total);
        shipping = parseFloat(shipping);
        
        $('#total').text(site_currency+''+ priceFormat(total - shipping));
        $('#total').attr('data-value', parseFloat(total - shipping));

        $('#shipping').text(site_currency+''+ priceFormat(0));
        $('#shipping').attr('data-value', 0);

        $('.place-order-cont').html('<p class="text-danger mb-0"><small>*Please fill in valid address details first </small></p><a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Order</a>');

        
        if($('#differentaddress').is(":checked")){
            $('#state-billing').val('');
            $('#state').val('');
        }else{
            $('#state-billing').val('');
        }
        
    }

    $('body').on('change', '#state', function (e) {
        var that = $(this);

        // if(that.hasClass('get-billing') && !$('#differentaddress').is(":checked")){
        //     return false;
        // }

        if(that.val() == '' || that.val() == null){
            if(that.hasClass('get-shipping')){
                resetAddressValidation();
            }
            return false;
        }
        if(that.hasClass('get-shipping')){
            getStateShipping(that);
        }
        
    });


    getSelectedStateShipping();
    function getSelectedStateShipping(){
        // if(!$('#differentaddress').is(":checked")){
        //     // var selectedStateShipping = $("#state-billing option:selected").val();
        //     var selectedStateShipping = $("#state-billing").attr('data-selected-state');
        //     if(typeof selectedStateShipping !== 'undefined' && selectedStateShipping != '' && selectedStateShipping != null){
        //         // alert('2')
        //         getStateShipping($('#state-billing'));
        //     }
        // }else{
        //     // var selectedState = $("#state option:selected").val();
        //     var selectedState = $("#state").attr('data-selected-state');;
        //     if(typeof selectedState !== 'undefined' && selectedState != '' && selectedState != null){
        //         // alert('1')
        //         getStateShipping($('#state'));
        //     }
        // }

        var selectedState = $("#state").attr('data-selected-state');;
        if(typeof selectedState !== 'undefined' && selectedState != '' && selectedState != null){
            getStateShipping($('#state'));
        }
        
    }
    

    function getStateShipping(stateObj){
        let state = stateObj.find(":selected").val();
        // alert(state)
        
        if(typeof state === 'undefined' || state == '' || state == null){
            state = stateObj.attr('data-selected-state');
        }

        
        // if(typeof selectedState !== 'undefined' && selectedState != '' && selectedState != null){
            
        // }
        
        $('.loader').removeClass('d-none');

        $.ajax({
            type: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/get-state-shipping",
            data: {state: state, shipping_method: $('input[name="shipping_method"]:checked').val() || standardMethodValue()},
            success: function (response) {
                $('.loader').addClass('d-none');
                console.log(response);
                applyPricingResponse(response);

                // if(response.result){

                //     // $('#shipping').attr('data-value',response.price);
                //     // $('#shipping').html(site_currency+''+response.price);
                //     return false;
                // }else{
                //     toastr.error(response.message,'Error');
                //     // $('#shipping').attr('data-value',0);
                //     // $('#shipping').html(site_currency+' '+0);
                // }

            },
            error: function(){
                $('.loader').addClass('d-none');
            }
        });
    }

    // Shared by getStateShipping() (guest, has #state) and the shipping_method
    // radio handler for logged-in users (no #state on the page - see below).
    function applyPricingResponse(response){
        $('#pricing-section').html(response.html);

        if(response.checkout.shipping_data.result){

            var noPaymentMethodCount = $('.place-order-cont').find('a.no-payment-method').length;
            var noUserAddressCount = $('.place-order-cont').find('a.no-user-address').length;
            if(noPaymentMethodCount <= 0 && noUserAddressCount <= 0){
                $('.place-order-cont').html('<input type="submit" class="btn btn-primary btn-md rounded w-100 submit-btn" value="Place Order" />');
            }

        }else{
            $('.place-order-cont').html('<p class="text-danger mb-0"><small>*'+response.checkout.shipping_data.message+' </small></p><a disabled class="btn btn-primary btn-md rounded w-100 text-white disabled" >Place Order</a>');
        }
    }

    // Express Shipping is a flat weight-only rate - the destination state/zone plays no
    // part in it, so the state field is only mandatory while "standard" is selected.
    function toggleStateRequiredForExpress(){
        var $state = $('#state');
        if(!$state.length){
            return;
        }
        if(isExpressMethodValue($('input[name="shipping_method"]:checked').val())){
            $state.removeAttr('required').removeClass('is-invalid');
        }else{
            $state.attr('required', 'required');
        }
    }

    // The radio "value" attributes come straight from config('constants.SHIPPING_STATUS')
    // (numeric, matches the orders.shipping_type column) rather than the literal words
    // "standard"/"express" - so comparisons go through this instead of a hardcoded string,
    // and automatically stay correct even if that config's values ever change.
    function isExpressMethodValue(value){
        return String(value) === String($('#shipping-method-express').val());
    }

    function standardMethodValue(){
        return $('#shipping-method-standard').val();
    }

    toggleStateRequiredForExpress();

    // Recomputes the whole pricing section (subtotal, shipping, tax, total) for
    // whichever shipping method is passed in (or currently selected if omitted).
    // Exposed on window so checkout.blade.php's own inline script - which sits
    // outside this file's closure and can't see getStateShipping()/applyPricingResponse()
    // directly - can trigger the same recompute after adding/removing the ice pack.
    function refreshCheckoutPricing(method){
        method = method || $('input[name="shipping_method"]:checked').val() || standardMethodValue();

        if($('#state').length){
            // Guest checkout: getStateShipping() already reads the picked shipping
            // method itself (see above) and, on the server, a state is only required
            // when "standard" is picked - so this is safe to call either way.
            if(isExpressMethodValue(method) || $('#state').val()){
                getStateShipping($('#state'));
            }
            // "standard" picked with no state selected yet: nothing to show until
            // they pick one, same as today's behavior before Express existed.
        }else{
            // Logged-in checkout has no #state select on the page (address is
            // fixed to the saved default), so recompute against Auth::user() instead.
            $('.loader').removeClass('d-none');
            $.ajax({
                type: "GET",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: site_url + "/refresh-pricing",
                data: {shipping_method: method},
                success: function(response){
                    $('.loader').addClass('d-none');
                    applyPricingResponse(response);
                },
                error: function(){
                    $('.loader').addClass('d-none');
                }
            });
        }
    }

    window.refreshCheckoutPricing = refreshCheckoutPricing;
    window.applyPricingResponse = applyPricingResponse;

    $('body').on('change', 'input[name="shipping_method"]', function(){
        toggleStateRequiredForExpress();

        // Reflect the pick immediately - the AJAX response below re-renders this
        // same markup a moment later, this just avoids a flash of the old state.
        $('.shipping-option').removeClass('is-selected');
        $(this).closest('.shipping-option').addClass('is-selected');

        refreshCheckoutPricing($(this).val());
    });

    $('body').on('change', 'input[name="payment_method"]', function(){
        $('.payment-option').removeClass('is-selected');
        $(this).closest('.payment-option').addClass('is-selected');
    });


    // $('body').on('change', '#state-billing', function (e) {
    //     var that = $(this);

    //     if($('#differentaddress').is(":checked")){
    //         return false;
    //     }

    //     if(that.val() == '' || that.val() == null){
    //         resetAddressValidation();
    //         return false;
    //     }

    //     getStateShipping(that);
        
    // });

    
    $('body').find('.disable-fields').find('input,select,textarea').prop('disabled',true);

    
    $('body').on('click', '.all-categories', function (e) {
        var that = $(this);
        $('#addCategoriesModal').modal('show');
    })
    $('body').on('click', '.all-brands', function (e) {
        var that = $(this);
        $('#addBrandsModal').modal('show');
    })
    
    $('body').on('click', '.show-add-payment-method', function (e) {
        var that = $(this);
        $('#addPaymentMethodModal').modal('show');
        return false;
    })


    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "200",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }

    function numberFormat(price) {
        return parseFloat(price).toFixed(2)
    }
    
    function priceFormat(price) {
        price = numberFormat(price);
        return price.toString().replace(/\B(?=(?:(\d\d)+(\d)(?!\d))+(?!\d))/g, ',');
    }

    $('[data-toggle="tooltip"]').tooltip()


    $('body').on('keydown', '.only-numbers', function (e) {
        allow_numbers_only(e)
    })
  
      function allow_numbers_only(e) {
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) ||
              // Allow: Ctrl+C
              (e.keyCode == 67 && e.ctrlKey === true) ||
              // Allow: Ctrl+X
              (e.keyCode == 88 && e.ctrlKey === true) ||
              // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
              // let it happen, don't do anything
              return;
          }
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      }
  
      function validateEmail(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(String(email).toLowerCase());
      }
      
      
      
      $(document).ready(function () {
          var minimumOrder = $('#top-nav-text-left').data('text');
        const messages = [
          minimumOrder,
          "Bringing Canadian flavours to American tables"
        ];
    
        let index = 0;
    
        setInterval(function () {
          $('#top-nav-text-left')
            .removeClass('animate-in-nav-left')
            .addClass('animate-out-nav-left');
    
          setTimeout(function () {
            index = (index + 1) % messages.length;
            $('#top-nav-text-left').text(messages[index]);
    
            $('#top-nav-text-left')
              .removeClass('animate-out-nav-left')
              .addClass('animate-in-nav-left');
          }, 300);
        }, 4000);
      });
})
