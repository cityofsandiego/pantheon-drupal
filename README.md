# Local development

## Prerequisites

- Authorized Pantheon account with SSH keys uploaded and generated machine token
- Lando

## Standing up local dev env

1. Clone project `git clone git@bitbucket.org:interpersonal-frequency/sand02.git`
2. Go into project `cd sand02`
3. Spin up Lando env `lando start`
4. Pull in database and files from dev `lando pull` _DO NOT PULL CODE!_

## Pipelines

### Pantheon downstream

Weekly on Mondays at 7AM EST a pipeline is run which creates a new pull request
into the `main` branch which includes the latest changes from the Pantheon
`master` branch.

Default project developers from IF need to review these changes every Monday.

### Pull requests

When pull requests are created a pipeline runs which tests if merging the
Pantheon `master` branch into the `main` branch will succeed.

### Deploys to Pantheon

When code is pushed or merged to the `main` branch a pipeline runs which will
merge the latest changes to `main` into the Pantheon `master` branch and push
the code up to the Pantheon "Dev" environment.
