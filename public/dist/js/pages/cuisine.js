jQuery(document).ready(function(){
    jQuery('#interest_tags').select2();
    var cuisine_id = $('#filter_cuisine').val();
    var cuisine_table = jQuery('#cuisine-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "res_cuisine_id"
        },{
            "mDataProp": "res_cuisine_name"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'cuisine/get_cuisine_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_cuisine", "value": cuisine_id});
        }
    });
    jQuery("#filter_cuisine").change(function() {
        cuisine_id = jQuery(this).val();
        cuisine_table.draw();
    });
    jQuery(document).on('click','.add-cuisine',function(){
        jQuery('#form-cuisine')[0].reset();
        jQuery('#modal-cuisine #form-cuisine #cuisine_id').val(0);
        jQuery('#interest_tags').select2();
        jQuery('#form-cuisine #blah').attr('src', '#');
        jQuery('#form-cuisine #blah_div').hide();
        jQuery('#modal-cuisine .modal-title').text('Add cuisine');
        jQuery('#modal-cuisine #form-cuisine #form-action').val('add');
        jQuery('#modal-cuisine').modal('show');
    });
    jQuery("#form-cuisine").validate({
        rules: {
            'res_cuisine_name': {
                required:true
            }
        },
        messages: {
            'res_cuisine_name': {
                required: "Please Enter Cuisine Name"
            }
        },
        errorPlacement: function(error, element){
            if(element.attr("name") == "allow[]"){
                error.appendTo($('#allow_error'));
            }else{
                error.insertAfter(element);
            }
        }
    });
    jQuery(document).on('submit','#form-cuisine',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'cuisine/add_edit_cuisine',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-cuisine').modal('hide');
                    jQuery('#form-cuisine')[0].reset();
                    cuisine_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-cuisine',function(){
        var cuisine_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'cuisine/get_cuisine',
            data:'res_cuisine_id='+cuisine_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-cuisine .modal-title').text('Edit Cuisine');
                    jQuery('#modal-cuisine #form-cuisine #form-action').val('edit');
                    jQuery('#modal-cuisine #form-cuisine #cuisine_id').val(cuisine_id);
                    jQuery('#form-cuisine')[0].reset();
                    jQuery('#modal-cuisine #form-cuisine #cuisine_name').val(data.data.res_cuisine_name);
                    jQuery('#modal-cuisine #form-cuisine #cuisine_name_pt').val(data.data.res_cuisine_name_pt);
                    
                    jQuery('#modal-cuisine').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-cuisine',function(){
        var cuisine_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'cuisine/delete_cuisine',
                data:'res_cuisine_id='+cuisine_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        cuisine_table.draw();
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

$("#modal-cuisine").on("hidden.bs.modal", function () {
    document.getElementById("form-cuisine").reset();
});