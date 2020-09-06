
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group">
            <label for="varchar">Image <?php echo form_error('image') ?></label>
            <input type="file" class="form-control" name="image" id="image" placeholder="Image" value="<?php echo $image; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label>
            <select name="status" id="status" class="form-control">
            <?php $state="";
            if($status==""){
                $state="Select";
            } else {
                $state=$status;
            }
            ?>
            <option value="<?$status?>" selected><?php echo $state?></option>
            <option value="1">Aktif</option>
            <option value="0">Tidak aktif</option>
            </select>
        </div>
	    <input type="hidden" name="id_promotion" value="<?php echo $id_promotion; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('promotion') ?>" class="btn btn-default">Cancel</a>
	</form>
   