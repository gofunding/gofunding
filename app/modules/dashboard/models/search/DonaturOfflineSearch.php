<?php
namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DonaturOffline;

/**
 * DonaturOfflineSearch represents the model behind the search form about `app\models\DonaturOffline`.
 */
class DonaturOfflineSearch extends DonaturOffline
{

    public $page;

    public function rules()
    {
        return [
            [['id', 'campaign_id', 'user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama_donatur', 'nominal_donasi', 'tanggal_donasi'], 'safe'],
            ['page', 'safe']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $id = null)
    {
        $query = DonaturOffline::find()->asArray();
        $query->where(['campaign_id' => $id]);
//        $query->joinWith('idCostumer');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'user_id' => $this->user_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'nama_donatur', $this->nama_donatur])
            ->andFilterWhere(['like', 'nominal_donasi', $this->nominal_donasi])
            ->andFilterWhere(['like', 'DATE_FORMAT(tanggal_donasi, "%d-%m-%Y")', $this->tanggal_donasi]);

        return $dataProvider;
    }
}
