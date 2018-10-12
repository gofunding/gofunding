<?php

namespace app\modules\log\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\log\models\LogSqlError;

/**
 * SqlError represents the model behind the search form about `app\modules\log\models\LogSqlError`.
 */
class SqlErrorSearch extends LogSqlError {

    public $fromDate;
    public $toDate;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'error_number', 'row_count', 'created_by'], 'integer'],
            [['sql_text', 'object_name', 'sql_state', 'error_message', 'description', 'created_at', 'fromDate', 'toDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = LogSqlError::find()->orderBy('created_at DESC');

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }

        $tanggal = explode('s/d', $this->created_at);

        if (isset($tanggal[0]) && isset($tanggal[1])) {
            $this->fromDate = date('Y-m-d', strtotime($tanggal[0]));
            $this->toDate = date('Y-m-d', strtotime($tanggal[1]));
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'error_number' => $this->error_number,
            'row_count' => $this->row_count,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'sql_text', $this->sql_text])
                ->andFilterWhere(['like', 'object_name', $this->object_name])
                ->andFilterWhere(['like', 'sql_state', $this->sql_state])
                ->andFilterWhere(['like', 'error_message', $this->error_message])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['between', 'FROM_UNIXTIME(created_at)', $this->fromDate, $this->toDate]);

        return $dataProvider;
    }

    public function searchOnDashboard() {
        $queryCount = "SELECT count(*) FROM log_sql_error";
        $query = "SELECT * FROM log_sql_error ORDER BY created_at DESC";

        $count = Yii::$app->db->createCommand($queryCount)->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $dataProvider;
    }

}
