#!/bin/sh

set -eo pipefail

readonly SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
readonly INSTALLER_URL="https://getcomposer.org/installer"
readonly SETUP_FILE="composer-setup.php"

curl -fsL --retry 3 -o "$SETUP_FILE" "$INSTALLER_URL"

php -r " \
    \$hash = hash_file('SHA384', '${SETUP_FILE}'); \
    if (!hash_equals('${SIGNATURE}', \$hash)) { \
        unlink('${SETUP_FILE}'); \
        echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
        exit(1); \
    } \
"

php "$SETUP_FILE" --no-ansi --install-dir=/usr/local/bin --filename=composer
rm "$SETUP_FILE"
