#!/bin/bash

RES=resources/bowervendor
OUT=$RES/vendors.min.js

rm -f $OUT
touch $OUT

cat \
	$RES/jquery-ui/jquery-ui.min.js \
	$RES/angular/angular.min.js \
	$RES/angular-resource/angular-resource.min.js \
	$RES/angular-ui-router/release/angular-ui-router.min.js \
	$RES/angular-loading-bar/build/loading-bar.min.js \
	$RES/angular-slugify/angular-slugify.js \
	$RES/ng-file-upload/ng-file-upload.min.js \
	$RES/ng-file-upload/ng-file-upload-shim.min.js \
	$RES/ng-wig/dist/ng-wig.min.js \
	$RES/twig.js/twig.min.js \
	> $OUT