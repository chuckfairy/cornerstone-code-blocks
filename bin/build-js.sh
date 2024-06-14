#!/bin/bash

# Run from the root directory
# Requires `npm i -g esbuild`

# Clean
rm -rf ./dist/js/*

# Build directories
mkdir -p ./dist/js
mkdir -p ./dist/js/languages

# Build out Rivet and CS integration
esbuild --bundle ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.js
esbuild --bundle --minify ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.min.js


# Language building

DIRECTORY="./node_modules/highlight.js/lib/languages";
OUTPUT_DIRECTORY="./dist/js/languages";

CONFIG_ARRAY=()

# Loop through files
for FILE in "$DIRECTORY"/*.js; do
  # If Directory ignore
  if [ -d "$FILE" ]; then
    # Skip directories
    continue
  fi

  # Ends with .js.js which are deprecated files
  if [[ "$FILE" =~ \.js\.js$ ]]; then
    continue;
  fi

  FILE_BASENAME=$(basename $FILE);
  FILE_WITHOUT_NODE_MODULES="${FILE/.\/node_modules\//}";
  FILE_BASENAME_WITHOUT_JS="${FILE_BASENAME/.js/}";
  FILE_OUTPUT=$OUTPUT_DIRECTORY/$FILE_BASENAME;

  echo "Processing $FILE_BASENAME_WITHOUT_JS";

  # Copy
  #cat $FILE > $FILE_OUTPUT;

  # Add register statement
  # This needs .tmp.js because esbuild doesn't like building to the same file
  echo "import language from '$FILE_WITHOUT_NODE_MODULES'" > $FILE_OUTPUT.tmp.js;
  echo "hljs.registerLanguage('$FILE_BASENAME_WITHOUT_JS', language);" >> $FILE_OUTPUT.tmp.js;

  esbuild --bundle --minify $FILE_OUTPUT.tmp.js > $FILE_OUTPUT;

  rm $FILE_OUTPUT.tmp.js

  CONFIG_ARRAY+=($FILE_BASENAME_WITHOUT_JS);
done


# Build Config JSON
json=$(jq -n --argjson arr "$(printf '%s\n' "${CONFIG_ARRAY[@]}" | jq -R . | jq -s .)" '$arr')

echo $json > ./dist/json/languages.json
