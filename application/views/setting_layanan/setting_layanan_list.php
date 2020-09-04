
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('setting_layanan/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('setting_layanan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('setting_layanan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Jenis</th>
		<th>Max Km</th>
		<th>Standar Km</th>
		<th>Standar Harga</th>
		<th>Per Km</th>
		<th>Jarak Driver</th>
		<th>Action</th>
            </tr><?php
            foreach ($setting_layanan_data as $setting_layanan)
            {
                $data_nama_jenis=$this->db->query("select jenis_layanan from jenis_layanan where id_jenis='$setting_layanan->id_jenis'")->row_array();
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $data_nama_jenis['jenis_layanan']?></td>
			<td><?php echo $setting_layanan->max_km ?></td>
			<td><?php echo $setting_layanan->standar_km ?></td>
			<td><?php echo $setting_layanan->standar_harga ?></td>
			<td><?php echo $setting_layanan->per_km ?></td>
			<td><?php echo $setting_layanan->jarak_driver ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('setting_layanan/update/'.$setting_layanan->id_setting_layanan),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('setting_layanan/delete/'.$setting_layanan->id_setting_layanan),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    