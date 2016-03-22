<div class="page-header">
    <div class="container-fluid">
        <h1>Homeopathy Words</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Homoeopathy',array('controller' => 'homoeopathy')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'homoeopathy','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#homoeopathy-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
           <button class="btn btn-success" id="more-action" title="" data-toggle="tooltip" type="button" data-original-title="More"><i class="fa fa-compress"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Homeopathy Words List</h3>
              <div class="pull-right"><?php echo $this->Paginator->numbers(); ?></div>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="panel panel-default">
                         <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                            <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                            <?php if($is_filter){ ?>
                                <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'homoeopathy','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                            <?php } ?>
                         </div>
                         <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                            <div class="well">
                                <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>homoeopathy/index">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-name" class="control-label">Word</label>
                                                <input type="text" class="form-control" id="input-name" placeholder="Word" value="<?php echo isset($this->request->query['filter_word']) ? $this->request->query['filter_word'] : ''; ?>" name="filter_word">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Type</label>
                                                <select name="filter_type" class="form-control">
                                                    <option value=""></option>
                                                    <option value="0">Free</option>
                                                    <option value="1">Paid</option>
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
                  </div>
              </div>

              <form id="homoeopathy-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'homoeopathy/delete'; ?>">

                    <div role="tabpanel">
                         <!-- Nav tabs -->
                         <ul class="nav nav-tabs" role="tablist">
                             <?php $i=0;?>
                             <?php foreach($child_categories['data'] as $category) { ?>
                                    <li role="presentation" <?php echo ($i==0) ? 'class="active"' : '';?>><a href="#tab-<?php echo $category['Category']['id']; ?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo $category['Category']['category_name']; ?></a></li>
                                  <?php $i++; ?>
                             <?php } ?>
                         </ul>

                         <!-- Tab panes -->
                         <div class="tab-content">
                              <?php $j=0;?>
                              <?php if($child_categories) { ?>
                                  <?php foreach($child_categories['data'] as $category) { ?>
                                      <div role="tabpanel" class="tab-pane fade in <?php echo ($j==0) ? 'active' : '';?>" id="tab-<?php echo $category['Category']['id']; ?>">

                                          <div class="row" style="margin-right: 3px;">
                                              <div class="pull-right"><?php echo $this->Paginator->numbers(); ?></div>
                                          </div>

                                          <div class="table-responsive">
                                              <table class="table table-bordered table-hover">
                                                  <thead>
                                                      <tr>
                                                          <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                                          <td class="text-center">Image</td>
                                                          <td class="text-left">Word</td>
                                                          <td class="text-left">Translation</td>
                                                          <td class="text-left">Meaning</td>
                                                          <td class="text-left">Category</td>
                                                          <td class="text-left">Type</td>
                                                          <td class="text-right">Action</td>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php if($word_details) { ?>
                                                          <?php foreach($word_details as $key=>$detail) { ?>
                                                              <?php if($key==$category['Category']['id']) { ?>
                                                                  <?php if($detail) { ?>
                                                                     <?php foreach($detail as $word) { ?>
                                                                          <tr>
                                                                              <td class="text-center"><input type="checkbox" value="<?php echo $word['Word']['id']; ?>" name="word_id[]"></td>
                                                                              <td class="text-center">
                                                                                 <?php if($word['Word']['image_url']) { ?>
                                                                                    <a href="<?php echo $word['Word']['image_url']; ?>" data-lightbox="roadtrip">
                                                                                       <img class="img-thumbnail" width="50" height="50" alt="<?php echo $word['Word']['word_name']; ?>" src="<?php echo $word['Word']['image_url']; ?>">
                                                                                    </a>
                                                                                 <?php } else { ?>
                                                                                     <img class="img-thumbnail" width="40" height="40" alt="<?php echo $word['Word']['word_name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                                                                 <?php } ?>
                                                                              </td>
                                                                              <td class="text-left"><?php echo $word['Word']['word_name']; ?></td>
                                                                              <td class="text-left"><?php echo $word['Translation']['transliteration']; ?></td>
                                                                              <td class="text-left"><?php echo $word['Translation']['meaning']; ?></td>
                                                                              <td class="text-left"><?php echo $word['Category']['category_name']; ?></td>
                                                                              <td class="text-left">
                                                                                    <?php if($word['Word']['is_paid']) { ?>
                                                                                      <span class="label label-warning">Paid</span>
                                                                                    <?php } else { ?>
                                                                                      <span class="label label-success">Free</span>
                                                                                    <?php } ?>
                                                                              </td>
                                                                              <td class="text-right">
                                                                                 <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'homoeopathy','action' => 'edit','?' => array('word_id' => $word['Word']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
                                                                              </td>
                                                                          </tr>
                                                                     <?php } ?>
                                                                  <?php } else{ ?>
                                                                      <tr>
                                                                         <td class="text-center" colspan="8">No Records Found</td>
                                                                      </tr>
                                                                  <?php } ?>
                                                              <?php } ?>
                                                          <?php } ?>
                                                      <?php } else { ?>
                                                             <tr>
                                                                 <td class="text-center" colspan="8">No Records Found</td>
                                                             </tr>
                                                      <?php } ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                          <div class="row">
                                              <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                                              <div class="col-sm-6 text-right">
                                                    <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                                              </div>
                                          </div>
                                      </div>
                                      <?php $j++; ?>
                                  <?php } ?>
                              <?php } ?>
                         </div>
                    </div>
              </form>
          </div>
    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Select Action</h4>
          </div>
          <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                  <div class="form-group">
                      <label for="input-parent" class="col-sm-2 control-label">Action</label>
                      <div class="col-sm-10">
                          <select name="word_action" onchange="getAction(this.value)" class="form-control">
                              <option value="price">Paid/Free Words</option>
                              <option value="status">Active/Inactive Words</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input-parent" class="col-sm-2 control-label"> Select</label>
                      <div class="col-sm-10" id="modal-div">

                      </div>
                  </div>
                  <input type="hidden" name="modal_val" value="" />
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Continue</button>
              </div>
          </form>
      </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo $this->webroot; ?>js/lightbox/js/lightbox.min.js"></script>
<link href="<?php echo $this->webroot; ?>js/lightbox/css/lightbox.css" rel="stylesheet" />
<script>
  $('#more-action').click(function(){
      var count = 0;
      $('input[name*=\'selected\']').each(function() {
          if($(this).is(':checked')) {
              count++;
          }
      });
      if(count>0) {
         getAction('price');
         $('#myModal').modal('show');
      }else{
          alert("Please Select atleast one checkbox");
      }
  });

  function getAction(val){
      html = '';

      html += '<div class="btn-group" data-toggle="buttons">';
          if(val=='price'){

              html += '<label class="btn btn-default active">';
                html += '<input type="radio" name="optn_val" checked="checked" value="0" /> Free ';
              html += '</label>';

              html += '<label class="btn btn-default">';
                html += '<input type="radio" name="optn_val" value="1" /> Paid';
              html += '</label>';
          }else{

              html += '<label class="btn btn-default active">';
                html += '<input type="radio" name="optn_val" checked="checked" value="1" /> Active ';
              html += '</label>';

              html += '<label class="btn btn-default">';
                html += '<input type="radio" name="optn_val" value="0" /> Inactive';
              html += '</label>';

          }
      html += '</div>';
      var i=0;
      var array = new Array();
      $('input[name*=\'selected\']').each(function() {
          if($(this).is(':checked')){
              html += '<input type="hidden" name="checkbox_val[]" value="'+$(this).val()+'" />';
              //array[i] = $(this).val();
              //i++;
          }
      });
      //alert(JSON.stringify(array));
      $('#modal-div').html(html);
  }
</script>