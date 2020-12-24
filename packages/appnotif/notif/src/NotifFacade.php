<?php

namespace appnotif\notif;

use Illuminate\Support\Facades\Facade;

class NotifFacade extends Facade{
	protected static function getFacadeAccessor() { return 'notif'; }
}