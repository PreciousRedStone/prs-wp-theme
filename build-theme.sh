#!/usr/bin/env bash

npm install
node_modules/.bin/gulp build

echo "**** Making a zipped theme archive"
zip -r prs-wp-theme-dist prs-wp-theme-dist