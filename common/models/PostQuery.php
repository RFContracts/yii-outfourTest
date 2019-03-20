<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Post
 */
class PostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param $builder
     * @return \yii\db\ActiveQuery|\yii\db\Query
     */
    public function prepare($builder)
    {
        $this->andWhere(['post.is_deleted' => false]);
        return parent::prepare($builder);
    }

    /**
     * {@inheritdoc}
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
