
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('a_user/create'),'Create', 'class="btn btn-primary"'); ?>
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
        <th>Nama Lengkap</th>
        <th>Username</th>
        <th>Level</th>
        <th>Foto</th>
      
        <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $a_user_data = $this->db->get('users');
            foreach ($a_user_data->result() as $a_user)
            {
                ?>
                <tr>
            <td width="80px"><?php echo ++$start ?></td>
            <td><?php echo $a_user->nama_lengkap ?></td>
            <td><?php echo $a_user->username ?></td>
            <td><?php echo $a_user->level ?></td>
            <td><img src="image/user/<?php echo $a_user->foto ?>" style="width: 100px;"></td>
            <td style="text-align:center" width="200px">
                <?php 
                echo anchor(site_url('a_user/update/'.$a_user->id_user),'<span class="label label-info">Ubah</span>'); 
                echo ' | '; 
                echo anchor(site_url('a_user/delete/'.$a_user->id_user),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                ?>
            </td>
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
    