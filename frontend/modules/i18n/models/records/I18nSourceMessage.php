<?php

namespace frontend\modules\i18n\models\records;

use Yii;

/**
 * This is the model class for table "i18n_source_message".
 *
 * @property int $id
 * @property string $category
 * @property string $message
 *
 * @property I18nMessage[] $i18nMessages
 */
class I18nSourceMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'i18n_source_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('i18n', 'ID'),
            'category' => Yii::t('i18n', 'Category'),
            'message' => Yii::t('i18n', 'Message'),
        ];
    }

    /**
     * Gets query for [[I18nMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI18nMessages()
    {
        return $this->hasMany(I18nMessage::class, ['id' => 'id']);
    }
}
