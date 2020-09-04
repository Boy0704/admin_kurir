<body onload="hide_and_show();">
    
</body>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="varchar">Nama Lengkap <?php echo form_error('nama_lengkap') ?></label>
            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $nama_lengkap; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Username <?php echo form_error('username') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="" />
            <div>
                *) Kosongkan, jika tidak dirubah
            </div>
            <input type="hidden" name="password_old" value="<?php echo $password ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Level <?php echo form_error('level') ?></label>
            <!-- <input type="text" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" /> -->
            <select name="level" id="level" class="form-control">
                <option value="<?php echo $level ?>"><?php echo $level ?></option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="driver">Driver</option>
            </select>
        </div>
        <div class="form-group">
            <label for="varchar">Foto <?php echo form_error('foto') ?></label>
            <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" value="<?php echo $foto; ?>" />
            <input type="hidden" name="foto_old" value="<?php echo $foto ?>">
            <div>
                <?php if ($foto != ''): ?>
                    <b>*) Foto Sebelumnya : </b><br>
                    <img src="image/user/<?php echo $foto ?>" style="width: 100px;">
                <?php endif ?>
            </div>
        </div>
        
        <div class="form-user-driver" id="form-user-driver">
            <div class="form-group">
                <label for="varchar">Jenis Kendaraan</label>
              

                <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control">
                <?php $select="";
                    if($jenis_kendaraan =="") {
                        $select="Select";
                    } else {
                        $select= $jenis_kendaraan;
                    }
                ?>
                <option value="<?=$jenis_kendaraan?>"><?php echo $select;?></option>
                <option value="mobil">Mobil</option>
                <option value="motor">Motor</option>
                </select>
            </div>
            <div class="form-group">
                <label for="varchar">No Plat</label>
                <input type="text" class="form-control" name="no_plat" id="no_plat" placeholder="No Plat" value="<?php echo $no_plat?>" />
            </div>
            <div class="form-group">
                <label for="varchar">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat?>" />
            </div>
        </div>
      

        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
        <a href="<?php echo site_url('a_user') ?>" class="btn btn-default">Cancel</a>
    </form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#level').change(function(){  
        
        var level = $('#level').val();
            if(level=="driver"){
                $('#form-user-driver').show();
            }else {
                $('#form-user-driver').hide();
            }
        });
});

function hide_and_show(){
    var level = $('#level').val();
    if(level=="driver"){
        $('#form-user-driver').show();
    }else if(level=="") {
        $('#form-user-driver').hide(); 
    }else {
        $('#form-user-driver').hide();
    } 
}
</script>
   