<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donasi;

/**
 * DonasiSearch represents the model behind the search form about `app\models\Donasi`.
 */
class DonasiSearch extends Donasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'user_id', 'kode_unik', 'nominal_donasi', 'bank_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_donasi', 'status', 'is_anonim', 'komentar', 'phone_penerima_sms', 'transfer_sebelum'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Donasi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'user_id' => $this->user_id,
            'kode_unik' => $this->kode_unik,
            'nominal_donasi' => $this->nominal_donasi,
            'tanggal_donasi' => $this->tanggal_donasi,
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
            ->andFilterWhere(['like', 'phone_penerima_sms', $this->phone_penerima_sms]);

        return $dataProvider;
    }
}
