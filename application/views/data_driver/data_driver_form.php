
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id User <?php echo form_error('id_user') ?></label>
            <input type="text" class="form-control" name="id_user" id="id_user" placeholder="Id User" value="<?php echo $id_user; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Nama Lengkap <?php echo form_error('id_user') ?></label>
            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $nama_lengkap; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Username <?php echo form_error('id_user') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Password <?php echo form_error('id_user') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Jenis Kendaraan <?php echo form_error('jenis_kendaraan') ?></label>
            <input type="text" class="form-control" name="jenis_kendaraan" id="jenis_kendaraan" placeholder="Jenis Kendaraan" value="<?php echo $jenis_kendaraan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">No Plat <?php echo form_error('no_plat') ?></label>
            <input type="text" class="form-control" name="no_plat" id="no_plat" placeholder="No Plat" value="<?php echo $no_plat; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </div>
	    
       
        <input type="hidden" class="form-control" name="lat" id="lat" placeholder="Lat" value="<?php echo $lat; ?>" />
        <input type="hidden" class="form-control" name="lng" id="lng" placeholder="Lng" value="<?php echo $lng; ?>" />
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('data_driver') ?>" class="btn btn-default">Cancel</a>
	</form>
   