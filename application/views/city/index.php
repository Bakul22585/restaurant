<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            City
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url()?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">City</li>
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
                            <a href="javascript:void(0)" class="btn btn-info btn-flat add-city"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="city-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
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

<div class="modal fade" id="modal-city">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-city" enctype="multipart/form-data">
                <input type="hidden" name="form-action" id="form-action">
                <input type="hidden" name="city_id" id="city_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="city_name">City Name *</label>
                            <input type="text" class="form-control" name="city_name" id="city_name" placeholder="Enter City">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="city_description">City Description</label>
                            <textarea class="form-control" name="city_description" id="city_description" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="city_type">City Type</label>
                            <select class="form-control" name="city_type" id="city_type">
                                <option value="0">Free</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="inapp_product_div" style="display: none;">
                            <label for="inapp_product">Inapp Product *</label>
                            <input type="text" class="form-control" name="inapp_product" id="inapp_product" required disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="city_price">City Price *</label>
                            <input type="text" class="form-control" name="city_price" id="city_price" placeholder="Enter Price">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="popular_interests">Popular Interests *</label>
                            <textarea class="form-control" name="popular_interests" id="popular_interests" placeholder="Nature,Hiking,Kids (use comma separator)"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="version">Version</label>
                            <input type="text" class="form-control" name="version" id="version" placeholder="Enter Number">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_cover_image">Cover Image</label>
                                <input type="file" id="city_cover_image" name="city_cover_image" accept="image/*">
                                <p class="help-block">Please upload less than 10 Mb</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="blah_div" style="display: none;height: auto;">
                                <img id="blah" src="#" alt="City Cover Image" width="150"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_other_images">Other Images</label>
                                <input type="file" name="city_other_images[]" accept="image/*" multiple>
                                <p class="help-block">Please upload multiple images</p>
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

<div class="modal fade" id="modal-city-images">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-city-images" enctype="multipart/form-data">
                <input type="hidden" name="img_city_id" id="img_city_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="other_images">Other Images</label>
                                <input type="file" name="other_images[]" accept="image/*" multiple>
                                <p class="help-block">Please upload multiple images</p>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="clearfix"></div>
                        <div id="other_images"></div>
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