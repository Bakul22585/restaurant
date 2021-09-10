jQuery(document).ready(function(){
    // jQuery('#interest_tags').select2();
    var food_id = $('#filter_food').val();
    var food_table = jQuery('#food-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "food_id"
        },{
            "mDataProp": "food_name"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'food/get_food_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_food", "value": food_id});
        }
    });
    jQuery("#filter_food").change(function() {
        food_id = jQuery(this).val();
        food_table.draw();
    });
    jQuery(document).on('click','.add-food',function(){
        jQuery('#form-food')[0].reset();
        jQuery('#modal-food #form-food #food_id').val(0);
        jQuery('#modal-food .modal-title').text('Add food');
        jQuery('#modal-food #form-food #form-action').val('add');
        jQuery('#modal-food').modal('show');
    });
    jQuery("#form-food").validate({
        rules: {
            'food_name': {
                required:true
            }
        },
        messages: {
            'food_name': {
                required: "Please Enter food Name"
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
    jQuery(document).on('submit','#form-food',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'food/add_edit_food',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-food').modal('hide');
                    jQuery('#form-food')[0].reset();
                    food_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-food',function(){
        var food_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'food/get_food',
            data:'food_id='+food_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-food .modal-title').text('Edit food');
                    jQuery('#modal-food #form-food #form-action').val('edit');
                    jQuery('#modal-food #form-food #food_id').val(food_id);
                    jQuery('#form-food')[0].reset();
                    jQuery('#modal-food #form-food #food_name').val(data.data.food_name);
                    jQuery('#modal-food #form-food #food_name_pt').val(data.data.food_name_pt);
                    
                    jQuery('#modal-food').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-food',function(){
        var food_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'food/delete_food',
                data:'food_id='+food_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        food_table.draw();
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

$("#modal-food").on("hidden.bs.modal", function () {
    document.getElementById("form-food").reset();
});