#!/bin/sh

set -eo pipefail

apk add -u --no-cache bash git openssh patch

readonly INSTALLER_URL="https://get.symfony.com/cli/installer"
readonly SETUP_FILE="symfony-installer"

curl -fsL --retry 3 -o "$SETUP_FILE" "$INSTALLER_URL"

bash ./"$SETUP_FILE"
mv /root/.symfony/bin/symfony /usr/local/bin/symfony
rm "$SETUP_FILE"
