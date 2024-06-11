#!/bin/bash

# Run from the root directory
# Requires `npm i -g node-sass`

mkdir -p ./dist/css
mkdir -p ./dist/json

# Clean
rm -rf ./dist/css/*

# Directory to loop through
DIRECTORY="./node_modules/highlight.js/scss";
OUTPUT_DIRECTORY="./dist/css";

CONFIG_ARRAY=()

# Loop through files
for FILE in "$DIRECTORY"/*; do
  # If Directory ignore
  if [ -d "$FILE" ]; then
    # Skip directories
    continue
  fi

  # Use basename of this file
  FILE_BASENAME=$(basename $FILE);
  FILE_BASENAME_WITHOUT_SCSS="${FILE_BASENAME/.scss/}";
  FILE_BASENAME_CSS="${FILE_BASENAME/.scss/.css}";
  FILE_OUTPUT=$OUTPUT_DIRECTORY/$FILE_BASENAME_CSS;

  # Message
  echo "Processing ${FILE_BASENAME_WITHOUT_SCSS}"

  # Build via SASS
  sass --no-source-map $FILE $FILE_OUTPUT;

  CONFIG_ARRAY+=($FILE_BASENAME_WITHOUT_SCSS);

  # Replace .hljs with our special class output so we can use multiple
  # Different syntax highlighting in the same CS page
  # @TODO need to only replace hljs and replace all hljs-* with a .cs-code-block check
  # sed -i "s/\.hljs/.cs-code-block-$FILE_BASENAME_WITHOUT_SCSS.hljs/g" $FILE_OUTPUT;
done

# Build Config JSON
json=$(jq -n --argjson arr "$(printf '%s\n' "${CONFIG_ARRAY[@]}" | jq -R . | jq -s .)" '$arr')

echo $json > ./dist/json/color-schemes.json
