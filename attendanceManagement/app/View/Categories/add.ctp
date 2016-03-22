<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-category" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a class="btn btn-default" title="" data-toggle="tooltip" href="../categories" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Category</h1>
        <ul class="breadcrumb">
        <li><?php echo $this->Html->link('Home', array('controller'=>'dashboard','action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('Categories', array('controller'=>'categories','action'=>'index')); ?></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> Add Category</h3>
        </div>
        <div class="panel-body">
            <form id="form-category" class="form-horizontal" method="post">
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Parent Category</label>
                    <div class="col-sm-10">
                        <select name="category" class="form-control">
                            <option value="Homoeopathy">Homoeopathy</option>
                        </select>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Sub Parent Category</label>
                    <div class="col-sm-10">
                        <select name="sub_category" class="form-control">
                            <option value='1'>Add Sub Parent</option>
                        <?php if(isset($subcategory)) {
                                foreach ($subcategory as $sc) {
                                    echo "<option value='".$sc."'>".$sc."</option>";
                                }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Child/Sub Parent Category</label>
                    <div class="col-sm-10">
                        <input type="text" name="child_category" class="form-control" placeholder="Category Name or Sub Parent Category" value="<?php echo isset($category['child_category']) ? $category['child_category'] : ''; ?>" />
                        <?php if(isset($c_error)){ ?>
                            <div class="text-danger"><?php echo $c_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo isset($category['description']) ? $category['description'] : ''; ?>" />
                        <?php if(isset($d_error)){ ?>
                            <div class="text-danger"><?php echo $d_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <select name="type" class="form-control">
                            <option value="term">Term</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                    <div class="col-sm-10">
                        <?php if(isset($category['active']) &&  $category['active'] == 1) { ?>
                            <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="ON" checked="checked" />
                        <?php } else { ?>
                            <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="ON" />
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>