<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserProfile;

/**
 * ProfilSearch represents the model behind the search form about `app\models\UserProfile`.
 */
class ProfilSearch extends UserProfile
{

    public $page;
    public function rules()
    {
        return [
            [['user_id', 'lokasi_id'], 'integer'],
            [['firstname', 'lastname', 'nama_lengkap', 'bio_singkat', 'is_community', 'no_telp', 'avatar'], 'safe'],
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
        $query = UserProfile::find()->asArray();
        //$query = UserProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $this->load($params);
        if(isset($this->page)){
            $dataProvider->pagination->pageSize=$this->page; 
        }
        //$query->joinWith('idCostumer');
  

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'lokasi_id' => $this->lokasi_id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'nama_lengkap', $this->nama_lengkap])
            ->andFilterWhere(['like', 'bio_singkat', $this->bio_singkat])
            ->andFilterWhere(['like', 'is_community', $this->is_community])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        return $dataProvider;
    }
}
