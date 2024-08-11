<?php 
global $post;
$thumbsize = !isset($args['thumbsize']) ? nerf_get_config( 'blog_item_thumbsize', 'full' ) : $args['thumbsize'];
$thumb = nerf_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout'); ?> style="padding: 10px;background: white;border:1px solid #005388">
    <div class="post-grid-v3" style="margin-bottom: 20px; font-size: 14px;">
        <?php
        if ( !empty($thumb) ) {
            ?>
            <div class="top-image position-relative" style="margin-bottom: 10px">
                <div class="date-bottom d-flex align-items-center" style="display:none !important">
                    <div class="day"><?php the_time('d'); ?></div>
                    <div class="ms-auto"><?php the_time('M'); ?></div>
                </div>
                <?php
                    echo trim($thumb);
                ?>
             </div>
            <?php
        } ?>
        <div style="display:<?php echo has_term('', 'danh_muc_thong_tin_su_kien') ? 'none' : 'flex' ?>;justify-content: space-between;align-items: center;">
            <div style="font-weight:bold">DTMB: <?php echo get_field('dien-tich-mat-bang'); ?>m²</div>
            <div style="font-weight:bold">DTSD: <?php echo get_field('dien-tich-su-dung'); ?>m²</div>
        </div>
        <div style="display:flex;justify-content: space-between; margin:5px 0px 8px 0px;align-items: center;">
            <div class="col-xs-5 lprice" bis_skin_checked="1">
                <?php nerf_post_categories_first($post); ?>
            </div>
            <div class="col-xs-7 rprice" style="background: #005388; border-radius: 5px; padding: 3px 10px; color: white; font-weight: 600;" bis_skin_checked="1">
                Giá: <?php echo get_field('gia'); ?>
            </div>
        </div>
        <?php if (get_the_title()) { ?>
            <h5 class="entry-title" style="font-size: 18px; line-height:1.3">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h5>
            <div style="font-size: 12px; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                    <?php
                        echo apply_filters( 'the_excerpt', get_the_excerpt() );
                    ?>
                </div>
        <?php } ?>
    </div>
</article>