<?php
$CI = & get_instance();
$urlController = $CI->router->fetch_class();
$urlAction = $CI->router->fetch_method();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta http-equiv="refresh" content="20">-->
    <title><?php echo $titlePage;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.png" sizes="24x24" type="image/png"/>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>font-awesome/4.2.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="<?php /*echo base_url().'public/'*/?>ionicons/2.0.1/css/ionicons.min.css">-->

    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Bootstrap datetime picker -->
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url().'public/'?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>dist/css/pagination.css">

    <link rel="stylesheet" href="<?php echo base_url().'public/' ?>backend/be_update.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'public/' ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().'public/' ?>bootstrap/js/bootstrap.min.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url()?>home/index" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>CMS</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>CMS</b> Thethao24</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url().'public/' ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Hi, <?php
                                if($this->session->userdata('admin_email')){
                                    echo $this->session->userdata('admin_email');
                                }else{
                                    redirect(base_url('backend/account/login'));
                                } ?>
                            </span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?php echo base_url().'public/' ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    <?php if($this->session->userdata('admin_fullname')){echo $this->session->userdata('admin_fullname');}else{echo  'DCV Team';} ?>
                                    <small><?php if($this->session->userdata('admin_email')){echo $this->session->userdata('admin_email');}else{echo  'DCV Email';} ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer" style="background-color: #D2CE4F">
                                <div class="pull-left">
                                    <a href="<?php echo base_url('index/changePassword').'/'.$this->session->userdata('admin_id')?>" class="btn btn-default btn-flat">Đổi mật khẩu</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url()?>index/logout" class="btn btn-danger btn-flat" onclick="return confirm('Bạn có chắc chắn muốn thoát không?')">Đăng xuất</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- search form -->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <!--<li class="header">MAIN NAVIGATION</li>-->

                <li class="<?php echo (in_array($urlController, array('home')) && in_array($urlAction, array('index', ''))) ? 'active' : ''  ?>">
                    <a href="<?php echo base_url()?>backend/home/index">
                        <i class="fa fa-home"></i> <span>Trang chủ</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview <?php echo (in_array($urlController, array('setting'))) ? 'active' : ''  ?>">
                    <a href="#">
                        <i class="fa fa-sun-o"></i> <span>Hệ thống</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (in_array($urlController, array('setting')) && in_array($urlAction, array('listAdmin', 'addAdmin', 'editAdmin', 'changePasswordAdmin', 'assignAdminAction'))) ? 'active' : ''  ?>">
                            <a href="<?php echo base_url('backend/setting/listAdmin')?>"><i class="fa fa-circle-o"></i> QL Admin</a>
                        </li>
                    </ul>
                </li>
                 <li class="treeview <?php echo (in_array($urlController, array('news'))) ? 'active' : ''  ?>">
                    <a href="#">
                        <i class="fa fa-sun-o"></i> <span>News</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (in_array($urlController, array('news')) && in_array($urlAction, array('listNews', 'editNews', 'addNews'))) ? 'active' : ''  ?>">
                            <a href="<?php echo base_url('backend/news/listNews')?>"><i class="fa fa-circle-o"></i> News</a>
                        </li>
                        <li class="<?php echo (in_array($urlController, array('news')) && in_array($urlAction, array( 'listNewsTopic', 'addNewsTopic', 'editNewsTopic'))) ? 'active' : ''  ?>">
                            <a href="<?php echo base_url('backend/news/listNewsTopic')?>"><i class="fa fa-circle-o"></i> Topics New</a>
                        </li>
                            
                            

                    </ul>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <p style="margin: 0px"><i class="fa fa-home"></i> CMS <?php echo ($breadCrumb)?$breadCrumb:''; ?></p>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php $this->load->view($loadPage); ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2018 by VAS.R&D Team</strong>.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
<!-- ./wrapper -->


<!-- FastClick -->
<script src="<?php echo base_url().'public/' ?>plugins/fastclick/fastclick.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url().'public/' ?>dist/js/app.min.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url().'public/' ?>plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?php echo base_url().'public/' ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url().'public/' ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url().'public/'?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url().'public/'?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url().'public/'?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url().'public/'?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Bootstrap datetime picker -->
<script src="<?php echo base_url('public/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js')?>"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url().'public/' ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>

<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url().'public/' ?>plugins/chartjs/Chart.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url().'public/' ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'public/' ?>fckeditor/ckeditor/ckeditor.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url().'public/' ?>dist/js/demo.js"></script>

</body>
</html>
