<?php

namespace app\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '/dashboard/main';

        $query = 'SELECT (SELECT count(id) FROM campaign WHERE user_id=:user_id AND is_active=2) AS campaign, 
        (SELECT count(id) FROM donasi WHERE user_id=:user_id and `status`=2) AS donasi,
        (SELECT sum(nominal_donasi) FROM donasi WHERE user_id=:user_id AND `status`=2) AS donasi_tersalurkan';

        $data = Yii::$app->db->createCommand($query)->bindValue(':user_id', Yii::$app->user->id)->queryOne();

        return $this->render('index', [
            'campaign' => $data['campaign'],
            'donasi' => $data['donasi'],
            'donasiTersalurkan' => empty($data['donasi_tersalurkan']) ? 0 : $data['donasi_tersalurkan']
        ]);
    }
}
