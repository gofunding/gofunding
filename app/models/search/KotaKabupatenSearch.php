<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KotaKabupaten;

/**
 * KotaKabupatenSearch represents the model behind the search form about `app\models\KotaKabupaten`.
 */
class KotaKabupatenSearch extends KotaKabupaten
{

    public $page;
    public function rules()
    {
        return [
            [['id', 'provinsi_id'], 'integer'],
            [['nama'], 'safe'],
            ['page', 'safe']
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = KotaKabupaten::find()->asArray();
        $query->joinWith('provinsi');
        //$query = KotaKabupaten::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $this->load($params);
        if(isset($this->page)){
            $dataProvider->pagination->pageSize=$this->page; 
        }
        //$query->joinWith('idCostumer');
  

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'kota_kabupaten.nama', $this->nama])
            ->andFilterWhere(['like', 'provinsi.nama', $this->provinsi_id]);

        return $dataProvider;
    }
}
