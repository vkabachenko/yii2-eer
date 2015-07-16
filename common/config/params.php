<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    /* расшифровка кодов полей втаблицах.
    Массив: ключ - таблица.поле,
    значение - параметр с массивом расшифровки
    */
    'decode' => [
        'program.level' => ['бакалавриат','магистратура','специалитет','аспирантура'],
        'program.form' => ['очное','заочное'],
        'discipline.kind' => ['дисциплина', 'практика', 'ГИА'],
        'discipline.block' => ['базовый','вариативный','ДПВ'], // см. common/models/Discipline
    ],


];
