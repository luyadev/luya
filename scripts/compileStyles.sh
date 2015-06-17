#!/bin/bash

SCRIPTS_PATH=$(pwd)/

if [[ "$SCRIPTS_PATH" == */scripts/ ]]
then
    SCRIPTS_PATH=$SCRIPTS_PATH"../"
fi

echo $SCRIPTS_PATH

BASE_PATH="modules/"
ASSETS_PATH="assets/"

PATHS=( "admin/" "cmsadmin/" )

for path in ${PATHS[@]}
do
    MODULE_ASSET_PATH=$SCRIPTS_PATH$BASE_PATH$path$ASSETS_PATH

    echo $MODULE_ASSET_PATH;

    if [ -e $MODULE_ASSET_PATH"config.rb" ]
    then
        echo "Compass compile: $path"
        cd $MODULE_ASSET_PATH
        compass watch
    fi

    cd $SCRIPTS_PATH
done