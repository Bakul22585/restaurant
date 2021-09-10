jQuery(document).ready(function(){
    jQuery('#interest_tags').select2();
    var establishment_id = $('#filter_establishment').val();
    var establishment_table = jQuery('#establishment-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "establishment_id"
        },{
            "mDataProp": "establishment_name"
        },{
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'establishment/get_establishment_data/',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Places in the system.",
            "sZeroRecords": "No Places to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "filter_establishment", "value": establishment_id});
        }
    });
    jQuery("#filter_establishment").change(function() {
        establishment_id = jQuery(this).val();
        establishment_table.draw();
    });
    jQuery(document).on('click','.add-establishment',function(){
        jQuery('#form-establishment')[0].reset();
        jQuery('#modal-establishment #form-establishment #establishment_id').val(0);
        jQuery('#interest_tags').select2();
        jQuery('#form-establishment #blah').attr('src', '#');
        jQuery('#form-establishment #blah_div').hide();
        jQuery('#modal-establishment .modal-title').text('Add Establishment');
        jQuery('#modal-establishment #form-establishment #form-action').val('add');
        jQuery('#modal-establishment').modal('show');
    });
    jQuery("#form-establishment").validate({
        rules: {
            'establishment_name': {
                required:true
            }
        },
        messages: {
            'establishment_name': {
                required: "Please Enter Establishment Name"
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
    jQuery(document).on('submit','#form-establishment',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'establishment/add_edit_establishment',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-establishment').modal('hide');
                    jQuery('#form-establishment')[0].reset();
                    establishment_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-establishment',function(){
        var establishment_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'establishment/get_establishment',
            data:'establishment_id='+establishment_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-establishment .modal-title').text('Edit Establishment');
                    jQuery('#modal-establishment #form-establishment #form-action').val('edit');
                    jQuery('#modal-establishment #form-establishment #establishment_id').val(establishment_id);
                    jQuery('#form-establishment')[0].reset();
                    jQuery('#modal-establishment #form-establishment #establishment_name').val(data.data.establishment_name);
                    jQuery('#modal-establishment #form-establishment #establishment_name_pt').val(data.data.establishment_name_pt);
                    
                    jQuery('#modal-establishment').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-establishment',function(){
        var establishment_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'establishment/delete_establishment',
                data:'establishment_id='+establishment_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        establishment_table.draw();
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

$("#modal-establishment").on("hidden.bs.modal", function () {
    document.getElementById("form-establishment").reset();
});