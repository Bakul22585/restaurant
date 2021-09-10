jQuery(document).ready(function(){
    jQuery('#interest_tags').select2();
    var city_id = $('#filter_city').val();
    var places_table = jQuery('#places-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "places_id"
        },{
            "mDataProp": "places_name"
        },{
            "mDataProp": "places_address"
        },{
            "mDataProp": "city_name"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'places/get_places_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_city", "value": city_id});
        }
    });
    jQuery("#filter_city").change(function() {
        city_id = jQuery(this).val();
        places_table.draw();
    });
    jQuery(document).on('click','.add-places',function(){
        jQuery('#form-places')[0].reset();
        jQuery('#modal-places #form-places #places_id').val(0);
        jQuery('#interest_tags').select2();
        jQuery('#form-places #blah').attr('src', '#');
        jQuery('#form-places #blah_div').hide();
        jQuery('#modal-places .modal-title').text('Add Place');
        jQuery('#modal-places #form-places #form-action').val('add');
        jQuery('#modal-places').modal('show');
    });
    jQuery("#form-places").validate({
        rules: {
            'places_name': {
                required:true
            },
            'places_address': {
                required:true
            },
            'city_id': {
                required:true
            },
            'places_stateprovince': {
                required:true
            },
            'places_country': {
                required:true
            },
            'latitude': {
                required:true
            },
            'longitude': {
                required:true
            },
            'places_description': {
                required:true
            },
            'places_website': {
                required:true
            },
            'places_budget': {
                required:true
            },
            'places_timeopen': {
                required:true
            },
            'places_timeclosed': {
                required:true
            },
            'places_timevisit': {
                required:true
            },
            'day_open[]': {
                required:true
            },
            'hours_complete': {
                required:true
            },
            'places_must_see': {
                required:true,
                number:true
            },
            'places_group': {
                required:true,
                number:true
            },
            'places_photo':{
                accept:'image/*'
            }
        },
        messages: {
            'places_name': {
                required: "Please Enter Place Name"
            },
            'places_address': {
                required:"Please Enter Place Address"
            },
            'city_id': {
                required:"Please Select City"
            },
            'places_stateprovince': {
                required:"Please Enter Place State"
            },
            'places_country': {
                required:"Please Enter Place Country"
            },
            'latitude': {
                required:"Please Enter Place Latitude"
            },
            'longitude': {
                required:"Please Enter Place Longitude"
            },
            'places_description': {
                required:"Please Enter Place Description"
            },
            'places_website': {
                required:"Please Enter Website"
            },
            'places_budget': {
                required:"Please Enter Budget"
            },
            'places_timeopen': {
                required:"Please Enter Open Time"
            },
            'places_timeclosed': {
                required:"Please Enter Close Time"
            },
            'places_timevisit': {
                required:"Please Enter Visit Time"
            },
            'day_open[]': {
                required:"Please Select At Least One Day"
            },
            'hours_complete': {
                required:"Please Enter Hours Complete"
            },
            'places_must_see': {
                required:"Please Enter Place Must See",
                number:"Please Enter Only Number"
            },
            'places_group': {
                required:"Please Enter Place Group",
                number:"Please Enter Only Number"
            },
            'places_photo':{
                accept:"Please Upload only Image file"
            }
        },
        errorPlacement: function(error, element){
            if(element.attr("name") == "day_open[]"){
                error.appendTo($('#day_open_error'));
            }else{
                error.insertAfter(element);
            }
        }
    });
    jQuery(document).on('submit','#form-places',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'places/add_edit_place',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-places').modal('hide');
                    jQuery('#form-places')[0].reset();
                    places_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-places',function(){
        var places_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'places/get_place',
            data:'places_id='+places_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-places .modal-title').text('Edit Place');
                    jQuery('#modal-places #form-places #form-action').val('edit');
                    jQuery('#modal-places #form-places #places_id').val(places_id);
                    jQuery('#form-places')[0].reset();
                    jQuery('#modal-places #form-places #places_name').val(data.data.places_name);
                    jQuery('#modal-places #form-places #places_address').val(data.data.places_address);
                    if(data.data.city_id==0){
                        jQuery('#modal-places #form-places #city_id').val('');
                    }
                    else{
                        jQuery('#modal-places #form-places #city_id').val(data.data.city_id);
                    }
                    jQuery('#modal-places #form-places #places_city').val(data.data.places_city);
                    jQuery('#modal-places #form-places #places_stateprovince').val(data.data.places_stateprovince);
                    jQuery('#modal-places #form-places #places_country').val(data.data.places_country);
                    jQuery('#modal-places #form-places #latitude').val(data.data.latitude);
                    jQuery('#modal-places #form-places #longitude').val(data.data.longitude);
                    jQuery('#modal-places #form-places #places_description').val(data.data.places_description);
                    jQuery('#modal-places #form-places #places_website').val(data.data.places_website);
                    jQuery('#modal-places #form-places #places_budget').val(data.data.places_budget);
                    jQuery('#modal-places #form-places #places_timeopen').val(data.data.places_timeopen);
                    jQuery('#modal-places #form-places #places_timeclosed').val(data.data.places_timeclosed);
                    jQuery('#modal-places #form-places #places_timevisit').val(data.data.places_timevisit);
                    $.each( data.data.day_open.split(", "), function( key, value ) {
                        jQuery('#modal-places #form-places #'+value+'_open').prop( "checked", true );
                    });
                    jQuery('#modal-places #form-places #hours_complete').val(data.data.hours_complete);
                    jQuery('#modal-places #form-places #places_must_see').val(data.data.places_must_see);
                    jQuery('#modal-places #form-places #places_group').val(data.data.places_group);
                    jQuery('#modal-places #form-places #interest_tags').select2({}).select2('val', data.data.places_tags);
                    jQuery('#modal-places #form-places #blah').attr('src', p_img_url+data.data.places_photo);
                    jQuery('#modal-places #form-places #blah_div').show();
                    jQuery('#modal-places').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-places',function(){
        var places_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'places/delete_place',
                data:'places_id='+places_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        places_table.draw();
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
});