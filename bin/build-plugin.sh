#!/bin/bash

_DIR=$(dirname $0);

ROOT_PATH=$(realpath $_DIR/..);

FOLDER=/tmp/cornerstone-code-blocks/cornerstone-code-blocks;

# Setup folder
mkdir -p $FOLDER;

# Clean
rm -rf $FOLDER/*;
rm ./dist/cornerstone-code-blocks.zip

# Copy files
cp -R ./ $FOLDER/;

# Clean dev files
rm $FOLDER/package.json;
rm $FOLDER/package-lock.json;
rm $FOLDER/dist/.gitkeep
rm $FOLDER/.gitignore
rm $FOLDER/README.md
rm -rf $FOLDER/node_modules;
rm -rf $FOLDER/src;
rm -rf $FOLDER/.git
rm -rf $FOLDER/bin
rm -rf $FOLDER/screenshots

# Navigate to zip so folder structure is okay
cd /tmp/cornerstone-code-blocks/;

# Create zip
zip -r $ROOT_PATH/dist/cornerstone-code-blocks.zip ./cornerstone-code-blocks;

# Navigate back
cd $ROOT_PATH;
