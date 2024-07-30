#!/bin/bash

# Run from the root directory
# Requires `npm i -g esbuild`

# Clean
rm -rf ./dist/js/languages

mkdir -p ./dist/js/languages


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

  # Remove .js at the end since imports with .js are deprecated
  FILE_IMPORT_NAME="${FILE_WITHOUT_NODE_MODULES/$FILE_BASENAME_WITHOUT_JS.js/$FILE_BASENAME_WITHOUT_JS}";

  FILE_OUTPUT=$OUTPUT_DIRECTORY/$FILE_BASENAME;

  echo "Processing Language : $FILE_BASENAME_WITHOUT_JS";

  # Copy
  #cat $FILE > $FILE_OUTPUT;

  # Add register statement
  # This needs .tmp.js because esbuild doesn't like building to the same file
  echo "import language from '$FILE_IMPORT_NAME'" > $FILE_OUTPUT.tmp.js;
  echo "hljs.registerLanguage('$FILE_BASENAME_WITHOUT_JS', language);" >> $FILE_OUTPUT.tmp.js;

  # esbuild command bundling the import statement
  esbuild --bundle --minify $FILE_OUTPUT.tmp.js > $FILE_OUTPUT;

  # Remove temp js file
  rm $FILE_OUTPUT.tmp.js

  # Add to JSON config for output later
  CONFIG_ARRAY+=($FILE_BASENAME_WITHOUT_JS);
done


# Build Config JSON
json=$(jq -n --argjson arr "$(printf '%s\n' "${CONFIG_ARRAY[@]}" | jq -R . | jq -s .)" '$arr')

echo $json > ./dist/json/languages.json
