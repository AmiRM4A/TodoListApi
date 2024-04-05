<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent;

/**
 * Class UserAgent
 *
 * Extends the Jenssegers\Agent\Agent class to provide additional functionality.
 */
class UserAgent extends Agent {
	/**
	 * UserAgent constructor.
	 *
	 * @param string|null $agent_string The user agent string to initialize the object with.
	 */
	public function __construct(?string $agent_string) {
		parent::__construct();
		if (!is_null($agent_string)) {
			$this->setUserAgent($agent_string);
		}
	}
}