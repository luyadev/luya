#!/bin/bash
# apt-get install svn
# wget https://github.com/dflydev/git-subsplit/archive/master.zip

REPO="git@github.com:zephir/luya"
BASE="git@github.com:zephir"

if [ "$1" = "init" ]; then
	git subsplit init $REPO
else
	git subsplit update
fi

git subsplit publish "
    modules/admin:$BASE/luya-module-admin.git
    modules/cms:$BASE/luya-module-cms.git
    modules/cmsadmin:$BASE/luya-module-cmsadmin.git
    modules/news:$BASE/luya-module-news.git
    modules/newsadmin:$BASE/luya-module-newsadmin.git
    modules/account:$BASE/luya-module-account.git
	modules/errorapi:$BASE/luya-module-errorapi.git
    modules/gallery:$BASE/luya-module-gallery.git
    modules/galleryadmin:$BASE/luya-module-galleryadmin.git
    envs/kickstarter:$BASE/luya-kickstarter.git
" --heads=master -q
