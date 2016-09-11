<?php

namespace luya\tag\tags;

use luya\tag\BaseTag;
use luya\helpers\StringHelper;
use yii\helpers\Html;

class TelTag extends BaseTag
{
	public function readme()
	{
		return 'Generate a tel link which is commonly used on mobile websites in order create a click to call link. tel[+41 061 123 123] or with with a name instead of the phone number tel[+41 061 123 123](call us now!).';
	}
	
	public function parse($value, $sub)
	{
		return Html::a(empty($sub) ? $value : $sub, 'tel:' . $this->ensureNumber($value));
	}
		
	private function ensureNumber($number)
	{
		if (!StringHelper::startsWith($number, '+')) {
			$number = '+'.$number;
		}
		
		return str_replace(" ", "", $number);
	}
}