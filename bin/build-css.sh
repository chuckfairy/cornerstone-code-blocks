#!/bin/bash

# Run from the root directory
# Requires `npm i -g node-sass`

mkdir ./dist/css
mkdir ./dist/json

# Directory to loop through
DIRECTORY="./node_modules/highlight.js/scss";
OUTPUT_DIRECTORY="./dist/css";

CONFIG_ARRAY=()

# Loop through files
for FILE in "$DIRECTORY"/*; do
  # Use basename of this file
  FILE_BASENAME=$(basename $FILE);
  FILE_BASENAME_WITHOUT_SCSS="${FILE_BASENAME/.scss/}";
  FILE_OUTPUT=$OUTPUT_DIRECTORY/$FILE_BASENAME;

  # Build via SASS
  sass $FILE $FILE_OUTPUT;

  # Replace .hljs with our special class output so we can use multiple
  # Different syntax highlighting in the same CS page
  sed -i "s/\.hljs/.cs-code-block-$FILE_BASENAME_WITHOUT_SCSS.hljs/g" $FILE_OUTPUT;

  echo $FILE_BASENAME;
  echo $FILE_BASENAME_WITHOUT_SCSS;
done

# Build Config JSON
json=$(jq -n --argjson arr "$(printf '%s\n' "${CONFIG_ARRAY[@]}" | jq -R . | jq -s .)" '$arr')

echo $json > ./dist/json/color-schemes.json
