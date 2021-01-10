#!/bin/bash
#===============================================================================
#
#          FILE: fetch-latest-docs-artifacts.sh
#
#         USAGE: ./fetch-latest-docs-artifacts.sh [PROJECT_ID] [PIPELINE_ID]
#
#   DESCRIPTION:
#                Arguments PROJECT_ID and PIPELINE are not mandatory
#                if env variables CI_PROJECT_ID and CI_PIPELINE_ID exists
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
shopt -s inherit_errexit
IFS=$'\n\t'

PROJECT_ID=${CI_PROJECT_ID:-$1}
LC_PIPELINE_ID=${CI_PIPELINE_ID:-$2}

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ..

function fetchArtefacts() {
  local PROJECT_ID=$1
  local LC_PIPELINE_ID=$2

  curl --silent --show-error --fail "https://gitlab.com/api/v4/projects/${PROJECT_ID}/pipelines/${LC_PIPELINE_ID}/jobs" \
    | jq '.[] | select(.status == "success" and .artifacts_file != null) | .id' \
    | tee \
    | xargs -I{} -n1 curl --silent --show-error --fail -L --output "{}.zip" "https://gitlab.com/api/v4/projects/${PROJECT_ID}/jobs/{}/artifacts"
}

function fetchChildPipelines() {
  local PROJECT_ID=$1
  local LC_PIPELINE_ID=$2

  curl --silent --show-error --fail "https://gitlab.com/api/v4/projects/${PROJECT_ID}/pipelines/${LC_PIPELINE_ID}/bridges?scope=success" \
    |  jq ".[] | .downstream_pipeline.id"
}

echo "Get artifacts for pipeline ${LC_PIPELINE_ID}"
fetchArtefacts $PROJECT_ID $LC_PIPELINE_ID

echo "Get artifacts for child pipelines"
CHILD_PIPELINES=$(fetchChildPipelines $PROJECT_ID $LC_PIPELINE_ID)

for pipelineID in "${CHILD_PIPELINES}"
do
  echo "Fetch artifacts for pipeline: $pipelineID"
  fetchArtefacts $PROJECT_ID $pipelineID
done

find -maxdepth 1 -name '*.zip' -print0 | xargs -0 -n 1 unzip -d docs/artifacts
