#!/bin/bash

FOLDER=./dist/cornerstone-code-blocks;

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
rm -rf $FOLDER/node_modules;
rm -rf $FOLDER/src;
rm -rf $FOLDER/.git

# Create zip
zip -r ./dist/cornerstone-code-blocks.zip $FOLDER;
