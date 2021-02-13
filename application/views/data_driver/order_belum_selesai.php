
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
                
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
                <th>No TRX</th>
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
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $this->db->where('status!=', '4');
            $this->db->where('driver', $this->uri->segment(3));
            $this->db->order_by('id_order', 'desc');
            $order_data = $this->db->get('order')->result();
            foreach ($order_data as $order)
            {
                $data_user=$this->db->query("select nama_lengkap from users where id_user='$order->customer'")->row_array();
                $data_driver=$this->db->query("select nama_lengkap from users where id_user='$order->driver'")->row_array();
                $data_jenis=$this->db->query("select jenis_layanan from jenis_layanan where id_jenis='$order->id_jenis'")->row_array();
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
            <td><?php echo "TR".$order->id_order ?></td>
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
                    echo "<b>Open</b>";
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
            <td>
                <?php if ($order->status == '1' or $order->status == '2'): ?>
                    <a onclick="javasciprt: return confirm('Are You Sure ?')" href="order/cancel_order/<?php echo $order->id_order.'/'.$order->driver ?>" class="label label-danger">Cancel</a>
                <?php endif ?>
            </td>
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
            </tbody>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                
	    </div>
            <div class="col-md-6 text-right">
               
            </div>
        </div>
    