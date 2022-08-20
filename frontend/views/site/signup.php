<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use frontend\models\SignupForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>


<table class="registration-table">
    <td>
        <div class="registration-form-container">
            <h1 class="title">
                Регистрация
                <a href="#!">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M35.6998 18.1C35.3998 28.2 27.6998 35.8 17.8998 35.8C7.69982 35.7 0.199816 27.8 0.299816 18C0.399816 7.79999 8.19982 0.299988 17.9998 0.299988C27.9998 0.299988 35.4998 8.09999 35.6998 18.1ZM18.0998 2.39999C9.49982 2.39999 2.49982 9.39999 2.39982 17.9C2.29982 26.5 9.39982 33.6 17.8998 33.7C26.3998 33.7 33.4998 26.8 33.5998 18.2C33.6998 9.59999 26.5998 2.49999 18.0998 2.39999Z"
                              fill="#195EA0"/>
                        <path d="M23.8002 15C23.8002 16.4 22.9002 17.9 21.6002 19.1C20.4002 20.3 19.1002 21.3 18.8002 23.1C18.8002 23.4 18.1002 23.8 17.8002 23.7C17.5002 23.6 17.0002 23 17.0002 22.8C17.3002 21.7 17.6002 20.5 18.2002 19.6C18.8002 18.6 19.9002 17.9 20.6002 17C21.7002 15.7 21.9002 14.2 21.1002 12.7C20.4002 11.3 19.0002 10.6 17.4002 10.8C15.9002 11 14.8002 11.9 14.4002 13.3C14.3002 13.6 14.2002 14.3 14.0002 14.6C13.7002 15 13.6002 15.4 13.1002 15.4C12.6002 15.4 12.2002 14.6 12.2002 14.2C12.2002 11.9 13.4002 10.2 15.4002 9.29998C17.6002 8.19998 19.7002 8.49998 21.6002 9.99998C23.1002 11.1 23.8002 12.7 23.8002 15Z"
                              fill="#195EA0"/>
                        <path d="M18.0994 28.6C19.0383 28.6 19.7994 27.8389 19.7994 26.9C19.7994 25.9611 19.0383 25.2 18.0994 25.2C17.1605 25.2 16.3994 25.9611 16.3994 26.9C16.3994 27.8389 17.1605 28.6 18.0994 28.6Z"
                              fill="#195EA0"/>
                    </svg>
                </a>
            </h1>
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => [
                    'class' => 'registration-form',
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>

            <?= $form->errorSummary($model) ?>

            <div class="registration-input-group">
                <div class="input-container">
                    <label for="sources">
                        Гражданство
                    </label>
                    <select name="sources" id="sources" class="custom-select sources" placeholder="Выберите страну">
                        <option value="1">Узбекистан</option>
                        <option value="2">Казахстан</option>
                        <option value="3">Россия</option>
                        <option value="4">Туркменистан</option>
                    </select>
                </div>
                <div class="input-container">
                    <div class="input-group">
                        <?= $form->field($model, 'gender',
                            [
                                'options' => ['class' => 'input-container'],
                            ])->radioList(['0' => 'М', '1' => 'Ж']) ?>

                        <div class="input-container">
                            <label for="">Дата рождения</label>
                            <input type="date" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="registration-input-group">
                <div class="input-container">
                    <label for="sources">
                        Регион проживания
                    </label>
                    <select name="sources" id="sources" class="custom-select sources" placeholder="Выберите страну">
                        <option value="1">Узбекистан</option>
                        <option value="2">Казахстан</option>
                        <option value="3">Россия</option>
                        <option value="4">Туркменистан</option>
                    </select>
                </div>
                <div class="input-container">
                    <label for="sources">
                        Электронная почта
                    </label>
                    <input type="email" placeholder="name@name.ru">
                    <span class="error">Введите E-mail</span>
                </div>
            </div>
            <div class="registration-input-group">
                <?= $form->field($model, 'last_name', [
                    'template' => ' {label} {input} {error}',
                    'options' => ['class' => 'input-container'],
                    'inputOptions' => [
                        'placeholder' => 'Введите фамилию',
                        'class' => 'order-input long_map',
                    ]
                ])->textInput() ?>

                <div class="input-container">
                    <label for="sources">
                        Номер
                    </label>
                    <input id="phoneNumber" type="tel" placeholder="+7 (999) 111-11-11">
                </div>
            </div>
            <div class="registration-input-group">
                <?= $form->field($model, 'first_name', [
                    'template' => ' {label} {input} {error}',
                    'options' => ['class' => 'input-container'],
                    'inputOptions' => [
                        'placeholder' => 'Введите имя',
                        'class' => 'order-input long_map',
                    ]
                ])->textInput() ?>
            </div>
            <div class="registration-input-group">
                <?= $form->field($model, 'middle_name', [
                    'template' => ' {label} {input} {error}',
                    'options' => ['class' => 'input-container'],
                    'inputOptions' => [
                        'placeholder' => 'Введите фамилию',
                        'class' => 'order-input long_map',
                    ]
                ])->textInput() ?>
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn-fill', 'name' => 'signup-button']) ?>
            </div>
            <div class="registration-input-group">
                <?= $form->field($model, 'is_agree_personal_data',
                    [
                        'options' => [
                            'tag' => false
                        ],
                    ])->checkbox([
                        'label' => '<span class="checkmark-checkbox"></span>' . SignupForm::instance()->getAttributeLabel('is_agree_personal_data'),
                        'labelOptions' => [
                            'class' => 'custom-checkbox'
                        ],

                    ]
                ) ?>
            </div>
            <div class="registration-input-group">
                <?= $form->field($model, 'is_user_accepted_agreement',
                    [
                        'options' => [
                            'tag' => false
                        ],
                    ])->checkbox([
                        'label' => '<span class="checkmark-checkbox"></span>' . SignupForm::instance()->getAttributeLabel('is_user_accepted_agreement'),
                        'labelOptions' => [
                            'class' => 'custom-checkbox'
                        ],

                    ]
                ) ?>
            </div>
            <div class="user-agreement">
                <a href="#!">
                    Ознакомиться с пользовательским соглашением
                </a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </td>
</table>