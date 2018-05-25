<div class="Box">
    <div class="Title">
        <div class="Title_left">
            <h1>
                <?php echo $titlePage; ?>
            </h1>
        </div>
        <div class="Title_right">
            <img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-title.png">
        </div>
    </div>

    <form name="frmList" method="post" style="margin: 0;">
        <input type="hidden" name="skip" id="skip" value="0">


        <div class="ND">
            <?php if(!empty($list_news)) :?>
            <a href="<?php echo base_url($list_news[0]['slug'])  . '.html'; ?>">
                <img src="<?php echo base_url($list_news[0]['image_path']) ?>"  class="images">
            </a>
            <p>
                <a href="<?php echo base_url($list_news[0]['slug']) . '.html'; ?>">
                    <?php echo $list_news[0]['title'];?>
                </a>
            </p>
            <?php endif; ?>
        </div>

        <div class="ND_news">
            <ul id="addMore">
            <?php if(!empty($list_news)) :?>
                <?php for ($i=1; $i < count($list_news) ; $i++) : ?>
                <li>
                <div class="ND_news_img">
                    <a href="<?php echo base_url($list_news[$i]['slug']) . '.html'; ?>">
                    <img src="<?php echo base_url($list_news[$i]['image_path']) ?>"  class="images">
                    </a>
                </div>
                <div class="ND_news_text">
                    <h3>
                    <a href="<?php echo base_url($list_news[$i]['slug']) . '.html'; ?>">
                        <?php echo $list_news[$i]['title'];?>
                    </a>
                    </h3>
                    <p><?php echo date('H:i', strtotime($list_news[$i]['created_at'])) . ' | ' . date('d.m.Y', strtotime($list_news[$i]['created_at']));?></p>
                </div>
                <div class="both"></div>
                </li>
                <?php endfor; ?>
            <?php endif; ?>
            </ul>
        </div>

        <div class="More">
            <a style="cursor: pointer;" id="btnAdd">XEM THÊM</a>
            <div id="loadingMsg" style="display: none;">Đang tải dữ liệu...</div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $(document).on("click", "#btnAdd", function () {
                    var skipVal = (parseInt($('#skip').val()) + 1);
                    var keyword = "<?php echo $keyword; ?>" ;
                    $('#skip').val(skipVal);
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url('news/searchAjax')?>",
                        data: {
                            skip: skipVal,
                            keyword : keyword
                        },
                        beforeSend: function () {
                            $("#btnAdd").hide();
                            $("#loadingMsg").show();
                        },
                        success: function (result) {
                            result = result.replace(/^\s+|\s+$/g, '');
                            if (result === null || result === "") {
                                $("#btnAdd").hide();
                                $("#loadingMsg").hide();
                            } else {
                                $("#btnAdd").show();
                                $("#loadingMsg").hide();
                                $("#addMore").append(result);
                            }
                        }
                    });
                });
            });
        </script>
    </form>
</div>