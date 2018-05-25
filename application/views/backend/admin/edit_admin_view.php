<?php
$input_fullname = array(
    'name' => 'fullname',
    'type' => 'text',
    'value' => ($admin[0]['fullname']) ? $admin[0]['fullname'] : $fullname,
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
                <h3 class="box-title info-box-text">Cập nhật Admin</h3>
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
            echo form_open(base_url().'index.php/backend/setting/editAdmin/'.$admin[0]['_id'], $attributes);
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
                        <?php echo $admin[0]['username']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-4">
                        <?php echo $admin[0]['email']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Kích hoạt không?</label>
                    <div class="col-sm-4">
                        <input name="is_active" type="checkbox" <?php if($admin[0]['is_active'] && $admin[0]['is_active'] == 1){ echo 'checked';}else{echo ($is_active == 'on') ? 'checked' : '';}  ?>>
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
