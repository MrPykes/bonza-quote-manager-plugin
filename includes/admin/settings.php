<?php

namespace BonzaQuote;

if (!defined('ABSPATH')) {
    exit;
}

class BonzaQuotePlugin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('init', [$this, 'register_post_type']);
        add_shortcode('bonza_quote_form', [$this, 'render_quote_form']);
        add_action('admin_post_nopriv_bonza_submit_quote', [$this, 'handle_form_submission']);
        add_action('admin_post_bonza_submit_quote', [$this, 'handle_form_submission']);
    }
    public function add_admin_menu()
    {
        add_menu_page('Bonza Quotes', 'Bonza Quotes', 'manage_options', 'bonza_quotes', [$this, 'render_admin_page']);
    }

    public function render_admin_page()
    {

        if (isset($_POST['bonza_change_status']) && current_user_can('manage_options')) {
            update_post_meta(intval($_POST['quote_id']), 'status', sanitize_text_field($_POST['new_status']));
        }

        $quotes = get_posts(['post_type' => 'bonza_quote', 'numberposts' => -1]);
        echo '<div class="wrap"><h1>Bonza Quotes</h1><table class="wp-list-table widefat"><thead><tr><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Action</th></tr></thead><tbody>';

        foreach ($quotes as $quote) {
            $email = get_post_meta($quote->ID, 'email', true);
            $service = get_post_meta($quote->ID, 'service_type', true);
            $status = get_post_meta($quote->ID, 'status', true);
            echo '<tr>
                    <td>' . esc_html($quote->post_title) . '</td>
                    <td>' . esc_html($email) . '</td>
                    <td>' . esc_html($service) . '</td>
                    <td>' . esc_html($status) . '</td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="quote_id" value="' . esc_attr($quote->ID) . '">
                            <select name="new_status">
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                            <input type="submit" name="bonza_change_status" value="Update">
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody></table></div>';
    }

    public function register_post_type()
    {
        register_post_type('bonza_quote', [
            'labels' => [
                'name' => 'Quotes',
                'singular_name' => 'Quote',
            ],
            'public' => false,
            'show_ui' => false,
            'supports' => ['title', 'custom-fields'],
        ]);
    }

    public function render_quote_form()
    {
        ob_start();

        if (isset($_GET['quote_submitted']) && $_GET['quote_submitted'] == '1') {
            echo '<div class="notice notice-success"><p>Thank you! Your quote request has been submitted.</p></div>';
        }
?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="bonza_submit_quote">
            <p><label>Name:<br><input type="text" name="bonza_name" required></label></p>
            <p><label>Email:<br><input type="email" name="bonza_email" required></label></p>
            <p><label>Service Type:<br><input type="text" name="bonza_service_type" required></label></p>
            <p><label>Notes:<br><textarea name="bonza_notes"></textarea></label></p>
            <p><input type="submit" value="Request Quote"></p>
        </form>
<?php
        return ob_get_clean();
    }

    public function handle_form_submission()
    {
        $name = sanitize_text_field($_POST['bonza_name']);
        $email = sanitize_email($_POST['bonza_email']);
        $service_type = sanitize_text_field($_POST['bonza_service_type']);
        $notes = sanitize_textarea_field($_POST['bonza_notes']);

        $post_id = wp_insert_post([
            'post_type' => 'bonza_quote',
            'post_title' => $name,
            'post_status' => 'publish',
            'meta_input' => [
                'email' => $email,
                'service_type' => $service_type,
                'notes' => $notes,
                'status' => 'pending'
            ]
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Send email to admin
            // $admin_email = get_option('admin_email');
            $admin_email = 'ed@storytimepods.com.au';
            $subject = 'New Quote Submission';
            $message = "A new quote has been submitted:\n\n";
            $message .= "Name: $name\n";
            $message .= "Email: $email\n";
            $message .= "Service Type: $service_type\n";
            $message .= "Notes: $notes\n";
            $message .= "Status: pending\n";

            wp_mail($admin_email, $subject, $message);
        }

        wp_redirect(add_query_arg('quote_submitted', '1', wp_get_referer()));
        exit;
    }
}

new BonzaQuotePlugin();
