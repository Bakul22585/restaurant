jQuery(document).ready(function(){

    var faq_table = jQuery('#faq-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 10,
        "bProcessing": true,
        "aoColumns": [{
            "mDataProp": "faq_question"
        },{
            "bSortable": false,
            "mDataProp": "faq_ans"
        }, {
            "bSortable": false,
            "mDataProp": "action"
        }],
        "serverSide": true,
        "sAjaxSource": base_url+'faq/get_faq_data',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Faq in the system.",
            "sZeroRecords": "No Faq to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {

        },
        "fnServerParams": function (aoData) {
            aoData.push({"name": "get_giftcard_plan", "value": true});
        }
    });

    jQuery(document).on('click','.add-faq',function(){
        jQuery('#form-faq')[0].reset();
        jQuery('#modal-faq #form-faq #faq_id').val(0);
        jQuery('#modal-faq .modal-title').text('Add Faq');
        jQuery('#modal-faq #form-faq #form-action').val('add');
        jQuery('#modal-faq').modal('show');
    });

    jQuery("#form-faq").validate({
        rules: {
            'faq_question': {
                required:true
            },
            'faq_ans': {
                required:true
            }
        },
        messages: {
            'faq_question': {
                required: "Please Enter Question"
            },
            'faq_ans': {
                required: "Please Enter Answer"
            }
        }
    });

    jQuery(document).on('submit','#form-faq',function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'faq/add_edit_faq',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-faq').modal('hide');
                    jQuery('#form-faq')[0].reset();
                    faq_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.edit-faq',function(){
        var faq_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'faq/get_faq',
            data:'faq_id='+faq_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-faq .modal-title').text('Edit Faq');
                    jQuery('#modal-faq #form-faq #form-action').val('edit');
                    jQuery('#modal-faq #form-faq #faq_id').val(faq_id);
                    jQuery('#form-faq')[0].reset();
                    jQuery('#modal-faq #form-faq #faq_question').val(data.data.faq_question);
                    jQuery('#modal-faq #form-faq #faq_ans').val(data.data.faq_ans);
                    jQuery('#modal-faq').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });

    jQuery(document).on('click','.delete-faq',function(){
        var faq_id = jQuery(this).data('id');
        if(confirm('Are you sure you want to delete this record?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'faq/delete_faq',
                data:'faq_id='+faq_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        faq_table.draw();
                        toastr.success(data.msg, "");
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });

});