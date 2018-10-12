<?php
namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donatur;

/**
 * DonaturSearch represents the model behind the search form about `app\models\Donatur`.
 */
class DonaturSearch extends Donatur
{

    public $page;

    public function rules()
    {
        return [
            [['id', 'campaign_id', 'user_id', 'donasi_id', 'nominal_donasi', 'biaya_administrasi', 'donasi_bersih', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = Donatur::find()->asArray();
        $query->andWhere(['donatur.campaign_id' => $id]);
        $query->joinWith(['donasi', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }

        $query->andFilterWhere([
//            'id' => $this->id,
//            'campaign_id' => $this->campaign_id,
//            'user_id' => $this->user_id,
            'donasi_id' => $this->donasi_id,
            'nominal_donasi' => $this->nominal_donasi,
            'biaya_administrasi' => $this->biaya_administrasi,
            'donasi_bersih' => $this->donasi_bersih,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'user_profile.nama_lengkap', $this->user_id]);

        return $dataProvider;
    }
}
