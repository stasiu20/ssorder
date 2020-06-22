#!/bin/sh

set -o nounset
set -e

for dir in /tests/tests/[^.]*/; do
  newman run --globals /tests/globals.json --environment /tests/environments/docker.postman_environment.json --iteration-data ${dir}/data.csv  --reporters cli ${dir}/ssorder.postman_collection.json
done
