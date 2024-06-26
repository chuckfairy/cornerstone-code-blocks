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
for FILE in "$DIRECTORY"/* "$DIRECTORY"/base16/*; do
  # If Directory ignore
  if [ -d "$FILE" ]; then
    # Skip directories
    continue
  fi

  # Use basename of this file
  FILE_BASENAME=$(basename $FILE);

  # /base16/ directory has some duplicate names as non base16
  # So we add -base16 to the file name
  if [[ $FILE == *"base16/"* ]]; then
    FILE_BASENAME="${FILE_BASENAME/.scss/-base16.scss}";
  fi

  # Basename without scss for usage in Dynamic Options
  FILE_BASENAME_WITHOUT_SCSS="${FILE_BASENAME/.scss/}";

  # We build .scss to .css through sass
  FILE_BASENAME_CSS="${FILE_BASENAME/.scss/.css}";

  # Final output file name
  FILE_OUTPUT=$OUTPUT_DIRECTORY/$FILE_BASENAME_CSS;

  # Message
  echo "Processing Color Scheme : ${FILE_BASENAME_WITHOUT_SCSS}"

  # Build via SASS
  sass --no-source-map $FILE $FILE_OUTPUT;

  CONFIG_ARRAY+=($FILE_BASENAME_WITHOUT_SCSS);

  # Replace .hljs with our special class output so we can use multiple
  # Different syntax highlighting in the same CS page
  # @TODO need to only replace hljs and replace all hljs-* with a .cs-code-block check
   sed -i "s/\.hljs\ /.cs-code-block-$FILE_BASENAME_WITHOUT_SCSS.hljs\ /g" $FILE_OUTPUT;
   sed -i "s/\.hljs-/.cs-code-block-$FILE_BASENAME_WITHOUT_SCSS .hljs-/g" $FILE_OUTPUT;
done

# Build Config JSON
json=$(jq -n --argjson arr "$(printf '%s\n' "${CONFIG_ARRAY[@]}" | jq -R . | jq -s .)" '$arr')

echo $json > ./dist/json/color-schemes.json
