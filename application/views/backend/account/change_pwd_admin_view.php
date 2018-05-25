<?php
$input_old_password = array(
    'name' => 'old_password',
    'type' => 'password',
    'value' => $old_password,
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'class' => 'form-control'
);

$input_new_password = array(
    'name' => 'new_password',
    'type' => 'password',
    'value' => '',
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '32',
    'minlength' => '8',
    'class' => 'form-control'
);

$input_repassword = array(
    'name' => 'repassword',
    'type' => 'password',
    'value' => '',
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
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
                <h3 class="box-title info-box-text">Đổi mật khẩu</h3>
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
            echo form_open(base_url().'partner/account/changePassword/'.$admin_id, $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
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
                        <?php echo form_input($input_repassword); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('repassword', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-4">
                        <p>(Chú ý: Mật khẩu bao gồm các ký tự: a-z,A-Z,0-9,._@#%&*)</p>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <?php echo form_button($buttonLogin); ?>
            </div><!-- /.box-footer -->
            <!--</form>-->
            <?php echo form_close(); ?>
        </div>
    </div><!-- /.col -->
</div>