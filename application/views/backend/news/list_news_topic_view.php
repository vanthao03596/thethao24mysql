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
                    <div class="col-md-3">
                        <label>Tìm theo tên</label>
                        <input type="text" class="form-control" id="input-name" placeholder="Nhập tên">
                    </div>
                </div>
                <div id="div-ajax-gift-category"></div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url()?>backend/news/addNewsTopic">
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

        var url = '<?php echo base_url()."backend/news/listNewsTopicAjax"; ?>';

        // Tìm kiếm theo SĐT
        var oldTimeout = '';
        $('#input-name').keyup(function(){
            clearTimeout(oldTimeout);
            oldTimeout = setTimeout(function(){
                loadDataByAjaxFromInput(url);
            }, 250);
        });

        // Xóa bộ lọc
        $('#delete-filter').click(function(){
            $("#input-name").val('');
            changePagination('0');
            return false;

        });
        changePagination('0');

    });
    //Ham chung cho cac input
    function loadDataByAjaxFromInput(url){
        $('#data-loading').show();
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var filterByName = $('#input-name').val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByName: filterByName
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-gift-category').html(data);
                $('#data-loading').hide();
            }
        });
    }

    function changePagination(pageId) {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var url = '<?php echo base_url()."backend/news/listNewsTopicAjax"; ?>';
        var filterByName = $("#input-name").val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByName: filterByName,
                pageId: pageId
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-gift-category').html(data);
                $('#data-loading').hide();
            }
        });
    }

</script>