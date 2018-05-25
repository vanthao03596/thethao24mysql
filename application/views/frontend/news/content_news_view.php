<div class="Box">
    <?php if(!empty($new)): ?>
    <div class="Title">
        <div class="Title_left">
        </div>
        <div class="Title_right">
            <img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-title.png">
        </div>
    </div>
    <!-- Title -->
    <div class="Page_Diemtin_Tin_Title">
        <?php echo $new[0]['title']?>
        <p><?php echo date('H:i', strtotime($new[0]['created_at'])) . ' | ' . date('d.m.Y', strtotime($new[0]['created_at']));?></p>
    </div>

    <!-- Content -->
    <div class="Page_Diemtin_Tin_Content">
       <?php echo $new[0]['content']; ?>
    </div>
    <?php endif; ?>
    <!-- Tin khac -->
    <div class="Page_Diemtin_Tin_Content_more">
        <div class="Page_Diemtin_Tin_Content_more_title">
            <h2>
                Các tin khác
            </h2>
        </div>


        <?php if(!empty($news_related)) :?>
            <?php foreach($news_related as $new) :?>
            <div class="Page_Diemtin_Tin_Content_more_1">
                ●
                <h3>
                    <a href="<?php echo base_url($new['slug'] . '.html')?>">
                        <?php echo $new['title']?>
                    </a>
                </h3>
                <span>(<?php echo date('H:i', strtotime($new['created_at'])) . ' | ' . date('d.m.Y', strtotime($new['created_at']));?>)</span>
            </div>
            <?php endforeach ;?>
        <?php endif; ?>


    </div>
</div>