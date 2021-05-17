#!/bin/sh

set -eo pipefail

NPROC=$(getconf _NPROCESSORS_ONLN)
docker-php-ext-install -j${NPROC} opcache
