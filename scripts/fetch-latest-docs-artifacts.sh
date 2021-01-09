#!/bin/bash
#===============================================================================
#
#          FILE: fetch-latest-docs-artifacts.sh
#
#         USAGE: ./fetch-latest-docs-artifacts.sh
#
#   DESCRIPTION:
#
#       OPTIONS: ---
#  REQUIREMENTS: ---
#          BUGS: ---
#         NOTES: ---
#        AUTHOR: Marcin Morawski (marcin@morawskim.pl),
#  ORGANIZATION:
#       CREATED: 09.01.2021 10:02
#      REVISION:  ---
#===============================================================================

set -euo pipefail
set -o nounset                              # Treat unset variables as an error
IFS=$'\n\t'

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ..

declare -a arr=("swagger" "openapi" "redoc" "sitespeed" "codeception" "newman" "assets" "phpunit")
for job in "${arr[@]}"
do
   echo "Fetch artifacts for: $job"
   curl --silent --show-error --fail -L --output "${job}.zip" "https://gitlab.com/morawskim/ssorder/-/jobs/artifacts/develop/download?job=$job"
   unzip -d docs/artifacts ${job}.zip
done
