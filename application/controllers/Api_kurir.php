<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kurir extends CI_Controller {

	public function tes_fcm()
	{
		$server_key = get_setting('server_fcm_customer');
		$token = get_data('users','id_user',"23",'token_fcm');
		$title = "Tes Aja";
		$body = "Hai Ini Tes";
		$screen ="list_trx";
		$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
		$result = json_decode($hasil);
		if ($result->success == 1) {
			echo "berhasil";
		} else {
			echo "gagal";
		}

	}
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function all_lokasi_driver()
	{
		// Start XML file, create parent node
		// $doc = domxml_new_doc("1.0");
		// $node = $doc->create_element("markers");
		// $parnode = $doc->append_child($node);

		// header("Content-type: text/xml");
		// $data = $this->db->get('data_driver');
		// foreach ($data->result_array() as $row) {
		// 	// Add to XML document node
		//   $node = $doc->create_element("marker");
		//   $newnode = $parnode->append_child($node);

		//   $newnode->set_attribute("id", $row['id_user']);
		//   $newnode->set_attribute("host", $row['no_plat']);
		//   $newnode->set_attribute("active", "motor");
		//   $newnode->set_attribute("lastupdate", get_waktu());
		//   $newnode->set_attribute("lat", $row['lat']);
		//   $newnode->set_attribute("lng", $row['lng']);

		// }

		// $xmlfile = $doc->dump_mem();
		// echo $xmlfile;
		$this->db->where('status_online', '1');
		$data = $this->db->get('data_driver');
		$attribs=array('id_user','no_plat','jenis_kendaraan','lat','lng','bearing','status_online');


	    $dom=new DOMDocument('1.0','utf-8');
	    $dom->formatOutput=true;
	    $dom->standalone=true;
	    $dom->recover=true;

	    $root=$dom->createElement('markers');
	    $dom->appendChild( $root );


	    foreach ($data->result() as $rs) {
	    	$node=$dom->createElement('marker');
	        $root->appendChild( $node );

	        foreach( $attribs as $attrib ){
	            $attr = $dom->createAttribute( $attrib );
	            $value= $dom->createTextNode( $rs->$attrib );
	            $attr->appendChild( $value );
	            $node->appendChild( $attr );
	        }
	    }

	    header("Content-Type: application/xml");
	    echo $dom->saveXML();


	}

	public function lokasi_driver()
	{
		$data = $this->db->query("SELECT * FROM data_driver WHERE lat !='' and lng !='' and bearing!='' and status_online = '1' ");
		$result = array();

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $rw) {
			
				array_push($result, array(
					'id_user'=>$rw->id_user,
					'lat' => $rw->lat,
					'lng' => $rw->lng,
					'no_plat' => $rw->no_plat,
					'bearing' => $rw->bearing,
				));
			}

			echo json_encode(array(
				'status_error' => '0',
				'detailnya' => $result
			));
		} else {
			echo json_encode(array(
				'status_error' => '1',
				'detailnya' => $result
			));
		}

		
	}

	public function lacak_driver($id_user_driver)
	{
		$data = $this->db->query("SELECT * FROM data_driver WHERE lat !='' and lng !='' and bearing!='' and id_user='$id_user_driver' and status_online='1' ");
		$result = array();

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $rw) {
			
				array_push($result, array(
					'id_user'=>$rw->id_user,
					'lat' => $rw->lat,
					'lng' => $rw->lng,
					'no_plat' => $rw->no_plat,
					'bearing' => $rw->bearing,
				));
			}

			echo json_encode(array(
				'status_error' => '0',
				'detailnya' => $result
			));
		} else {
			echo json_encode(array(
				'status_error' => '1',
				'detailnya' => $result
			));
		}
	}

	public function daftar()
	{
		if ($_POST) {
			$nama = $this->input->post('nama');
			$no_telp = $this->input->post('no_telp');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			$cek = $this->db->get_where('users', array('no_telp'=>$no_telp));
			if ($cek->num_rows() > 0) {
				$result = array(
					'status' => "0",
					'pesan' => 'No Telp Sudah terdaftar, silahkan login !'
				);
				echo json_encode($result);
			} else {
				$simpan = $this->db->insert('users', array(
					'nama_lengkap' => $nama,
					'username' => $no_telp,
					'password' => $password,
					'no_telp' => $no_telp,
					'email' => $email,
					'level' => 'user'
				));

				if ($simpan) {
					$result = array(
						'status' => "1",
						'pesan' => 'Pendaftaran berhasil, silahkan login'
					);
					echo json_encode($result);
				} else {
					$result = array(
						'status' => "0",
						'pesan' => 'Gagal'
					);
					echo json_encode($result);
				}
			}

			
		}
	}

	public function cek_username_driver()
	{
		if ($_POST) {
			$username = $this->input->post('username');
			$cek = $this->db->get_where('users', array('username'=>$username));
			if ($cek->num_rows() > 0) {
				$result = array(
					'status' => "0",
					'pesan' => 'Username Sudah terdaftar !'
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "1",
					'pesan' => 'Username Bisa digunakan !'
				);
				echo json_encode($result);
			}
		}
	}

	public function daftar_driver()
	{
		if ($_POST) {
			$nama = $this->input->post('nama');
			$username = $this->input->post('username');
			$no_telp = $this->input->post('no_telp');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$jenis_kendaraan = $this->input->post('jenis_kendaraan');
			$no_plat = $this->input->post('no_plat');
			$alamat = $this->input->post('alamat');


			$simpan = $this->db->insert('users', array(
				'nama_lengkap' => $nama,
				'username' => $username,
				'password' => $password,
				'no_telp' => $username,
				'email' => $email,
				'level' => 'driver'
			));

			$id_user = $this->db->insert_id();

			$data_driver = array(
				'id_user' => $id_user,
				'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
				'no_plat' => $this->input->post('no_plat'),
				'alamat' => $this->input->post('alamat'),
			);
			$simpan_driver = $this->db->insert('data_driver', $data_driver);

			if ($simpan_driver) {
				$result = array(
					'status' => "1",
					'pesan' => 'Pendaftaran berhasil, silahkan login'
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "0",
					'pesan' => 'Gagal'
				);
				echo json_encode($result);
			}

			
		}
	}

	public function login()
	{
		if ($_POST) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$token_fcm = $this->input->post('token_fcm');
			$level = $this->input->post('level');

			$cek = $this->db->get_where('users', array('username' => $username, 'password' => $password,'level'=>$level));

			if ($cek->num_rows() == 1) {
				$data = $cek->row();

				//cek driver aktif
				if ($level == 'driver') {
					$aktif_driver = $this->db->get_where('data_driver', array('id_user'=>$data->id_user))->row()->status;
					if ($aktif_driver == '0') {
						$result = array(
							'status' => "0",
							'pesan' => 'Akun kamu belum aktif, silahkan hubungi admin'
						);
						echo json_encode($result);
						exit();
					}
				}

				// update fcm token
				$this->db->where('id_user', $data->id_user);
				$this->db->update('users', array('token_fcm'=>$token_fcm));
				$result = array(
					'status' => "1",
					'id_user' => $data->id_user,
					'nama' => $data->nama_lengkap,
					'no_telp' => $data->no_telp,
					'password' => $data->password,
					'email' => $data->email,
					'level' => $data->level,
					'pesan' => "Selamat datang dan selamat beraktifitas $data->nama_lengkap"
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "0",
					'pesan' => 'Gagal'
				);
				echo json_encode($result);
			}
		}
	}

	public function get_promotion()
	{
		$req = $this->input->post('request');
		$data = $this->db->get_where('promotion',array('status'=>'1'));
		$result = array();

		foreach ($data->result() as $rw) {
			
			array_push($result, array(
				'image' => $rw->image,
			));
		}

		echo json_encode(array(
			'detailPromo' => $result
		));
	}

	public function cek_jarak()
	{
		if ($_POST) {
			$jarak = $this->input->post('jarak');
			$id_jenis = $this->input->post('id_jenis');
			$cek = $this->db->get_where('setting_layanan', array('id_jenis'=>$id_jenis))->row();
			if ($cek->max_km > $jarak) {
				if ($jarak > $cek->standar_km) {
					$jarak = ceil($jarak);
					$sisa = $jarak - $cek->standar_km;
					$n_sisa = $sisa * $cek->per_km;
					$total_harga = $cek->standar_harga + $n_sisa;
					$result = array(
						'status' => "1",
						'pesan' => "success",
						'total_harga' => "$total_harga",
					);
					echo json_encode($result);
				} else {
					$result = array(
						'status' => "1",
						'pesan' => "success",
						'total_harga' => "$cek->standar_harga",
					);
					echo json_encode($result);
				}
				
			} else {
				$result = array(
					'status' => "0",
					'pesan' => "Jarak tidak boleh melebihi $cek->max_km KM"
				);
				echo json_encode($result);
			}
		}

	}

	public function set_status_driver()
	{
		if ($_GET) {
			$id = $this->input->get('id_user');
			$update = $this->db->query("UPDATE data_driver SET status_online='0' WHERE id_user='$id'");
			if ($update) {
				echo "berhasil update $id";
			}
			exit();
		}
		$update = $this->db->query("UPDATE data_driver SET status_online='0'");
		if ($update) {
			echo "berhasil update";
		}
	}

	public function set_online_driver()
	{
		if ($_POST) {
			$id = $this->input->post('id_user');
			$update = $this->db->query("UPDATE data_driver SET status_online='1' WHERE id_user='$id'");
			if ($update) {
				echo "berhasil update online $id";
			}
			exit();
		}
	}

	public function order()
	{
		if ($_POST) {
			$customer = $this->input->post('customer');
			$originlat = $this->input->post('originlat');
			$originlng = $this->input->post('originlng');
			$destinationlat = $this->input->post('destinationlat');
			$destinationlng = $this->input->post('destinationlng');
			$alamat_origin = $this->input->post('alamat_origin');
			$alamat_destination = $this->input->post('alamat_destination');
			$jarak = $this->input->post('jarak');
			$harga = $this->input->post('harga');
			$catatan = $this->input->post('catatan');
			$telp_penerima = $this->input->post('telp_penerima');
			$telp_pengirim = $this->input->post('telp_pengirim');
			$nama_penerima = $this->input->post('nama_penerima');
			$nama_pengirim = $this->input->post('nama_pengirim');
			$status = "0"; // 0 = open
			$id_jenis = $this->input->post('id_jenis');
			$jarak_driver = get_data('setting_layanan','id_jenis',$id_jenis,'jarak_driver');

			// cari driver terdekat
			$sql = "SELECT
						id_user,
						(
							6371 * acos(
								cos( radians( $originlat ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( $originlng ) ) + sin( radians( $originlat ) ) * sin( radians( lat ) ) 
							) 
						) AS distance 
					FROM
						data_driver 
					WHERE status_online='1' AND status_order='0'
					HAVING distance <= $jarak_driver
					 order by distance asc limit 1";
			$data_driver = $this->db->query($sql);
			if ($data_driver->num_rows() == 0) {
				$result = array(
					'status' => "0",
					'pesan' => "Driver tidak dapat ditemukan di lokasi terdekat"
				);
				echo json_encode($result);
				exit();
			} 
			$data_driver = $this->db->query($sql)->row();
			$driver = $data_driver->id_user;
			$jarak_driver = $data_driver->distance;
			$data = array(
				'customer' => $customer,
				'driver' => $driver,
				'origin' => "$originlat, $originlng",
				'destination' => "$destinationlat, $destinationlng",
				'alamat_origin' => $alamat_origin,
				'alamat_destination' => $alamat_destination,
				'jarak' => $jarak,
				'harga' => $harga,
				'catatan' => $catatan,
				'telp_pengirim' => $telp_pengirim,
				'telp_penerima' => $telp_penerima,
				'nama_pengirim' => $nama_pengirim,
				'nama_penerima' => $nama_penerima,
				'status' => $status,
				'id_jenis' => $id_jenis,
				'date_at' => get_waktu()

			);

			// push notifikasi ke driver
			$server_key = get_setting('server_fcm_driver');
			$token = get_data('users','id_user',$driver,'token_fcm');
			$title = "Ada Order Masuk";
			$body = "Hai Driver, ambil order kamu sekarang";
			$screen ="list_trx";
			$hasil = $this->send_notif($server_key,$token,$title, $body, $screen);
			$result = json_decode($hasil);



			// batas notifikasi
			
			if ($result->success == 1) {

				$simpan = $this->db->insert('order', $data);
				$this->db->where('id_user', $driver);
				$this->db->update('data_driver', array('status_order'=>'1'));
				

				$result = array(
					'status' => "1",
					'pesan' => "driver untukmu sudah ditemukan",
					'jarak_driver' => $jarak_driver
				);
				echo json_encode($result);
			} else {
				$result = array(
					'status' => "0",
					'pesan' => "driver tidak ditemukan atau sedang tidak bekerja"
				);
				echo json_encode($result);
			}



		}
	}

	public function get_slider()
	{
		$req = $this->input->post('req');
		$data = $this->db->get('slider', 3, 0);
		$result = array();

		foreach ($data->result() as $rw) {
			
			array_push($result, array(
				'image' => $rw->image,
			));
		}

		echo json_encode(array(
			'detailnya' => $result
		));
	}

	public function get_list_transaksi_user()
	{
		$id_user = $this->input->post('id_user');
			$tgl = date('Y-m-d');
			$result = array();
			$this->db->where('customer', $id_user);
			$this->db->like('date_at', $tgl, 'after');
			$this->db->order_by('id_order', 'desc');
			$data = $this->db->get('order');

			foreach ($data->result() as $rw) {
				$status = '';
				if ($rw->status == '0') {
					$status = "Open";
				} elseif ($rw->status == '1') {
					$status = "Sedang Menjemput";
				} elseif ($rw->status == '2') {
					$status = "Delivery";
				} elseif ($rw->status == '3') {
					$status = "Cancel";
				} elseif ($rw->status == '4') {
					$status = "Selesai";
				}

				$origin = explode(',', $rw->origin);
				$destination = explode(',', $rw->destination);



				array_push($result, array(
					'id_user_driver' => $rw->driver,
					'id_order' => $rw->id_order,
					'lat_origin' => $origin[0],
					'lng_origin' => $origin[1],
					'lat_destination' => $destination[0],
					'lng_destination' => $destination[1],
					'no_trx' =>'TR'.$rw->id_order,
					'jemput' => $rw->alamat_origin,
					'antar' => $rw->alamat_destination,
					'no_plat' => get_data('data_driver','id_user',$rw->driver,'no_plat'),
					'nama_driver' => get_data('users','id_user',$rw->driver,'nama_lengkap'),
					'ongkos' => "Rp. ".number_format($rw->harga),
					'status' => $status
				));
			}

			echo json_encode(array(
				'detailnya' => $result
			));
	}

	public function batalkan_order()
	{
		if ($_POST) {
			$id_order = $this->input->post('id_order');

			$status = get_data('order','id_order',$id_order,'status');
			$driver = get_data('order','id_order',$id_order,'driver');
			if ($status == '1' || $status == '2') {
				
				echo "order tidak bisa di batalkan karna sedang dalam proses";
				exit();
			}

			$this->db->where('id_order', $id_order);
			$update = $this->db->update('order', array('status'=>'3'));
			$this->db->where('id_user', $driver);
			$this->db->update('data_driver', array('status_order'=>'0'));
			if ($update) {
				$driver = get_data('order','id_order',$id_order,'driver');
				$server_key = get_setting('server_fcm_driver');
				$token = get_data('users','id_user',$driver,'token_fcm');
				$title = "Order dibatalkan";
				$body = "Hai Driver, order telah dibatalkan pelanggan";
				$screen ="list_trx";
				$this->send_notif($server_key,$token,$title, $body, $screen);

				echo "Order kamu berhasil di batalkan";
			} else {
				echo "ada kesalahan server";
			}
		}
	}

	public function get_list_transaksi_driver()
	{
		$id_user = $this->input->post('id_user');
			$tgl = date('Y-m-d');
			$result = array();
			$this->db->where('driver', $id_user);
			// $this->db->where('status !=', "4");
			$this->db->like('date_at', $tgl, 'after');
			$this->db->order_by('id_order', 'desc');
			$this->db->order_by('status', 'asc');
			$data = $this->db->get('order');

			foreach ($data->result() as $rw) {
				$status = '';
				if ($rw->status == '0') {
					$status = "Open";
				} elseif ($rw->status == '1') {
					$status = "Sedang Menjemput";
				} elseif ($rw->status == '2') {
					$status = "Delivery";
				} elseif ($rw->status == '3') {
					$status = "Cancel";
				} elseif ($rw->status == '4') {
					$status = "Selesai";
				}
				array_push($result, array(
					'id_order' => $rw->id_order,
					'no_trx' =>'TR'.$rw->id_order,
					'jemput' => $rw->alamat_origin,
					'antar' => $rw->alamat_destination,
					'jarak' => $rw->jarak,
					'origin' => $rw->origin,
					'destination' => $rw->destination,
					'catatan' => $rw->catatan,
					'telp_penerima' => $rw->telp_penerima,
					'telp_pengirim' => $rw->telp_pengirim,
					'nama_penerima' => $rw->nama_penerima,
					'nama_pengirim' => $rw->nama_pengirim,
					'nama_customer' => get_data('users','id_user',$rw->customer,'nama_lengkap'),
					'ongkos' => "Rp. ".number_format($rw->harga),
					'status' => $status
				));
			}

			echo json_encode(array(
				'detailnya' => $result
			));
	}

	public function update_lokasi_driver()
	{
		if ($_POST) {
			$id_user = $this->input->post('id_user');
			$lat = $this->input->post('lat');
			$lng = $this->input->post('lng');
			$bearing = $this->input->post('bearing');
			$this->db->where('id_user', $id_user);
			$update = $this->db->update('data_driver', array(
				'lat'=>$lat,
				'lng'=>$lng,
				'bearing'=>$bearing,
				'status_online' => '1'
			));
			if ($update) {
				echo json_encode(array(
					'status' => '1',
					'pesan' => 'lokasi driver update',
				));
			}
		}
	}

	public function dijemput()
	{
		if ($_POST) {
			$id_order = $this->input->post('id_order');
			$customer = get_data('order','id_order',$id_order,'customer');
			$nama_customer = get_data('users','id_user',$customer,'nama_lengkap');
			$this->db->where('id_order', $id_order);
			$update = $this->db->update('order', array('status'=>'1'));
			
			// push notifikasi ke customer
				$server_key = get_setting('server_fcm_customer');
				$token = get_data('users','id_user',$customer,'token_fcm');
				$title = "Driver sedang menuju ke lokasi";
				$body = "Hai $nama_customer, Driver sedang menuju ke lokasi";
				$screen ="detail_trx";
				$this->send_notif($server_key,$token,$title, $body, $screen);

				// batas notifikasi
			if ($update) {

				

				echo json_encode(array(
					'status' => '1',
					'pesan' => 'Driver menuju kelokasi jemput',
				));
			}
		}
	}

	public function update_profil_driver()
	{
		if ($_POST) {
			$id_user = $this->input->post('id_user');
			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			$no_telp = $this->input->post('no_telp');
			$password = $this->input->post('password');

			$data = array();

			if ($password != '') {
				$data = array(
					'nama_lengkap' => $nama,
					'no_telp' => $no_telp,
					'email' => $email,
					'password' => $password
				);
			} else {
				$data = array(
					'nama_lengkap' => $nama,
					'no_telp' => $no_telp,
					'email' => $email,
				);
			}

			$this->db->where('id_user', $id_user);
			$update = $this->db->update('users', $data);
			if ($update) {
				echo json_encode(array(
					'status' => '1',
					'pesan' => 'Data berhasil di ubah',
				));
			}


		}
	}

	public function update_profil_customer()
	{
		if ($_POST) {
			$id_user = $this->input->post('id_user');
			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			$no_telp = $this->input->post('no_telp');
			$password = $this->input->post('password');

			$data = array();

			if ($password != '') {
				$data = array(
					'nama_lengkap' => $nama,
					'no_telp' => $no_telp,
					'username' => $no_telp,
					'email' => $email,
					'password' => $password
				);
			} else {
				$data = array(
					'nama_lengkap' => $nama,
					'no_telp' => $no_telp,
					'username' => $no_telp,
					'email' => $email,
				);
			}

			$this->db->where('id_user', $id_user);
			$update = $this->db->update('users', $data);
			if ($update) {
				echo json_encode(array(
					'status' => '1',
					'pesan' => 'Data berhasil di ubah',
				));
			}


		}
	}

	public function diantar()
	{
		if ($_POST) {
			$id_order = $this->input->post('id_order');
			$customer = get_data('order','id_order',$id_order,'customer');
			$nama_customer = get_data('users','id_user',$customer,'nama_lengkap');
			$this->db->where('id_order', $id_order);
			$update = $this->db->update('order', array('status'=>'2'));

			// push notifikasi ke customer
			$server_key = get_setting('server_fcm_customer');
			$token = get_data('users','id_user',$customer,'token_fcm');
			$title = "Driver sedang antar paket kamu";
			$body = "Hai $nama_customer, Driver sedang antar paket kamu";
			$screen ="detail_trx";
			$this->send_notif($server_key,$token,$title, $body, $screen);

				// batas notifikasi

			if ($update) {
				echo json_encode(array(
					'status' => '1',
					'pesan' => 'Driver menuju kelokasi antar',
				));
			}
		}
	}

	public function order_selesai()
	{
		if ($_POST) {
			$id_order = $this->input->post('id_order');
			$customer = get_data('order','id_order',$id_order,'customer');
			$nama_customer = get_data('users','id_user',$customer,'nama_lengkap');
			$id_driver  = get_data('order','id_order',$id_order,'driver');
			$this->db->where('id_order', $id_order);
			$update = $this->db->update('order', array('status'=>'4'));

			$this->db->where('id_user', $id_driver);
			$this->db->update('data_driver', array('status_order'=>'0'));
			// push notifikasi ke customer
			$server_key = get_setting('server_fcm_customer');
			$token = get_data('users','id_user',$customer,'token_fcm');
			$title = "Driver sudah selesai mengantar paket kamu";
			$body = "Hai $nama_customer, Driver sudah selesai mengantar paket kamu";
			$screen ="detail_trx";
			$this->send_notif($server_key,$token,$title, $body, $screen);

				// batas notifikasi
			if ($update) {
				echo json_encode(array(
					'status' => '1',
					'pesan' => 'Order selesai',
				));
			}
		}
	}

	private function send_notif($server_key,$token,$title, $body, $screen)
	{
		# agar diparse sebagai JSON di browser
		header('Content-Type:application/json');

		# atur zona waktu sender server ke Jakarta (WIB / GMT+7)
		date_default_timezone_set("Asia/Jakarta");


		$headers = [
		'Content-Type:application/json',
		'Accept:application/json',
		'Authorization: key='.$server_key.''
		];


		// echo $post_raw_json;
		// exit();
		

		# Inisiasi CURL request
		$ch = curl_init();

		# atur CURL Options
		curl_setopt_array($ch, array(
		CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send', # URL endpoint
		CURLOPT_HTTPHEADER => $headers, # HTTP Headers
		CURLOPT_RETURNTRANSFER => 1, # return hasil curl_exec ke variabel, tidak langsung dicetak
		CURLOPT_FOLLOWLOCATION => 1, # atur flag followlocation untuk mengikuti bila ada url redirect di server penerima tetap difollow
		CURLOPT_CONNECTTIMEOUT => 60, # set connection timeout ke 60 detik, untuk mencegah request gantung saat server mati
		CURLOPT_TIMEOUT => 60, # set timeout ke 120 detik, untuk mencegah request gantung saat server hang
		CURLOPT_POST => 1, # set method request menjadi POST
		CURLOPT_POSTFIELDS => '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}', # attached post data dalam bentuk JSON String,
		// CURLOPT_VERBOSE => 1, # mode debug
		// CURLOPT_HEADER => 1, # cetak header
		CURLOPT_SSL_VERIFYPEER => true  
		));

		# eksekusi CURL request dan tampung hasil responsenya ke variabel $resp
		$resp = curl_exec($ch);

		# validasi curl request tidak error
		if (curl_errno($ch) == false) {
		# jika curl berhasil
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code == 200) {
		  # http code === 200 berarti request sukses (harap pastikan server penerima mengirimkan http_code 200 jika berhasil)
		//   return $resp;
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  
			$send = '{"notification": {"body": "'.$body.'","title": "'.$title.'","sound": "default","badge":"1"}, "priority": "high", "data": {"click_action": "FLUTTER_NOTIFICATION_CLICK", "screen": "'.$screen.'", "status": "done"}, "to": "'.$token.'"}';
			$this->db->insert('log_notif', array('log'=>$send,'resp'=>$resp));
			return $resp;
		}
		} else {
		# jika curl error (contoh: request timeout)
		# Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
		// echo "Error while sending request, reason:".curl_error($ch);
		}

		# tutup CURL
		curl_close($ch);
	}





}
