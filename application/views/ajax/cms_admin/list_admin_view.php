<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th style="text-align: center">TT</th>
            <th style="text-align: center; min-width: 100px;">Tài khoản</th>
            <th style="text-align: center">Họ và tên</th>
            <th style="text-align: center">Email</th>
            <th style="text-align: center">Trạng thái</th>
            <th style="text-align: center">Ngày cập nhật</th>
            <th style="text-align: center">Xử lý</th>
        </tr>
        </thead>
        <tbody>
        <?php



        if(count($listUser) > 0):
            foreach($listUser as $key => $valUser): ?>
                <tr>
                    <td style="text-align: center">
                        <?php echo ($key+1+$offset); ?>
                    </td>
                    <td title="<?php echo $valUser['fullname']; ?>">
                        <?php echo $valUser['username']; ?>
                    </td>
                    <td><?php echo $valUser['fullname']; ?></td>
                    <td>
                        <?php echo $valUser['email']; ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        if($valUser['is_active'] == true){
                            echo '<span class="label label-success">Hoạt động</span>';
                        }else{
                            echo '<span class="label label-danger">Tạm dừng</span>';
                        }?>
                    </td>
                    <td style="text-align: center">
                        <?php echo (array_key_exists('updated_at', $valUser)) ? MyHelper::reFormatDate($valUser['updated_at']) : ''; ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($this->session->userdata('admin_id') == $valUser['_id']): ?>
                            <a href="<?php echo base_url().'index.php/backend/setting/editAdmin/'.$valUser['_id']; ?>" title="Click để Cập nhật">
                                <i class="fa fa-edit"></i>
                            </a>&nbsp;
                        <?php else: ?>
                            <?php if($this->session->userdata('admin_is_super') == 1): ?>
                                <a href="<?php echo base_url().'index.php/backend/setting/editAdmin/'.$valUser['_id']; ?>" title="Click để Cập nhật">
                                    <i class="fa fa-edit"></i>
                                </a>&nbsp;
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($this->session->userdata('admin_is_super') == 1): ?>
                            <?php if($valUser['is_active'] == true): ?>
                                <a href="<?php echo base_url().'index.php/backend/setting/changeIsActiveAdmin/0/'.$valUser['_id']; ?>"
                                   onclick="return confirm('Bạn có chắc chắn muốn khóa không?')" title="Click để Khoá">
                                    <i class="fa fa-lock"></i>
                                </a>&nbsp;
                            <?php else: ?>
                                <a href="<?php echo base_url().'index.php/backend/setting/changeIsActiveAdmin/1/'.$valUser['_id']; ?>"
                                   onclick="return confirm('Bạn có chắc chắn muốn mở khóa không?')" title="Click để Mở khóa">
                                    <i class="fa fa-unlock"></i>
                                </a>&nbsp;
                            <?php endif ?>
                            <a href="<?php echo base_url().'index.php/backend/setting/changePasswordAdmin/'.$valUser['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn thay đổi mật khẩu không?')" title="Click để thay đổi mật khẩu">
                                <i class="fa fa-refresh color-yellow"></i>
                            </a>&nbsp;
                            <a href="<?php echo base_url().'index.php/backend/setting/deleteAdmin/'.$valUser['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" title="Click để Xóa">
                                <i class="fa fa-remove color-red"></i>
                            </a>
                        <?php endif ?>
                    </td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="8" style="color: red">Không có dữ liệu nào!</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- /.row -->
<div style="text-align: center;"><?php echo $pagination; ?></div>