#!/bin/bash

if [ "$1" = "init" ];  then
	git remote add upstream https://github.com/luyadev/luya.git
fi

git checkout master
git fetch upstream
git rebase upstream/master