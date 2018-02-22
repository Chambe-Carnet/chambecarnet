<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * @since  1.14.0
 */

if ( ! get_the_company_name() ) {
	return;
}
?>
<div class="infos-company" itemscope itemtype="http://data-vocabulary.org/Organization">
	<?php the_company_logo(); ?>

    <ul>
		<li class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>" itemprop="employmentType"><?php the_job_type(); ?></li>
        <li class="nom-company"><?php the_company_name( '<strong itemprop="name">', '</strong>' ); ?>
        <?php the_company_tagline( '<p class="tagline">', '</p>' ); ?></li>
				<?php if ( $twitter = get_the_company_twitter() ) : ?>
					<li class="twitter-company">@<?php the_company_twitter(); ?></li>
				<?php endif; ?>
				<li class="location" itemprop="jobLocation"><?php the_job_location(); ?></li>
        <?php if ( $website = get_the_company_website() ) : ?>
					<li class="website-compagny">
						<a class="website" href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><?php _e( 'Website', 'wp-job-manager' ); ?></a>
					</li>
				<?php endif; ?>
    </ul>
</div>
