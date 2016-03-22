<?php

//$callback	= !empty($callback) ? $callback : null;
$data		= (isset($data) && !empty($data)) ? (array)$data : array('status' => 'fail', 'message' => 'NoDataFound', 'data' => null);

/*if (Configure::read('debug') >= 2) {
	$data['debug'] = json_decode($this -> element('sql_dump'));
}*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode($data);

exit;
?>