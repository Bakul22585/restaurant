<style>
    .select_dropdown,
    .select2-search-field {
        width: 100% !important;
    }

    .select2-container-multi .select2-choices {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Establishment
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Establishment</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-xs-12 col-md-3" style="padding-left: 0;">
                            <!-- <div class="form-group">
                                <select class="form-control" name="filter_restaurant" id="filter_restaurant">
                                    <?php if (!empty($city)) { ?>
                                        <?php foreach ($city as $val) { ?>
                                            <option value="<?= $val->city_id; ?>"><?= $val->city_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div> -->
                        </div>
                        <div class="col-xs-12 col-md-3"></div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <a href="javascript:void(0)" class="btn btn-info btn-flat add-establishment" title="Add Restaurant"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
                            <a href="javascript:void(0)" class="btn bg-purple btn-flat import-restaurant hide" title="Import Place"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Import</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="establishment-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
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

<div class="modal fade" id="modal-establishment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-establishment" enctype="multipart/form-data">
                <input type="hidden" name="form-action" id="form-action">
                <input type="hidden" name="establishment_id" id="establishment_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="establishment_name">Establishment Name (English-en)*</label>
                                <input type="text" class="form-control" name="establishment_name" id="establishment_name" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="establishment_name_pt">Establishment Name (Portuguese-pt)*</label>
                                <input type="text" class="form-control" name="establishment_name_pt" id="establishment_name_pt" placeholder="Enter Name">
                            </div>
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

<div class="modal fade" id="modal-import-places">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-import-places" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div style="text-align: center;display: none;" id="loader">
                            <img src="<?= base_url(); ?>public/uploads/loader.gif" width="70%" />
                        </div>
                        <div class="col-md-12" id="import_form">
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <strong>Note: </strong>The first line in downloaded csv file should remain as it is. Please do not change the order of columns.<br>
                                Please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM).<br>
                                The images should be uploaded in folder.
                            </p>
                            <div class="form-group">
                                <a href="<?= base_url(); ?>public/uploads/sample-places.csv" class="btn btn-primary pull-right" download="places.csv"><i class="fa fa-download"></i> Download Sample File</a>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="file_city">City *</label>
                                <select class="form-control" name="file_city" id="file_city">
                                    <option value="">Select City</option>
                                    <?php if (!empty($city)) { ?>
                                        <?php foreach ($city as $val) { ?>
                                            <option value="<?= $val->city_id; ?>"><?= $val->city_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file_csv">Upload File *</label>
                                <input type="file" id="file_csv" name="file_csv">
                                <p class="help-block">Please upload only csv file.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->