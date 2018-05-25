<?php
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
                <h3 class="box-title info-box-text">Cập nhật gán quyền</h3>
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
            echo form_open(base_url().'index.php/backend/setting/assignAdminAction/'.$admin_id, $attributes);
            ?>
            <!--<form class="form-horizontal">-->
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Họ và tên</label>
                    <div class="col-sm-4">
                        <?php echo $admin_info[0]['fullname'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Tài khoản</label>
                    <div class="col-sm-4">
                        <?php echo $admin_info[0]['email']; ?>
                    </div>
                </div>
                <hr>
                <?php if(count($listActionByController) > 0): ?>
                <?php foreach($listActionByController as $keyAction => $arrAction): ?>
                        <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $listController[$keyAction] ?></label>
                    <div class="col-sm-8">
                        <div class="row">
                            <?php if(count($arrAction) > 0): ?>
                                <?php foreach($arrAction as $keyAction => $valAction): ?>
                            <div class="col-sm-4 checkbox">
                                <label title="<?php echo $valAction; ?>">
                                    <input type="checkbox" value="<?php echo $keyAction; ?>" name="actions[]" <?php if(is_array($listActions) && in_array($keyAction, $listActions)) echo 'checked' ?>>
                                    <?php echo MyHelper::truncate($valAction, 50); ?>
                                </label>
                            </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>

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
