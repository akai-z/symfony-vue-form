#!/bin/sh

set -eo pipefail

extensions="$(printenv | grep "DOCKER_PHP")"

for ext in $extensions
do
  ext_status="$(echo "$ext" | cut -d '=' -f 2)"

  if [ "$ext_status" -eq 1 ] || [ "$PHP_FULL_INSTALL" -eq 1 ]; then
    ext_name="$( \
      echo "$ext" | \
      cut -d '=' -f 1 | \
      cut -d '_' -f 3 | \
      awk '{print tolower($0)}' \
    )"

    if [ -e "/usr/local/bin/docker-php-ext-${ext_name}.sh" ]; then
      "docker-php-ext-${ext_name}.sh"
    fi
  fi
done
