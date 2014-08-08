<?php
class Allocine
{
	private $_api_url = 'http://api.allocine.fr/rest/v3';
	private $_partner_key;
	private $_secret_key;
	private $_user_agent = 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; Nexus 4 Build/JDQ39E)';

	// Constructeur
	public function __construct($partner_key, $secret_key)
	{
		$this->_partner_key = $partner_key;
		$this->_secret_key = $secret_key;
	}

	// Envoi requête
	private function _do_request($method, $params)
	{
		// Création URL
		$query_url = $this->_api_url.'/'.$method;
 
		// Création query
		$sed = date('Ymd');
		$sig = urlencode(base64_encode(sha1($this->_secret_key.http_build_query($params).'&sed='.$sed, true)));
		$query_url .= '?'.http_build_query($params).'&sed='.$sed.'&sig='.$sig;
 
		// Envoi requête
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $query_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->_user_agent);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$response = curl_exec($ch);
		curl_close($ch);
 
		return $response;
	}

	// Création recherche
	public function search($query)
	{
		// Création tableau paramétrage
		$params = array(
			'partner' => $this->_partner_key,
			'q' => $query,
			'format' => 'json',
			'filter' => 'movie'
		);
 
		// Envoi requête
		$response = $this->_do_request('search', $params);
		 
		return $response;
	}

	// Récupération élément
	public function get($id)
	{
		// Création tableau paramétrage
		$params = array(
			'partner' => $this->_partner_key,
			'code' => $id,
			'profile' => 'large',
			'filter' => 'movie',
			'striptags' => 'synopsis,synopsisshort',
			'format' => 'json',
		);
 
		// Envoi requête
		$response = $this->_do_request('movie', $params);
 
		return $response;
	}
}
?>