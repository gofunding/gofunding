<?php

namespace app\modules\log\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\log\models\Login;

/**
 * LoginSearch represents the model behind the search form about `app\modules\log\models\Login`.
 */
class LoginSearch extends Login {

    public $page;
    public $fromDate;
    public $toDate;

    public function rules() {
        return [
            [['id', 'log_id', 'uid'], 'integer'],
            [['date', 'ip', 'os_device', 'status', 'desc', 'data_json', 'fromDate', 'toDate'], 'safe'],
            [['page', 'username'], 'safe']
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Login::find()->asArray();
        //$query = Login::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]]
        ]);

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }
        //$query->joinWith('idCostumer');

        $tanggal = explode('s/d', $this->date);
        if (isset($tanggal[0]) && isset($tanggal[1])) {
            $this->fromDate = date('Y-m-d', strtotime($tanggal[0]));
            $this->toDate = date('Y-m-d', strtotime($tanggal[1]));
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'log_id' => $this->log_id,
//            'date' => $this->date,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'os_device', $this->os_device])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'data_json', $this->data_json])
                ->andFilterWhere(['like', 'desc', $this->desc])
                ->andFilterWhere(['between', 'date', $this->fromDate, $this->toDate]);
//                ->andFilterWhere(['>=', 'date', $this->fromDate])
//                ->andFilterWhere(['<=', 'date', $this->toDate]);

        return $dataProvider;
    }

    public function searchOnDashboard() {

        $queryCount = "SELECT count(*) FROM log_login";
        $query = "SELECT * FROM log_login ORDER BY date DESC";

        $count = Yii::$app->db->createCommand($queryCount)->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
//            'sort' => [
//                'defaultOrder' => ['date' => SORT_DESC],
//                'attributes' => [
//                    'date'
//                ],
//            ],
        ]);

        return $dataProvider;
    }

}
