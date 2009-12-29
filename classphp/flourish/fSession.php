<?php
/**
 * Wraps the session control functions and the `$_SESSION` superglobal for a more consistent and safer API
 * 
 * A `Cannot send session cache limiter` warning will be triggered if ::open(),
 * ::clear(), ::get() or ::set() is called after output has been sent to the
 * browser. To prevent such a warning, explicitly call ::open() before
 * generating any output.
 * 
 * @copyright  Copyright (c) 2007-2009 Will Bond
 * @author     Will Bond [wb] <will@flourishlib.com>
 * @license    http://flourishlib.com/license
 * 
 * @package    Flourish
 * @link       http://flourishlib.com/fSession
 * 
 * @version    1.0.0b6
 * @changes    1.0.0b6  Backwards Compatibility Break - the first parameter of ::clear() was removed, use ::delete() instead [wb, 2009-05-08] 
 * @changes    1.0.0b5  Added documentation about session cache limiter warnings [wb, 2009-05-04]
 * @changes    1.0.0b4  The class now works with existing sessions [wb, 2009-05-04]
 * @changes    1.0.0b3  Fixed ::clear() to properly handle when `$key` is `NULL` [wb, 2009-02-05]
 * @changes    1.0.0b2  Made ::open() public, fixed some consistency issues with setting session options through the class [wb, 2009-01-06]
 * @changes    1.0.0b   The initial implementation [wb, 2007-06-14]
 */
class fSession
{
	// The following constants allow for nice looking callbacks to static methods
	const clear           = 'fSession::clear';
	const close           = 'fSession::close';
	const delete          = 'fSession::delete';
	const destroy         = 'fSession::destroy';
	const get             = 'fSession::get';
	const ignoreSubdomain = 'fSession::ignoreSubdomain';
	const open            = 'fSession::open';
	const reset           = 'fSession::reset';
	const set             = 'fSession::set';
	const setLength       = 'fSession::setLength';
	const setPath         = 'fSession::setPath';
	
	
	/**
	 * If the session is open
	 * 
	 * @var boolean
	 */
	static private $open = FALSE;
	
	
	/**
	 * Removes all session values with the provided prefix
	 * 
	 * @param  string $prefix  The prefix to clear all session values for
	 * @return void
	 */
	static public function clear($prefix='fSession::')
	{
		self::open();
		
		$remove = array();
		foreach ($_SESSION as $key => $value) {
			if (strpos($key, $prefix) === 0) {
				unset($_SESSION[$key]);
			}
		}
	}
	
	
	/**
	 * Closes the session for writing, allowing other pages to open the session
	 * 
	 * @return void
	 */
	static public function close()
	{
		if (!self::$open) { return; }
		
		session_write_close();
		self::$open = FALSE;
	}
	
	
	/**
	 * Deletes a value from the session
	 * 
	 * @param  string $key     The key of the value to delete
	 * @param  string $prefix  The prefix to use for the key
	 * @return void
	 */
	static public function delete($key, $prefix='fSession::')
	{
		self::open();
		
		unset($_SESSION[$prefix . $key]);
	}
	
	
	/**
	 * Destroys the session, removing all values
	 * 
	 * @return void
	 */
	static public function destroy()
	{
		self::open();
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time()-43200, $params['path'], $params['domain'], $params['secure']);
		}
		session_destroy();
	}
	
	
	/**
	 * Gets data from the `$_SESSION` superglobal, prefixing it with `fSession::` to prevent issues with `$_REQUEST`
	 * 
	 * @param  string $key            The name to get the value for
	 * @param  mixed  $default_value  The default value to use if the requested key is not set
	 * @param  string $prefix         The prefix to stick before the key
	 * @return mixed  The data element requested
	 */
	static public function get($key, $default_value=NULL, $prefix='fSession::')
	{
		self::open();
		return (isset($_SESSION[$prefix . $key])) ? $_SESSION[$prefix . $key] : $default_value;
	}
	
	
	/**
	 * Sets the session to run on the main domain, not just the specific subdomain currently being accessed
	 * 
	 * This method should be called after any calls to
	 * [http://php.net/session_set_cookie_params `session_set_cookie_params()`].
	 * 
	 * @return void
	 */
	static public function ignoreSubdomain()
	{
		if (self::$open || isset($_SESSION)) {
			throw new fProgrammerException(
				'%1$s must be called before any of %2$s, %3$s, %4$s, %5$s or %6$s',
				__CLASS__ . '::ignoreSubdomain()',
				__CLASS__ . '::clear()',
				__CLASS__ . '::get()',
				__CLASS__ . '::open()',
				__CLASS__ . '::set()',
				'session_start()'
			);
		}
		
		$current_params = session_get_cookie_params();
		
		$params = array(
			$current_params['lifetime'],
			$current_params['path'],
			preg_replace('#.*?([a-z0-9\\-]+\.[a-z]+)$#iD', '.\1', $_SERVER['SERVER_NAME'])
		);
		
		call_user_func_array('session_set_cookie_params', $params);
	}
	
	
	/**
	 * Opens the session for writing, is automatically called by ::clear(), ::get() and ::set()
	 * 
	 * A `Cannot send session cache limiter` warning will be triggered if this,
	 * ::clear(), ::get() or ::set() is called after output has been sent to the
	 * browser. To prevent such a warning, explicitly call this method before
	 * generating any output.
	 * 
	 * @param  boolean $cookie_only_session_id  If the session id should only be allowed via cookie - this is a security issue and should only be set to `FALSE` when absolutely necessary 
	 * @return void
	 */
	static public function open($cookie_only_session_id=TRUE)
	{
		if (self::$open) { return; }
		
		self::$open = TRUE;
		
		// If the session is already open, we just piggy-back without setting options
		if (isset($_SESSION)) { return; }
		
		if ($cookie_only_session_id) {
			ini_set('session.use_cookies', 1);
			ini_set('session.use_only_cookies', 1);
		}
		session_start();
	}
	
	
	/**
	 * Resets the configuration of the class
	 * 
	 * @internal
	 * 
	 * @return void
	 */
	static public function reset()
	{
		self::destroy();
		self::close();	
	}
	
	
	/**
	 * Sets data to the `$_SESSION` superglobal, prefixing it with `fSession::` to prevent issues with `$_REQUEST`
	 * 
	 * @param  string $key     The name to save the value under
	 * @param  mixed  $value   The value to store
	 * @param  string $prefix  The prefix to stick before the key
	 * @return void
	 */
	static public function set($key, $value, $prefix='fSession::')
	{
		self::open();
		$_SESSION[$prefix . $key] = $value;
	}
	
	
	/**
	 * Sets the minimum length of a session - PHP might not clean up the session data right away once this timespan has elapsed
	 * 
	 * @param  string $timespan  An english description of a timespan (e.g. `'30 minutes'`, `'1 hour'`, `'1 day 2 hours'`)
	 * @return void
	 */
	static public function setLength($timespan)
	{
		if (self::$open || isset($_SESSION)) {
			throw new fProgrammerException(
				'%1$s must be called before any of %2$s, %3$s, %4$s, %5$s or %6$s',
				__CLASS__ . '::setLength()',
				__CLASS__ . '::clear()',
				__CLASS__ . '::get()',
				__CLASS__ . '::open()',
				__CLASS__ . '::set()',
				'session_start()'
			);
		}
		
		$seconds = strtotime($timespan) - time();
		ini_set('session.gc_maxlifetime', $seconds);
	}
	
	
	/**
	 * Sets the path to store session files in
	 * 
	 * @param  string|fDirectory $directory  The directory to store session files in
	 * @return void
	 */
	static public function setPath($directory)
	{
		if (self::$open || isset($_SESSION)) {
			throw new fProgrammerException(
				'%1$s must be called before any of %2$s, %3$s, %4$s, %5$s or %6$s',
				__CLASS__ . '::setPath()',
				__CLASS__ . '::clear()',
				__CLASS__ . '::get()',
				__CLASS__ . '::open()',
				__CLASS__ . '::set()',
				'session_start()'
			);
		}
		
		if (!$directory instanceof fDirectory) {
			$directory = new fDirectory($directory);	
		}
		
		if (!$directory->isWritable()) {
			throw new fEnvironmentException(
				'The directory specified, %s, is not writable',
				$directory->getPath()
			);	
		}
		
		session_save_path($directory->getPath());
	}
	
	
	/**
	 * Forces use as a static class
	 * 
	 * @return fSession
	 */
	private function __construct() { }
}



/**
 * Copyright (c) 2007-2009 Will Bond <will@flourishlib.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */