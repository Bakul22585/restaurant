<style>
    .select_dropdown, .select2-search-field{
        width: 100% !important;
    }
    .select2-container-multi .select2-choices{
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Places
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url()?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Places</li>
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
                            <!-- <h3 class="box-title">Category List</h3> -->
                            <div class="form-group">
                                <select class="form-control" name="filter_city" id="filter_city">
                                    <?php if(!empty($city)){ ?>
                                        <?php foreach ($city as $val){ ?>
                                            <option value="<?= $val->city_id; ?>"><?= $val->city_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3"></div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <a href="javascript:void(0)" class="btn btn-info btn-flat add-places" title="Add Place"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
                            <a href="javascript:void(0)" class="btn bg-purple btn-flat import-places" title="Import Place"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Import</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="places-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Place Name</th>
                                <th>Place Address</th>
                                <th>City Name</th>
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

<div class="modal fade" id="modal-places">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-places" enctype="multipart/form-data">
                <input type="hidden" name="form-action" id="form-action">
                <input type="hidden" name="places_id" id="places_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="places_name">Place Name *</label>
                                <input type="text" class="form-control" name="places_name" id="places_name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="places_address">Place Address *</label>
                                <textarea class="form-control" name="places_address" id="places_address" placeholder="Enter Address"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="city_id">City *</label>
                                <select class="form-control" name="city_id" id="city_id">
                                    <option value="">Select City</option>
                                    <?php if(!empty($city)){ ?>
                                        <?php foreach ($city as $val){ ?>
                                            <option value="<?= $val->city_id; ?>"><?= $val->city_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="places_city">Nearest City</label>
                                <input type="text" class="form-control" name="places_city" id="places_city" placeholder="Enter Nearest City">
                            </div>
                            <div class="form-group">
                                <label for="places_stateprovince">State *</label>
                                <input type="text" class="form-control" name="places_stateprovince" id="places_stateprovince" placeholder="Enter State">
                            </div>
                            <div class="form-group">
                                <label for="places_country">Country *</label>
                                <input type="text" class="form-control" name="places_country" id="places_country" placeholder="Enter Country">
                            </div>
                            <div class="form-group">
                                <label for="latitude">Latitude *</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter Latitude">
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude *</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter Longitude">
                            </div>
                            <div class="form-group">
                                <label for="places_description">Place Description *</label>
                                <textarea class="form-control" name="places_description" id="places_description" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="places_website">Website *</label>
                                <input type="text" class="form-control" name="places_website" id="places_website" placeholder="Enter Website">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="places_budget">Budget *</label>
                                <input type="text" class="form-control" name="places_budget" id="places_budget" placeholder="Free/$/$$/$$$">
                            </div>
                            <div class="form-group">
                                <label for="places_timeopen">Open Time *</label>
                                <input type="text" class="form-control" name="places_timeopen" id="places_timeopen" placeholder="09:30">
                            </div>
                            <div class="form-group">
                                <label for="places_timeclosed">Close Time *</label>
                                <input type="text" class="form-control" name="places_timeclosed" id="places_timeclosed" placeholder="05:30">
                            </div>
                            <div class="form-group">
                                <label for="places_timevisit">Visit Time *</label>
                                <input type="text" class="form-control" name="places_timevisit" id="places_timevisit" placeholder="Morning/Afternoon/Evening/Night">
                            </div>
                            <div class="form-group">
                                <label for="day_open">Place Open Day *</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Sun_open" value="Sun">Sunday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Mon_open" value="Mon">Monday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Tues_open" value="Tues">Tuesday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Wed_open" value="Wed">Wednesday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Thurs_open" value="Thurs">Thursday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Fri_open" value="Fri">Friday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="day_open[]" id="Sat_open" value="Sat">Saturday</label>
                                </div>
                                <div id="day_open_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="hours_complete">Hours Complete *</label>
                                <input type="text" class="form-control" name="hours_complete" id="hours_complete" placeholder="1.5">
                            </div>
                            <div class="form-group">
                                <label for="places_must_see">Place Must See *</label>
                                <input type="number" class="form-control" name="places_must_see" id="places_must_see" placeholder="0/1">
                            </div>
                            <div class="form-group">
                                <label for="places_group">Place Group *</label>
                                <input type="number" class="form-control" name="places_group" id="places_group" placeholder="1/2/3/4/5">
                            </div>
                            <div class="form-group">
                                <label for="interest_tags">Interest Tags</label>
                                <select name="interest_tags[]" id="interest_tags" class="select_dropdown" multiple="multiple">
                                    <?php foreach ($category as $val){ ?>
                                        <option value="<?= $val->category_id; ?>"><?= $val->category_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="places_photo">Place Photo</label>
                                <input type="file" id="places_photo" name="places_photo" accept="image/*">
                                <p class="help-block">Please upload less than 10 Mb</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="blah_div" style="display: none;height: auto;">
                                <img id="blah" src="#" alt="Places Photo" width="150"/>
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
                            <img src="<?= base_url(); ?>public/uploads/loader.gif" width="70%"/>
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
                                    <?php if(!empty($city)){ ?>
                                        <?php foreach ($city as $val){ ?>
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