<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\log\components;

/**
 * Description of ActionLogs
 *
 * @author haifahrul
 */
use Yii;

class ActionLogs {

//    public function create($action) {
//        if ($this->checkResponse(Yii::$app->response->getStatusCode())) { // Found || Success
//            $status = 1;
//        } else {
//            $status = 0;
//        }
//
//        self::saveToDatabase('log_create', $status, $action, $desc);
//    }
//
//    public function update($action, $desc = null) {
//        if ($this->checkResponse(Yii::$app->response->getStatusCode())) { // Found || Success
//            $status = 1;
//        } else {
//            $status = 0;
//        }
//
//        self::saveToDatabase("log_update", $status, $action, $desc);
//    }
//
//    public function view($action, $desc = null) {
//        if ($this->checkResponse(Yii::$app->response->getStatusCode())) { // Found || Success
//            $status = 1;
//        } else {
//            $status = 0;
//        }
//
//        self::saveToDatabase("log_view", $status, $action, $desc);
//    }

    public function setLog($action) {
	$actionId = $action->id;
	$module = $action->controller->module->id;
	$id = !empty($action->controller->actionParams['id']) ? $action->controller->actionParams['id'] : '';

	if ($module == 'tnde') {
	    $desc = $action->controller->id . '/' . $actionId . ' : ' . $id;
	} else {
	    $desc = $module . '/' . $action->controller->id . '/' . $actionId . ' : ' . $id;
	}

	if ($this->checkResponse(Yii::$app->response->getStatusCode())) { // Found || Success
	    $status = 1;
	} else {
	    $status = 0;
	}

	// log_view
	if ($actionId == 'view') {
	    self::saveToDatabase("log_view", $status, $action, $desc);
	} else if ($actionId == 'view-cetak-barcode') {
	    $desc .= isset($_GET['data']) ? implode(', ', $_GET['data']) : '-';
	    self::saveToDatabase("log_view", $status, $action, $desc);
	}
	// log_create
	else if ($actionId == 'create' || $actionId == 'pemesanan-nomor-surat-keluar' || $actionId == 'pemesanan-nomor-surat-undangan' || $actionId == 'pemesanan-nomor-surat-intern' || $actionId == 'pemesanan-nomor-surat-lain-lain' || $actionId == 'registrasi' || $action->controller->id . '/' . $actionId == 'barcode/surat-keluar' || $action->controller->id . '/' . $actionId == 'barcode/surat-masuk') {
	    if ($module == 'tnde') {
		$desc = $action->controller->id . '/' . $actionId;
	    } else {
		$desc = $module . '/' . $action->controller->id . '/' . $actionId;
	    }
	    self::saveToDatabase("log_create", $status, $action, $desc);
	}
	// log_edit
	else if ($actionId == 'update' || $actionId == 'change-password') {
	    self::saveToDatabase('log_edit', $status, $action, $desc);
	}
	// log_delete
	else if ($actionId == 'delete' || $actionId == 'delete-items') {
	    self::saveToDatabase("log_delete", $status, $action, $desc);
	}
	// log_print
	else if ($actionId == 'print') {
	    self::saveToDatabase("log_print", $status, $action, $desc);
	} else if ($actionId == 'cetak-pdf') {
	    $fromDate = isset($_GET[1]['JumlahSuratSearch']['from_date']) ? $_GET[1]['JumlahSuratSearch']['from_date'] : '-';
	    $toDate = isset($_GET[1]['JumlahSuratSearch']['to_date']) ? $_GET[1]['JumlahSuratSearch']['to_date'] : '-';
	    $desc .= $fromDate . ' s/d ' . $toDate;
	    self::saveToDatabase("log_print", $status, $action, $desc);
	} else if ($actionId == 'cetak-barcode') {
	    $desc .= isset($_GET['id']) ? implode(', ', $_GET['id']) : '-';
	    self::saveToDatabase("log_print", $status, $action, $desc);
	}
	// log_download 
	else if ($actionId == 'download') {
	    self::saveToDatabase("log_download", $status, $action, $desc);
	}
    }

    protected function saveToDatabase($nameTable, $status, $action, $desc) {
	$detect = Yii::$app->detect;
	$result['uid'] = $uid = Yii::$app->user->id;
	$result['username'] = $username = !empty(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : null;
	$result['email'] = !empty(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : null;
	$result['action'] = Yii::$app->controller->route;
	$result['ip'] = $ip = $this->getClientIp();
	$result['deviceType'] = $deviceType = $detect::deviceType();
	$result['os'] = $os = $detect::os();
	$result['browser'] = $browser = $detect::browser();
	$result['status'] = $status;
	$result['desc'] = $desc;
	$result['time'] = date('Y-m-d H:i:s');

	Yii::$app->db->createCommand()->insert($nameTable, [
	    'log_id' => NULL,
	    'uid' => $uid,
	    'username' => $username,
	    'ip' => $ip,
	    'os_device' => $os . ', ' . $deviceType . ', ' . $browser,
	    'status' => $status,
	    'desc' => $desc,
	    'data_json' => json_encode($result, JSON_PRETTY_PRINT)])->execute();
    }

    protected function checkResponse($code) {
//        return in_array($code, [400, 409, 403, 410, 405, 406, 404, 500, 429, 401, 415]);
	return in_array($code, [200, 302]); // success || found
    }

    // using getenv() Function to get the client IP address
    protected function getClientIp() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
	    $ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
	    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
	    $ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
	    $ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
	    $ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
	    $ipaddress = getenv('REMOTE_ADDR');
	else
	    $ipaddress = 'UNKNOWN';
	return $ipaddress;
    }

    public function setLogDownload() {
	if (isset($_POST['export_type']) == 'Excel5' || isset($_POST['export_type']) == 'Excel2007' || isset($_POST['export_type']) == 'PDF' || isset(Yii::$app->controller->action->id) == 'export-pdf' || isset(Yii::$app->controller->action->id) == 'export-pdf-per-biro') {

	    $action = Yii::$app;
	    $module = $action->controller->module->id;
	    $actionId = Yii::$app->controller->action->id;
	    $id = null;

	    if (isset($_POST['export_type']) == 'Excel5') {
		$id = 'Excel 95';
		$actionId = 'export';
	    } else if (isset($_POST['export_type']) == 'Excel2007') {
		$id = 'Excel 2007';
		$actionId = 'export';
	    } else if (isset($_POST['export_type']) == 'PDF' || $actionId == 'export-pdf') {
		$id = 'PDF';
		$actionId = 'export-pdf';
	    } else if ($actionId == 'export-pdf-per-biro') {
		$id = 'PDF';
	    }

	    if ($action->controller->action->id == 'per-biro') {
		$desc = $module . '/' . $action->controller->id . '/' . $action->controller->action->id . ' : ' . $id;
	    } elseif ($module == 'tnde') {
		$desc = $action->controller->id . '/' . $actionId . ' : ' . $id;
	    } else {
		$desc = $module . '/' . $action->controller->id . '/' . $actionId . ' : ' . $id;
	    }

	    if ($this->checkResponse(Yii::$app->response->getStatusCode())) { // Found || Success
		$status = 1;
	    } else {
		$status = 0;
	    }

	    self::saveToDatabase("log_download", $status, $action, $desc);
	}
    }

}
