<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a class="btn btn-primary" title="" data-toggle="tooltip" href="categories/add" data-original-title="Add Category"><i class="fa fa-plus"></i></a>
            <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#news-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
        <h1><i class="fa fa-newspaper-o fa-fw"></i> Categories</h1>
    </div>
</div>
<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Category List</h3>
        </div>
        <div class="panel-body">
            <form id="news-list" enctype="multipart/form-data" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                <td class="text-left">Category Name</td>
                                <td class="text-left">Parent Category Name</td>
                                <td class="text-left">Created Date</td>
                                <td class="text-right">Active</td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($categories)) { ?>
                                <?php foreach($categories as $category) { ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" value="<?php echo $category['Category']['id']; ?>" name="selected[]"></td>
                                        <td class="text-left"><?php echo $category['Category']['category_name']; ?></td>
                                        <td class="text-left">
                                        <?php if($category['Category']['parent_category'] != 0) {
                                                App::import('Model', 'Category');
                                                $this->Category = new Category();
                                                $c = $this->Category->find('first', array('conditions' => array('id' => $category['Category']['parent_category'])));
                                                echo $c['Category']['category_name'];
                                              } else { ?>
                                            -----------
                                        <?php } ?>
                                        </td>
                                        <td class="text-left"><?php echo date("d M, Y h:i A",strtotime($category['Category']['created_date'])); ?></td>
                                        <td class="text-right">
                                        <?php if($category['Category']['active'] == 'ON') { ?>
                                            <span class="label label-success">Yes</span>
                                        <?php } else { ?>
                                            <span class="label label-warning">No</span>
                                        <?php } ?>
                                        </td>
                                        <td class="text-right">
                                        <a class="btn btn-primary" title="" data-toggle="tooltip" href="categories/add?category_id=<?php echo $category['Category']['id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Records Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                <div class="col-sm-6 text-right">
                    <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

