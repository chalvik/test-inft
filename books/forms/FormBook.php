<?php
declare(strict_types=1);

namespace books\forms;

use yii\base\Model;

class FormBook extends Model
{
public string $title;
public string $description;
public int $year;
public string $isbn;
public string $image;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'year', 'isbn','authors'], 'required'],
            [['year'], 'integer'],
            [['authors'], 'array'],
            [['description'], 'string'],
            [['title', 'isbn', 'image'],  'string', 'max' => 255],
        ];
    }
}