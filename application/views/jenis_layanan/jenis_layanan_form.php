
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Jenis Layanan <?php echo form_error('jenis_layanan') ?></label>
            <input type="text" class="form-control" name="jenis_layanan" id="jenis_layanan" placeholder="Jenis Layanan" value="<?php echo $jenis_layanan; ?>" />
        </div>
	    <input type="hidden" name="id_jenis" value="<?php echo $id_jenis; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('jenis_layanan') ?>" class="btn btn-default">Cancel</a>
	</form>
   