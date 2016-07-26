<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-infos">
        <?php twentysixteen_entry_single_meta(); ?>
        <?php
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>


        <?php if (is_singular('job_listing')) : ?>
            <li class="date-posted" itemprop="datePosted">
                <date><?php printf(__('Posted %s ago', 'wp-job-manager'), human_time_diff(get_post_time('U'), current_time('timestamp'))); ?></date>
            </li>
        <?php endif; ?>


    </div><!-- .entry-footer -->
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <?php twentysixteen_excerpt(); ?>

    <?php twentysixteen_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        the_content();

        if (in_category('jobs-posts')) {
            ?>
            <p class="jobs-plus">Vous en voulez plus ?</p>
            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup_jobs">
                <form
                    action="//chambe-carnet.us4.list-manage.com/subscribe/post?u=05a3c26b35bbf2d0edeb6c8fb&amp;id=c0e8588f3b"
                    method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                    target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <input type="hidden" value="16384" name="group[12761][16384]" id="mce-group[12761]-12761-2"
                               checked="checked">
                        <div class="mc-field-group">
                            <label for="mce-EMAIL">Recevez tous les jours les
                                dernières offres d'emploi</label>
                            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"
                                   placeholder="email">
                            <input type="submit" value="Recevoir les offres" name="subscribe"
                                   id="mc-embedded-subscribe" class="button">
                        </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true">
                            <input type="text"
                                   name="b_05a3c26b35bbf2d0edeb6c8fb_c0e8588f3b"
                                   tabindex="-1"
                                   value="">
                        </div>
                    </div>
                </form>
                <p><a href="http://www.chambe-carnet.com/jobs" onMouseDown="ga('send', 'event', 'Job Listing', this.href);">Consultez notre job board</a></p>
            </div>
            <!--End mc_embed_signup-->
            <?php
        }

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentysixteen') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'twentysixteen') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));

        if ('' !== get_the_author_meta('description')) {
            get_template_part('template-parts/biography');
        }
        ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
