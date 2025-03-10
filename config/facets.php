<?php
/*
 * Topics, Blogs and Pages
 * Темы, Блоги и Страницы
 */

return [
    // The number of topics and blogs that the participant reads on the sidebar
    // Количество тем и блогов которые читает участник на боковой панели
    'quantity_home' => 10,

    // Pages with information about the site (link in the footer of the site) 
    // The URL must match the SLUG of the posts attached to the Info facet
    // Страницы с информацией про сайт (ссылка в подвале сайта)
    // URL должен совпадать с SLUG постов прикрепленного с фасету Информация
    'page-one'      => 'information',
    'page-two'      => 'privacy',

    // Default facets settings for an unauthorized participant
    // Настройки тем по умолчанию для не авторизованного участника
    'default' => [
        [
            'img'   => '/uploads/facets/logos/t-1-1625149922.jpeg',
            'name'  => Translate::get('SEO'),
            'url'   => '/topic/seo',
        ], [
            'img'   => '/uploads/facets/logos/t-2-1625149821.jpeg',
            'name'  => Translate::get('interesting sites'),
            'url'   => '/topic/sites',
        ],
    ],
];
