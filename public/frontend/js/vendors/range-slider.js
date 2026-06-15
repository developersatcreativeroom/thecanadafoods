$(".at-pricing-range").each(function(){
    var priceInput = $(this).find(".price-input");

    var min_price = $(this).find(".min_price");
    var max_price = $(this).find(".max_price");

    priceInput.on("change", function(){

        var min_price = $(this).parents(".at-pricing-range").find(".min_price");
        var max_price = $(this).parents(".at-pricing-range").find(".max_price");

        var min_price_range = parseInt(min_price.val());

        var max_price_range = parseInt(max_price.val());

        
        if( min_price_range < data_min_price_range){
            min_price_range = data_min_price_range;
            $(".min_price").val(data_min_price_range);
        }

        if( min_price_range > data_max_price_range){
            min_price_range = data_max_price_range;
            $(".min_price").val(data_max_price_range);
        }

        if( max_price_range > data_max_price_range ){
            max_price_range = data_max_price_range;
            $(".max_price").val(data_max_price_range);
        }

        if( max_price_range < data_min_price_range ){
            max_price_range = data_min_price_range;
            $(".max_price").val(data_min_price_range);
        }

        if (min_price_range > max_price_range) {
            max_price.val(min_price_range);
        }

        var price_filter_range = $(this).parents(".at-pricing-range").find(".price-filter-range");

        price_filter_range.slider({
            values: [min_price_range, max_price_range]
        });
    });

    priceInput.on("paste keyup", function(){

        var min_price = $(this).parents(".at-pricing-range").find(".min_price");
        var max_price = $(this).parents(".at-pricing-range").find(".max_price");

        var min_price_range = parseInt(min_price.val());

        var max_price_range = parseInt(max_price.val());


        if( min_price_range < data_min_price_range){
            min_price_range = data_min_price_range;
            $(".min_price").val(data_min_price_range);
        }

        if( min_price_range > data_max_price_range){
            min_price_range = data_max_price_range;
            $(".min_price").val(data_max_price_range);
        }

        if( max_price_range > data_max_price_range ){
            max_price_range = data_max_price_range;
            $(".max_price").val(data_max_price_range);
        }

        if( max_price_range < data_min_price_range ){
            max_price_range = data_min_price_range;
            $(".max_price").val(data_min_price_range);
        }

        // if(min_price_range == max_price_range) {
        //     max_price_range = min_price_range + 100;

        //     min_price.val(min_price_range);
        //     max_price.val(max_price_range);
        // }

        var price_filter_range = $(this).parents(".at-pricing-range").find(".price-filter-range");

        price_filter_range.slider({
            values: [min_price_range, max_price_range]
        });

    }); 

    var price_filter_range = $(this).find(".price-filter-range");


    var data_min_price_range = parseInt($(".min_price").attr('data-min'));
    var data_max_price_range = parseInt($(".max_price").attr('data-max'));

    var data_min_selected_price = parseInt($(".min_price").attr('data-min-selected'));
    var data_max_selected_price = parseInt($(".max_price").attr('data-max-selected'));

    price_filter_range.slider({
        range: true,
        orientation: "horizontal", 
        min: data_min_price_range, 
        max: data_max_price_range, 
        values: [data_min_selected_price, data_max_selected_price], 
        step: 1, 

        slide: function(event, ui) {
            // console.log(ui.values)
            if(ui.values[0] == ui.values[1]) {
                return false;
            }

            min_price.val(ui.values[0]); 
            max_price.val(ui.values[1]);

            $('#min-amount').val(ui.values[0]);
            $('#max-amount').val(ui.values[1]);
        }
    });

    min_price.val(price_filter_range.slider("values", 0)); 
    max_price.val(price_filter_range.slider("values", 1));
});