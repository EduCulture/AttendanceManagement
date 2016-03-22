<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-allopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'allopathy','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Allopathy</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Allopathy Words',array('controller' => 'allopathy','action' => 'index')); ?>
           </li>
       </ul>
   </div>
</div>

<div class="container-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($word_id) ? 'Edit' : 'Add'); ?> Allopathy Word</h3>
      </div>
      <div class="panel-body">
          <form id="form-allopathy" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($word_id) ? 'allopathy/edit' : 'allopathy/add'); ?>" enctype="multipart/form-data">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10">
                      <select name="category_id" class="form-control">
                         <option value="1">Allopathy</option>
                         <?php if($child_categories) { ?>
                             <?php foreach($child_categories['data'] as $category) { ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                             <?php } ?>
                         <?php } ?>
                      </select>
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
                      <input type="text" name="meaning" class="form-control" placeholder="Meaning" value="<?php echo $meaning; ?>" />
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
                                  <input type="radio" name="type" value="1" checked="checked" /> Paid
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
              <div class="form-group">
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