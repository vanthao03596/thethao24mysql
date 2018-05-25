<?php
$input_title = array(
    'name' => 'title',
    'type' => 'text',
    'value' => ($news[0]['title']) ? $news[0]['title'] : $title,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '255',
    'minlength' => '2',
    'class' => 'form-control'
);

$input_summary = array(
    'name' => 'summary',
    'type' => 'text',
    'value' => ($news[0]['summary']) ? $news[0]['summary'] : $summary,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '500',
    'minlength' => '2',
    'id' => 'summary',
    'class' => 'form-control'
);

$input_image_path = array('name' => 'image_path','type' => 'text','value' => ($news[0]['image_path']) ? $news[0]['image_path'] : $image_path,
    'maxlength' => '255','minlength' => '2','readonly' => true,'id' => 'image_path','class' => 'form-control');


$content = strip_tags(html_entity_decode($content), '<a><img><strong>');
$input_content = array(
    'name' => 'content',
    'type' => 'text',
    'value' => ($news[0]['content']) ? $news[0]['content'] : $content,
    'placeholder' => '',
    'autocomplete' => 'on',
    'maxlength' => '3000',
    'minlength' => '2',
    'id' => 'content',
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
                <h3 class="box-title info-box-text">Cập nhật Tin tức</h3>
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
            echo form_open(base_url().'index.php/backend/news/editNews/'.$news[0]['_id'], $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Thuộc chủ đề</label>
                    <div class="col-sm-8">
                        <?php $attr = 'class="form-control"';
                        echo form_dropdown('topic_id', $listNewsTopic, ($news[0]['topic_id']) ? $news[0]['topic_id'] : $topic_id, $attr);
                        ?>
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if(validation_errors()){echo form_error('topic_id', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tiêu đề tin tức</label>
                    <div class="col-sm-8">
                        <?php echo form_input($input_title); ?>
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if(validation_errors()){echo form_error('title', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Ảnh đại diện</label>
                    <div class="col-sm-8">
                        <?php echo form_input($input_image_path); ?>
                        <?php if($news[0]['image_path'] != ''): ?>
                            <br>
                            <img src="<?php echo MyHelper::getImageSrcFromDB(base_url(), $news[0]['image_path'])?>" style="max-width: 335px; max-height: 335px">
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-2">
                        <label class="btn btn-buy" onclick="browseServer();">
                            <i class="fa fa-fw fa-image"></i>
                        </label>
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if(validation_errors()){echo form_error('image_path', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nội dung tóm tắt</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea($input_summary); ?>
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if(validation_errors()){echo form_error('summary', '<div class="error">', '</div>');}?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nội dung chi tiết</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea($input_content); ?>
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if(validation_errors()){echo form_error('content', '<div class="error">', '</div>');}?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Kích hoạt không?</label>
                    <div class="col-sm-4">
                        <input name="is_active" type="checkbox" <?php if($news[0]['is_active'] && $news[0]['is_active'] == 1){ echo 'checked';}else{echo ($is_active == 'on') ? 'checked' : '';}  ?>>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url().'index.php/backend/news/listNews'?>">
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
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        //$("#summary").wysihtml5();
        CKEDITOR.replace('content');
    });
</script>
<script>
    $(document).ready(function(){
        $('#date_range').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'YYYY/MM/DD H:mm:ss',
            locale: {
                applyLabel: '<?php MyHelper::t('115_0005','Chọn') ?>',
                cancelLabel: '<?php MyHelper::t('115_0006','Hủy') ?>'
            },
            minDate: '<?php echo date('Y/m/d 00:00:00', time())?>'
        });
    });
</script>
