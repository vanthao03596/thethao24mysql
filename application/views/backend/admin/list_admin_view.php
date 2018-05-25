<div class="row">
    <div style="text-align: center" id="data-loading">
        <i class="fa fa-refresh fa-spin bigger-200"></i> Đang tải dữ liệu...
    </div>
    <?php if($this->session->flashdata('error')): ?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-ban"></i> <?php echo $this->session->flashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('notice')): ?>
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-warning"></i> <?php echo $this->session->flashdata('notice') ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('success')): ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row" style="margin-bottom: 5px">
                    <div class="col-md-2">
                        <label>Tìm theo tài khoản</label>
                        <input type="text" class="form-control" id="input-username" placeholder="Nhập tên, email">
                    </div>
                    <div class="col-md-2">
                        <label>Tìm theo trạng thái</label>
                        <select class="form-control" id="select-isactive">
                            <option value="">- Tất cả -</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Tạm dừng</option>
                        </select>
                    </div>
                </div>
                <div id="div-ajax-slideAds-items"></div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url()?>index.php/backend/setting/addAdmin">
                            <button class="btn btn-primary">Thêm mới</button>
                        </a>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

<script type="text/javascript">
    //Thuc hien viec ve bieu do
    $(document).ready(function() {
        $('#data-loading').hide();

        var url = '<?php echo base_url()."index.php/backend/setting/listAdminAjax"; ?>';

        // Tim kiem theo danh muc
        loadDataByAjaxFromSelectBox("select-isactive", url);

        // Tìm kiếm theo SĐT
        var oldTimeout = '';
        $('#input-username').keyup(function(){
            clearTimeout(oldTimeout);
            oldTimeout = setTimeout(function(){
                loadDataByAjaxFromInput(url);
            }, 250);
        });

        // Xóa bộ lọc
        $('#delete-filter').click(function(){
            $("#input-username").val('');
            changePagination('0');
            return false;

        });
        changePagination('0');

    });

    //Ham chung cho cac input
    function loadDataByAjaxFromInput(url){
        $('#data-loading').show();
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var filterByIsActive = $('#select-isactive').val();
        var filterByUserName = $('#input-username').val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByIsActive: filterByIsActive,
                filterByUserName: filterByUserName
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-slideAds-items').html(data);
                $('#data-loading').hide();
            }
        });
    }

    //Ham chung cho cac SelectBox
    function loadDataByAjaxFromSelectBox(id, url){
        $('#'+id).change(function(){
            $('#data-loading').show();
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
            var filterByIsActive = $('#select-isactive').val();
            var filterByUserName = $('#input-username').val();
            //Ajax ve bieu do
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    csrf_name: csrf_value,
                    filterByIsActive: filterByIsActive,
                    filterByUserName: filterByUserName
                },
                dataType: "text",
                cache: false,
                success: function(data){
                    $('#div-ajax-slideAds-items').html(data);
                    $('#data-loading').hide();
                }
            });
        });
    }

    function changePagination(pageId) {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var url = '<?php echo base_url()."index.php/backend/setting/listAdminAjax"; ?>';
        var filterByIsActive = $('#select-isactive').val();
        var filterByUserName = $("#input-username").val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByIsActive: filterByIsActive,
                filterByUserName: filterByUserName,
                pageId: pageId
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-slideAds-items').html(data);
                $('#data-loading').hide();
            }
        });
    }

</script>