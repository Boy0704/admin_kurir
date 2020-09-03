
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="text">Id Jenis <?php echo form_error('id_jenis') ?></label>
            <select name="id_jenis" id="id_jenis" class="form-control">
                <option value="<?php echo $id_jenis?>">Select</option>
                <?php $data_jenis_layanan=$this->db->query("SELECT * from jenis_layanan")->result();?>
                <?php foreach($data_jenis_layanan as $d):?>
                 <option value="<?=$d->id_jenis?>"><?=$d->id_jenis?> | <?=$d->jenis_layanan?></option>
                <?php endforeach;?>
            </select>
        </div>
	    <div class="form-group">
            <label for="float">Max Km <?php echo form_error('max_km') ?></label>
            <input type="text" class="form-control" name="max_km" id="max_km" placeholder="Max Km" value="<?php echo $max_km; ?>" />
        </div>
	    <div class="form-group">
            <label for="float">Standar Km <?php echo form_error('standar_km') ?></label>
            <input type="text" class="form-control" name="standar_km" id="standar_km" placeholder="Standar Km" value="<?php echo $standar_km; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Standar Harga <?php echo form_error('standar_harga') ?></label>
            <input type="text" class="form-control" name="standar_harga" id="standar_harga" placeholder="Standar Harga" value="<?php echo $standar_harga; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Per Km <?php echo form_error('per_km') ?></label>
            <input type="text" class="form-control" name="per_km" id="per_km" placeholder="Per Km" value="<?php echo $per_km; ?>" />
        </div>
	    <input type="hidden" name="id_setting_layanan" value="<?php echo $id_setting_layanan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('setting_layanan') ?>" class="btn btn-default">Cancel</a>
	</form>
   