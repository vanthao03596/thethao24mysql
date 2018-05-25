<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th style="text-align: center">TT</th>
            <th style="text-align: center;">Ảnh</th>
            <th style="text-align: center;">Tiêu đề tin tức</th>
            <th style="text-align: center;">Tên chủ đề</th>
            <th style="text-align: center">Trạng thái</th>
            <th style="text-align: center">Viết bởi</th>
            <th style="text-align: center">Ngày cập nhật</th>
            <th style="text-align: center">Xử lý</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($listGift) > 0):
            foreach($listGift as $key => $valGift): ?>
                <tr>
                    <td style="text-align: center"><?php echo ($key+1+$offset); ?></td>
                    <td style="text-align: center">
                        <a href="#" onclick="viewDetails('<?php echo $valGift['_id']; ?>')">
                            <img src="<?php echo MyHelper::getImageSrcFromDB(base_url(), $valGift['image_path']) ?>" style="max-width: 80px; max-height: 60px">
                        </a>
                    </td>
                    <td title="<?php echo $valGift['title']; ?>">
                        <?php echo MyHelper::truncate($valGift['title'], 50); ?>
                    </td>
                    <td>
                        <?php echo MyHelper::getParentsName($listNewsTopicName, $valGift['topic_id']); ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        if($valGift['is_active'] == true){
                            echo '<span class="label label-success">'.'Hoạt động'.'</span>';
                        }else{
                            echo '<span class="label label-danger">'.'Tạm dừng'.'</span>';
                        }?>
                    </td>
                    <td>
                        <?php echo MyHelper::getParentsName($listAdminName, $valGift['created_by']); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo MyHelper::reFormatDate($valGift['updated_at'], 'd/m/Y'); ?>
                    </td>
                    <td style="text-align: center">
                        <a href="<?php echo base_url().'index.php/backend/news/editNews/'.$valGift['_id']; ?>" title="Click để Cập nhật">
                            <i class="fa fa-edit"></i>
                        </a>&nbsp;
                        <?php
                        if($valGift['is_active'] == true): ?>
                            <a href="<?php echo base_url().'index.php/backend/news/changeIsActiveNews/0/'.$valGift['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn khóa không?')" title="Click để Khoá">
                                <i class="fa fa-lock"></i>
                            </a>&nbsp;
                        <?php else: ?>
                            <a href="<?php echo base_url().'index.php/backend/news/changeIsActiveNews/1/'.$valGift['_id']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn mở khóa không?')" title="Click để Mở khóa">
                                <i class="fa fa-unlock"></i>
                            </a>&nbsp;
                        <?php endif ?>
                        <a href="<?php echo base_url().'index.php/backend/news/deleteNews/'.$valGift['_id']; ?>"
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
                <td colspan="10" style="color: red">Không có dữ liệu nào</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- /.row -->
<div style="text-align: center;"><?php echo $pagination; ?></div>
