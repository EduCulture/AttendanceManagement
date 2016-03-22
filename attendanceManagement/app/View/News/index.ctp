<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a class="btn btn-primary" title="" data-toggle="tooltip" href="news/add" data-original-title="Add New"><i class="fa fa-plus"></i></a>
            <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#news-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
        <h1><i class="fa fa-newspaper-o fa-fw"></i> News</h1>

    </div>
</div>
<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> News List</h3>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                    <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample">
                        <span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span>
                    </a>
                    <?php if($is_filter){ ?>
                        <a class="pull-right" data-toggle="tooltip" data-original-title="Reset Filter" style="margin-right: 15px;" title="" href="news">
                            <i class="fa fa-undo"></i>
                        </a>
                    <?php } ?>
                </div>
                <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                    <div class="well">
                        <form enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="input-name" class="control-label">News</label>
                                        <input type="text" class="form-control" id="input-name" placeholder="Headline" value="" name="filter_word">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="input-price" class="control-label">Status</label>
                                            <select name="filter_type" class="form-control">
                                                <option value=""></option>
                                                <option value="0">Inactive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary pull-left" style="margin-top:20px;" id="button-filter" type="submit"><i class="fa fa-search"></i> Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form id="news-list" enctype="multipart/form-data" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                <td class="text-left">Headlines</td>
                                <!--<td class="text-left">Description</td>-->
                                <td class="text-left">Reference Link</td>
                                <td class="text-left">Image Url</td>
                                <td class="text-left">Release Date</td>
                                <td class="text-right">Active</td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($news)) { ?>
                                <?php foreach($news as $new) { ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" value="<?php echo $new['News']['id']; ?>" name="selected[]"></td>
                                        <td class="text-left"><?php echo $new['News']['news_title']; ?></td>
                                        <td class="text-left"><a href="<?php echo $new['News']['ref_link']; ?>" target="_blank"><?php echo $new['News']['ref_link']; ?></a></td>
                                        <td class="text-left">
                                        <?php if(isset($new['News']['image_url']) && $new['News']['image_url'] != '') { ?>
                                            <a href="<?php echo $new['News']['image_url']; ?>" target="_blank">
                                            <img class="img-thumbnail" height="100" width="100" src="<?php echo $new['News']['image_url']; ?>" /></a>
                                        <?php } ?>
                                        </td>
                                        <td class="text-left"><?php echo date("d M, Y h:i A",strtotime($new['News']['created_date'])); ?></td>
                                        <td class="text-center">
                                        <?php if($new['News']['active'] == 'ON') { ?>
                                            <span class="label label-success">Yes</span>
                                        <?php } else { ?>
                                            <span class="label label-warning">No</span>
                                        <?php } ?>
                                        </td>
                                        <td class="text-right">
                                        <a class="btn btn-primary" title="" data-toggle="tooltip" href="news/add?news_id=<?php echo $new['News']['id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
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

