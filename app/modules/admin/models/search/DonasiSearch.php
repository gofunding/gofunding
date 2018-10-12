<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donasi;

/**
 * DonasiSearch represents the model behind the search form about `app\models\Donasi`.
 */
class DonasiSearch extends Donasi {

    public $page;

    public function rules() {
        return [
                [['id', 'campaign_id', 'user_id', 'nominal_donasi', 'bank_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'order_id', 'kode_unik'], 'integer'],
                [['tanggal_donasi', 'status', 'is_anonim', 'komentar', 'phone_penerima_sms', 'transfer_sebelum', 'signature_key', 'upload_bukti_transaksi'], 'safe'],
                ['page', 'safe']
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Donasi::find()->asArray();
        $query->joinWith(['campaign', 'userProfile', 'bank']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }
        
        if (!empty($params['DonasiSearch']['tanggal_donasi'])) {
            $tanggal_donasi = date('Y-m-d', strtotime($this->tanggal_donasi));
        } else {
            $tanggal_donasi = null;
        }

        $query->andFilterWhere([
            'id' => $this->id,
//            'campaign_id' => $this->campaign_id,
//            'user_id' => $this->user_id,
//            'nominal_donasi' => $this->nominal_donasi,
//            'tanggal_donasi' => $this->tanggal_donasi,
            'bank_id' => $this->bank_id,
            'transfer_sebelum' => $this->transfer_sebelum,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'order_id' => $this->order_id,
            'kode_unik' => $this->kode_unik,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'is_anonim', $this->is_anonim])
                ->andFilterWhere(['like', 'komentar', $this->komentar])
                ->andFilterWhere(['like', 'phone_penerima_sms', $this->phone_penerima_sms])
                ->andFilterWhere(['like', 'signature_key', $this->signature_key])
                ->andFilterWhere(['like', 'upload_bukti_transaksi', $this->upload_bukti_transaksi])
                ->andFilterWhere(['like', 'campaign.judul_campaign', $this->campaign_id])
                ->andFilterWhere(['like', 'user_profile.nama_lengkap', $this->user_id])
                ->andFilterWhere(['like', 'nominal_donasi', $this->nominal_donasi])
                ->andFilterWhere(['like', 'tanggal_donasi', $tanggal_donasi])
                ;

        return $dataProvider;
    }

}
