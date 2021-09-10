jQuery(document).ready(function(){

    var city_table = jQuery('#city-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "city_name"
        }, {
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'city/get_city_data',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No City in the system.",
            "sZeroRecords": "No City to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "get_giftcard_plan", "value": true});
        }
    });
    jQuery(document).on('click','.add-city',function(){
        jQuery('#form-city')[0].reset();
        jQuery('#modal-city #form-city #city_id').val(0);
        jQuery('#modal-city #form-city #blah').attr('src', '#');
        jQuery('#modal-city #form-city #blah_div').hide();
        jQuery('#inapp_product').attr('disabled', 'disabled');
        jQuery('#inapp_product_div').css('display', 'none');
        jQuery('#modal-city .modal-title').text('Add City');
        jQuery('#modal-city #form-city #form-action').val('add');
        jQuery('#modal-city').modal('show');
    });
    jQuery("#form-city").validate({
        rules: {
            'city_name': {
                required:true
            },
            'city_price': {
                required:true
            },
            'popular_interests': {
                required:true
            },
            'inapp_product': {
                required:true
            },
            'city_cover_image':{
                accept:'image/*'
            }
        },
        messages: {
            'city_name': {
                required: "Please Enter City Name"
            },
            'city_price': {
                required: "Please Enter City Price"
            },
            'popular_interests': {
                required: "Please Enter Popular Interests"
            },
            'inapp_product': {
                required:"Please Enter Inapp Product"
            },
            'city_cover_image':{
                accept:"Please Upload only Image file"
            }
        }
    });
    jQuery(document).on('submit','#form-city',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'city/add_edit_city',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-city').modal('hide');
                    jQuery('#form-city')[0].reset();
                    city_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-city',function(){
        var city_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'city/get_city',
            data:'city_id='+city_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-city .modal-title').text('Edit City');
                    jQuery('#modal-city #form-city #form-action').val('edit');
                    jQuery('#modal-city #form-city #city_id').val(city_id);
                    jQuery('#form-city')[0].reset();
                    jQuery('#modal-city #form-city #city_name').val(data.data.city_name);
                    jQuery('#modal-city #form-city #city_description').val(data.data.city_description);
                    jQuery('#modal-city #form-city #city_type').val(data.data.city_type);
                    if(data.data.city_type=='1'){
                        jQuery('#inapp_product').removeAttr('disabled');
                        jQuery('#modal-city #form-city #inapp_product').val(data.data.inapp_product);
                        jQuery('#inapp_product_div').css('display', 'block');
                    }
                    else{
                        jQuery('#inapp_product').attr('disabled', 'disabled');
                        jQuery('#inapp_product_div').css('display', 'none');
                    }
                    jQuery('#modal-city #form-city #city_price').val(data.data.city_price);
                    jQuery('#modal-city #form-city #popular_interests').val(data.data.popular_interests);
                    if(data.data.version!=0){
                        jQuery('#modal-city #form-city #version').val(data.data.version);
                    }
                    else{
                        jQuery('#modal-city #form-city #version').val('');
                    }
                    if(data.data.city_cover_image!=''){
                        jQuery('#modal-city #form-city #blah').attr('src', c_img_url+data.data.city_cover_image);
                        jQuery('#modal-city #form-city #blah_div').show();
                    }
                    else{
                        jQuery('#modal-city #form-city #blah').attr('src', '#');
                        jQuery('#modal-city #form-city #blah_div').hide();
                    }
                    jQuery('#modal-city').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-city',function(){
        var city_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'city/delete_city',
                data:'city_id='+city_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        city_table.draw();
                        toastr.success(data.msg, "");
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                jQuery('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            jQuery('#blah_div').show();
        }else{
            jQuery('#blah_div').hide();
        }
    }
    jQuery("#city_cover_image").change(function() {
        readURL(this);
    });

    jQuery("#city_type").change(function() {
        var val = jQuery(this).val();
        if(val=='1'){
            jQuery('#inapp_product').removeAttr('disabled');
            jQuery('#inapp_product_div').css('display', 'block');
        }
        else{
            jQuery('#inapp_product').attr('disabled', 'disabled');
            jQuery('#inapp_product_div').css('display', 'none');
        }
    });

    jQuery(document).on('click','.view-city-images',function(){
        jQuery('#other_images').html('');
        var img_city_id = jQuery(this).data('id');
        jQuery('#form-city-images')[0].reset();
        jQuery('#modal-city-images .modal-title').text('City Images');
        jQuery('#modal-city-images #img_city_id').val(img_city_id);
        jQuery.ajax({
            type: 'post',
            url: base_url + 'city/get_city_images',
            data: 'img_city_id=' + img_city_id,
            dataType: 'JSON',
            success: function (response) {
                var html = '';
                jQuery.each( response.data, function( key, value ) {
                    html += '<div class="col-sm-6 col-md-3" id="city_img_'+value.city_image_id+'">';
                    html += '<a class="thumbnail">';
                    html += '<button type="button" class="close delete-image" data-city-image-id="'+value.city_image_id+'" title="Delete Image">×</button>';
                    html += '<img src="'+c_img_url+value.city_image+'" alt="">';
                    html += '</a>';
                    html += '</div>';
                });
                jQuery('#other_images').html(html);
            }
        });
        jQuery('#modal-city-images').modal('show');
    });
    jQuery(document).on('submit','#form-city-images',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'city/upload_city_images',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#form-city-images')[0].reset();
                    jQuery('#modal-city-images').modal('hide');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.delete-image',function(){
        var city_image_id = jQuery(this).data('city-image-id');
        if(confirm('Are you sure you want to delete this image?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'city/delete_city_images',
                data:'city_image_id='+city_image_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        toastr.success(data.msg, "");
                        jQuery('#city_img_'+city_image_id).remove();
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });
});