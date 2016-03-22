<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-news" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a class="btn btn-default" title="" data-toggle="tooltip" href="../news" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
        <h1>News</h1>
        <ul class="breadcrumb">
        <li><?php echo $this->Html->link('Home', array('controller'=>'dashboard','action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('News', array('controller'=>'news','action'=>'index')); ?></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> Add News</h3>
        </div>
        <div class="panel-body">
            <form id="form-news" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Headlines</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="input-headline" placeholder="Headline" value="<?php echo isset($news['news_title']) ? $news['news_title'] : ''; ?>" name="heading">
                        <?php if(isset($heading_error)){ ?>
                            <div class="text-danger"><?php echo $heading_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="input-description" name="description" style=""><?php echo isset($news['news_description']) ? $news['news_description'] : ''; ?></textarea>
                        <?php if(isset($des_error)){ ?>
                            <div class="text-danger"><?php echo $des_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Reference Link</label>
                    <div class="col-sm-10">
                        <input type="text" name="ref_link" class="form-control" placeholder="Reference Link" value="<?php echo isset($news['ref_link']) ? $news['ref_link'] : ''; ?>" />
                        <?php if(isset($ref_error)){ ?>
                            <div class="text-danger"><?php echo $ref_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                <label for="input-parent" class="col-sm-2 control-label">Image Url</label>
                    <div class="col-sm-10">
                    <input type="text" name="imageurl" class="form-control" placeholder="Image url" value="<?php echo isset($news['image_url']) ? $news['image_url'] : ''; ?>" />
                    <?php if(isset($image_error)){ ?>
                        <div class="text-danger"><?php echo $image_error; ?></div>
                    <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                    <div class="col-sm-10">
                    <?php if(isset($news['active']) &&  $news['active'] == 1) { ?>
                        <input type="checkbox" name="Isactive" class="form-control" style="margin-top:10px;" value="ON" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="Isactive" class="form-control" style="margin-top:10px;" value="ON" />
                    <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    echo $this->Html->script('summernote.js');
    echo $this->Html->css('summernote.css');
    echo "<script>
        $('#input-description').summernote({
            height: 170
        });
    </script>";
?>