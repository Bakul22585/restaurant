<style>
    .select_dropdown,
    .select2-search-field {
        width: 100% !important;
    }

    .select2-container-multi .select2-choices {
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .DisplayImage,
    .DisplayMenuImage {
        display: grid;
        grid-template-columns: auto auto;
        grid-gap: 10px;
    }

    .Image-contain {
        display: grid;
        grid-template-columns: auto auto;
    }

    .Image-contain a.btn.btn-danger.btn-flat.btn-xs.delete-restaurant-image,
    .Image-contain a.btn.btn-danger.btn-flat.btn-xs.delete-menu-restaurant-image {
        height: 25px;
        width: 25px;
    }

    .time-table {
        display: grid;
        grid-template-columns: 68px 150px 150px;
        grid-gap: 15px;
        margin-bottom: 10px;
    }

    .timepicker-box {
        position: absolute;
        border: 1px solid #ccc;
        padding: 8px 20PX 8PX 8PX;
        left: auto;
        right: 0px;
        top: 0px;
        z-index: 99;
    }
    .timepicker-box-input-width {
        width: 81% !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Restaurant
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Restaurant</li>
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
                                </select>
                            </div> -->
                        </div>
                        <div class="col-xs-12 col-md-3"></div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <a href="javascript:void(0)" class="btn btn-info btn-flat add-restaurant" title="Add Restaurant"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
                            <a href="javascript:void(0)" class="btn bg-purple btn-flat import-restaurant hide" title="Import Place"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Import</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="restaurant-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Address</th>
                                    <th>Serves Alcohol</th>
                                    <th>Veg</th>
                                    <th>Halal</th>
                                    <th>Kosher</th>
                                    <th>Delivery</th>
                                    <th>Image</th>
                                    <th>Type</th>
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

<div class="modal fade" id="modal-restaurant">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-restaurant" enctype="multipart/form-data">
                <input type="hidden" name="form-action" id="form-action">
                <input type="hidden" name="restaurant_id" id="restaurant_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="restaurant_name">Restaurant Name *</label>
                                <input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="restaurant_description">Restaurant Description *</label>
                                <textarea class="form-control" name="restaurant_description" id="restaurant_description" placeholder="Enter Description"></textarea>
                            </div>
                            <!-- <div class="form-group">
                                <label for="latitude">Latitude *</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter Latitude">
                            </div> -->
                            <div class="form-group" style="display: grid;grid-template-columns: auto auto;">
                                <label for="latitude">Establishment *</label>
                                <label></label>
                                <?php
                                foreach ($total_establishment as $key => $value) {
                                    echo '<div class="checkbox" style="margin-top: -5px;">
                                                <label><input type="checkbox" name="establishment[]" value="' . $value['establishment_id'] . '" id="' . $value['establishment_name'] . '">' . $value['establishment_name'] . '</label>
                                            </div>';
                                }
                                ?>
                                <div id="establishment_error"></div>
                            </div>
                            <div class="form-group" style="display: grid;grid-template-columns: auto auto;">
                                <label>Meal *</label>
                                <label></label>
                                <?php
                                foreach ($total_meal as $key => $value) {
                                    echo '<div class="checkbox" style="margin-top: -5px;">
                                                <label><input type="checkbox" name="meal[]" value="' . $value['meal_id'] . '" id="' . $value['meal_name'] . '">' . $value['meal_name'] . '</label>
                                            </div>';
                                }
                                ?>
                                <div id="meal_error"></div>
                            </div>
                            <div class="form-group" style="display: grid;grid-template-columns: auto auto;">
                                <label>Food *</label>
                                <label></label>
                                <?php
                                foreach ($total_food as $key => $value) {
                                    echo '<div class="checkbox" style="margin-top: -5px;">
                                                <label><input type="checkbox" name="food[]" value="' . $value['food_id'] . '" id="' . $value['food_name'] . '">' . $value['food_name'] . '</label>
                                            </div>';
                                }
                                ?>
                                <div id="food_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="main_image">Restaurant Main Photo</label>
                                <input type="file" id="main_image" name="main_image" accept="image/*">
                                <p class="help-block">Please upload less than 10 Mb</p>
                            </div>
                            <div class="DisplayMainImage">
                                <div class="Image-contain">
                                    <img src="" width="150" id="MainImage">
                                    <a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-restaurant-main-image"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="restaurant_photo">Restaurant Photo</label>
                                <input type="file" id="restaurant_photo" multiple="multiple" name="restaurant_photo[]" accept="image/*">
                                <p class="help-block">Please upload less than 10 Mb</p>
                            </div>
                            <div class="form-group" id="blah_div" style="display: none;height: auto;">
                                <img id="blah" src="#" alt="Restaurant Photo" width="150" />
                            </div>
                            <div class="DisplayImage">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="restaurant_address">Restaurant Address *</label>
                                <textarea class="form-control" name="restaurant_address" id="restaurant_address" placeholder="Enter Address"></textarea>
                            </div>
                            <!-- <div class="form-group">
                                <label for="longitude">Longitude *</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter Longitude">
                            </div> -->
                            <div class="form-group" style="display: grid;grid-template-columns: auto auto;">
                                <label for="day_open">Allow services *</label>
                                <label></label>
                                <div class="checkbox" style="margin-top: -5px;">
                                    <label><input type="checkbox" name="allow[]" value="serves_alcohol" id="serves_alcohol">Serves Alcohol</label>
                                </div>
                                <div class="checkbox" style="margin-top: -5px;">
                                    <label><input type="checkbox" name="allow[]" value="veg" id="veg">Veg</label>
                                </div>
                                <div class="checkbox" style="margin-top: -5px;">
                                    <label><input type="checkbox" name="allow[]" value="halal" id="halal">Halal</label>
                                </div>
                                <div class="checkbox" style="margin-top: -5px;">
                                    <label><input type="checkbox" name="allow[]" value="kosher" id="kosher">Kosher</label>
                                </div>
                                <div class="checkbox" style="margin-top: -5px;">
                                    <label><input type="checkbox" name="allow[]" value="delivery" id="delivery">Delivery</label>
                                </div>
                                <div id="allow_error"></div>
                            </div>
                            <div class="form-group" style="display: grid;grid-template-columns: auto auto;">
                                <label for="cuisine_selection">Cuisine *</label>
                                <label></label>
                                <?php
                                foreach ($total_cuisine as $key => $value) {
                                    echo '<div class="checkbox" style="margin-top: -5px;">
                                                <label><input type="checkbox" name="cuisine[]" value="' . $value['res_cuisine_id'] . '" id="' . $value['res_cuisine_name'] . '">' . $value['res_cuisine_name'] . '</label>
                                            </div>';
                                }
                                ?>
                                <div id="cuisine_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="menu_photo">Menu Photo</label>
                                <input type="file" id="menu_photo" multiple="multiple" name="menu_photo[]" accept="image/*">
                                <p class="help-block">Please upload less than 10 Mb</p>
                            </div>
                            <div class="DisplayMenuImage">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="time-table">
                                <label>Sunday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="sunday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="sunday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Monday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="monday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="monday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Tuesday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="tuesday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="tuesday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Wednesday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="wednesday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="wednesday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Thursday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="thursday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="thursday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Friday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="friday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="friday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="time-table">
                                <label>Saturday</label>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="saturday_open">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <input type="time" class="form-control TimeTag" name="saturday_close">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
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