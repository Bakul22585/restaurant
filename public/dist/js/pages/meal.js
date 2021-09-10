jQuery(document).ready(function(){
    // jQuery('#interest_tags').select2();
    var meal_id = $('#filter_meal').val();
    var meal_table = jQuery('#meal-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "meal_id"
        },{
            "mDataProp": "meal_name"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'meal/get_meal_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_food", "value": meal_id});
        }
    });
    jQuery("#filter_food").change(function() {
        meal_id = jQuery(this).val();
        meal_table.draw();
    });
    jQuery(document).on('click','.add-meal',function(){
        jQuery('#form-meal')[0].reset();
        jQuery('#modal-meal #form-meal #meal_id').val(0);
        jQuery('#modal-meal .modal-title').text('Add meal');
        jQuery('#modal-meal #form-meal #form-action').val('add');
        jQuery('#modal-meal').modal('show');
    });
    jQuery("#form-meal").validate({
        rules: {
            'meal_name': {
                required:true
            }
        },
        messages: {
            'meal_name': {
                required: "Please Enter meal Name"
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
    jQuery(document).on('submit','#form-meal',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'meal/add_edit_meal',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-meal').modal('hide');
                    jQuery('#form-meal')[0].reset();
                    meal_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-meal',function(){
        var meal_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'meal/get_meal',
            data:'meal_id='+meal_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-meal .modal-title').text('Edit meal');
                    jQuery('#modal-meal #form-meal #form-action').val('edit');
                    jQuery('#modal-meal #form-meal #meal_id').val(meal_id);
                    jQuery('#form-meal')[0].reset();
                    jQuery('#modal-meal #form-meal #meal_name').val(data.data.meal_name);
                    jQuery('#modal-meal #form-meal #meal_name_pt').val(data.data.meal_name_pt);
                    
                    jQuery('#modal-meal').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-meal',function(){
        var meal_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'meal/delete_meal',
                data:'meal_id='+meal_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        meal_table.draw();
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

$("#modal-meal").on("hidden.bs.modal", function () {
    document.getElementById("form-meal").reset();
});