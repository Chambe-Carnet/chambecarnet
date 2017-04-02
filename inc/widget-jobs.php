<?php
/**
 * Compte Rendu Widget Template
 */
if (!defined('ABSPATH')) {
    die('-1');
}
?>
<section class="jobs-widget widget">
    <h2 class="widget-title">Job board</h2>
    <ul class="jobs">
        <li>
            <a class="title" href="https://www.chambe-carnet.com/jobs/depot/">
                <strong>
                    Déposer une offre
                </strong>
            </a>
        </li>
        <?php
        $user = wp_get_current_user();
        if (in_array('employer', (array)$user->roles)) {
            //The user has the "employer" role
            ?>
            <li>
                <a class="title" href="https://www.chambe-carnet.com/jobs/mes-offres-demploi/">
                    <strong>
                        Gérer mes offres
                    </strong>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</section>
