<?php
// *	@copyright	OCSHOP.CMS \ ocshop.net 2011 - 2015.
// *	@demo	http://ocshop.net
// *	@blog	http://ocshop.info
// *	@forum	http://forum.ocshop.info
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class Session {
	public $data = array();

	public function __construct($session_id = '',  $key = 'default') {
		ini_set('session.use_only_cookies', 'Off');
		ini_set('session.use_cookies', 'On');
		ini_set('session.use_trans_sid', 'Off');
		ini_set('session.cookie_httponly', 'On');

		if ($session_id) {
			session_id($session_id);
		}

		if (!preg_match('/^[0-9a-z]*$/i', session_id())) {
			exit();
		}

		session_set_cookie_params(0, '/');
		session_start();

		if (!isset($_SESSION[$key])) {
			$_SESSION[$key] = array();
		}

		$this->data =& $_SESSION[$key];
	}

	public function getId() {
		return session_id();
	}

	public function __destruct() {
		//return session_destroy();
	}
}
