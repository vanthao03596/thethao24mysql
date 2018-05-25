<?php
$input_old_password = array(
    'name' => 'old_password',
    'type' => 'password',
    'value' => '',
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_new_password = array(
    'name' => 'new_password',
    'type' => 'password',
    'value' => '',
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_renew_password = array(
    'name' => 'renew_password',
    'type' => 'password',
    'value' => '',
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$buttonLogin = array(
    'name' => 'btnSave',
    'type' => 'submit',
    'class' => 'btn btn-info pull-right',
    'content' => 'Lưu lại'
);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title info-box-text">Cập nhật mật khẩu Admin</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php if($this->session->flashdata('loginErrorMsg')): ?>
                        <ul>
                            <li style="color: red">
                                <?php echo $this->session->flashdata('loginErrorMsg'); ?>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <?php $attributes = array('class' => 'form-horizontal');
            echo form_open(base_url().'index.php/backend/setting/changePasswordAdmin/'.$admin[0]['_id'], $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tài khoản</label>
                    <div class="col-sm-4">
                        <?php echo $admin[0]['username']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Mật khẩu cũ</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_old_password); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('old_password', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Mật khẩu mới</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_new_password); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('new_password', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Xác nhận Mật khẩu mới</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_renew_password); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('renew_password', '<div class="error">', '</div>');}?>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url().'index.php/backend/setting/listAdmin'?>">
                    <button type="button" class="btn btn-default">Danh sách</button>
                </a>
                <?php echo form_button($buttonLogin); ?>
            </div><!-- /.box-footer -->
            <!--</form>-->
            <?php echo form_close(); ?>
        </div>
    </div><!-- /.col -->
</div>