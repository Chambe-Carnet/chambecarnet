<?php
/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.16.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php if ( $apply = get_the_job_application_method() ) :
	wp_enqueue_script( 'wp-job-manager-job-application' );
	?>
	<div class="job_application application">
		<?php do_action( 'job_application_start', $apply ); ?>

		<input type="button" class="application_button button" value="<?php _e( 'Apply for job', 'wp-job-manager' ); ?>" onMouseDown="ga('send', 'event', 'Jobs', 'Postuler', window.location.href);" />

		<div class="application_details">
			<?php
				/**
				 * job_manager_application_details_email or job_manager_application_details_url hook
				 */
				do_action( 'job_manager_application_details_' . $apply->type, $apply );
			?>
		</div>
		<?php do_action( 'job_application_end', $apply ); ?>
	</div>
<?php endif; ?>

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
											 id="mc-embedded-subscribe" class="button" onMouseDown="ga('send', 'event', 'Newsletter', 'Inscription', 'Billet Jobs');">
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
		<p><a href="https://www.chambe-carnet.com/jobs" onMouseDown="ga('send', 'event', 'Jobs', 'Clic', 'Billet Jobs');">Consultez notre job board</a></p>
</div>
<!--End mc_embed_signup-->
