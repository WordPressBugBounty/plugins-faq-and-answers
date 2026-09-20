<?php
/**
 * The Form Submissions menu item on a free install.
 *
 * The pro build ships includes/submissions/, which owns the real
 * Awesome FAQ › Form Submissions screen. On a free install that whole folder is
 * stripped by the @fs_premium_only header, so the menu item would disappear and
 * a free user would never learn the feature exists.
 *
 * This class puts the item back on the free build only, at the very same slug
 * and in the same position, and renders a locked preview of the real table
 * instead of the table itself. Upgrading swaps this screen for the real one at
 * the same URL, so nothing has to be re-learned.
 *
 * The preview is drawn in HTML rather than shipped as a screenshot: it is the
 * same markup and the same columns the real screen uses, so it cannot drift out
 * of date the way an image would, and it costs no asset in the zip.
 *
 * Loaded from FaaPlugin::pluginsDependency next to FaaFreeAskAi, and listed
 * under @fs_free_only so it never reaches the premium build.
 *
 * @package Awesome_FAQ
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('FaaFreeSubmissions')) {
    class FaaFreeSubmissions
    {
        /**
         * Same slug the premium screen uses
         * (AFAQ_Submissions_Admin::PAGE_SLUG), so a bookmark made on the free
         * build keeps working after upgrading.
         */
        const PAGE_SLUG = 'afaq-form-submissions';

        public function __construct()
        {
            add_action('admin_menu', [$this, 'register_page'], 9);
        }

        public function register_page()
        {
            add_submenu_page(
                'edit.php?post_type=faq_cpt',
                __('Form Submissions', 'faq-and-answers'),
                __('Form Submissions', 'faq-and-answers'),
                // The person who can act on this screen is the person who can
                // buy. An Editor seeing an upgrade wall they cannot clear is
                // noise, so the item is not shown to them.
                'manage_options',
                self::PAGE_SLUG,
                [$this, 'render_page'],
                // The same position the premium screen takes, so the menu does
                // not reorder itself the moment somebody upgrades.
                8
            );
        }

        /**
         * Sample rows for the locked preview.
         *
         * Deliberately obvious as samples — a made up question with a made up
         * address, not something that could be mistaken for a real submission
         * somebody needs to answer.
         *
         * @return array<int,array<string,string>>
         */
        private function sample_rows()
        {
            return [
                [
                    'question' => __('Do you ship outside the country?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('New', 'faq-and-answers'),
                    'tone'     => '#e5f0fb;#0a4b78',
                    'received' => __('2 hours ago', 'faq-and-answers'),
                ],
                [
                    'question' => __('How long does a refund take?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('Answered', 'faq-and-answers'),
                    'tone'     => '#e4f3e7;#135e28',
                    'received' => __('Yesterday', 'faq-and-answers'),
                ],
                [
                    'question' => __('Can I change my plan later?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('Answered', 'faq-and-answers'),
                    'tone'     => '#e4f3e7;#135e28',
                    'received' => __('3 days ago', 'faq-and-answers'),
                ],
                [
                    'question' => __('Is there a discount for non-profits?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('Answered', 'faq-and-answers'),
                    'tone'     => '#e4f3e7;#135e28',
                    'received' => __('1 week ago', 'faq-and-answers'),
                ],
                [
                    'question' => __('Which payment methods do you take?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('Answered', 'faq-and-answers'),
                    'tone'     => '#e4f3e7;#135e28',
                    'received' => __('2 weeks ago', 'faq-and-answers'),
                ],
                [
                    'question' => __('Do you offer a trial?', 'faq-and-answers'),
                    'name'     => __('Sample visitor', 'faq-and-answers'),
                    'email'    => 'visitor@example.com',
                    'state'    => __('Spam', 'faq-and-answers'),
                    'tone'     => '#fcebea;#8a1f11',
                    'received' => __('3 weeks ago', 'faq-and-answers'),
                ],
            ];
        }

        public function render_page()
        {
            if (!current_user_can('manage_options')) {
                wp_die(esc_html__('You do not have permission to view form submissions.', 'faq-and-answers'));
            }

            $pricing = admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard#/pricing');
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Form Submissions', 'faq-and-answers'); ?></h1>
                <p class="description">
                    <?php esc_html_e('Questions visitors sent in through the FAQ Form block.', 'faq-and-answers'); ?>
                </p>

                <?php
                // A floor on the height rather than a fixed one: the sample
                // rows already fill more than this, and a hard height would cut
                // them off the moment a translated question wrapped to a second
                // line.
                ?>
                <div style="position:relative; overflow:hidden; border:1px solid #dcdcde; background:#fff; margin-top:16px; min-height:480px;">
                    <?php
                    // The preview itself. Hidden from screen readers and from
                    // the keyboard: it is a picture of a table, and a reader
                    // walking into three fake rows would be told about
                    // submissions that do not exist.
                    ?>
                    <div aria-hidden="true" style="padding:12px 0; filter:blur(1.5px); opacity:.75; pointer-events:none; user-select:none;">
                        <table class="wp-list-table widefat fixed striped" style="border:0;">
                            <thead>
                                <tr>
                                    <th scope="col"><?php esc_html_e('Question', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('From', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Email', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Status', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Received', 'faq-and-answers'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->sample_rows() as $row) : ?>
                                    <?php list($tone_bg, $tone_fg) = explode(';', $row['tone']); ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($row['question']); ?></strong></td>
                                        <td><?php echo esc_html($row['name']); ?></td>
                                        <td><?php echo esc_html($row['email']); ?></td>
                                        <td>
                                            <span style="display:inline-block; padding:2px 8px; border-radius:9px; font-size:11px; font-weight:600; background:<?php echo esc_attr($tone_bg); ?>; color:<?php echo esc_attr($tone_fg); ?>;">
                                                <?php echo esc_html($row['state']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo esc_html($row['received']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    // The padding here is what keeps the card off the edges of
                    // the panel. border-box on both, or the padding is added to
                    // the widths and the card runs past the sides it is meant
                    // to be inset from.
                    ?>
                    <div style="position:absolute; inset:0; box-sizing:border-box; display:flex; align-items:center; justify-content:center; padding:40px 32px; background:rgba(15,23,42,0.55);">
                        <div style="box-sizing:border-box; width:100%; max-width:520px; padding:36px 32px; background:#fff; border:1px solid #dcdcde; border-top:3px solid #2563eb; text-align:center;">
                            <h2 style="margin:0 0 12px; font-size:22px; font-weight:700; color:#0f172a;">
                                <?php esc_html_e('Form Submissions is a Pro feature', 'faq-and-answers'); ?>
                            </h2>
                            <p style="margin:0 0 24px; font-size:14px; line-height:1.7; color:#475569;">
                                <?php esc_html_e('Let visitors send in the question they could not find an answer to. Every one arrives here with their name and email, ready to read, mark answered and reply to.', 'faq-and-answers'); ?>
                            </p>
                            <a href="<?php echo esc_url($pricing); ?>"
                                style="display:inline-block; padding:11px 28px; background:#2563eb; border:1px solid #2563eb; color:#fff; font-size:15px; font-weight:600; text-decoration:none;">
                                <?php esc_html_e('Upgrade to Pro', 'faq-and-answers'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    new FaaFreeSubmissions();
}
