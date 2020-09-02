
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Image <?php echo form_error('image') ?></label>
            <input type="text" class="form-control" name="image" id="image" placeholder="Image" value="<?php echo $image; ?>" />
        </div>
	    <input type="hidden" name="id_slide" value="<?php echo $id_slide; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('slider') ?>" class="btn btn-default">Cancel</a>
	</form>
   