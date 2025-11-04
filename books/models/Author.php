<?php
declare(strict_types=1);

namespace books\models;

use yii\db\ActiveRecord;

/**
 * Author model
 *
 * @property integer $id
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 * @property integer $created_at
 * @property integer $updated_at
 */
final class Author extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'surname'], 'required'],
            [['firstname', 'surname', 'patronymic'], 'string', 'max' => 255]
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id']);
    }
}