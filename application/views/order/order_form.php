
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Customer <?php echo form_error('customer') ?></label>
            <input type="text" class="form-control" name="customer" id="customer" placeholder="Customer" value="<?php echo $customer; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Driver <?php echo form_error('driver') ?></label>
            <input type="text" class="form-control" name="driver" id="driver" placeholder="Driver" value="<?php echo $driver; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Origin <?php echo form_error('origin') ?></label>
            <input type="text" class="form-control" name="origin" id="origin" placeholder="Origin" value="<?php echo $origin; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Destination <?php echo form_error('destination') ?></label>
            <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination" value="<?php echo $destination; ?>" />
        </div>
	    <div class="form-group">
            <label for="alamat_origin">Alamat Origin <?php echo form_error('alamat_origin') ?></label>
            <textarea class="form-control" rows="3" name="alamat_origin" id="alamat_origin" placeholder="Alamat Origin"><?php echo $alamat_origin; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="alamat_destination">Alamat Destination <?php echo form_error('alamat_destination') ?></label>
            <textarea class="form-control" rows="3" name="alamat_destination" id="alamat_destination" placeholder="Alamat Destination"><?php echo $alamat_destination; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="float">Jarak <?php echo form_error('jarak') ?></label>
            <input type="text" class="form-control" name="jarak" id="jarak" placeholder="Jarak" value="<?php echo $jarak; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
        </div>
	    <div class="form-group">
            <label for="catatan">Catatan <?php echo form_error('catatan') ?></label>
            <textarea class="form-control" rows="3" name="catatan" id="catatan" placeholder="Catatan"><?php echo $catatan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="varchar">Telp Penerima <?php echo form_error('telp_penerima') ?></label>
            <input type="text" class="form-control" name="telp_penerima" id="telp_penerima" placeholder="Telp Penerima" value="<?php echo $telp_penerima; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Telp Pengirim <?php echo form_error('telp_pengirim') ?></label>
            <input type="text" class="form-control" name="telp_pengirim" id="telp_pengirim" placeholder="Telp Pengirim" value="<?php echo $telp_pengirim; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Penerima <?php echo form_error('nama_penerima') ?></label>
            <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Nama Penerima" value="<?php echo $nama_penerima; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Pengirim <?php echo form_error('nama_pengirim') ?></label>
            <input type="text" class="form-control" name="nama_pengirim" id="nama_pengirim" placeholder="Nama Pengirim" value="<?php echo $nama_pengirim; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Jenis <?php echo form_error('id_jenis') ?></label>
            <input type="text" class="form-control" name="id_jenis" id="id_jenis" placeholder="Id Jenis" value="<?php echo $id_jenis; ?>" />
        </div>
	    <div class="form-group">
            <label for="datetime">Date At <?php echo form_error('date_at') ?></label>
            <input type="text" class="form-control" name="date_at" id="date_at" placeholder="Date At" value="<?php echo $date_at; ?>" />
        </div>
	    <input type="hidden" name="id_order" value="<?php echo $id_order; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('order') ?>" class="btn btn-default">Cancel</a>
	</form>
   