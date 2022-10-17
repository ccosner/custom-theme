<?php

/**
 * The front page template file
 */
?>

<?php get_header();
$i = 1; ?>

<a href="#" id="scroll"></a>

<section class="section full-page site-intro" id="section_0">
    <div class="container-fluid container-heading">
        <div class="heading">
            <p>
            <span class="cc1">My name is </span>
            <span class="cc2">Christopher Cosner. </span>
            <span class="cc3">I’m a creative person working in information technology.</span>
            </p>
        </div>
        <div class="sub-heading">
            <p class="cc4">I've spent the past 13 years doing<br> <strong>Digital Art, UX/UI Design, Web Design, Web Development, & Branding.</strong></p>
        </div>
    </div>
    <div class="container-fluid container-bottom">
            <p class="cc5 look">Take a look at some of my work...</p>
        <div class="bottom">
            <span class="me1">Email</span> <span class="me2"><a href="mailto:me@christophercosner.com">me@christophercosner.com</a></span>
        </div>
    </div>
</section>

<?php if (have_rows('projects')) : while (have_rows('projects')) : the_row();

        $post_id = get_sub_field('project');

        $proj_intro = get_field('project_intro', $post_id);
        $proj_scope = get_field('project_scope', $post_id);
        $post_title = get_post_field('post_title', $post_id);
        $post_slug = get_post_field('post_name', $post_id);
        $p_bg_image = get_field('p_background_image', $post_id);
        $p_bg_video = get_field('p_background_video', $post_id);
        $p_logo = get_field('p_logo', $post_id);

?>
        <section class="section full-page split project-<?php echo $post_slug; ?>" id="<?php echo 'section_' . $i; ?>">
            <div class="split-col content">
                <div class="container-fluid fadeIn cssAnimate">
                    <h2 class="project-title"><?php echo $post_title; ?></h2>
                    <div class="project-scope"><?php echo $proj_scope; ?></div>
                    <div class="project-intro"><?php echo $proj_intro ?: ''; ?></div>
                    <div class="buttons">
                        <a href="<?php echo get_permalink($post_id); ?>" class="btn btn-cta">View Project <i class="fas fa-caret-circle-right"></i></a>
                        <?php if (have_rows('external_links', $post_id)) : while (have_rows('external_links', $post_id)) : the_row();
                                $ext_link = get_sub_field('external_link', $post_id);
                        ?>
                                <a href="<?php echo $ext_link['url']; ?>" class="btn btn-cta-ghost" target="<?php echo $ext_link['target']; ?>"><?php echo $ext_link['title']; ?></a>
                        <?php endwhile;
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="split-col imagery">
                <?php if ($p_bg_video && !wp_is_mobile()) { ?>
                    <video class="p-bg-video" autoplay muted loop>
                        <source src="<?php echo $p_bg_video; ?>" type="video/mp4">
                    </video>
                <?php } elseif ($p_bg_image) { ?>
                    <div class="p-bg-image" <?php echo 'style="background-image:url(' . $p_bg_image['url'] . ');"' ?: ''; ?>></div>
                    <cite class="visually-hidden"><?php echo $p_bg_image['alt']; ?></cite>
                <?php } ?>
                <?php if ($p_logo) { ?>
                    <img src="<?php echo $p_logo['url']; ?>" alt="<?php echo $p_logo['alt']; ?>" class="p-logo" height="100%" width="100%">
                <?php } ?>
            </div>
        </section>

<?php $i++;
    endwhile;
endif; ?>

<?php get_footer(); ?>