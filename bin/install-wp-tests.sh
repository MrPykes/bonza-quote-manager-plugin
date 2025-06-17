#!/usr/bin/env bash
# Based on: https://github.com/wp-cli/scaffold-command/blob/trunk/templates/install-wp-tests.sh

set -e

# Validate and assign arguments
if [ $# -ne 5 ]; then
  echo ""
  echo "Usage: $0 <db-name> <db-user> <db-pass> <db-host> <wp-version>"
  echo "Example: $0 wordpress_test root '' 127.0.0.1 6.8.1"
  echo ""
  exit 1
fi

DB_NAME=$1
DB_USER=$2
DB_PASS=$3
DB_HOST=$4
WP_VERSION=$5

WP_TESTS_DIR=${WP_TESTS_DIR:-/tmp/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR:-/tmp/wordpress}

download() {
  if command -v curl > /dev/null; then
    curl -s "$1" -o "$2"
  elif command -v wget > /dev/null; then
    wget -q -O "$2" "$1"
  else
    echo "Missing curl or wget. Cannot download files."
    exit 1
  fi
}

install_wp() {
  if [ ! -d "$WP_CORE_DIR" ]; then
    mkdir -p "$WP_CORE_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/" "$WP_CORE_DIR"
  fi
}

install_test_suite() {
  if [ ! -d "$WP_TESTS_DIR" ]; then
    mkdir -p "$WP_TESTS_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/includes" "$WP_TESTS_DIR/includes"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/data" "$WP_TESTS_DIR/data"
  fi
}

create_db() {
  echo "Creating database '$DB_NAME' on host '$DB_HOST'..."
  mysqladmin create "$DB_NAME" --user="$DB_USER" --password="$DB_PASS" --host="$DB_HOST" || true
}

install_wp
install_test_suite
create_db
#!/usr/bin/env bash
# Script to install WordPress test suite for plugin integration testing

set -e

# Validate number of args
if [ "$#" -ne 5 ]; then
  echo ""
  echo "Usage: $0 <db-name> <db-user> <db-pass> <db-host> <wp-version>"
  echo "Example: $0 wordpress_test root '' 127.0.0.1 6.8.1"
  echo ""
  exit 1
fi

DB_NAME=$1
DB_USER=$2
DB_PASS=$3
DB_HOST=$4
WP_VERSION=$5

WP_TESTS_DIR=${WP_TESTS_DIR:-/tmp/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR:-/tmp/wordpress}

download() {
  if command -v curl >/dev/null; then
    curl -s "$1" -o "$2"
  elif command -v wget >/dev/null; then
    wget -q -O "$2" "$1"
  else
    echo "Error: curl or wget is required to download files."
    exit 1
  fi
}

install_wp() {
  if [ ! -d "$WP_CORE_DIR" ]; then
    mkdir -p "$WP_CORE_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/" "$WP_CORE_DIR"
  fi
}

install_test_suite() {
  if [ ! -d "$WP_TESTS_DIR" ]; then
    mkdir -p "$WP_TESTS_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/includes" "$WP_TESTS_DIR/includes"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/data" "$WP_TESTS_DIR/data"
  fi
}

create_db() {
  echo "Creating database '$DB_NAME' on host '$DB_HOST'..."
  mysqladmin create "$DB_NAME" --user="$DB_USER" --password="$DB_PASS" --host="$DB_HOST" || true
}

install_wp
install_test_suite
create_db
#!/usr/bin/env bash
# Script to install WordPress test suite for plugin integration testing

set -e

# Validate number of args
if [ "$#" -ne 5 ]; then
  echo ""
  echo "Usage: $0 <db-name> <db-user> <db-pass> <db-host> <wp-version>"
  echo "Example: $0 wordpress_test root '' 127.0.0.1 6.8.1"
  echo ""
  exit 1
fi

DB_NAME=$1
DB_USER=$2
DB_PASS=$3
DB_HOST=$4
WP_VERSION=$5

WP_TESTS_DIR=${WP_TESTS_DIR:-/tmp/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR:-/tmp/wordpress}

download() {
  if command -v curl >/dev/null; then
    curl -s "$1" -o "$2"
  elif command -v wget >/dev/null; then
    wget -q -O "$2" "$1"
  else
    echo "Error: curl or wget is required to download files."
    exit 1
  fi
}

install_wp() {
  if [ ! -d "$WP_CORE_DIR" ]; then
    mkdir -p "$WP_CORE_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/" "$WP_CORE_DIR"
  fi
}

install_test_suite() {
  if [ ! -d "$WP_TESTS_DIR" ]; then
    mkdir -p "$WP_TESTS_DIR"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/includes" "$WP_TESTS_DIR/includes"
    svn co --quiet "https://develop.svn.wordpress.org/tags/$WP_VERSION/tests/phpunit/data" "$WP_TESTS_DIR/data"
  fi
}

create_db() {
  echo "Creating database '$DB_NAME' on host '$DB_HOST'..."
  mysqladmin create "$DB_NAME" --user="$DB_USER" --password="$DB_PASS" --host="$DB_HOST" || true
}

install_wp
install_test_suite
create_db
