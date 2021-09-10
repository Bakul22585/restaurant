<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Faq
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url()?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Faq</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-xs-12 col-md-6">
                            <!-- <h3 class="box-title">Category List</h3> -->
                        </div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <a href="javascript:void(0)" class="btn btn-info btn-flat add-faq"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="faq-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="30%">Question</th>
                                <th width="50%">Answer</th>
                                <th width="20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-faq">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-faq">
                <input type="hidden" name="form-action" id="form-action">
                <input type="hidden" name="faq_id" id="faq_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="faq_question">Question *</label>
                            <textarea class="form-control" name="faq_question" id="faq_question" placeholder="Enter Question" required></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="faq_ans">Answer *</label>
                            <textarea class="form-control" name="faq_ans" id="faq_ans" placeholder="Enter Answer" required rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->