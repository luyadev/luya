<?php

namespace luya\admin\base;

interface DashboardObjectInterface
{
	public function getTemplate();
	
	public function getDataApiUrl();
	
	public function getTitle();
}