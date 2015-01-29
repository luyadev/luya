#!/bin/bash

if [ "$1" = "init" ];  then
	git remote add upstream https://github.com/zephir/luya.git
fi

git checkout master
git fetch upstream
git rebase upstream/master