<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-homoeopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'homoeopathy','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Homeopathy</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Homoeopathy Words',array('controller' => 'homoeopathy','action' => 'index')); ?>
           </li>
       </ul>
   </div>
</div>

<div class="container-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($word_id) ? 'Edit' : 'Add'); ?> Homoeopathy Word</h3>
      </div>
      <div class="panel-body">
          <form id="form-homoeopathy" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($word_id) ? 'homoeopathy/edit' : 'homoeopathy/add'); ?>" enctype="multipart/form-data">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Parent Category</label>
                  <div class="col-sm-10">
                      <select name="parent_category_id" class="form-control" id="parent-category" onchange="getChildCategory(this.value)">
                          <?php if($child_categories) { ?>
                             <?php foreach($child_categories['data'] as $details) { ?>
                                <option value="<?php echo $details['Category']['id']; ?>"><?php echo $details['Category']['category_name']; ?></option>
                             <?php } ?>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="form-group required" id="child-div" style="display: none">
                  <label for="input-parent" class="col-sm-2 control-label">Child Category</label>
                  <div class="col-sm-10">

                  </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Word</label>
                  <div class="col-sm-10">
                      <input type="text" name="word_name" class="form-control" placeholder="Word" value="<?php echo $word_name; ?>" />
                      <?php if($error_word_name){ ?>
                          <div class="text-danger"><?php echo $error_word_name; ?></div>
                      <?php } ?>
                  </div>
                  <?php if($word_id) { ?>
                      <input type="hidden" name="word_id" value="<?php echo $word_id; ?>" />
                  <?php } ?>
              </div>
              <div class="form-group required" style="display:none;" id="desc-div">
                    <label for="input-parent" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" id="input-description"><?php echo $description; ?></textarea>
                        <?php if($error_description){ ?>
                            <div class="text-danger"><?php echo $error_description; ?></div>
                        <?php } ?>
                    </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Translation</label>
                  <div class="col-sm-10">
                      <input type="text" name="transliteration" class="form-control" placeholder="Translation" value="<?php echo $transliteration; ?>" />
                      <?php if($error_transliteration){ ?>
                          <div class="text-danger"><?php echo $error_transliteration; ?></div>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Meaning</label>
                  <div class="col-sm-10">
                      <textarea name="meaning" class="form-control" id="input-meaning"><?php echo $meaning; ?></textarea>
                      <?php if($error_meaning){ ?>
                          <div class="text-danger"><?php echo $error_meaning; ?></div>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Language</label>
                  <div class="col-sm-10">
                      <select name="language_id" class="form-control">
                          <?php if($this->Session->read('language_id') == 1){ ?>
                            <option value="1">Gujarati</option>
                          <?php } else { ?>
                            <option value="2">Hindi</option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Word Type</label>
                  <div class="col-sm-10">
                      <div class="btn-group" data-toggle="buttons">
                          <?php if($type) { ?>
                              <label class="btn btn-default">
                                  <input type="radio" name="type" value="0" /> Free
                              </label>

                              <label class="btn btn-default active">
                                  <input type="radio" name="type" value="1" /> Paid
                              </label>
                          <?php } else { ?>
                              <label class="btn btn-default active">
                                  <input type="radio" name="type" value="0" checked="checked" /> Free
                              </label>

                              <label class="btn btn-default">
                                  <input type="radio" name="type" value="1" /> Paid
                              </label>
                          <?php } ?>
                      </div>
                  </div>
              </div>
              <div class="form-group required" style="display:none;" id="summary-div">
                  <label for="input-parent" class="col-sm-2 control-label">Summary</label>
                  <div class="col-sm-10">
                      <textarea name="summary" class="form-control" id="input-summary"><?php echo $summary; ?></textarea>
                      <?php if($error_summary){ ?>
                         <div class="text-danger"><?php echo $error_summary; ?></div>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group" id="img-div" style="display:none;">
                  <label for="input-parent" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-10">
                      <?php if($image_url){ ?>
                        <a class="img-thumbnail" href="#" id="thumb-image" data-toggle="image">
                            <img src="<?php echo $image_url; ?>" width="80px" height="80px">
                        </a>
                      <?php } ?>
                      <input type="hidden" name="image_url" id="available-url" value="<?php echo $image_url; ?>" />
                      <input type="file" name="image_url" />
                      <?php if(isset($image_error)){ ?>
                          <div class="text-danger"><?php echo $image_error; ?></div>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-2 control-label">Video Url</label>
                  <div class="col-sm-10">
                      <input type="text" name="video_url" class="form-control" placeholder="Video Url" value="<?php echo $video_url; ?>" />
                      <?php if($error_video_url){ ?>
                          <div class="text-danger"><?php echo $error_video_url; ?></div>
                      <?php } ?>
                  </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                  <div class="col-sm-10">
                      <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="1" <?php echo ($active) ? 'checked="checked"' : ''; ?> />
                  </div>
              </div>
          </form>
      </div>
   </div>
</div>


<link href="<?php echo $this->webroot; ?>js/summernote//summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/blockui.js" type="text/javascript"></script>

<script>
    $('#input-description').summernote({
        height: 170
    });

    $('#input-summary').summernote({
        height: 170
    });

    $('#input-meaning').summernote({
        height: 170
    });

    $('document').ready(function(){
         getChildCategory($('#parent-category').val());
    });

    $(document).ajaxStop($.unblockUI);

    function getChildCategory(category_id){

        if(category_id == 4){
            $('#img-div').hide();
            $('#summary-div').show();
            $('#desc-div').show();
        }else{
            $('#img-div').show();
            $('#summary-div').hide();
            $('#desc-div').hide();
        }

        $.ajax({
            url: '<?php echo $this->webroot;?>homoeopathy/getChildCategories',
            type: 'post',
            data: {parent_id : category_id , name : $('#parent-category :selected').text(),current  : '<?php echo $category_id; ?>' },
            dataType: 'html',
            beforeSend : function(){
                  $.blockUI({message: '<h4><img src="<?php echo $this->webroot; ?>images/loader.gif" />  Just a moment...</h4>'});
            },
            success: function (response) {
                if (response) {
                    $('#child-div').children('div').html(response);
                    $('#child-div').show();
                }
            }
        });
    }

</script>