<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use yii\helpers\Html;

/**
 * Description of GlobalFunction
 *
 * @author haifa
 */
class GlobalFunction {

    const ACTIVE = 1;
    const DEACTIVE = 0;
    /*
     * BEGIN
     * Below consts is using at menu Surat Masuk, Keluar & Rekapitulasi 
     */
    const FLAG_ACTIVE = '1';
    const FLAG_EXPIRED = '0';
    const ISACTIVE_ACTIVE = 1;
    const ISACTIVE_SOFTDELETE = 0;

    /* END */

    public static function mergePDFFiles(Array $filenames, $outFile) {
	if ($filenames) {
	    $filesTotal = sizeof($filenames);
	    $fileNumber = 1;

	    $mPdf = new \mPDF;
	    $mPdf->SetImportUse();

	    if (!file_exists($outFile)) {
		$handle = fopen($outFile, 'w');
		fclose($handle);
	    }

	    foreach ($filenames as $fileName) {
		$pagesInFile = $mPdf->SetSourceFile($fileName->tempName);
		for ($i = 1; $i <= $pagesInFile; $i++) {
		    $tplId = $mPdf->ImportPage($i);
		    $mPdf->UseTemplate($tplId);
		    if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
			$mPdf->WriteHTML('<pagebreak />');
		    }
		}
		$fileNumber++;
	    }

	    $mPdf->Output($outFile);
	}
    }

    public static function convertFilesToPdf(Array $filenames, $outFile) {
	if ($filenames) {
	    $filesTotal = sizeof($filenames);
	    $fileNumber = 1;

	    $mPdf = new \mPDF;
	    $mPdf->SetImportUse();

	    if (!file_exists($outFile)) {
		$handle = fopen($outFile, 'w');
		fclose($handle);
	    }

	    $pdf = 'application/pdf';
	    $docx = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	    $jpeg = 'image/jpeg';
	    $png = 'image/png';

	    foreach ($filenames as $fileName) {
		if ($fileName->type == $pdf) {
		    $pagesInFile = $mPdf->SetSourceFile($fileName->tempName);
		    for ($i = 1; $i <= $pagesInFile; $i++) {
			$tplId = $mPdf->ImportPage($i);
			$mPdf->UseTemplate($tplId);
			if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
			    $mPdf->WriteHTML('<pagebreak />');
			}
		    }
		} else if ($fileName->type == $jpeg || $fileName->type == $png) {
		    $inputPath = $fileName->tempName;
		    $html = '<img src="' . $inputPath . '"/>';
		    $mPdf->WriteHTML($html);
		    if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
			$mPdf->WriteHTML('<pagebreak />');
		    }
		}
		$fileNumber++;
	    }

	    $mPdf->Output($outFile, 'F');
	}
    }

    public static function getAccess() {
	$data = array_values(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
	if (!empty($data)) {
	    return $data[0]->name;
	} else {
	    return 'is Guset?';
	}
    }

    public static function checkAccess() {
	if (self::getAccess() == 'Super User' || self::getAccess() == 'Administrator' || self::getAccess() == 'Admin TU') {
	    return true;
	} else {
	    return false;
	}
    }

    public static function setNoUrut($tableName) {
	$user_id = Yii::$app->user->id;
	$filter = null;
	if (self::getAccess() != 'Administrator') {
	    $filter = ' WHERE created_by =' . $user_id;
	}
	$last_no_urut = Yii::$app->db->createCommand('SELECT count(id) AS no_urut FROM ' . $tableName . $filter)->queryOne();
	return $last_no_urut['no_urut'] + 1;
    }

    public static function getLogStatus($key = null) {
	if (!is_null($key)) {
	    $value = [
		0 => '<div class="label label-danger">Gagal</div>',
		1 => '<div class="label label-success">Sukses</div>',
	    ];
	} else {
	    $value = [
		0 => 'Gagal',
		1 => 'Sukses',
	    ];
	}

	return !is_null($key) ? $value[$key] : $value;
    }

    public function getStatusUser($key = null) {
	if (!is_null($key)) {
	    $value = [
		0 => '<div class="label label-danger"> ' . Yii::t('app', 'Inactive') . '</div>',
		5 => '<div class="label label-warning"> ' . Yii::t('app', 'Banned') . '</div>',
		10 => '<div class="label label-success">' . Yii::t('app', 'Active') . '</div>',
	    ];
	} else {
	    $value = [
		0 => Yii::t('app', 'Inactive'),
		5 => Yii::t('app', 'Banned'),
		10 => Yii::t('app', 'Active'),
	    ];
	}

	return !is_null($key) ? $value[$key] : $value;
    }

    public function isEmpty($value) {
	return !empty($value) ? Html::encode($value) : '-';
    }

    public function jabatanId() {
	return Yii::$app->user->identity->userProfile->jabatan_id;
    }

    public function unitKerjaId() {
	return Yii::$app->user->identity->userProfile->unit_kerja_id;
    }

    public function biroId() {
	return Yii::$app->user->identity->userProfile->biro_id;
    }
    
    public function penerimaId() {
	return Yii::$app->user->identity->userProfile->penerima_id;
    }

    public function nip() {
	return Yii::$app->user->identity->userProfile->nip;
    }

    function indonesianDate2($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
	if (trim($timestamp) == '') {
	    $timestamp = time();
	} elseif (!ctype_digit($timestamp)) {
	    $timestamp = strtotime($timestamp);
	}

	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace("/S/", "", $date_format);
	$pattern = array(
	    '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
	    '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
	    '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
	    '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
	    '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
	    '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
	    '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
	    '/November/', '/December/',
	);
	$replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
	    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
	    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
	    'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'Sepember',
	    'Oktober', 'November', 'Desember',
	);
	$date = date($date_format, $timestamp);
	$date = preg_replace($pattern, $replace, $date);
	$date = "{$date} {$suffix}";

	return $date;
    }

    function indonesianDate($date_format) {
	$date_format = preg_replace("/S/", "", $date_format);
	$pattern = array(
	    '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
	    '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
	    '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
	    '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
	    '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
	    '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
	    '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
	    '/November/', '/December/',
	);
	$replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
	    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
	    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
	    'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'Sepember',
	    'Oktober', 'November', 'Desember',
	);

	return preg_replace($pattern, $replace, $date_format);
	}
	
	public function isActive($param = null) {
		$data = [
			1 => Yii::t('app', 'Active'),
			2 => Yii::t('app', 'Non Active'),
		];

		return !empty($param) ? $data[$param] : $data;
	}

}
