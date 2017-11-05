#!/bin/bash

# When running the rebasemaster on the first time, use the init command.

if [ "$1" = "init" ];  then
	git remote add upstream https://github.com/luyadev/luya.git
fi

# simply type ./scripts/rebasemaster.sh branch **your-branch-name** in terminal

BRANCH="master"

if [ "$1" = "branch" ];  then
	BRANCH=$2
fi

git checkout $BRANCH
git fetch upstream
git rebase upstream/$BRANCH $BRANCH
