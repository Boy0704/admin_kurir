
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <!-- <?php echo anchor(site_url('order/create'),'Create', 'class="btn btn-primary"'); ?> -->
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('order/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('order'); ?>" class="btn btn-default">Reset</a>
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
		<th>Customer</th>
		<th>Driver</th>
		<th>Origin</th>
		<th>Destination</th>
		<th>Alamat Origin</th>
		<th>Alamat Destination</th>
		<th>Jarak</th>
		<th>Harga</th>
		<th>Catatan</th>
		<th>Telp Penerima</th>
		<th>Telp Pengirim</th>
		<th>Nama Penerima</th>
		<th>Nama Pengirim</th>
		<th>Status</th>
		<th>Id Jenis</th>
		<th>Date At</th>
		<!-- <th>Action</th> -->
            </tr><?php
            foreach ($order_data as $order)
            {
                $data_user=$this->db->query("select nama_lengkap from users where id_user='$order->customer'")->row_array();
                $data_driver=$this->db->query("select nama_lengkap from users where id_user='$order->driver'")->row_array();
                $data_jenis=$this->db->query("select jenis_layanan from jenis_layanan where id_jenis='$order->id_jenis'")->row_array();
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $data_user['nama_lengkap'] ?></td>
			<td><?php echo $data_driver['nama_lengkap']  ?></td>
			<td><?php echo $order->origin ?></td>
			<td><?php echo $order->destination ?></td>
			<td><?php echo $order->alamat_origin ?></td>
			<td><?php echo $order->alamat_destination ?></td>
			<td><?php echo $order->jarak ?></td>
			<td><?php echo number_format($order->harga,0,',','.') ?></td>
			<td><?php echo $order->catatan ?></td>
			<td><?php echo $order->telp_penerima ?></td>
			<td><?php echo $order->telp_pengirim ?></td>
			<td><?php echo $order->nama_penerima ?></td>
			<td><?php echo $order->nama_pengirim ?></td>
			<td>
                <?php if($order->status=="0"){
                    echo "<b></b>";
                } else if($order->status=="1"){
                    echo "<b>Sedang Menjemput</b>";
                } else if($order->status=="2"){
                    echo "<b>Delivery</>";
                } else if($order->status=="3"){
                    echo "<b>Cancel</>";
                } else if($order->status == "4"){
                    echo "<span class='label label-success'>Success/Done</span>";  
                }
                ?>
            </td>
			<td><?php echo $data_jenis['jenis_layanan'] ?></td>
			<td><?php echo $order->date_at ?></td>
			<!-- <td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('order/update/'.$order->id_order),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('order/delete/'.$order->id_order),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td> -->
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
    