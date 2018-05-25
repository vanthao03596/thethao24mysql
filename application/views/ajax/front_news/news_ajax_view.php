<?php foreach ($list_news as $key => $new) : ?>
<li>
    <div class="ND_news_img">
        <a href="<?php echo base_url('nhan-dinh-bong-da') . $new['slug'] . '.html'; ?>">
        <img src="<?php echo base_url($new['image_path']) ?>"  class="images">
        </a>
    </div>
    <div class="ND_news_text">
        <h3>
            <a href="<?php echo base_url('nhan-dinh-bong-da') . $new['slug'] . '.html'; ?>">
            <?php echo $new['title'];?>
            </a>
        </h3>
        <p><?php echo date('H:i', strtotime( $new['created_at'])) . ' | ' . date('d.m.Y', strtotime( $new['created_at']));?></p>
    </div>
    <div class="both"></div>
</li>

<?php endforeach; ?>