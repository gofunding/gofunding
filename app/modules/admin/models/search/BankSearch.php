<?php
namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bank;

/**
 * BankSearch represents the model behind the search form about `app\models\Bank`.
 */
class BankSearch extends Bank
{

    public $page;

    public function rules()
    {
        return [
            [['nama_bank', 'nama_payment'], 'string'],
            [['biaya_per_transaksi', 'va_number', 'is_active'], 'integer'],
            [['path_logo'], 'string'],
            [['page', 'is_va'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Bank::find()->asArray();
        //$query = Bank::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }
        //$query->joinWith('idCostumer');

        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_va' => $this->is_va,
        ]);

        $query->andFilterWhere(['like', 'nama_bank', $this->nama_bank]);

        return $dataProvider;
    }
}
