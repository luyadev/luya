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
    envs/kickstarter:$BASE/luya-kickstarter.git
    modules/admin:$BASE/luya-module-admin.git
    modules/cms:$BASE/luya-module-cms.git
    modules/news:$BASE/luya-module-news.git
    modules/errorapi:$BASE/luya-module-errorapi.git
    modules/gallery:$BASE/luya-module-gallery.git
    modules/crawler:$BASE/luya-module-crawler.git
    modules/styleguide:$BASE/luya-module-styleguide.git
    modules/frontendgroup:$BASE/luya-module-frontendgroup.git
    modules/remoteadmin:$BASE/luya-module-remoteadmin.git
" --heads=master -q
