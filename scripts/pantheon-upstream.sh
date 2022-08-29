#!/bin/bash
# Exit when any command fails (-e).
set -e

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

git remote add pantheon ssh://codeserver.dev.558ccf9c-33c1-459f-a727-08540af54518@codeserver.dev.558ccf9c-33c1-459f-a727-08540af54518.drush.in:2222/~/repository.git
git fetch pantheon
git checkout master
git pull pantheon master
git merge main
git push pantheon master
