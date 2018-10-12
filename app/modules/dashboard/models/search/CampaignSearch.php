<?php

namespace app\modules\dashboard\models\search;

use app\models\Campaign;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * CampaignSearch represents the model behind the search form about `app\models\Campaign`.
 */
class CampaignSearch extends Campaign
{

    public $page;
    public function rules()
    {
        return [
            [['id', 'user_id', 'target_donasi', 'kategori_id', 'lokasi_id', 'terkumpul', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['judul_campaign', 'link', 'deadline', 'cover_image', 'video_url', 'deskripsi_singkat', 'deskripsi_lengkap', 'is_reached', 'is_agree', 'is_active', 'is_community'], 'safe'],
            ['page', 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Campaign::find()->asArray();
        $query->joinWith('userProfile');
        $query->where(['campaign.user_id' => Yii::$app->user->id]);
        // Menampilkan data yang Life / di terima
        // $query->where(['campaign.is_active' => Campaign::IS_ACTIVE_LIFE]); 
        // Filter berdasarkan sisa hari (deadline)
        // $query->andWhere(['>', 'campaign.deadline', date('Y-m-d')]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if(isset($this->page)){
            $dataProvider->pagination->pageSize=$this->page; 
        } else {
            $dataProvider->pagination->pageSize= 10; 
        }

        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'target_donasi' => $this->target_donasi,
            // 'deadline' => $this->deadline,
            // 'kategori_id' => $this->kategori_id,
            // 'lokasi_id' => $this->lokasi_id,
            // 'terkumpul' => $this->terkumpul,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'judul_campaign', $this->judul_campaign])
            // ->andFilterWhere(['like', 'link', $this->link])
            // ->andFilterWhere(['like', 'cover_image', $this->cover_image])
            // ->andFilterWhere(['like', 'video_url', $this->video_url])
            // ->andFilterWhere(['like', 'deskripsi_singkat', $this->deskripsi_singkat])
            // ->andFilterWhere(['like', 'deskripsi_lengkap', $this->deskripsi_lengkap])
            ->andFilterWhere(['like', 'is_reached', $this->is_reached])
            // ->andFilterWhere(['like', 'is_agree', $this->is_agree])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);
            // ->andFilterWhere(['like', 'is_community', $this->is_community]);

        return $dataProvider;
    }
}
