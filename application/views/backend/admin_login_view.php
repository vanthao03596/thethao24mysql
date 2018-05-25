<?php
$email = array(
    'name' => 'txtEmail',
    'type' => 'email',
    'value' => '',
    'placeholder' => 'Nhập email',
    'autocomplete' => 'off',
    'class' => 'form-control'
);
$password = array(
    'name' => 'txtPassword',
    'type' => 'password',
    'value' => '',
    'placeholder' => 'Nhập password',
    'autocomplete' => 'off',
    'class' => 'form-control'
);
$buttonLogin = array(
    'name' => 'btnLogin',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Đăng nhập'
);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="900">
    <title>Partner.dcv.vn | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.png" sizes="24x24" type="image/png"/>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>dist/css/AdminLTE.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>CMS</b> Thethao24</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Vui lòng, nhập đầy đủ thông tin!</p>
        <?php if($this->session->flashdata('loginErrorMsg')): ?>
        <ul>
            <li style="color: red">
                <?php echo $this->session->flashdata('loginErrorMsg'); ?>
            </li>
        </ul>
        <?php endif; ?>
        <?php
        echo validation_errors('<ul style="color: red">', '</ul>');
        echo form_open(base_url('backend/account/login'));
        ?>
            <div class="form-group has-feedback">
                <?php echo form_input($email); ?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo form_input($password); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                </div><!-- /.col -->
            </div>
        <?php echo form_close(); ?>
    </div><!-- /.login-box-body -->
    <div style="text-align: center;margin-top: 5px">
        <a href="http://dcv.vn" target="_blank">
            <img src="<?php echo base_url() ?>images/logo_dcv_71x35.png" width="60px">
        </a>
    </div>
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url().'public/'?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url().'public/'?>bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
