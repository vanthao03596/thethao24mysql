<div class="Box">
    <div class="Title">
        <div class="Title_left">
            <h2>
                NHẬN ĐỊNH
            </h2>
        </div>
        <div class="Title_right">
            <img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-title.png">
        </div>
    </div>

    <div class="ND">
        <?php if(!empty($nhandinh)): ?>
            <a href="<?php echo base_url($nhandinh[0]['slug'] . '.html')  ; ?>">
                <img src="<?php echo base_url($nhandinh[0]['image_path']) ?>"  class="images">
            </a>
            <p>
            <a href="<?php echo base_url($nhandinh[0]['slug'] ). '.html' ; ?>">
                    <?php echo $nhandinh[0]['title'];?>
                </a>
            </p>
        <?php endif; ?>
    </div>

    <div class="ND_news">
        <ul>
        <?php if(!empty($nhandinh)): ?>
            <?php
            for ($i=1; $i < count($nhandinh) ; $i++) : ?>
                <li>
                <div class="ND_news_img">
                    <a href="<?php echo base_url($nhandinh[$i]['slug']) . '.html'; ?>">
                    <img src="<?php echo base_url($nhandinh[$i]['image_path']) ?>"  class="images">
                    </a>
                </div>
                <div class="ND_news_text">
                    <h3>
                    <a href="<?php echo base_url( $nhandinh[$i]['slug']) .  '.html'; ?>">
                        <?php echo $nhandinh[$i]['title'];?>
                    </a>
                    </h3>
                    <p><?php echo date('H:i', strtotime( $nhandinh[$i]['created_at'])) . ' | ' . date('d.m.Y', strtotime( $nhandinh[$i]['created_at']));?></p>
                </div>
                <div class="both"></div>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        </ul>
    </div>

    <div class="More">
        <a href="<?php echo base_url('nhan-dinh-bong-da') . '.html'; ?>">XEM THÊM</a>
    </div>
</div>
<div class="Box">
    <div class="Title">
        <div class="Title_left">
            <h2>
                Tin tức
            </h2>
        </div>
        <div class="Title_right">
            <img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-title.png">
        </div>
    </div>

    <div class="ND">
        <?php if(!empty($tintuc)): ?>
            <a href="<?php echo base_url($tintuc[0]['slug'] ). '.html' ; ?>">
                <img src="<?php echo base_url($tintuc[0]['image_path']) ?>"  class="images">
            </a>
            <p>
                <a href="<?php echo base_url($tintuc[0]['slug'] ). '.html' ; ?>">
                    <?php echo $tintuc[0]['title'];?>
                </a>
            </p>
        <?php endif; ?>
    </div>

    <div class="ND_news">
        <ul>
        <?php if(!empty($tintuc)): ?>
            <?php
            for ($i=1; $i < count($tintuc) ; $i++) : ?>
                <li>
                <div class="ND_news_img">
                    <a href="<?php echo base_url($tintuc[$i]['slug'] ). '.html' ; ?>">
                    <img src="<?php echo base_url($tintuc[$i]['image_path']) ?>"  class="images">
                    </a>
                </div>
                <div class="ND_news_text">
                    <h3>
                    <a href="<?php echo base_url($tintuc[$i]['slug'] ). '.html' ; ?>">
                        <?php echo $tintuc[$i]['title'];?>
                    </a>
                    </h3>
                    <p><?php echo date('H:i', strtotime( $tintuc[$i]['created_at'])) . ' | ' . date('d.m.Y', strtotime( $nhandinh[$i]['created_at']));?></p>
                </div>
                <div class="both"></div>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        </ul>
    </div>

    <div class="More">
        <a href="<?php echo base_url('tin-tuc-bong-da') . '.html'; ?>">XEM THÊM</a>
    </div>
</div>
<div class="Box">
    <div class="Title">
        <div class="Title_left">
            <h2>
                Tip
            </h2>
        </div>
        <div class="Title_right">
            <img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-title.png">
        </div>
    </div>

    <div class="ND">
        <?php if(!empty($tip)): ?>
            <a href="<?php echo base_url($tip[0]['slug'] ). '.html' ; ?>">
                <img src="<?php echo base_url($tip[0]['image_path']) ?>"  class="images">
            </a>
            <p>
                <a href="<?php echo base_url('nhan-dinh-bong-da') . $tip[0]['slug']; ?>">
                    <?php echo $tip[0]['title'];?>
                </a>
            </p>
        <?php endif; ?>
    </div>

    <div class="ND_news">
        <ul>
        <?php if(!empty($tip)): ?>
            <?php
            for ($i=1; $i < count($tip) ; $i++) : ?>
                <li>
                <div class="ND_news_img">
                    <a href="<?php echo base_url($tip[$i]['slug'] ). '.html' ; ?>">
                    <img src="<?php echo base_url($tip[$i]['image_path']) ?>"  class="images">
                    </a>
                </div>
                <div class="ND_news_text">
                    <h3>
                    <a href="<?php echo base_url('nhan-dinh-bong-da') . $tip[$i]['slug'] . '.html'; ?>">
                        <?php echo $tip[$i]['title'];?>
                    </a>
                    </h3>
                    <p><?php echo date('H:i', strtotime( $tip[$i]['created_at'])) . ' | ' . date('d.m.Y', strtotime( $nhandinh[$i]['created_at']));?></p>
                </div>
                <div class="both"></div>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        </ul>
    </div>

    <div class="More">
        <a href="<?php echo base_url('tip') . '.html'; ?>">XEM THÊM</a>
    </div>
</div>