#!/bin/bash
# apt-get install svn
# wget https://github.com/dflydev/git-subsplit/archive/master.zip

REPO="git@github.com:luyadev/luya"
BASE="git@github.com:luyadev"

if [ "$1" = "init" ]; then
	git subsplit init $REPO
else
	git subsplit update
fi

git subsplit publish "
    core:$BASE/luya-core.git
" --heads=master -q
