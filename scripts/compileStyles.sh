#!/bin/bash

SCRIPTS_PATH=$(pwd)/

LOGFILE=$(pwd)/scripts/.sass_log
PIDFILETEMPLATE=$(pwd)/scripts/.pid
PIDFILES=$(pwd)/scripts/.pid*

if [[ "$SCRIPTS_PATH" == */scripts/ ]]
then
    SCRIPTS_PATH=$SCRIPTS_PATH"../"
fi

echo $SCRIPTS_PATH

BASE_PATH="modules/"
ASSETS_PATH="resources/"

PATHS=( "admin/src/" "cms/src/admin/" )

startCompass() {
    stopCompass

    for path in ${PATHS[@]}
    do
        MODULE_ASSET_PATH=$SCRIPTS_PATH$BASE_PATH$path$ASSETS_PATH

        echo $MODULE_ASSET_PATH;

        if [ -e $MODULE_ASSET_PATH"config.rb" ]
        then
            echo "Starting compass watch: $path"
            cd $MODULE_ASSET_PATH

            nohup compass watch>$LOGFILE 2>&1&

            echo $! > "$PIDFILETEMPLATE.$!"

            echo "compass watch success, pid: $!"
        fi

        cd $SCRIPTS_PATH
    done

    tail -f $LOGFILE
}

stopCompass() {
    # Kill all running tasks
    for f in $PIDFILES
    do
        if [ -e "$f" ]
        then
            kill -9 `cat $f` >/dev/null 2>&1
            echo "Stopped $(cat $f)"
            rm $f
        fi
    done
}

case $1 in
    "start")
        startCompass
    ;;

    "stop")
        stopCompass
    ;;

    *)
        echo "- start (Will start compass watch for all resources in project"
        echo "- stop (Stop all compass tasks)"
esac
