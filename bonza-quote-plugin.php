<?php

/**
 * Plugin Name: Bonza Quote Manager
 * Description: A simple quote management plugin for handling service quote requests.
 * Version: 1.0
 * Author: Ed Francis T. Calimlim
 */

namespace BonzaQuote;

if (!defined('ABSPATH')) {
    exit;
}

class BonzaQuotePlugin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function render_admin_page()
    {
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

        if (isset($_POST['bonza_change_status']) && current_user_can('manage_options')) {
            update_post_meta(intval($_POST['quote_id']), 'status', sanitize_text_field($_POST['new_status']));
            wp_redirect(admin_url('admin.php?page=bonza_quotes'));
            exit;
        }
    }
}

new BonzaQuotePlugin();
