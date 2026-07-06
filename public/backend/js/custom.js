$( document ).ready(function() {

  $('.select2').select2({
    theme: 'bootstrap4'
  });

  $('.select2.tags').select2({
    theme: 'bootstrap4',
    tags: true,
    tokenSeparators: [',', ' ']
  }).on('select2:open', function (e) {
    $('.select2-container--open .select2-dropdown--below').css('display','none');
 });


  // price	old_price	image	stock	min_quantity	threshold	length width	height weight\

  

  $('body').on('change','#is_variant', function(){
    showHideVariants();
  })

  showHideVariants();
  function showHideVariants(){
    var fields = $('[name="price"],[name="old_price"],[name="sku"],[name="stock"],[name="min_quantity"],[name="threshold"],[name="length"],[name="width"],[name="height"],[name="weight"],[name="shipping_weight"]');
    
    if($('#is_variant').is(":checked")){
      $('#variants').removeClass('d-none')
      fields.closest('.form-group').addClass('d-none');
      fields.prop('disabled', true);
    }else{
      $('#variants').addClass('d-none');
      $('#accordion').html('');
      $('#attributes').val(null).trigger('change');
      fields.closest('.form-group').removeClass('d-none');
      fields.prop('disabled', false);
    }
  }

  var ATTRIBUTES;

  $("#show-variations").click(function(){
      var attributes = $('#attributes').val();
      //console.log(attributes);
      if( attributes.length < 1 ){
        alert('Please select atleast 1 attrubute!');
        return false;
      }
      if( $('#accordion').children().length > 0 ){
        if(!confirm('The previous added variants will be lost!  Are you sure you want to update the attributes?')){
          return false;
        }
      }
      ATTRIBUTES = attributes;
      getAttributeCombinations(attributes);
      return false;
    });


    function getAttributeCombinations(attributes){
      $('#loading').removeClass('d-none');
      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/attribute-combinations",
        data: {attributes: attributes},
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response)
          var html = makeAttributeHtml(response.combinations)
          $('#accordion').html(html);
          initDropifyPreview();
          return false;
        }
      });
    }

    function makeAttributeHtml(combinations, defaultKey = null){
      if(combinations.length > 0){
        var html = '';

        var key = 0;
        if(defaultKey != null){
          key = defaultKey
        }

        $.each(combinations, function (k0,val) {
          console.log('combinations:', combinations)
            //console.log(key);
            html += '<div class="card card-primary"  data-key="'+key+'">\
              <div class="card-header">\
              <h4 class="card-title w-100 d-flex">\
                <a class="d-block w-100" data-toggle="collapse" href="#collapse'+key+'">';

                $.each(val, function (k, v) {
                  html +='<strong>'+v.attribute_name+'</strong> : '+v.attribute_value+' ';
                  html +='<input type="hidden" name="attributes['+key+'][details]['+k+'][attribute]" value="'+v.attribute+'">';
                  html +='<input type="hidden" name="attributes['+key+'][details]['+k+'][attributes_option]" value="'+v.attribute_option+'">';

                  html +='<input type="hidden" name="attributes['+key+'][details]['+k+'][attribute_name]" value="'+v.attribute_name+'">';
                  html +='<input type="hidden" name="attributes['+key+'][details]['+k+'][attribute_value]" value="'+v.attribute_value+'">';

                  html +='<input class="combination-detail" data-attribute="'+v.attribute+'" data-attribute-option="'+v.attribute_option+'" data-attribute-name="'+v.attribute_name+'" data-attribute-value="'+v.attribute_value+'" type="hidden" >';

                })

                html +='</a> <a href="#" class="remove-attribute"><i class="fas fa-window-close text-white"></i></a> </h4>\
              </div>\
              <div id="collapse'+key+'" class="collapse" data-parent="#accordion">\
              <div class="card-body">\
                <div class="row">\
                  <div class="col">\
                  <div class="form-group">\
                      <label for="input-'+key+'">Product Image <span class="text-danger">*</span></label>\
                      <input type="file" accept="image/png, image/gif, image/jpeg, image/webp, image/avif" class="form-control dropify" id="input-'+key+'" name="attributes['+key+'][image]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Price <span class="text-danger">*</span></label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Price" name="attributes['+key+'][price]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Old Price </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Old Price" name="attributes['+key+'][old_price]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">SKU <span class="text-danger">*</span></label>\
                      <input type="text" class="form-control" id="input-'+key+'" placeholder="Enter SKU" name="attributes['+key+'][sku]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Stock <span class="text-danger">*</span></label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Stock" name="attributes['+key+'][stock]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Threshold Quantity </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Threshold" name="attributes['+key+'][threshold]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Length </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Length" name="attributes['+key+'][length]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Width </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Width" name="attributes['+key+'][width]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Height </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Height" name="attributes['+key+'][height]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Weight </label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Weight" name="attributes['+key+'][weight]">\
                    </div>\
                    <div class="form-group">\
                      <label for="input-'+key+'">Shipping Weight (In gms) <span class="text-danger">*</span></label>\
                      <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter Shipping Weight (In gms)" name="attributes['+key+'][shipping_weight]">\
                    </div>\
                  </div>\
                </div>\
              </div>\
              </div>\
          </div>';
          key++;
        });

        // <div class="form-group">\
        //   <label for="input-'+key+'">Minimum Quantity <span class="text-danger">*</span></label>\
        //   <input type="text" class="form-control only-numbers" id="input-'+key+'" placeholder="Enter minimum quantity" name="attributes['+key+'][min_quantity]">\
        // </div>\
        return html;
      }
    }


    
    $('body').on('click','.remove-attribute', function(){
      var that = $(this);
      if(!confirm('Are you sure you want to delete?')){
        return false;
      }
      that.closest('.card').remove();
      // reviseSerialIndex();
      return false;
    })

    $('#attributes').on('select2:select', function (e) {
      hideUnhideCustomVariantBtn($(this));
    });

    $('#attributes').on('select2:unselect', function (e) {
      hideUnhideCustomVariantBtn($(this));
    });

    if($('#attributes').length > 0){
      hideUnhideCustomVariantBtn($('#attributes'));
    }
    
    function hideUnhideCustomVariantBtn(that){
      if(that.val().length > 0){
        $('#add-custom-variants').removeClass('d-none');
      }else{
        $('#add-custom-variants').addClass('d-none');
      }
    } 

    $('body').on('click','#add-custom-variants', function(){
      var that = $(this);

      var attributes = $('#attributes').val();
      console.log(attributes);
      $('#attribute-custom-modal').find('.modal-body').find('.combination-html').html('');
      
      var accordiansCount = $('#accordion').find('.card').length;
      if(accordiansCount <= 0){
        alert('Please select variations first');
        return false;
      }

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/attribute-custom-combinations",
        data: {attributes: attributes},
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response);
          if(response.attributes.length > 0){
            var html = makeCustomAttributeHtml(response.attributes);
            $('#attribute-custom-modal').find('.modal-body').find('.combination-html').html(html);
            $('#attribute-custom-modal').modal('show');
          }else{
            alert('No attribute combination found')
          }
          return false;
        }
      });

      return false;
      
    });

    function makeCustomAttributeHtml(attributes){
      if(attributes.length > 0){
        html = '<div class="form-row">';
          $.each(attributes, function (key, val) {
            html +='<div class="form-group col-md-6" data-key="'+key+'">\
                <label for="input-'+key+'">'+val.attribute_name+'</label>\
                <select class="form-control" id="input-'+key+'" data-attribute="'+val.attribute+'" data-attribute-name="'+val.attribute_name+'" data-attribute="'+val.attribute+'" >';
                  html +='<option value="">--Select--</option>';
                  $.each(val.options, function (k, option) {
                  html +='<option value="'+option.id+'" data-attribute-value="'+option.name+'">'+option.name+'</option>';
                  })
                html +='</select>\
                      </div>';
          });
          html +='</div>';
          return html;
      }
    }

    $('body').on('click','#add-custom-variation', function(){
      var that = $(this);
      // alert('a');
      // return false;
      $('.combination-html').find('select').removeClass('is-invalid');
      var inputAttrs = [];
      var validationFlag = true;
      $('.combination-html').find('select').each(function(key,val){
        if($(this).find('option:selected').val() == ""){
          $(this).addClass('is-invalid');
          validationFlag = false;
        }
        inputAttrs.push(
          {
            'attribute_name': $(this).attr('data-attribute-name'),
            'attribute_value': $(this).find('option:selected').attr('data-attribute-value'),
            'attribute': $(this).attr('data-attribute'),
            'attribute_option': parseInt($(this).find('option:selected').val()),
          }
        );
      })
      if(!validationFlag){
        return false;
      }

      var flag = true;

      $('#accordion').find('.card-header').each(function(key,val){
        var testObj = [];
        $(this).find('.combination-detail').each(function(k,v){
          testObj.push(
            {
              'attribute_name': $(this).attr('data-attribute-name'),
              'attribute_value': $(this).attr('data-attribute-value'),
              'attribute': $(this).attr('data-attribute'),
              'attribute_option': parseInt($(this).attr('data-attribute-option')),
            }
          );
        })
        // console.log('start');
        // console.log(inputAttrs);
        // console.log(testObj);
        // console.log('end');
        if(JSON.stringify(inputAttrs) == JSON.stringify(testObj)){
        //if(!_.isEqual(inputAttrs, testObj)){
          console.log('a');
          flag = false;
          return false;
        }
      })

      if(!flag){
        alert('Attribute combination already exists');
        return false;
      }
      
      var dataKey = $('#accordion').find('.card:last-child').attr('data-key');
      if(!dataKey){
        alert('Please select variations first');
        return false;
      }

      var dataKeyIncrease = parseInt(dataKey) + 1;
      var html = makeAttributeHtml([inputAttrs], dataKeyIncrease);
      $('#accordion').append(html);
      initDropifyPreview();
      $('#attribute-custom-modal').modal('hide');      
      return false;
    });


    // function reviseSerialIndex(){
    //   $('#accordion').find('.card').each(function(key,val){
    //       var index=parseInt($(this).attr('data-key'));
    //       $(this).attr('data-key',key)

    //       $(this).find('input,select').each(function(){
    //           var name=$(this).attr('name')
    //           var updatedName=name.replace(index, key);
    //           $(this).attr('name',updatedName);
    //       })
    //   })
    //   return false;
    // }


    $('body').on('click','#update-status', function(){
      var that = $(this)
      var status = $('#status').find(":selected").val();
      var note = $('#note').val().trim();
      var id = $('[name="id"]').val();

      if(status == "" || status == null){
        toastr.error('Please select Order Status','Error');
        return false;
      }

      that.prop("disabled", true);
      that.prepend('<i class="fas fa-spinner fa-spin mr-2"></i>');

      $.ajax({
        type: "POST",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/update-status",
        data: {status: status, note:note, id:id},
        success: function (response) {     
          $('#loading').addClass('d-none');
          that.prop("disabled", false);
          that.find('i').remove();
          console.log(response)
          if(response.result){
            toastr.success(response.message,'Success');
            $('.order-status').text(status)
            $('#status').find('option:selected').prop("selected", false)
            $('#note').val('')
            $('#order-history').html(response.historyHtml);
          }else{
            toastr.error(response.message,'Error');
          }
          return false;
        }
      });

    });

    $('body').on('click','#update-enquiry-status', function(){
      var that = $(this)
      var status = $('#enquiry-status').find(":selected").val();
      var note = $('#enquiry-note').val().trim();
      var id = $('[name="id"]').val();

      if(status == "" || status == null){
        toastr.error('Please select Enquiry Status','Error');
        return false;
      }

      that.prop("disabled", true);
      that.prepend('<i class="fas fa-spinner fa-spin mr-2"></i>');

      $.ajax({
        type: "POST",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/update-enquiry-status",
        data: {status: status, note:note, id:id},
        success: function (response) {     
          $('#loading').addClass('d-none');
          that.prop("disabled", false);
          that.find('i').remove();
          console.log(response)
          if(response.result){
            toastr.success(response.message,'Success');
            $('.enquiry-status').text(status)
            $('#enquiry-status').find('option:selected').prop("selected", false)
            $('#enquiry-note').val('')
            $('#enquiry-history').html(response.historyHtml);
          }else{
            toastr.error(response.message,'Error');
          }
          return false;
        }
      });

    });


    

    $('body').on('click', '#generate-coupon', function (e) {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < 8; i++)
          text += possible.charAt(Math.floor(Math.random() * possible.length));

      $("#coupon-code").val(text);

    })


    
    $('body').on('change', '#coupon-type', function (e) {
      couponType();
    })

    couponType();
    function couponType(){
      var that = $('#coupon-type');
      var element = $('#no_of_times');
      if(that.val() == 'multiple'){
        element.prop('disabled',false);
        element.closest('.form-group').removeClass('d-none')
      }else{
        element.prop('disabled',true);
        element.closest('.form-group').addClass('d-none')
      }
    }


    $('body').on('click','.add-option', function(){
      var that = $(this);
      var row = $('#options-cont').find('.row:first-child').clone();
      
      row.find('input,select').each(function(){
        $(this).val('');
        $(this).closest('.form-group').removeClass('has-error');
        $(this).prop("disabled", false);
      })
      //console.log(row)
      that.closest('#options-cont').append(row);
      reviseOptionSerialIndex();
      return false;
    })

    $('body').on('click','.remove-option', function(){
      var that = $(this);
      if($('#options-cont').find('.row').length <= 1){
        return false;
      }
      if(!confirm('Are you sure you want to delete?')){
        return false;
      }
      var attr = that.attr('data-id');
      if (typeof attr !== 'undefined' && attr !== false) {
        $.ajax({
          type: "POST",            
          dataType: "json",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: site_url + "/delete-attribute-option",
          data: {attr: attr},
          success: function (response) {     
            console.log(response)
            if(response.result){
              toastr.success(response.message,'Success');
              that.closest('.row').remove();
              reviseOptionSerialIndex();
            }else{
              toastr.error(response.message,'Error');
            }
            return false;
          }
        });
      }else{
        that.closest('.row').remove();
        reviseOptionSerialIndex();
      }
      return false;
    })

    function reviseOptionSerialIndex(){
      $('#options-cont').find('.row').each(function(key,val){
          var index=parseInt($(this).attr('data-key'));
          $(this).attr('data-key',key)

          $(this).find('input,select').each(function(){
              var name=$(this).attr('name')
              var updatedName=name.replace(index, key);
              $(this).attr('name',updatedName);
          })
      })
      return false;
    }

  
    $('.datepicker').datetimepicker({
      format: 'L',
      //format:'DD/MM/YYYY',
    });

    $('body').on('click','.delete-btn',function(){
      if(!confirm("Are you sure you want to delete this?")){
          return false;
      }
  })

  countCharacters();
  function countCharacters(){
      if($('.count-characters').length > 0){
        $('.count-characters').each(function(key,val){
          var that = $(this);
          var count = that.val().length;
          that.after('<div class="text-muted characters-count"><small>Characters: '+count+'</small></div>')  
        });
      }
  }


  
  $('body').on('change', '#is_pixel_script', function (e) {
    isPixelScript();
  });

  isPixelScript();
  function isPixelScript(){
    if($('#is_pixel_script').is(":checked")){
      $('.pixel_script').removeClass('d-none');
      //$('.pixel_script').find('textarea,input,select').prop('disabled', false);
    }else{
      $('.pixel_script').addClass('d-none');
      //$('.pixel_script').find('textarea,input,select').prop('disabled', true);
    }
  }

    $('body').on('keyup', '.count-characters', function (e) {
      var that = $(this);
      var count = that.val().length;
      that.closest('.form-group').find('.characters-count').remove();
      that.after('<div class="text-muted characters-count"><small>Characters: '+count+'</small></div>')
    })


    $('#orders-date-range').on('apply.daterangepicker', function(e, picker) {
      
      var startDate = picker.startDate.format('DD-MM-YYYY');
      var endDate = picker.endDate.format('DD-MM-YYYY');
      $(this).val(startDate + ' - ' + endDate);
      
      filterOrders();
    }); 

    $('#orders-date-range').on('cancel.daterangepicker', function(e, picker) {
      $(this).val('');

      filterOrders();
    }); 

    $('#orders-status').on('change', function(e) {
      filterOrders();
    });

    $('#orders-payment-method').on('change', function(e) {
      filterOrders();
    });
    $('#orders-search-btn').on('click', function(e) {
      filterOrders();
    });
  
    var orderSearchClear = false;

    $('#clear-orders-search-btn').on('click', function(e) {
      orderSearchClear = true;
      $('#orders-date-range').val('');
      $('#orders-status').val('');
      $('#orders-payment-method').val('');
      $('#orders-search').val('');
      filterOrders();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterOrders(){

      var startDate, endDate;
      if($('#orders-date-range').val().trim() != "" && $('#orders-date-range').val().trim() != null){
        var picker = $('#orders-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }
      var status = $('#orders-status').val();
      var payment = $('#orders-payment-method').val();
      var search = $('#orders-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-orders",
        data: {startDate:startDate, endDate:endDate, status:status, payment:payment, search:search, clear:orderSearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#order-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(orderSearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          orderSearchClear = false;
        }
      });
    }



    $('#enquiries-date-range').on('apply.daterangepicker', function(e, picker) {
      
      var startDate = picker.startDate.format('DD-MM-YYYY');
      var endDate = picker.endDate.format('DD-MM-YYYY');
      $(this).val(startDate + ' - ' + endDate);
      
      filterEnquiries();
    }); 

    $('#enquiries-date-range').on('cancel.daterangepicker', function(e, picker) {
      $(this).val('');

      filterEnquiries();
    }); 

    $('#enquiries-status').on('change', function(e) {
      filterEnquiries();
    });

    $('#enquiries-payment-method').on('change', function(e) {
      filterEnquiries();
    });
    $('#enquiries-search-btn').on('click', function(e) {
      filterEnquiries();
    });
  
    var enquirySearchClear = false;

    $('#clear-enquiries-search-btn').on('click', function(e) {
      enquirySearchClear = true;
      $('#enquiries-date-range').val('');
      $('#enquiries-status').val('');
      $('#enquiries-payment-method').val('');
      $('#enquiries-search').val('');
      filterEnquiries();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterEnquiries(){

      var startDate, endDate;
      if($('#enquiries-date-range').val().trim() != "" && $('#enquiries-date-range').val().trim() != null){
        var picker = $('#enquiries-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }
      var status = $('#enquiries-status').val();
      var payment = $('#enquiries-payment-method').val();
      var search = $('#enquiries-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-enquiries",
        data: {startDate:startDate, endDate:endDate, status:status, payment:payment, search:search, clear:enquirySearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#enquiry-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(enquirySearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          enquirySearchClear = false;
        }
      });
    }

  
    
    $('#categories-search').on('change', function(e) {
      filterProducts();
    });

    $('#statuses-search').on('change', function(e) {
      filterProducts();
    });

    $('#meta-statuses-search').on('change', function(e) {
      filterProducts();
    });

    $('#products-search-btn').on('click', function(e) {
      filterProducts();
    });
  
    var productSearchClear = false;

    $('#clear-products-search-btn').on('click', function(e) {
      productSearchClear = true;
      $('#categories-search').val('')
      $('#statuses-search').val('')
      $('#meta-statuses-search').val('')
      $('#products-search').val('');
      filterProducts();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterProducts(){
   
      var category = $('#categories-search').val();
      var status = $('#statuses-search').val();
      var metaStatus = $('#meta-statuses-search').val();
      var search = $('#products-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-products",
        data: {category:category, status:status, meta_status:metaStatus, search:search, clear:productSearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#product-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(productSearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          productSearchClear = false;
        }
      });
    }

    $('#users-search-btn').on('click', function(e) {
      filterUsers();
    });
  
    var userSearchClear = false;

    $('#clear-users-search-btn').on('click', function(e) {
      userSearchClear = true;
      $('#users-search').val('');
      filterUsers();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterUsers(){
   
      var search = $('#users-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-users",
        data: {search:search, clear:userSearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#user-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(userSearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          userSearchClear = false;
        }
      });
    }
    

    $('#testimonials-search-btn').on('click', function(e) {
      filterTestimonials();
    });
  
    var testimonialSearchClear = false;

    $('#clear-testimonials-search-btn').on('click', function(e) {
      testimonialSearchClear = true;
      $('#testimonials-search').val('');
      filterTestimonials();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterTestimonials(){
   
      var search = $('#testimonials-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-testimonials",
        data: {search:search, clear:testimonialSearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#testimonial-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(testimonialSearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          testimonialSearchClear = false;
        }
      });
    }

    $('#subadminusers-search-btn').on('click', function(e) {
      filterSubAdminUsers();
    });
  
    var subadminuserSearchClear = false;

    $('#clear-subadminusers-search-btn').on('click', function(e) {
      subadminuserSearchClear = true;
      $('#subadminusers-search').val('');
      filterSubAdminUsers();
      $('ul.pagination').removeClass('d-none');
    });
  
    function filterSubAdminUsers(){
   
      var search = $('#subadminusers-search').val();

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/filter-admin-sub-user",
        data: {search:search, clear:subadminuserSearchClear},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          
          $('#subadminuser-rows').html(response.html);
          // $('ul.pagination').addClass('pagination-sm m-0 float-right')
          // $('ul.pagination').addClass('d-none');
          return false;
        },
        complete: function () {     
          if(subadminuserSearchClear){
            $('ul.pagination').removeClass('d-none');
          }else{
            $('ul.pagination').addClass('d-none');
          }
          subadminuserSearchClear = false;
        }
      });
    }

    
    
    $('body').on('change', '#product-filter', function (e) {
      var that = $(this);
      var key = that.val();
      var user = $('#users-filter').val();
      var stock = $('#stock-filter').val();

      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }

      var event = $('#event-filter').val();

      fetchInventoryLogs(key, null, user, stock, event, startDate, endDate, true);

    })

    $('body').on('change', '#attribute-filter', function (e) {
      var that = $(this);
      var key = $('#product-filter').val();
      var attribute = that.val();
      var user = $('#users-filter').val();
      var stock = $('#stock-filter').val();

      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }

      var event = $('#event-filter').val();

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);
      
    })

    $('body').on('change', '#users-filter', function (e) {
      var that = $(this);
      var key = $('#product-filter').val();
      var attribute = $('#attribute-filter').val();
      var user = that.val();
      var stock = $('#stock-filter').val();

      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }

      var event = $('#event-filter').val();

      $('#loading').removeClass('d-none');

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);
      
    })

    $('body').on('change', '#stock-filter', function (e) {
      var that = $(this);
      var key = $('#product-filter').val();
      var attribute = $('#attribute-filter').val();
      var user = $('#users-filter').val();
      var stock = that.val();

      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }

      var event = $('#event-filter').val();

      $('#loading').removeClass('d-none');

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);
      
    })

    $('body').on('change', '#event-filter', function (e) {
      var that = $(this);
      var key = $('#product-filter').val();
      var attribute = $('#attribute-filter').val();
      var user = $('#users-filter').val();
      var stock = $('#stock-filter').val();

      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }

      var event = that.val();

      $('#loading').removeClass('d-none');

      // var tt = $('#inventory-date-range').data('daterangepicker').startDate.format('DD-MM-YYYY');
      // alert(tt)

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);

    })


    $('#inventory-date-range').on('apply.daterangepicker', function(e, picker) {
      // console.log(ev);
      // console.log(picker);

      

      var key = $('#product-filter').val();
      var attribute = $('#attribute-filter').val();
      var user = $('#users-filter').val();
      var stock = $('#stock-filter').val();
      
      var startDate = picker.startDate.format('DD-MM-YYYY');
      var endDate = picker.endDate.format('DD-MM-YYYY');
      //console.log(picker.endDate.format('DD-MM-YYYY'));

      //$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      $(this).val(startDate + ' - ' + endDate);

      var event = $('#event-filter').val();

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);
  });


  $('#inventory-date-range').on('cancel.daterangepicker', function(e, picker) {
      $(this).val('');

      var key = $('#product-filter').val();
      var attribute = $('#attribute-filter').val();
      var user = $('#users-filter').val();
      var stock = $('#stock-filter').val();
      
      var startDate, endDate;
      if($('#inventory-date-range').val().trim() != "" && $('#inventory-date-range').val().trim() != null){
        var picker = $('#inventory-date-range').data('daterangepicker');
        startDate = picker.startDate.format('DD-MM-YYYY');
        endDate = picker.endDate.format('DD-MM-YYYY');
      }


      var event = $('#event-filter').val();

      fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate);
      
  }); 

    function fetchInventoryLogs(key, attribute, user, stock, event, startDate, endDate, isProduct = false){

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/inventory",
        data: {key: key, attribute:attribute, user:user, stock:stock, event:event, startDate:startDate, endDate:endDate},
        success: function (response) {     
          $('#loading').addClass('d-none');
          //console.log(response)
          $('#inventory-logs').html(response.html)

          if(isProduct){
            var optionsHtml = makeAttributesOptionHtml(response.attributes, '#attribute-filter');
            $('#attribute-filter').html(optionsHtml);
          }
          
          $('#inventory-logs').html(response.html);

          return false;
        }
      });
    }

    function makeAttributesOptionHtml(attributes, optionsHtmlID){
      var optionsHtml = '';
          
      if(attributes.length > 0){
        $(optionsHtmlID).prop('disabled', false);
        optionsHtml += '<option value="">--Select Attribute--</option>';
        $.each(attributes, function (key, attribute) {
          optionsHtml += '<option value="'+attribute.id+'">';
            $.each(attribute.details, function (k, detail) {
              //attribute 
              optionsHtml += detail.attribute_name+': '+detail.attribute_value+' ';
            });
            optionsHtml.trim()
          optionsHtml += '</option>';
        });
      }else{
        optionsHtml = '<option value="">--No Attribute--</option>';
        $(optionsHtmlID).prop('disabled', true);
      }
      return optionsHtml;
    }


    $('body').on('change', '#product-inventory-add', function (e) {
      var that = $(this);
      var key = that.val();

      $('#stock-quantity').find('select,input').removeClass('is-invalid');

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/inventory-add",
        data: {key: key},
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response);
          
          //var optionsHtml = makeAttributesOptionHtml(response.attributes, '#attribute-inventory-add');

          if(response.attributes.length > 0){

            var attributeHtml = '';
            $.each(response.attributes, function (k, attribute) {
              attributeHtml += '<div class="form-group row" data-key="'+key+'" data-attribute="'+attribute.id+'" data-price="'+attribute.price+'" data-type="attribute"><label class="col-sm-2 col-form-label">';
                $.each(attribute.details, function (k1, detail) {
                  //attribute 
                  attributeHtml += detail.attribute_name+': '+detail.attribute_value+' ';
                });

                attributeHtml += 'Stock';
                attributeHtml += '</label>';

                attributeHtml += '<div class="col-sm-1">\
                          <p class="form-control-plaintext">'+attribute.stock+'</p>\
                          </div>\
                          <div class="col-sm-2">\
                          <select class="form-control" required name="event">\
                            <option value="">--Select Event--</option>\
                            <option value="added">Add</option>\
                            <option value="remove">Remove</option>\
                          </select>\
                          </div>\
                            <div class="col-sm-2">\
                            <input type="text" placeholder="Stock Quantity" required class="form-control only-numbers" name="stock"  />\
                            </div>\
                            <div class="col-sm-2">\
                            <input type="text" placeholder="Note (Optional)" class="form-control" name="note"  />\
                            </div>\
                            <div class="col-sm-2">\
                            <button class="btn btn-success update-stock">Update</button>\
                            </div>\
                          </div>';

            });

            $('#stock-attribute-quantity').removeClass('d-none');
            $('#stock-attribute-quantity').html(attributeHtml);

            $('#stock-quantity').addClass('d-none');
            $('#stock-quantity').find('.form-control-plaintext').text('');
            $('#stock-quantity').attr('data-key','');
            $('#stock-quantity').attr('data-price','');

          }else{

            $('#stock-attribute-quantity').addClass('d-none');
            $('#stock-attribute-quantity').html('');

            $('#stock-quantity').removeClass('d-none');
            $('#stock-quantity').find('.form-control-plaintext').text(response.product.stock);
            $('#stock-quantity').attr('data-key',response.product.slug);
            $('#stock-quantity').attr('data-price',response.product.price);
            
          }
          
          //$('#attribute-inventory-add').html(optionsHtml)
          return false;
        }
      });
    });

    // $('body').on('change', '#attribute-inventory-add', function (e) {
    //   var that = $(this);
    //   var key = $('#product-inventory-add').val();
    //   var attribute = that.val();


    //   $('#loading').removeClass('d-none');

    //   $.ajax({
    //     type: "GET",            
    //     dataType: "json",
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     url: site_url + "/inventory-add",
    //     data: {key: key, attribute:attribute},
    //     success: function (response) {     
    //       $('#loading').addClass('d-none');
    //       console.log(response);
          
    //       return false;
    //     }
    //   });
    // });


    $('body').on('click', '.update-stock', function (e) {
      var that = $(this);
      
      var row = that.closest('.row');
      var type = row.attr('data-type');
      var key = row.attr('data-key');
      var attribute = row.attr('data-attribute');
      var price = row.attr('data-price');
      var event = row.find('[name="event"]').find('option:selected').val();
      var stock = row.find('[name="stock"]').val();
      var note = row.find('[name="note"]').val();
      
      // alert(type)
      // alert(event)
      // alert(stock)
      // alert(note)
      // return false;

      // alert(key);
      // return false;

      row.find('input,textarea,select').removeClass('is-invalid');
      row.find('.invalid-feedback').remove();

      var flag = true;
      
      flag = validateEmptyFields(row);

      if(!flag){
        return false;
      }

      
      $('#loading').removeClass('d-none');

      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/inventory-add-stock",
        data: {type: type, key:key, attribute:attribute, event: event, stock:stock, note:note, price:price},
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response);

          if(response.result){
            toastr.success(response.message,'Success');

            $('#stock-quantity').addClass('d-none');
            $('#stock-quantity').find('.form-control-plaintext').text('');
            $('#stock-quantity').attr('data-key','');
            $('#stock-quantity').attr('data-price','');
            $('#product-inventory-add').val('')
            $('#stock-quantity').find('input,select').val('')
            $('#stock-attribute-quantity').html('')

          }else{
            toastr.error(response.message,'Error');
          }
          
          return false;
        },
        error: function(xhr, textStatus) {
          $('#loading').addClass('d-none');
          if(xhr.status == 422){
              var responseText = $.parseJSON(xhr.responseText);
              validateAfterCall(responseText, row);
          }
          return false;
        },
      });
    });




    $('body').on('click','.add-specification', function(){
      var that = $(this);
      var row = $('#specifications-cont').find('.row:first-child').clone();
      
      row.find('input,select').each(function(){
        $(this).val('');
        $(this).closest('.form-group').removeClass('has-error');
        $(this).prop("disabled", false);
      })
      //console.log(row)
      that.closest('#specifications-cont').append(row);
      reviseSpecificationSerialIndex();
      return false;
    })

    $('body').on('click','.remove-specification', function(){
      var that = $(this);
      // if($('#specifications-cont').find('.row').length <= 1){
      //   return false;
      // }
      if(!confirm('Are you sure you want to delete?')){
        return false;
      }

      var rowEmpty = '<div class="row" data-key="0">\
                        <div class="col-md-9">\
                          <div class="form-group">\
                            <div class="form-row">\
                              <div class="col">\
                                <input type="text" class="form-control" placeholder="Specification" name="specifications[0][specification]">\
                              </div>\
                              <div class="col">\
                                <input type="text" class="form-control" placeholder="Value" name="specifications[0][value]">\
                              </div>\
                              <div class="col">\
                                <input type="text" class="form-control" placeholder="Units (Optional)" name="specifications[0][units]">\
                              </div>\
                            </div>\
                          </div>\
                        </div>\
                        <div class="col-md-3">\
                          <button class="btn btn-success add-specification"><i class="fa fa-plus"></i></button>\
                          <button class="btn btn-danger remove-specification"><i class="fa fa-minus"></i></button>\
                        </div>\
                      </div>';

      var key = that.attr('data-product-id');
      var id = that.attr('data-id');
      if ((typeof key !== 'undefined' && key !== false) && (typeof id !== 'undefined' && id !== false)) {
        $.ajax({
          type: "POST",            
          dataType: "json",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: site_url + "/delete-product-specification",
          data: {key: key, id:id},
          success: function (response) {     
            console.log(response)
            if(response.result){
              toastr.success(response.message,'Success');
              that.closest('.row').remove();
              if($('#specifications-cont').find('.row').length <= 0){
                $('#specifications-cont').append(rowEmpty);
              }
              reviseSpecificationSerialIndex();
            }else{
              toastr.error(response.message,'Error');
            }
            return false;
          }
        });
      }else{
        that.closest('.row').remove();
        if($('#specifications-cont').find('.row').length <= 0){
          $('#specifications-cont').append(rowEmpty);
        }
        reviseSpecificationSerialIndex();
      }
      return false;
    })

    function reviseSpecificationSerialIndex(){
      $('#specifications-cont').find('.row').each(function(key,val){
          var index=parseInt($(this).attr('data-key'));
          $(this).attr('data-key',key)

          $(this).find('input,select').each(function(){
              var name=$(this).attr('name')
              var updatedName=name.replace(index, key);
              $(this).attr('name',updatedName);
          })
      })
      return false;
    }


    if($('#chart_div').length > 0){
      drawSalesGraph();
    }
    
    function drawSalesGraph(){
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Sales', 'Orders'],
          ['January',  1000, 10],
          ['Feburary',  1170, 22],
          ['March',  660, 24],
          ['April',  1030, 56],
          ['May',  130, 45],
          ['June',  530, 57],
          ['July',  7000, 55],
          ['August',  1300, 23],
          ['September',  230, 47],
          ['October',  250, 67],
          ['November',  70, 5],
          ['December',  800, 56],
        ]);

        var options = {
          title: 'Monthly Sales ('+site_currency+')',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    }









    if($('#sales-chart-canvas').length > 0){
     /* Chart.js Charts */
    // Sales chart
    var salesChartCanvas = document.getElementById('sales-chart-canvas').getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');


    function setYearSalesChart(year){
      $.ajax({
        type: "GET",            
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //url: site_url + "/sales-data",
        url: site_url + "/sales-data",
        data: {year: year},
        success: function (response) {     
          console.log(response);
          //alert('aaa')
  
          drawSalesChart(response.sales);
  
          //return false;
        }
      });
    }
    

    //drawSalesChart([28, 48, 40, 19, 86, 27, 90, 60, 88, 25, 5, 90])

    function drawSalesChart(data){

      var salesChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [
          {
            label: 'Sales',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: data
          },
        ]
      }
  
      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false
            }
          }],
          yAxes: [{
            gridLines: {
              display: false
            }
          }]
        }
      }
  
      // This will get the first returned node in the jQuery collection.
      // eslint-disable-next-line no-unused-vars
      var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesChartData,
        options: salesChartOptions
      })
  
      console.log(salesChart)
    }
    }

    





    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
    var mode = 'index'
  var intersect = true

    var $salesChart1 = $('#sales-amount-chart')
  // eslint-disable-next-line no-unused-vars

  if($('#sales-amount-chart').length > 0){
    setYearSalesAmountChart();
  }
  
  function setYearSalesAmountChart(){
    $.ajax({
      type: "GET",            
      dataType: "json",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      //url: site_url + "/sales-data",
      url: site_url + "/sales-amount-data",
      //data: {year: year},
      success: function (response) {     
        console.log(response);
        //alert('aaa')

        drawSalesAmountChart([response.current, response.previous]);

        //return false;
      }
    });
  }

  function drawSalesAmountChart(data){
    var salesChart1 = new Chart($salesChart1, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            //data: [1000, 2000, 3000, 2500, 2700, 2500, 3000, 1000, 2000, 3000, 2500, 2700, 2500, 3000]
            data: data[0]
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            // data: [700, 1700, 2700, 2000, 1800, 1500, 2000, 700, 1700, 2700, 2000, 1800, 1500, 2000]
            data: data[1]
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              // lineWidth: '4px',
              // color: 'rgba(0, 0, 0, .2)',
              // zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
  
              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }
  
                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: true
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  }
  
  if($('#highest-sale').length > 0){
  getHighestSaleProducts();
  }

  function getHighestSaleProducts(){
    $.ajax({
      type: "GET",            
      dataType: "json",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      //url: site_url + "/sales-data",
      url: site_url + "/highest-sale-product-data",
      //data: {year: year},
      success: function (response) {     
        console.log(response);
        //alert('aaa')

        drawProductSaleChart([response.labels, response.data]);

        //return false;
      }
    });
  }


  function drawProductSaleChart(data){

      //-------------
      //- PIE CHART -
      //-------------

      var pieData = {
        // labels: [
        //     'Chrome',
        //     'IE',
        //     'FireFox',
        //     'Safari',
        //     'Opera',
        //     'Navigator',
        // ],
        labels: data[0],
        datasets: [
          {
            //data: [700,500,400,600,300,100],
            data: data[1],
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }

      // Get context with jQuery - using jQuery's .get() method.
      var pieChartSaleCanvas = $('#highest-sale').get(0).getContext('2d')
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieChartSaleCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })


  }



  

  if($('#pieChart1').length > 0){
    getHighestIncomeProducts();
  }

  function getHighestIncomeProducts(){
    $.ajax({
      type: "GET",            
      dataType: "json",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      //url: site_url + "/sales-data",
      url: site_url + "/highest-sale-amount-product-data",
      //data: {year: year},
      success: function (response) {     
        console.log(response);
        //alert('aaa')

        drawProductIncomeChart([response.labels, response.data]);

        //return false;
      }
    });
  }


  function drawProductIncomeChart(data){
    var pieData1 = {
      // labels: [
      //     'Chrome',
      //     'IE',
      //     'FireFox',
      //     'Safari',
      //     'Opera',
      //     'Navigator',
      // ],
      labels: data[0],
      datasets: [
        {
          // data: [700,500,400,600,300,100],
          data: data[1],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }

     // Get context with jQuery - using jQuery's .get() method.
     var pieChartCanvas1 = $('#pieChart1').get(0).getContext('2d')
     var pieOptions1     = {
       maintainAspectRatio : false,
       responsive : true,
     }
     //Create pie or douhnut chart
     // You can switch between pie and douhnut using the method below.
     new Chart(pieChartCanvas1, {
       type: 'pie',
       data: pieData1,
       options: pieOptions1
     })
  }



  
    $('body').on('click','.open-import-modal', function(){
      var that = $(this);

      $('#import-modal').modal('show');

      return false;
  
    });
    
    // $('#import-modal').modal('show');
  
    $('body').on('click','.validate-import', function(){
      var that = $(this);

      var row = that.closest('.modal-content').find('.row');

      row.find('input').removeClass('is-invalid');
      row.find('.invalid-feedback').remove();
      

      let formData = new FormData();
      let fileInput = $('#import-modal').find('input[name="file"]')[0].files[0];

      if (!fileInput) {
          alert("Please select a file.");
          return;
      }

      formData.append("file", fileInput);

      $('#import-validation-html').html('');
      $('#loading').removeClass('d-none');

      $.ajax({
        type: "POST",            
        // dataType: "json",
        contentType: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/validate-products-import",
        data: formData,
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response);
          // return false;

          $('#import-validation-html').html(response.html);

          // if(response.result){
          //   toastr.success(response.message,'Success');

          //   $('#stock-quantity').addClass('d-none');
          //   $('#stock-quantity').find('.form-control-plaintext').text('');
          //   $('#stock-quantity').attr('data-key','');
          //   $('#stock-quantity').attr('data-price','');
          //   $('#product-inventory-add').val('')
          //   $('#stock-quantity').find('input,select').val('')
          //   $('#stock-attribute-quantity').html('')

          // }else{
          //   toastr.error(response.message,'Error');
          // }
          
          // return false;
        },
        error: function(xhr, textStatus) {
          $('#loading').addClass('d-none');
          console.log(xhr)
          if (xhr.status === 0) {
            $('#import-validation-html').html('');
            alert('File upload was interrupted. Please reselect the Import file and try again.');
            $('#import-modal').find('input[name="file"]').val('');
          }
          if(xhr.status == 422){
              var responseText = $.parseJSON(xhr.responseText);
              console.log(responseText)

              if(!$.isEmptyObject(responseText.errors)){
                // console.log(responseText.errors);
                // console.log(row);
                row.find('input,textarea,select').each(function(){
                    var key = $(this).attr('name');
                    console.log(key)
                    if(key in responseText.errors){
                      console.log(responseText.errors[key])
                      row.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').addClass('is-invalid');
                      row.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').after('<div class="invalid-feedback">'+ responseText.errors[key] +'</div>');
                    } else {
      
                    }
                });
            }

          }
          return false;
        },
      });

      return false;
  
    });


    $('body').on('click','.import-now', function(){
      var that = $(this);

      var row = that.closest('.modal-content').find('.row');

      row.find('input').removeClass('is-invalid');
      row.find('.invalid-feedback').remove();
      

      let formData = new FormData();
      let fileInput = $('#import-modal').find('input[name="file"]')[0].files[0];

      if (!fileInput) {
          alert("Please select a file.");
          return;
      }

      formData.append("file", fileInput);

      $('#loading').removeClass('d-none');

      $.ajax({
        type: "POST",            
        // dataType: "json",
        contentType: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: site_url + "/products-import",
        data: formData,
        success: function (response) {     
          $('#loading').addClass('d-none');
          console.log(response);
          // return false;


          if(response.result){
            toastr.success(response.message,'Success');
            $('#import-modal').modal('hide');
            // productSearchClear = true;
            // $('#products-search').val('');
            filterProducts();
            // $('ul.pagination').removeClass('d-none');

          }else{
            toastr.error(response.message,'Error');
          }

          $('#import-validation-html').html('');
          $('#import-modal').find('input[name="file"]').val('');
          
          // return false;
        },
        error: function(xhr, textStatus) {
          $('#loading').addClass('d-none');
          if (xhr.status === 0) {
            $('#import-validation-html').html('');
            $('#import-modal').find('input[name="file"]').val('');
          }
          if(xhr.status == 422){
              // var responseText = $.parseJSON(xhr.responseText);
              // console.log(responseText)
              alert('There is some error, please refresh the page and retry again')
          }
          return false;
        },
      });

      return false;
  
    });

    $('#import-modal').on('hidden.bs.modal', function (event) {
      $('#import-validation-html').html('');
      $('#import-modal').find('input[name="file"]').val('');
    })
    











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


    function validateAfterCall(responseText, form){
      if(!$.isEmptyObject(responseText.errors)){
          console.log(responseText.errors);
          console.log(form);
          form.find('input,textarea,select').each(function(){
              var key = $(this).attr('name');
              console.log(key)
              if(key in responseText.errors){
                console.log(responseText.errors[key])
                form.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').addClass('is-invalid');
                form.find('textarea[name="'+key+'"],input[name="'+key+'"],select[name="'+key+'"]').after('<div class="invalid-feedback">'+ responseText.errors[key] +'</div>');
              } else {

              }
          });
      }
  }


    // $('.date-picker').daterangepicker({
    //   format: 'L',
    // })

    if($('#year-date-picker').length > 0){

      $('#year-date-picker').datetimepicker({
        format: 'L',
        viewMode: 'years',
        format: 'YYYY',
        date: new Date(),
      });


      var $picker = $("#year-date-picker");
      setYearSalesChart($picker.find('input').val());
      
      $picker.on("update.datetimepicker", function (e) {
        var year = e.viewDate.year();
      console.log(year);
      setYearSalesChart(year)
      });
    }

    $('.date-range-picker').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }

      // "startDate": null,
      // "endDate": null
    })

    initDropifyPreview();

    function initDropifyPreview(){
      $('.dropify').dropify();
      showWebpAvifDropifyPreview($('.dropify'));
      showDefaultWebpAvifDropifyPreview($('.dropify'));
    }

    function showWebpAvifDropifyPreview(inputs){
      inputs.off('change.webpAvifPreview').on('change.webpAvifPreview', function(){
        var input = this;
        var file = input.files && input.files[0] ? input.files[0] : null;

        if(!file){
          return;
        }

        var fileName = file.name.toLowerCase();
        var isPreviewFormat = fileName.endsWith('.webp') || fileName.endsWith('.avif');

        if(!isPreviewFormat){
          return;
        }

        var imageUrl = URL.createObjectURL(file);

        setTimeout(function(){
          var wrapper = $(input).closest('.dropify-wrapper');
          var render = wrapper.find('.dropify-render');
          var preview = wrapper.find('.dropify-preview');

          render.html('<img src="'+imageUrl+'" style="max-width: 100%; max-height: 100%;" />');
          preview.show();
          wrapper.addClass('has-preview');
        }, 100);
      });
    }

    function showDefaultWebpAvifDropifyPreview(inputs){
      inputs.each(function(){
        var input = this;
        var defaultFile = $(input).attr('data-default-file');

        if(!defaultFile){
          return;
        }

        var defaultFileLower = defaultFile.toLowerCase().split('?')[0];
        var isPreviewFormat = defaultFileLower.endsWith('.webp') || defaultFileLower.endsWith('.avif');

        if(!isPreviewFormat){
          return;
        }

        setTimeout(function(){
          var wrapper = $(input).closest('.dropify-wrapper');
          var render = wrapper.find('.dropify-render');
          var preview = wrapper.find('.dropify-preview');

          render.html('<img src="'+defaultFile+'" style="max-width: 100%; max-height: 100%;" />');
          preview.show();
          wrapper.addClass('has-preview');
        }, 100);
      });
    }

    // $("#multiple_images").spartanMultiImagePicker({
    //   fieldName:  'images[]',
    //    allowedExt: "png|jpg|jpeg|webp|avif",
    // });

$("#multiple_images").spartanMultiImagePicker({
    fieldName: 'images[]',
    allowedExt: "png|jpg|jpeg|webp|avif",

    onAddRow: function (index) {

        setTimeout(function () {

            var container = $("#multiple_images")
                .find(".spartan_item_wrapper")
                .last();

            if (container.find(".gallery-alt-text").length === 0) {

                container.append(`
                    <div class="mt-2 gallery-alt-text">
                        <label class="mb-1"><strong>Image Alt Text</strong></label>
                        <input type="text"
                               name="images_alt[]"
                               class="form-control"
                               placeholder="Enter image alt text">
                    </div>
                `);

            }

        }, 100);

    }
});

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
    
})
