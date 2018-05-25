<?php
$input_name = array(
    'name' => 'name',
    'type' => 'text',
    'value' => $name,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_image_path = array('name' => 'image_path','type' => 'text','value' => $image_path,
    'maxlength' => '255','minlength' => '2','readonly' => true,'id' => 'image_path','class' => 'form-control');

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
                <h3 class="box-title info-box-text">Thêm mới Chủ đề</h3>
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
            echo form_open(base_url().'index.php/backend/news/addNewsTopic', $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tên chủ đề</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_name); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if(validation_errors()){echo form_error('name', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Ảnh đại diện</label>
                    <div class="col-sm-4">
                        <?php echo form_input($input_image_path); ?>
                    </div>
                    <div class="col-sm-4">
                        <label class="btn btn-buy" onclick="browseServer();">
                            <i class="fa fa-fw fa-image"></i>
                        </label>
                        <?php if(validation_errors()){echo form_error('image_path', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Kích hoạt không ?</label>
                    <div class="col-sm-4">
                        <input name="is_active" type="checkbox" <?php if($is_active == 'on') echo 'checked' ?>>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url().'index.php/backend/news/listNewsTopic'?>">
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
