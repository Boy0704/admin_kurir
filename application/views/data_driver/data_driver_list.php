
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <!-- <?php echo anchor(site_url('data_driver/create'),'Create', 'class="btn btn-primary"'); ?> -->
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!-- <form action="<?php echo site_url('data_driver/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('data_driver'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form> -->
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
		<th>Nama Lengkap</th>
		<th>Username</th>
		<th>Jenis Kendaraan</th>
		<th>No Plat</th>
		<th>Alamat</th>
        <th>Status</th>
		<th>Status Online</th>
		<th>Action</th>
    </thead>
    <tbody>
            </tr><?php
            $data_driver_data = $this->db->get('data_driver')->result();
            foreach ($data_driver_data as $data_driver)
            {
                $dataUserLengkap=$this->db->query("SELECT * FROM users where id_user='$data_driver->id_user'")->row_array();
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $dataUserLengkap['nama_lengkap'] ?></td>
			<td><?php echo $dataUserLengkap['username'] ?></td>
			<td><?php echo $data_driver->jenis_kendaraan ?></td>
			<td><?php echo $data_driver->no_plat ?></td>
			<td><?php echo $data_driver->alamat ?></td>
            <td>
                <?php if ($data_driver->status_order=='1'): ?>
                    <span class="label label-success">Sedang ambil order</span>
                <?php else: ?>
                    <span class="label label-info">tidak ada order</span>
                <?php endif ?>
               
            </td>
			<td>
                <?php if ($data_driver->status_online=='1'): ?>
                    <i class="fa fa-circle text-success"></i> Online
                <?php else: ?>
                    <i class="fa fa-circle text-danger"></i> Offline
                <?php endif ?>
               
            </td>
            <?php if($data_driver->status=='1'){?>
                <td style="text-align:center" width="200px">
                <a href="order/log_order_driver/<?php echo $data_driver->id_user ?>" class="label label-primary">Log Order</a>
				<?php 
				echo anchor(site_url('data_driver/update/'.$data_driver->id_user),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('data_driver/delete/'.$data_driver->id_user),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>

            <?php } else { ?>
                <td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('data_driver/confirm/'.$data_driver->id_user),'<span class="label label-success">Confirm</span>'); 
				echo ' | '; 
				echo anchor(site_url('data_driver/update/'.$data_driver->id_user),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('data_driver/delete/'.$data_driver->id_user),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
              <?php } ?>
			
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div> -->
    