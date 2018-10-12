<?php

namespace app\modules\userManagement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\userManagement\models\User;

/**
 * UserSearch represents the model behind the search form about `app\modules\administrator\models\User`.
 */
class UserSearch extends User {

    public $page;
    public $roles;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'roles', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'page'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = User::find();
        $query->leftJoin('auth_assignment aa', '`user`.id=aa.user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);        
        if (isset($this->page)) {
            $dataProvider->pagination->pageSize = $this->page;
        }
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'aa.item_name', $this->roles])                
                ->andFilterWhere(['=', 'FROM_UNIXTIME(`user`.created_at, "%d-%m-%Y")', $this->created_at])
                ->andFilterWhere(['=', 'FROM_UNIXTIME(`user`.updated_at, "%d-%m-%Y")', $this->updated_at]);

        return $dataProvider;
    }

}
