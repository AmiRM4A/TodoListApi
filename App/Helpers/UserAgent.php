<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent;

class UserAgent extends Agent {
	public function __construct($agent_string) {
		parent::__construct();
		if (!is_null($agent_string)) {
			$this->setUserAgent($agent_string);
		}
	}
}
