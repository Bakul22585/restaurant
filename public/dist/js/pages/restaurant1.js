jQuery(document).ready(function(){
    jQuery('#interest_tags').select2();
    $('.TimeTag').timepicker({
        showMeridian: false,
        showSeconds: true
    });
    var restaurant_id = $('#filter_restaurant').val();
    var restaurant_table = jQuery('#restaurant-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "res_id"
        },{
            "mDataProp": "res_name"
        },{
            "mDataProp": "desc"
        },{
            "mDataProp": "address"
        },{
            "mDataProp": "serves_alcohol"
        },{
            "mDataProp": "veg"
        },{
            "mDataProp": "halal"
        },{
            "mDataProp": "kosher"
        },{
            "mDataProp": "delivery"
        },{
            "mDataProp": "res_images"
        },{
            "mDataProp": "res_type"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'restaurant/get_restaurant_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_restaurant", "value": restaurant_id});
        }
    });
    jQuery("#filter_restaurant").change(function() {
        restaurant_id = jQuery(this).val();
        restaurant_table.draw();
    });
    jQuery(document).on('click','.add-restaurant',function(){
        jQuery("#userTimeZone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
        jQuery('#form-restaurant')[0].reset();
        jQuery('#modal-restaurant #form-restaurant #restaurant_id').val(0);
        jQuery('#interest_tags').select2();
        jQuery('#form-restaurant #blah').attr('src', '#');
        jQuery('#form-restaurant #blah_div').hide();
        jQuery('#modal-restaurant .modal-title').text('Add Restaurant');
        jQuery('#modal-restaurant #form-restaurant #form-action').val('add');
        jQuery('#modal-restaurant').modal('show');
    });
    jQuery("#form-restaurant").validate({
        rules: {
            'restaurant_name': {
                required:true
            },
            'restaurant_description': {
                required:true
            },
            'restaurant_address': {
                required:true
            },
            'halal': {
                required:true
            }
            ,'allow[]': {
                required:true
            },
            'establishment[]': {
                required:true
            },
            'meal[]': {
                required:true
            },
            'food[]': {
                required:true
            },
            'cuisine[]': {
                required:true
            },
            'latitude': {
                required:true
            },
            'longitude': {
                required:true
            },
            'sunday_open': {
                required:true
            },
            'sunday_close': {
                required:true
            },
            'monday_open': {
                required:true
            },
            'monday_close': {
                required:true
            },
            'tuesday_open': {
                required:true
            },
            'tuesday_close': {
                required:true
            },
            'wednesday_open': {
                required:true
            },
            'wednesday_close': {
                required:true
            },
            'thursday_open': {
                required:true
            },
            'thursday_close': {
                required:true
            },
            'friday_open': {
                required:true
            },
            'friday_close': {
                required:true
            },
            'saturday_open': {
                required:true
            },
            'saturday_close': {
                required:true
            },
            'restaurant_photo':{
                accept:'image/*'
            }
        },
        messages: {
            'restaurant_name': {
                required: "Please Enter Restaurant Name"
            },
            'restaurant_description': {
                required:"Please Enter Restaurant Description"
            },
            'restaurant_address': {
                required:"Please Enter Restaurant Address"
            },
            'sunday_open': {
                required:"Please Enter Sunday Open Time"
            },
            'sunday_close': {
                required:"Please Enter Sunday Close Time"
            },
            'monday_open': {
                required:"Please Enter Monday Open Time"
            },
            'monday_close': {
                required:"Please Enter Monday Close Time"
            },
            'tuesday_open': {
                required:"Please Enter Tuesday Open Time"
            },
            'tuesday_close': {
                required:"Please Enter Tuesday Close Time"
            },
            'wednesday_open': {
                required:"Please Enter Wednesday Open Time"
            },
            'wednesday_close': {
                required:"Please Enter Wednesday Close Time"
            },
            'thursday_open': {
                required:"Please Enter Thursday Open Time"
            },
            'thursday_close': {
                required:"Please Enter Thursday Close Time"
            },
            'friday_open': {
                required:"Please Enter Friday Open Time"
            },
            'friday_close': {
                required:"Please Enter Friday Close Time"
            },
            'saturday_open': {
                required:"Please Enter Saturday Open Time"
            },
            'saturday_close': {
                required:"Please Enter Saturday Close Time"
            },
            'allow[]': {
                required:"Please Select At Least One Service"
            },
            'establishment[]': {
                required:"Please Select At Least One Service"
            },
            'meal[]': {
                required:"Please Select At Least One Service"
            },
            'food[]': {
                required:"Please Select At Least One Service"
            },
            'cuisine[]': {
                required:"Please Select At Least One Service"
            },
            'restaurant_photo':{
                accept:"Please Upload only Image file"
            }
        },
        errorPlacement: function(error, element){
            if(element.attr("name") == "allow[]"){
                error.appendTo($('#allow_error'));
            } else if (element.attr("name") == "cuisine[]") {
                error.appendTo($('#cuisine_error'));
            } else if (element.attr("name") == "food[]") {
                error.appendTo($('#food_error'));
            } else if (element.attr("name") == "meal[]") {
                error.appendTo($('#meal_error'));
            } else if (element.attr("name") == "establishment[]") {
                error.appendTo($('#establishment_error'));
            } else if (element.attr("name") == "halal") {
                error.appendTo($('#halal_error'));
            } else{
                error.insertAfter(element);
            }
        }
    });
    jQuery(document).on('submit','#form-restaurant',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'restaurant/add_edit_restaurant',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-restaurant').modal('hide');
                    jQuery('#form-restaurant')[0].reset();
                    restaurant_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-restaurant',function(){
        jQuery("#userTimeZone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
        var restaurant_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'restaurant/get_restaurant',
            data:'restaurant_id='+restaurant_id+'&userTimeZone='+Intl.DateTimeFormat().resolvedOptions().timeZone,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-restaurant .modal-title').text('Edit Restaurant');
                    jQuery('#modal-restaurant #form-restaurant #form-action').val('edit');
                    jQuery('#modal-restaurant #form-restaurant #restaurant_id').val(restaurant_id);
                    jQuery('#form-restaurant')[0].reset();
                    jQuery('#modal-restaurant #form-restaurant #restaurant_name').val(data.data.res_name);
                    jQuery('#modal-restaurant #form-restaurant #restaurant_address').val(data.data.address);
                    
                    jQuery('#modal-restaurant #form-restaurant #serves_alcohol').prop('checked', ((data.data.serves_alcohol == '1')? true: false));
                    jQuery('#modal-restaurant #form-restaurant #veg').prop('checked', ((data.data.veg == '1')? true: false));
                    jQuery('#modal-restaurant #form-restaurant input[name="halal"][value="'+data.data.halal+'"]').prop('checked', 'true');
                    jQuery('#modal-restaurant #form-restaurant #kosher').prop('checked', ((data.data.kosher == '1')? true: false));
                    jQuery('#modal-restaurant #form-restaurant #delivery').prop('checked', ((data.data.delivery == '1')? true: false));

                    jQuery('#modal-restaurant #form-restaurant #latitude').val(data.data.res_latitude);
                    jQuery('#modal-restaurant #form-restaurant #longitude').val(data.data.res_longitude);
                    jQuery('#modal-restaurant #form-restaurant #restaurant_description').val(data.data.desc);
                    // jQuery('#modal-restaurant #form-restaurant #blah').attr('src', p_img_url+data.data.res_images);
                    jQuery('#modal-restaurant #form-restaurant #MainImage').attr('src', p_img_url+data.data.res_images);
                    $('.DisplayMainImage').removeClass('hide');
                    var html = '';
                    $(data.data.image).each(function(key, val) {
                        html += '<div class="Image-contain">\
                                    <img src="'+p_img_url+val.images+'" width="150">\
                                    <a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-restaurant-image" data-name="'+val.images+'" data-id="'+val.Images_id+'"><i class="fa fa-trash"></i></a>\
                                </div>';
                    });
                    jQuery('#modal-restaurant #form-restaurant .DisplayImage').html(html);
                    var html = '';
                    $(data.data.menu).each(function(key, val) {
                        html += '<div class="Image-contain">\
                                    <img src="'+menu_img_url+val.menu_image+'" width="150">\
                                    <a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-menu-restaurant-image" data-name="'+val.menu_image+'" data-id="'+val.res_menu_id+'"><i class="fa fa-trash"></i></a>\
                                </div>';
                    });
                    jQuery('#modal-restaurant #form-restaurant .DisplayMenuImage').html(html);
                    $(data.data.establishment).each(function(key, val) {
                        jQuery('#modal-restaurant #form-restaurant input[type="checkbox"][name="establishment[]"][value="'+val.establishment_id+'"]').prop('checked', true);
                    });
                    $(data.data.cuisine).each(function(key, val) {
                        jQuery('#modal-restaurant #form-restaurant input[type="checkbox"][name="cuisine[]"][value="'+val.res_cuisine_id+'"]').prop('checked', true);
                    });
                    $(data.data.meal).each(function(key, val) {
                        jQuery('#modal-restaurant #form-restaurant input[type="checkbox"][name="meal[]"][value="'+val.meal_id+'"]').prop('checked', true);
                    });
                    $(data.data.food).each(function(key, val) {
                        jQuery('#modal-restaurant #form-restaurant input[type="checkbox"][name="food[]"][value="'+val.food_id+'"]').prop('checked', true);
                    });

                    if (data.data.time.length > 0) {
                        var timeData = data.data.time[0];
                        console.log(timeData.sun_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="sunday_open"]').val(timeData.sun_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="sunday_close"]').val(timeData.sun_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="monday_open"]').val(timeData.mon_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="monday_close"]').val(timeData.mon_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="tuesday_open"]').val(timeData.tue_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="tuesday_close"]').val(timeData.tue_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="wednesday_open"]').val(timeData.wed_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="wednesday_close"]').val(timeData.wed_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="thursday_open"]').val(timeData.thu_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="thursday_close"]').val(timeData.thu_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="friday_open"]').val(timeData.fri_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="friday_close"]').val(timeData.fri_end_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="saturday_open"]').val(timeData.sat_start_time);
                        jQuery('#modal-restaurant #form-restaurant input[type="time"][name="saturday_close"]').val(timeData.sat_end_time);
                    }
                    jQuery('#modal-restaurant #form-restaurant #blah_div').show();
                    jQuery('#modal-restaurant').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-restaurant',function(){
        var restaurant_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'restaurant/delete_restaurant',
                data:'restaurant_id='+restaurant_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        restaurant_table.draw();
                        toastr.success(data.msg, "");
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });

    jQuery(document).on('click','.delete-restaurant-image',function(){
        var $this = $(this);
        var restaurant_id = jQuery(this).data('id');
        var image_url = jQuery(this).data('name');
        if(confirm('Are you sure you want to delete this image?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'restaurant/delete_restaurant_image',
                data:'restaurant_image_id='+restaurant_id+'&imageName='+image_url,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        jQuery($this).parent().remove();
                        toastr.success(data.msg, "");
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });
    jQuery(document).on('click','.delete-menu-restaurant-image',function(){
        var $this = $(this);
        var restaurant_id = jQuery(this).data('id');
        var image_url = jQuery(this).data('name');
        if(confirm('Are you sure you want to delete this image?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'restaurant/delete_menu_restaurant_image',
                data:'restaurant_image_id='+restaurant_id+'&imageName='+image_url,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        jQuery($this).parent().remove();
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
    jQuery("#places_photo").change(function() {
        readURL(this);
    });

    jQuery(document).on('click','.import-places',function(){
        jQuery('#loader').css('display', 'none');
        jQuery('#import_form').css('display', 'block');
        jQuery('#form-import-places')[0].reset();
        jQuery('#modal-import-places .modal-title').text('Import Places');
        jQuery('#modal-import-places').modal('show');
    });
    jQuery("#form-import-places").validate({
        rules: {
            'file_city': {
                required:true
            },
            'file_csv':{
                required:true
            }
        },
        messages: {
            'file_city': {
                required:"Please Select City"
            },
            'file_csv':{
                required:"Please Upload file"
            }
        }
    });
    jQuery(document).on('submit','#form-import-places',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery('#loader').css('display', 'block');
        jQuery('#import_form').css('display', 'none');
        jQuery.ajax({
            type: 'post',
            url: base_url+'places/import_places',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                jQuery('#loader').css('display', 'none');
                jQuery('#import_form').css('display', 'block');
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-import-places').modal('hide');
                    jQuery('#form-import-places')[0].reset();
                    places_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    var autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('restaurant_address')),
        { types: ['geocode'] });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var geocoder = new google.maps.Geocoder();
        var address = jQuery('#restaurant_address').val();
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                jQuery('#latitude').val(latitude.toFixed(4));
                jQuery('#longitude').val(longitude.toFixed(4));
                var city = '';
                for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0;b<results[0].address_components[i].types.length;b++) {
                        if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                            city = results[0].address_components[i];
                            break;
                        }
                    }
                }
                // jQuery('#machine_city').val(city.long_name);
            }
        });
    });
});

$("#modal-restaurant").on("hidden.bs.modal", function () {
    document.getElementById("form-restaurant").reset();
    $('input[type="checkbox"][name="establishment[]"]').prop('checked', false);
    $('input[type="checkbox"][name="cuisine[]"]').prop('checked', false);
    $('input[type="checkbox"][name="allow[]"]').prop('checked', false);
    jQuery('#modal-restaurant #form-restaurant .DisplayImage').html('');
    jQuery('#modal-restaurant #form-restaurant .DisplayMenuImage').html('');
});