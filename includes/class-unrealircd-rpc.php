<?php
/**
 * Communicate with UnrealIRCd via RPC
 *
 * @link        https://https://github.com/ValwareIRC
 * @since       1.0.0
 * @author      Valware <v.a.pond@outlook.com>
 * @package     Unrealircd
 * @subpackage  Unrealircd/includes
 */

/** Remote Procedure Call Class
 * 
*/

class RPC
{
	public $errs = [];
	public $errcount = 0; // more of a bool check
	public $content = [];
	public $body = [];
	function __construct()
	{
		if (!defined('UNREALIRCD_RPC_USER') ||
			!defined('UNREALIRCD_RPC_PASSWORD') ||
			!defined('UNREALIRCD_HOST') ||
			!defined('UNREALIRCD_PORT')
		) wp_die("Unable to find RPC credentials in your wp-config", "CONFIG_NEEDED");

		$sslverify = (defined('UNREALIRCD_SSL_VERIFY')) ? UNREALIRCD_SSL_VERIFY : true;

		$this->content['headers']['Content-Type'] = 'application/json';
		$this->content['headers']['Authorization'] = 'Basic ' . base64_encode(UNREALIRCD_RPC_USER.":".UNREALIRCD_RPC_PASSWORD);
		$this->content['body'] = NULL;
		$this->content['sslverify'] = $sslverify;
		$this->body['id'] = $this->generate_id();
		$this->body['jsonrpc'] = "2.0";
		$this->body['method'] = NULL; // MUST be set later
		$this->body['params'] = []; // CAN be set later
	}
	function add_body(array $b) : void
	{
		array_merge($this->body, $b);
	}

	private function generate_id()
	{
		$time = microtime(true);
		$str = (string)$time;
		$last = $str[strlen($str) - 1];
		$last = (int)$last;
		$id = $time * $time * $last;
		$id = md5(base64_encode($id));
		return $id;
	}

	/**
	 * This function sets the method of the RPC call you're making.
	 * For a list of available methods, see:
	 * https://www.unrealircd.org/docs/JSON-RPC#JSON-RPC_Methods
	 */
	function set_method(String $method) : void
	{
		$this->body['method'] = $method;
	}

	function set_params(array $params) : void
	{
		array_merge($this->body['params'], $params);
	}

	function execute()
	{
		$this->content['body'] = wp_json_encode($this->body);
		$apiResponse = wp_remote_post("https://".UNREALIRCD_HOST.":".UNREALIRCD_PORT."/api", $this->content);
		if ($apiResponse instanceof WP_Error)
		{
			self::die((array)$apiResponse);
			return;
		}
		if (!isset($apiResponse['body']))
		{
			unreal_log($apiResponse);
			return;
		}
		$this->result = $apiResponse['body'];
	}

	function fetch_assoc()
	{
		return json_decode($this->result, true);
	}

	static function die(array $err)
	{
		wp_die("There was a problem processing the request: ".$err['message']." (".$err['code'].")<br>Please contact the plugin author.<br>".
					"If you are a developer, see: <a href=\"https://www.unrealircd.org/docs/JSON-RPC#Error\">https://www.unrealircd.org/docs/JSON-RPC#Error</a>");
	}
}

class RPC_List
{
    static $user = [];
    static $channel = [];
    static $tkl = [];
    static $spamfilter = [];

	static $opercount = 0;
	static $services_count = 0;
	static $most_populated_channel = NULL;
	static $channel_pop_count = 0;
}

function rpc_pop_lists()
{
	$rpc = new RPC();

	/* Get the user list */
	$rpc->set_method("user.list");
	$rpc->execute();

	foreach($rpc->fetch_assoc() as $key => $value)
	{
		if ($key == "error")
		{
			RPC::die($value);
			return;
		}
		if ($key == "result")
			foreach($value['list'] as $r)
			{
				RPC_List::$user[] = $r;
				if (strpos($r['user']['modes'],"o") !== false && strpos($r['user']['modes'],"S") == false)
					RPC_List::$opercount++;
				elseif (strpos($r['user']['modes'],"S") !== false)
					RPC_List::$services_count++;
			}
	}

	/* Get the channels list */
	$rpc->set_method("channel.list");
	$rpc->execute();

	foreach($rpc->fetch_assoc() as $key => $value)
	{
		if ($key == "error")
		{
			RPC::die($value);
			return;
		}
		if ($key == "result")
			foreach($value['list'] as $r)
			{
				RPC_List::$channel[] = $r;
				if ($r['num_users'] > RPC_List::$channel_pop_count)
				{
					RPC_List::$channel_pop_count = $r['num_users'];
					RPC_List::$most_populated_channel = $r['name'];
				}
			}
	}
	
	/* Get the tkl list */
	$rpc->set_method("server_ban.list");
	$rpc->execute();

	foreach($rpc->fetch_assoc() as $key => $value)
	{
		if ($key == "error")
		{
			RPC::die($value);
			return;
		}
		if ($key == "result")
			foreach($value['list'] as $r)
				RPC_List::$tkl[] = $r;
	}

	
	/* Get the tkl list */
	$rpc->set_method("spamfilter.list");
	$rpc->execute();

	foreach($rpc->fetch_assoc() as $key => $value)
	{
		if ($key == "error")
		{
			RPC::die($value);
			return;
		}
		if ($key == "result")
			foreach($value['list'] as $r)
				RPC_List::$spamfilter[] = $r;
	}

}