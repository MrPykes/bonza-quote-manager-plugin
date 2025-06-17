# Bonza Quote Manager

A simple WordPress plugin for managing service quote requests via frontend form submission and admin review.

## 🚀 Features

- Frontend shortcode `[bonza_quote_form]` to submit a quote
- Admin menu to view and update quote status
- Email notification to admin on new submission
- Secure form submission using WordPress nonce
- Custom post type storage (`bonza_quote`)

## 🧪 Running Tests

### Prerequisites

- PHP with `mysqli` extension
- MySQL running locally or via Laragon/WSL
- Composer installed
- SVN installed (for downloading WP test suite)
- WordPress set up locally

### Setup

- Run `composer install` from the plugin root

- Determine your MySQL host

  - Laragon: use `127.0.0.1`
  - WSL: run `cat /etc/resolv.conf` and copy the `nameserver` IP (e.g., `172.28.32.1`)
  - Docker: use `host.docker.internal`

- Install the WordPress testing suite using:

  `bash bin/install-wp-tests.sh wordpress_test root '' <host> 6.8.1`

  Example (WSL):  
  `bash bin/install-wp-tests.sh wordpress_test root '' 172.28.32.1 6.8.1`

- Run tests:

  `composer test`
