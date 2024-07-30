#!/bin/bash

# Run from the root directory
# Requires `npm i -g esbuild`

# Clean
rm ./dist/js/cornerstone-code-blocks.js
rm ./dist/js/cornerstone-code-blocks.min.js

# Build directories
mkdir -p ./dist/js

# Build out Rivet and CS integration
esbuild --bundle ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.js
esbuild --bundle --minify ./src/cornerstone-code-blocks.js > ./dist/js/cornerstone-code-blocks.min.js
