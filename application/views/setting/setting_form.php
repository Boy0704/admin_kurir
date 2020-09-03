
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
	    <div class="form-group">
            <label for="value">Value <?php echo form_error('value') ?></label>
            <textarea class="form-control" rows="3" name="value" id="value" placeholder="Value"><?php echo $value; ?></textarea>
        </div>
	    <input type="hidden" name="id_setting" value="<?php echo $id_setting; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('setting') ?>" class="btn btn-default">Cancel</a>
	</form>
   