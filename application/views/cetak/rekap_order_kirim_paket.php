
<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Backup Order.xls");
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<table class="table table-bordered" border="1" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
        <th>No Trx</th>
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
            $start = 1;
            foreach ($order_data->result() as $order)
            {
                $data_user=$this->db->query("select nama_lengkap from users where id_user='$order->customer'")->row_array();
                $data_driver=$this->db->query("select nama_lengkap from users where id_user='$order->driver'")->row_array();
                $data_jenis=$this->db->query("select jenis_layanan from jenis_layanan where id_jenis='$order->id_jenis'")->row_array();
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
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
			
		</tr>
                <?php
                $start++;
            }
            ?>
        </table>


</body>
</html>