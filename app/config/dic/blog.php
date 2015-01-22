<?php

return array(

    'fields' => function() {

        return array(
            'image_id' => array(
                'title' => 'Основное изображение',
                'type' => 'image',
            ),
            'preview' => array(
                'title' => 'Анонс записи',
                'type' => 'textarea',
            ),
            'full_text' => array(
                'title' => 'Полный текст записи',
                'type' => 'textarea_redactor',
            ),
        );
    },

    'seo' => 0,

    'versions' => 0,

);