<?php
$post_format = get_post_format();
global $post;
?>
<style>
    /* CSS để tạo slider */
.slider-container {
    background-color: #003a9b14;
    position: relative;
    max-width: 100%;
    overflow: hidden;
}

.slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    justify-content: center;
    display: flex;
    min-width: 100%;
    box-sizing: border-box;
}

.slide img {
    width: auto;
    height: auto;
    max-height: 600px;
    object-fit: cover;
}

@media only screen and (max-width: 768px) {
    .slide img {
        max-height: 300px;
    }
}

.prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1000;
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

.prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
}

</style>
<script>
    let currentSlide = 0;

function moveSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    document.querySelector('.slider').style.transform = `translateX(-${currentSlide * 100}%)`;
}

</script>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="inner">
        <div class="entry-content-detail <?php echo esc_attr((!has_post_thumbnail())?'not-img-featured':'' ); ?>">

            <div class="single-info">
                    <div class="top-detail-post mb-1">
                        <div class="container">
                            <div class="d-md-flex">
                                <div class="top-detail-info col-md-8 col-12 m-auto">
                                    <?php if (get_the_title()) { ?>
                                        <h1 class="detail-title fs-1" style="text-align: left; padding:0% 2%;">
                                            <?php the_title(); ?>
                                        </h1>
                                    <?php } ?>
                                    <div class="detail-post-info align-items-center"  style="display:none">
                                        <div class="d-flex align-items-center info-author">
                                            <div class="avatar-img">
                                                <?php echo get_avatar( get_the_author_meta( 'ID' ),40 ); ?>
                                            </div>
                                            <h4 class="author-title">
                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                                    <?php echo get_the_author(); ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="date"><?php the_time( get_option('date_format', 'd M, Y') ); ?></div>
                                        <?php nerf_post_categories($post); ?>
                                    </div>
                                    <?php if(get_field('slide')) : ?>
                                        <div class="slider-container">
                                            <div class="slider">
                                                <?php foreach(get_field('slide') as $key => $value) : ?>
                                                    <div class="slide">
                                                        <img src="<?php echo $value['url']; ?>" alt="Slide Image">
                                                    </div>
                                                <?php endforeach; ?> 
                                            </div>
                                            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                                            <button class="next" onclick="moveSlide(1)">&#10095;</button>
                                        </div>
                                    <?php else : ?> 
                                        <?php if(has_post_thumbnail()) { ?>
                                            <div class="entry-thumb text-center" style="padding:0% 2%;">
                                                <?php
                                                    $thumb = nerf_post_thumbnail();
                                                    echo trim($thumb);
                                                ?>
                                            </div>
                                        <?php } ?>
                                    <?php endif;?>
                                    <div class="container mt-3 p-md-3 p p-0">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td>Diện Tích Mặt Bằng</td>
                                                <td><?php echo get_field('dien-tich-mat-bang'); ?>m²</td>
                                            </tr>
                                            <tr>
                                                <td>Diện Tích Sử Dụng</td>
                                                <td><?php echo get_field('dien-tich-su-dung'); ?>m²</td>
                                            </tr>
                                            <tr>
                                                <td>Địa Chỉ</td>
                                                <td><?php echo get_field('dia-chi'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Giấy tờ</td>
                                                <td><?php echo get_field('giay-to'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Hướng</td>
                                                <td><?php echo get_field('huong'); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inner-detail">
                        <div class="entry-description">
                            <?php
                                the_content();
                            ?>
                        </div>
                        <?php
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'nerf' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'nerf' ) . ' </span>%',
                            'separator'   => '',
                        ) );
                        ?>
                    
                        <?php  
                            $posttags = get_the_tags();
                        ?>
                        <?php get_template_part( 'template-parts/author-bio' ); ?>
                        
                        <?php
                            //Previous/next post navigation.
                            the_post_navigation( array(
                                'next_text' => 
                                    '<div class="inner inner-right">'.
                                    '<div class="navi">' . esc_html__( 'Next', 'nerf' ) . '<i class="ti-angle-right"></i></div>'.
                                    '<span class="title-direct">%title</span></div>',
                                'prev_text' => 
                                    '<div class="inner inner-left">'.
                                    '<div class="navi"><i class="ti-angle-left"></i>' . esc_html__( 'Prev', 'nerf' ) . '</div>'.
                                    '<span class="title-direct">%title</span></div>',
                            ) );
                        ?>
                    </div>
            </div>
        </div>
    </div>
</article>