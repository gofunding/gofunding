<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CampaignKategori;

/**
 * CampaignKategoriSearch represents the model behind the search form about `app\models\CampaignKategori`.
 */
class CampaignKategoriSearch extends CampaignKategori
{

    public $page;
    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
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
        $query = CampaignKategori::find()->asArray();
        //$query = CampaignKategori::find();

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
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
