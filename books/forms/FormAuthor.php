<?php
declare(strict_types=1);

namespace books\forms;

use yii\base\Model;

/**
 * Author form
 *
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 */
class FormAuthor extends Model
{
public string $firstname;
public string $surname;
public int $patronymic;

    private $_user;


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
}