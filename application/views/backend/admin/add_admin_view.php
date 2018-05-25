<?php
$input_fullname = array(
    'name' => 'fullname',
    'type' => 'text',
    'value' => $fullname,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_username = array(
    'name' => 'username',
    'type' => 'text',
    'value' => $username,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_password = array(
    'name' => 'password',
    'type' => 'password',
    'value' => $password,
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_repassword = array(
    'name' => 'repassword',
    'type' => 'password',
    'value' => $repassword,
    'placeholder' => '',
    'autocomplete' => 'off',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_email = array(
    'name' => 'email',
    'type' => 'email',
    'value' => $email,
    'placeholder' => '',
    'autocomplete' => 'on',
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
                <h3 class="box-title info-box-text">Thêm mới Admin</h3>
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
            echo form_open(base_url().'index.php/backend/setting/addAdmin', $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Họ và tên</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_fullname); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('fullname', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tài khoản</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_username); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('username', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Mật khẩu</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_password); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('password', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Xác nhận Mật khẩu</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_repassword); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('repassword', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_email); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('email', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Kích hoạt không?</label>
                    <div class="col-sm-4">
                        <input name="is_active" type="checkbox" <?php if($is_active == 'on') echo 'checked' ?>>
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

<script type="text/javascript" src="<?php echo base_url().'public/fckeditor/ckfinder/'?>ckfinder.js"></script>
<script type="text/javascript">
    function browseServer() {
        var finder = new CKFinder();
        finder.selectActionFunction = setFileField;
        finder.popup();
    }
    function setFileField(fileUrl) {
        $('#image_path').val(fileUrl);
    }
</script>
<script>
    $(document).ready(function() {
        $('#from_to').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'YYYY/MM/DD H:mm:ss',
            locale: {
                applyLabel: 'Chọn',
                cancelLabel: 'Hủy'
            },
            minDate: '<?php echo date('Y/m/d 00:00:00', time())?>'
        });
    });
</script>