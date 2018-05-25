<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th style="text-align: center">TT</th>
            <th style="text-align: center;">Ảnh đại diện</th>
            <th style="text-align: center;">Tên chủ đề</th>
            <th style="text-align: center;">Trạng thái</th>
            <th style="text-align: center;">Người tạo</th>
            <th style="text-align: center;">Ngày cập nhật</th>
            <th style="text-align: center;">Xử lý</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($listNewsTopic) > 0):
            foreach($listNewsTopic as $key => $valNewsTopic): ?>
                <tr>
                    <td style="text-align: center"><?php echo ($key+1+$offset); ?></td>
                    <td>
                        <img src="<?php echo MyHelper::getImageSrcFromDB(base_url(), $valNewsTopic['image_path']) ?>" style="max-width: 80px; max-height: 60px">
                    </td>
                    <td title="<?php echo $valNewsTopic['name']; ?>">
                        <?php echo MyHelper::truncate($valNewsTopic['name'], 50); ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        if($valNewsTopic['is_active'] == true){
                            echo '<span class="label label-success">' . 'Hoạt động'.'</span>';
                        }else{
                            echo '<span class="label label-danger">'. 'Tạm dừng' .'</span>';
                        }?>
                    </td>
                    <td><?php echo MyHelper::getParentsName($listAdminName, $valNewsTopic['created_by']); ?></td>
                    <td style="text-align: center">
                        <?php echo MyHelper::reFormatDate($valNewsTopic['updated_at']); ?>
                    </td>
                    <td style="text-align: center">
                        <a href="<?php echo base_url().'index.php/backend/news/editNewsTopic/'.$valNewsTopic['_id']; ?>" title="Click để Cập nhật">
                            <i class="fa fa-edit"></i>
                        </a>&nbsp;
                        <?php
                        if($valNewsTopic['is_active'] == true): ?>
                            <a href="<?php echo base_url().'index.php/backend/news/changeIsActiveNewsTopic/0/'.$valNewsTopic['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn khóa không?')" title="'Click để Khoá'">
                                <i class="fa fa-lock"></i>
                            </a>&nbsp;
                        <?php else: ?>
                            <a href="<?php echo base_url().'index.php/backend/news/changeIsActiveNewsTopic/1/'.$valNewsTopic['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn mở khóa không?')" title="Click để Mở khóa">
                                <i class="fa fa-unlock"></i>
                            </a>&nbsp;
                        <?php endif ?>
                        <a href="<?php echo base_url().'index.php/backend/news/deleteNewsTopic/'.$valNewsTopic['_id']; ?>"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" title="Click để Xóa">
                            <i class="fa fa-remove color-red"></i>
                        </a>
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
