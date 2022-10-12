#!/bin/bash
# Exit when any command fails (-e).
set -e

# Give our branch a name such as ...
NEW_BRANCH=$(date "+feature/pantheon-downstream-%Y%m%d-%H%M")

# Helper to print an error message and exit.
function echoerr() {
	echo "$@" 1>&2
	exit 42
}

# Ensure this is only run in CI.
if [[ -z "$CI" ]]; then
	echoerr "This script is designed to only run in a CI environment."
fi

# Make sure we identify ourselves to git. These are repo variables.
git config user.email "it@ifsight.com"
git config user.name "IF IT"

TITLE="[PANTHEON DOWNSTREAM] Updates generated on $(date "+%Y-%m-%d")";

# Prepare the branch and push it up.
# Note: This assumes callers already staged for commit what they want to
# be committed and pushed to the new branch.
git remote add pantheon ssh://codeserver.dev.558ccf9c-33c1-459f-a727-08540af54518@codeserver.dev.558ccf9c-33c1-459f-a727-08540af54518.drush.in:2222/~/repository.git
git fetch pantheon
git checkout master
git pull pantheon master
git checkout main
git checkout -b "${NEW_BRANCH}"
git merge master
git push origin "${NEW_BRANCH}"

BB_TOKEN=$(curl -s -S -f -X POST -u "${AUTOMATED_UPDATES_AUTH}" \
  https://bitbucket.org/site/oauth2/access_token \
  -d grant_type=client_credentials -d scopes="repository" | jq --raw-output '.access_token')
export BB_TOKEN

curl https://api.bitbucket.org/2.0/repositories/"${BITBUCKET_REPO_OWNER}"/"${BITBUCKET_REPO_SLUG}"/pullrequests \
  -S -v -X POST \
  -H 'Content-Type: application/json' \
  -H "Authorization: Bearer ${BB_TOKEN}" \
  -d '{
      "title": "'"${TITLE}"'",
      "description": "",
      "source": {
        "branch": {
          "name": "'"${NEW_BRANCH}"'"
        }
      },
      "destination": {
        "branch": {
          "name": "main"
        }
      },
      "close_source_branch": true,
      "reviewers": '[]'
    }'
