<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donasi;

/**
 * DonasiSearch represents the model behind the search form about `app\models\Donasi`.
 */
class DonasiSearch extends Donasi
{

    public $page;
    public $judul_campaign;

    public function rules()
    {
        return [
            [['id', 'campaign_id', 'user_id', 'kode_unik', 'nominal_donasi', 'bank_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_donasi', 'status', 'is_anonim', 'komentar', 'phone_penerima_sms', 'transfer_sebelum'], 'safe'],
            ['page', 'safe'],
            ['judul_campaign', 'string'],
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Donasi::find()->asArray();
        $query->joinWith(['campaign', 'bank']);
        $query->where(['donasi.user_id' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if(isset($this->page)){
            $dataProvider->pagination->pageSize=$this->page; 
        } else {
            $dataProvider->pagination->pageSize= 10; 
        }

        if (!empty($params['DonasiSearch']['tanggal_donasi'])) {
            $tanggal_donasi = date('Y-m-d', strtotime($this->tanggal_donasi));
        } else {
            $tanggal_donasi = null;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            // 'campaign_id' => $this->campaign_id,
            // 'user_id' => $this->user_id,
            'kode_unik' => $this->kode_unik,
            // 'nominal_donasi' => $this->nominal_donasi,
            // 'tanggal_donasi' => $tanggal_donasi,
            'bank_id' => $this->bank_id,
            'transfer_sebelum' => $this->transfer_sebelum,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'is_anonim', $this->is_anonim])
            ->andFilterWhere(['like', 'komentar', $this->komentar])
            ->andFilterWhere(['like', 'phone_penerima_sms', $this->phone_penerima_sms])
            ->andFilterWhere(['like', 'judul_campaign', $this->judul_campaign])
            ->andFilterWhere(['like', 'nominal_donasi', $this->nominal_donasi])
            ->andFilterWhere(['like', 'tanggal_donasi', $tanggal_donasi])
            ;

        return $dataProvider;
    }
}
