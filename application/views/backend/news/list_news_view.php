<div class="row">
    <div style="text-align: center" id="data-loading">
        <i class="fa fa-refresh fa-spin bigger-200"></i>Đang tải dữ liệu...
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
                        <div class="form-group">
                            <label>Tìm theo Chủ đề</label>
                            <select class="form-control" name="select-category" id="select-category">
                                <option value="">-- Tất cả --</option>
                                <?php if(count($listNewsTopic) > 0):
                                    foreach($listNewsTopic as $keyNewsTopic => $valNewsTopic): ?>
                                    <option value="<?php echo $keyNewsTopic; ?>"><?php echo MyHelper::truncate($valNewsTopic, 20); ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-3">
                        <label>Tìm theo tiêu đề</label>
                        <input type="text" class="form-control" id="input-name" placeholder="Nhập tiêu đề">
                    </div>
                </div>
                <div id="div-ajax-gift-items"></div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url()?>index.php/backend/news/addNews">
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

        var url = '<?php echo base_url()."index.php/backend/news/listNewsAjax"; ?>';

        // Tim kiem theo danh muc
        loadDataByAjaxFromSelectBox("select-category", url);
        loadDataByAjaxFromSelectBox("select-type", url);

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
        var filterByTopic = $('#select-category').val();
        var filterByType = $('#select-type').val();
        var filterByName = $('#input-name').val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByTopic: filterByTopic,
                filterByType: filterByType,
                filterByName: filterByName
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-gift-items').html(data);
                $('#data-loading').hide();
            }
        });
    }

    //Ham chung cho cac SelectBox
    function loadDataByAjaxFromSelectBox(id, url){
        $('#'+id).change(function(){
            $('#data-loading').show();
            var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
            var filterByTopic = $('#select-category').val();
            var filterByType = $('#select-type').val();
            var filterByName = $('#input-name').val();
            //Ajax ve bieu do
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    csrf_name: csrf_value,
                    filterByTopic: filterByTopic,
                    filterByType: filterByType,
                    filterByName: filterByName
                },
                dataType: "text",
                cache: false,
                success: function(data){
                    $('#div-ajax-gift-items').html(data);
                    $('#data-loading').hide();
                }
            });
        });
    }

    function changePagination(pageId) {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var url = '<?php echo base_url()."index.php/backend/news/listNewsAjax"; ?>';
        var filterByTopic = $('#select-category').val();
        var filterByType = $('#select-type').val();
        var filterByName = $("#input-name").val();
        //Ajax ve bieu do
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_name: csrf_value,
                filterByTopic: filterByTopic,
                filterByType: filterByType,
                filterByName: filterByName,
                pageId: pageId
            },
            dataType: "text",
            cache: false,
            success: function(data){
                $('#div-ajax-gift-items').html(data);
                $('#data-loading').hide();
            }
        });
    }

    function viewDetails(id) {
        $.ajax({
            url: '<?php echo base_url()."index.php/backend/news/viewNewsAjax" ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name() ?>: "<?php echo $this->security->get_csrf_hash(); ?>"
            },
        })
        .done(function(result) {
            //alert(result);
            $("body").append(result);
        });
    }

    function SK_closeWindow () {
        $(".window-container").remove(), $(document.body).css("overflow", "auto");
    }

</script>
