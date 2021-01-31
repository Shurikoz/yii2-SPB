<?php

use yii\widgets\LinkPager;

$this->title = 'Feedback';

?>

<?php foreach($model as $item){ ?>
    <p><b>Имя:</b> <?= $item->name ?></p>
    <p><b>Email:</b> <?= $item->email ?></p>
    <p><b>Телефон:</b> <?= $item->phone ?></p>
    <p><b>Сообщение:</b> <?= $item->message ?></p>
    <hr>
<?php } ?>

<?= LinkPager::widget([
    'pagination' => $pages,
]); ?>