<?php
    if (has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url();
    } else {
        $image_url = DU_PLUGIN_URL . 'assets/images/placeholder.png';
    }
    $post_link = get_permalink();
?>
<div class="du-post-list-item">
    <a href="<?php echo $post_link ?>">
        <div class="inner-container-top" style="background-image: url(<?php echo $image_url ?>)">
            <?php if(is_sticky()) : ?><div class="sticky-icon"><img src="<?php echo DU_PLUGIN_URL; ?>assets/images/pin-solid.svg" class="du-icon"></div><?php endif; ?>
        </div>
        <div class="inner-container-bottom">
            <div class="post-title"><?php echo get_the_title(); ?></div>
            <div class="post-date"><wvicon class="icon-calendar"></wvicon> <?php echo get_the_date() ?></div>
            <div class="post-description"><?php echo get_the_excerpt() ?></div>
            <div class="post-bottom-gradient"></div>
            <div class="post-button"><wvicon class="icon-arrow-right-circle"></wvicon></div>
        </div>
    </a>
</div>