#!/bin/bash
# apt-get install svn
# wget https://github.com/dflydev/git-subsplit/archive/master.zip

REPO="https://github.com/zephir/luya"
BASE="https://github.com/zephir"

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
" --heads=master -q
