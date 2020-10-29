<?php 
$id = $this->session->userdata('id_user');
$rw = $this->db->get_where('users', array('id_user'=>$id))->row();
 ?>
<div class="row">
	<div class="col-md-12">
		<form action="" method="POST">
			<div class="form-group">
				<label>Nama Lengkap</label>
				<input type="text" name="nama" class="form-control" value="<?php echo $rw->nama_lengkap ?>">
			</div>

			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $rw->username ?>">
			</div>
			<div class="form-group">
				<label>password</label>
				<input type="text" name="password" class="form-control">
				<div>
	                *) Kosongkan, jika tidak dirubah
	            </div>
	            <input type="hidden" name="password_old" value="<?php echo $rw->password ?>">
			</div>
			<div class="form-group">
				<label>No Telp</label>
				<input type="text" name="no_telp" class="form-control" value="<?php echo $rw->no_telp ?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" class="form-control" value="<?php echo $rw->email ?>">
			</div>
			<div class="form-group">
				<label>Foto</label>
				<input type="file" name="foto" class="form-control">
				<input type="hidden" name="foto_old" value="<?php echo $rw->foto ?>">
				<div>
	                <?php if ($rw->foto != ''): ?>
	                    <b>*) Foto Sebelumnya : </b><br>
	                    <img src="image/user/<?php echo $rw->foto ?>" style="width: 100px;">
	                <?php endif ?>
	            </div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info">Update Profil</button>
			</div>
		</form>
	</div>
</div>