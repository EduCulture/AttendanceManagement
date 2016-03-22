<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Image Manager</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5"><a href="<?php echo $data['parent']; ?>" data-toggle="tooltip" title="Parent" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a> <a href="<?php echo $data['refresh']; ?>" data-toggle="tooltip" title="Refresh" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
          <button type="button" data-toggle="tooltip" title="Upload" id="button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="New Folder" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="Delete" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        </div>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="search" value="<?php echo $data['filter_name']; ?>" placeholder="Search" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="Search" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
      </div>
      <hr />
      <?php if(isset($data['images'])) { ?>
      	<?php foreach (array_chunk($data['images'], 4) as $image) { ?>
		  <div class="row">
			<?php foreach ($image as $image) { ?>
			<div class="col-sm-3 text-center">
			  <?php if ($image['type'] == 'directory') { ?>
				<div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
				<label>
				  <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
				  <?php echo $image['name']; ?>
				</label>
			  <?php } ?>
			  <?php if ($image['type'] == 'image') { ?>
				<a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
				<label>
				  <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
				  <?php echo $image['name']; ?>
				</label>
			  <?php } ?>
			</div>
			<?php } ?>
		  </div>
		  <br />
        <?php } ?>
      <?php } else { ?>
        <div class="row">
        	<div class="col-sm-12">
        		<div class="text-center">No images available</div>
        	</div>
        </div>
      <?php } ?>
    </div>
    <div class="modal-footer"><?php //echo $pagination; ?></div>
  </div>
</div>

<script type="text/javascript"><!--
$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

	<?php if ($data['thumb']) { ?>
	$('#<?php echo $data['thumb']; ?>').find('img').attr('src', $(this).find('img').attr('src'));
	<?php } ?>

	<?php if ($data['target']) { ?>
	$('#<?php echo $data['target']; ?>').attr('value', $(this).parent().find('input').attr('value'));
	<?php } else { ?>
	var range, sel = document.getSelection();

	if (sel.rangeCount) {
		var img = document.createElement('img');
		img.src = $(this).attr('href');

		range = sel.getRangeAt(0);
		range.insertNode(img);
	}
	<?php } ?>

	$('#modal-image').modal('hide');
});

$('a.directory').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-search').on('click', function() {
	var url = '<?php echo $this->webroot.'image/fileManager?directory='.$data['directory']; ?>';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	<?php if ($data['thumb']) { ?>
		url += '&thumb=' + '<?php echo $data['thumb']; ?>';
	<?php } ?>

	<?php if ($data['target']) { ?>
		url += '&target=' + '<?php echo $data['target']; ?>';
	<?php } ?>

	$('#modal-image').load(url);
});


$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" value="" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
			    url : '<?php echo $this->webroot."image/upload?directory=".$data['directory']; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: 'Create folder',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="create folder" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="folder" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
		    url : '<?php echo $this->webroot."image/folder?directory=".$data['directory']; ?>',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});

$('#modal-image #button-delete').on('click', function(e) {
	if (confirm('Are you sure want to delete?')) {
		$.ajax({
			url: '<?php echo $this->webroot."image/delete"; ?>',
			type: 'post',
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

//--></script>