--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `answer_post_id` int(11) NOT NULL DEFAULT '0',
  `answer_user_id` int(11) NOT NULL DEFAULT '0',
  `answer_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answer_modified` timestamp NOT NULL DEFAULT '2020-12-29 15:00:00',
  `answer_published` tinyint(1) NOT NULL DEFAULT '1',
  `answer_ip` varbinary(16) DEFAULT NULL,
  `answer_order` smallint(6) NOT NULL DEFAULT '0',
  `answer_after` smallint(6) NOT NULL DEFAULT '0',
  `answer_votes` smallint(6) NOT NULL DEFAULT '0',
  `answer_content` text NOT NULL,
  `answer_lo` int(11) NOT NULL DEFAULT '0',
  `answer_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`answer_id`, `answer_post_id`, `answer_user_id`, `answer_date`, `answer_modified`, `answer_published`, `answer_ip`, `answer_order`, `answer_after`, `answer_votes`, `answer_content`, `answer_lo`, `answer_is_deleted`) VALUES
(1, 3, 1, '2021-04-28 10:41:27', '2020-12-29 15:00:00', 1, 0x3132372e302e302e31, 0, 0, 0, 'Первый ответ в теме', 0, 0),
(2, 1, 2, '2021-06-30 13:34:52', '2021-08-15 04:50:53', 1, 0x3132372e302e302e31, 0, 0, 0, 'Интересно, спасибо. Вы забыли указать, что можно задавать вопросы в чате (ссылка в footer) этого сайта.', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `audits`
--

CREATE TABLE `audits` (
  `id` int(11) NOT NULL,
  `action_type` varchar(32) DEFAULT NULL,
  `type_belonging` varchar(16) NOT NULL DEFAULT 'audit' COMMENT 'audit or repost)',
  `content_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_flag` tinyint(1) DEFAULT '0' COMMENT 'Состояние прочтения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `badges`
--

CREATE TABLE `badges` (
  `badge_id` int(11) NOT NULL,
  `badge_icon` varchar(550) NOT NULL,
  `badge_tl` int(6) DEFAULT NULL,
  `badge_score` int(6) DEFAULT NULL,
  `badge_title` varchar(150) NOT NULL,
  `badge_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `badges`
--

INSERT INTO `badges` (`badge_id`, `badge_icon`, `badge_tl`, `badge_score`, `badge_title`, `badge_description`) VALUES
(1, '<i title=\"Тестер\" class=\"bi bi-bug\"></i>', 0, 0, 'Тестер', 'Сообщение об ошибке, которое понравилось команде сайта.');

-- --------------------------------------------------------

--
-- Структура таблицы `badges_user`
--

CREATE TABLE `badges_user` (
  `bu_id` int(11) NOT NULL,
  `bu_badge_id` int(6) NOT NULL,
  `bu_user_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL DEFAULT '0',
  `comment_answer_id` int(11) NOT NULL DEFAULT '0',
  `comment_comment_id` int(11) NOT NULL DEFAULT '0',
  `comment_user_id` int(11) NOT NULL DEFAULT '0',
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_modified` timestamp NOT NULL DEFAULT '2020-12-29 15:00:00',
  `comment_published` tinyint(1) NOT NULL DEFAULT '1',
  `comment_ip` varbinary(16) DEFAULT NULL,
  `comment_after` smallint(6) NOT NULL DEFAULT '0',
  `comment_votes` smallint(6) NOT NULL DEFAULT '0',
  `comment_content` text NOT NULL,
  `comment_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `facets`
--

CREATE TABLE `facets` (
  `facet_id` int(11) NOT NULL,
  `facet_title` varchar(64) DEFAULT NULL,
  `facet_description` varchar(255) DEFAULT NULL,
  `facet_short_description` varchar(160) DEFAULT NULL,
  `facet_info` text,
  `facet_slug` varchar(32) DEFAULT NULL,
  `facet_img` varchar(255) DEFAULT 'facet-default.png',
  `facet_cover_art` varchar(255) DEFAULT 'cover_art.jpeg',
  `facet_add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `facet_seo_title` varchar(255) DEFAULT NULL,
  `facet_merged_id` int(11) DEFAULT '0' COMMENT 'с кем слита',
  `facet_top_level` tinyint(1) NOT NULL DEFAULT '0',
  `facet_user_id` int(11) NOT NULL DEFAULT '1',
  `facet_tl` tinyint(1) DEFAULT '0',
  `facet_post_related` varchar(255) DEFAULT NULL,
  `facet_the_day` tinyint(1) NOT NULL DEFAULT '0',
  `facet_focus_count` int(11) DEFAULT '0',
  `facet_count` int(11) DEFAULT '0',
  `facet_sort` int(11) NOT NULL DEFAULT '0',
  `facet_type` varchar(32) NOT NULL DEFAULT 'topic' COMMENT 'Topic, Group or Blog...',
  `facet_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets`
--

INSERT INTO `facets` (`facet_id`, `facet_title`, `facet_description`, `facet_short_description`, `facet_info`, `facet_slug`, `facet_img`, `facet_cover_art`, `facet_add_date`, `facet_seo_title`, `facet_merged_id`, `facet_top_level`, `facet_user_id`, `facet_tl`, `facet_post_related`, `facet_the_day`, `facet_focus_count`, `facet_count`, `facet_sort`, `facet_type`, `facet_is_deleted`) VALUES
(1, 'SEO', 'Поисковая оптимизация — это комплекс мер по внутренней и внешней оптимизации для поднятия позиций сайта в результатах выдачи поисковых систем.', 'Краткое описание темы...', 'Комплекс мер по внутренней и внешней оптимизации для поднятия позиций сайта в результатах выдачи поисковых систем по определённым запросам пользователей.\r\n\r\n**Поисковая оптимизация** — это способ использования правил поиска поисковых систем для улучшения текущего естественного ранжирования веб-сайтов в соответствующих поисковых системах. \r\n\r\nЦелью SEO является предоставление экологического решения для саморекламы для веб-сайта, позволяющего веб-сайту занимать лидирующие позиции в отрасли, чтобы получить преимущества бренда. \r\n\r\nSEO включает как внешнее, так и внутреннее SEO. \r\n\r\nSEO средства получить от поисковых систем больше бесплатного трафика, разумное планирование с точки зрения структуры веб-сайта, плана построения контента, взаимодействия с пользователем и общения, страниц и т.д., чтобы сделать веб-сайт более подходящим для принципов индексации поисковых систем. \r\n\r\nПовышение пригодности веб-сайтов для поисковых систем также называется Оптимизацией для поисковых систем, может не только улучшить эффект SEO, но и сделать информацию, относящуюся к веб-сайту, отображаемую в поисковой системе, более привлекательной для пользователей.', 'seo', 't-1-1625149922.jpeg', 'cover_art.jpeg', '2021-06-27 15:29:20', 'Поисковая оптимизация (SEO)', 0, 0, 1, 0, '1,2,3', 0, 1, 2, 0, 'topic', 0),
(2, 'Интересные сайты', 'Интересные сайты в Интернете. Обзоры, интересные материалы, переводы. Статьи.', 'Краткое описание темы...', 'Интересные сайты в Интернете. Обзоры, интересные материалы, переводы. Статьи.\r\n\r\nПросто вводная страница... В разработке...', 'sites', 't-2-1625149821.jpeg', 'cover_art.jpeg', '2021-06-27 15:29:20', 'Интересные сайты', 0, 0, 1, 0, '3', 0, 1, 2, 0, 'topic', 0),
(3, 'Веб-разработка', 'Веб-разработка — это работа, связанная с разработкой веб-сайта для Интернета (World Wide Web) или интрасети (частной сети).', 'Веб-разработка', 'Веб-разработка — это работа, связанная с разработкой веб-сайта для Интернета (World Wide Web) или интрасети (частной сети). Веб-разработка может варьироваться от разработки простой статической страницы с открытым текстом до сложных веб-приложений, электронного бизнеса и социальных сетей.', 'web-development', 'topic-default.png', 'cover_art.jpeg', '2021-11-04 17:04:41', 'Веб-разработка', 0, 0, 1, 0, '1,2,3', 0, 1, 1, 0, 'topic', 0),
(4, 'Информация', 'Информация (помощь). Этот раздел содержит справочную информацию.', 'Информация ', 'Информация (помощь). Этот раздел содержит справочную информацию.', 'info', 'facet-default.png', 'cover_art.jpeg', '2021-12-22 08:07:54', 'Информация', 0, 0, 1, 0, '', 0, 1, 0, 0, 'section', 0),
(5, 'Интернет', 'Internet - всемирная паутина. Каталог сайтов, полезные ресурсы.', 'Internet - это всё', 'Internet - всемирная паутина. Каталог сайтов, полезные ресурсы.', 'internet', 'facet-default.png', 'cover_art.jpeg', '2022-02-10 02:52:33', 'Internet - это всё', 0, 0, 1, 0, '', 0, 1, 0, 0, 'category', 0),
(6, 'Справочная информация', 'Словари и энциклопедии, справочная информация. Информационные сайты.', 'Справочная информация', NULL, 'reference', 'facet-default.png', 'cover_art.jpeg', '2022-02-10 02:58:47', 'Справочная информация', 0, 0, 1, 0, NULL, 0, 1, 0, 0, 'category', 0),
(7, 'Безопасность', 'Сайты посвященные безопасности в сети. Вирусы и антивирусы и т.д.', 'Безопасность', NULL, 'security', 'facet-default.png', 'cover_art.jpeg', '2022-02-10 03:02:11', 'Безопасность', 0, 0, 1, 0, NULL, 0, 1, 0, 0, 'category', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_items_relation`
--

CREATE TABLE `facets_items_relation` (
  `relation_facet_id` int(11) DEFAULT '0',
  `relation_item_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_items_relation`
--

INSERT INTO `facets_items_relation` (`relation_facet_id`, `relation_item_id`) VALUES
(5, 2),
(5, 1),
(5, 3),
(6, 3),
(6, 5),
(5, 4),
(7, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_matching`
--

CREATE TABLE `facets_matching` (
  `matching_parent_id` int(11) DEFAULT NULL,
  `matching_chaid_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_matching`
--

INSERT INTO `facets_matching` (`matching_parent_id`, `matching_chaid_id`) VALUES
(2, 3),
(3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_merge`
--

CREATE TABLE `facets_merge` (
  `merge_id` int(11) NOT NULL,
  `merge_add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `merge_source_id` int(11) NOT NULL DEFAULT '0',
  `merge_target_id` int(11) NOT NULL DEFAULT '0',
  `merge_user_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `facets_posts_relation`
--

CREATE TABLE `facets_posts_relation` (
  `relation_facet_id` int(11) DEFAULT '0',
  `relation_post_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_posts_relation`
--

INSERT INTO `facets_posts_relation` (`relation_facet_id`, `relation_post_id`) VALUES
(1, 1),
(2, 2),
(2, 4),
(1, 4),
(3, 5),
(4, 6),
(4, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_relation`
--

CREATE TABLE `facets_relation` (
  `facet_parent_id` int(11) DEFAULT NULL,
  `facet_chaid_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_relation`
--

INSERT INTO `facets_relation` (`facet_parent_id`, `facet_chaid_id`) VALUES
(3, 1),
(5, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_signed`
--

CREATE TABLE `facets_signed` (
  `signed_id` int(11) NOT NULL,
  `signed_facet_id` int(11) NOT NULL,
  `signed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_signed`
--

INSERT INTO `facets_signed` (`signed_id`, `signed_facet_id`, `signed_user_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 1),
(8, 7, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `facets_types`
--

CREATE TABLE `facets_types` (
  `type_id` int(11) NOT NULL,
  `type_code` varchar(50) NOT NULL,
  `type_lang` varchar(50) NOT NULL,
  `type_title` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `facets_types`
--

INSERT INTO `facets_types` (`type_id`, `type_code`, `type_lang`, `type_title`) VALUES
(1, 'topic', 'topic', 'Темы'),
(2, 'blog', 'blog', 'Блог'),
(3, 'section', 'section', 'Секция'),
(4, 'category', 'category', 'Категории');

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `tid` int(11) NOT NULL,
  `action_type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(32) DEFAULT NULL,
  `file_content_id` int(11) UNSIGNED DEFAULT NULL,
  `file_user_id` int(11) UNSIGNED DEFAULT NULL,
  `file_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`file_id`, `file_path`, `file_type`, `file_content_id`, `file_user_id`, `file_date`, `file_is_deleted`) VALUES
(1, '2021/c-1638777119.webp', 'post', 0, 1, '2021-12-05 19:52:00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `invitations`
--

CREATE TABLE `invitations` (
  `invitation_id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) DEFAULT '0',
  `invitation_code` varchar(32) DEFAULT NULL,
  `invitation_email` varchar(100) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  `add_ip` varchar(45) DEFAULT NULL,
  `active_expire` tinyint(1) DEFAULT '0',
  `active_time` datetime DEFAULT NULL,
  `active_ip` varchar(45) DEFAULT NULL,
  `active_status` tinyint(4) DEFAULT '0',
  `active_uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_url` varchar(255) DEFAULT NULL,
  `item_url_domain` varchar(255) DEFAULT NULL,
  `item_title_url` varchar(255) DEFAULT NULL,
  `item_content_url` text,
  `item_title_soft` varchar(255) DEFAULT NULL,
  `item_content_soft` text,
  `item_published` tinyint(1) NOT NULL DEFAULT '1',
  `item_user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Who added',
  `item_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_type_url` int(11) NOT NULL DEFAULT '0' COMMENT 'Site Type (0 - common, 1 - the blog, 2 - encyclopedia)',
  `item_status_url` int(11) NOT NULL DEFAULT '200' COMMENT 'Site status (200, 403, 404)',
  `item_status_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When was the status check',
  `item_is_soft` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'There is a program (script)',
  `item_is_github` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'The site is on GitHub',
  `item_github_url` varchar(255) DEFAULT NULL COMMENT 'URL on GitHub',
  `item_post_related` varchar(255) DEFAULT NULL,
  `item_votes` int(11) DEFAULT '0',
  `item_count` int(11) DEFAULT '1',
  `item_following_link` int(11) NOT NULL DEFAULT '1',
  `item_is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`item_id`, `item_url`, `item_url_domain`, `item_title_url`, `item_content_url`, `item_title_soft`, `item_content_soft`, `item_published`, `item_user_id`, `item_date`, `item_type_url`, `item_status_url`, `item_status_date`, `item_is_soft`, `item_is_github`, `item_github_url`, `item_post_related`, `item_votes`, `item_count`, `item_following_link`, `item_is_deleted`) VALUES
(1, 'https://agouti.ru', 'agouti.ru', '«Agouti» — сообщество по интересам', 'Лучшие публикации за сутки. Темы, личные дневники, группы. Каталог сайтов и программ, поиск..', 'Agouti', 'Discussion (forum) and Q&A platform. Community based on PHP Micro-Framework HLEB. (Zhihu, Quora clone)', 1, 1, '2021-06-20 19:35:02', 0, 200, '2021-06-20 19:35:02', 1, 1, 'https://github.com/AgoutiDev/agouti', '2', 1, 1, 1, 0),
(2, 'https://github.com', 'github.com', '«GitHub» — веб-сервис для хостинга IT-проектов', 'Веб-сервис, хостинговая платформа  для программистов основанная на системе контроля версий Git. Бесплатные, платные версии репозитория.', '', '', 1, 1, '2021-11-02 23:30:40', 0, 200, '2021-11-02 23:30:40', 0, 0, '', '', 1, 1, 1, 0),
(3, 'https://phphleb.ru', 'phphleb.ru', '«HLEB» — микрофреймворк', 'Документация и описание Micro-Framework(а) использующий базовую реализацию MVC на PHP. Установить, настройка, структура проекта. Маршрутизация, контроллеры и модели.', 'HLEB', 'Отличительной особенностью микропрограммы HLEB является минимализм кода и скорость работы. Выбор данного фреймворка позволяет запустить полноценный продукт с минимальными временными затратами и обращениями к документации; это легко, просто и быстро. \r\n\r\nВ то же время он решает типовые задачи, такие как маршрутизация, перенос действий на контроллеры, поддержка модели, то есть базовая реализация MVC. Это самый минимум, необходимый для быстрого запуска приложения.', 1, 1, '2021-11-08 08:02:24', 0, 200, '2021-11-08 08:02:24', 1, 1, 'https://github.com/phphleb/hleb', '', 1, 1, 1, 0),
(4, 'https://ispserver.ru', 'ispserver.ru', '«ISPserveru» — хостинг-провайдер', 'Веб-хостинг, VPS и выделенные серверы в трёх дата-центрах в Москве и Германии. Информация по панели управления ISPmanager. Контакты, обратная связь.', '', '', 1, 1, '2021-11-12 06:50:54', 0, 200, '2021-11-12 06:50:54', 0, 0, '', '', 1, 1, 1, 0),
(5, 'https://sourceforge.net', 'sourceforge.net', '«Sourceforge» — проекты с открытым исходным кодом', 'Список проектов с открытым исходным кодом. Перечень проектов, нуждающиеся в помощи. Возможность загрузить различные материалы. Информация на английском языке.', '', '', 1, 1, '2021-11-12 07:12:18', 0, 200, '2021-11-12 07:12:18', 0, 0, '', '', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `items_signed`
--

CREATE TABLE `items_signed` (
  `signed_id` int(11) NOT NULL,
  `signed_item_id` int(11) NOT NULL,
  `signed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message_sender_id` int(11) DEFAULT NULL COMMENT 'Отправитель',
  `message_dialog_id` int(11) DEFAULT NULL,
  `message_content` text,
  `message_add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_sender_remove` tinyint(1) DEFAULT '0',
  `message_recipient_remove` tinyint(1) DEFAULT '0',
  `message_receipt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages_dialog`
--

CREATE TABLE `messages_dialog` (
  `dialog_id` int(11) NOT NULL,
  `dialog_sender_id` int(11) DEFAULT NULL COMMENT 'Отправитель',
  `dialog_sender_unread` int(11) DEFAULT NULL COMMENT 'Отправитель, 0 непрочитано',
  `dialog_recipient_id` int(11) DEFAULT NULL COMMENT 'Получатель',
  `dialog_recipient_unread` int(11) DEFAULT NULL COMMENT 'Получатель, 0 непрочитано',
  `dialog_add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dialog_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dialog_sender_count` int(11) DEFAULT NULL COMMENT 'Отправитель кол.',
  `dialog_recipient_count` int(11) DEFAULT NULL COMMENT 'Получатель кол.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL COMMENT 'Отправитель',
  `recipient_id` int(11) DEFAULT '0' COMMENT 'Получает ID',
  `action_type` int(4) DEFAULT NULL COMMENT 'Тип оповещения',
  `url` varchar(255) DEFAULT NULL COMMENT 'URL источника',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_flag` tinyint(1) DEFAULT '0' COMMENT 'Состояние прочтения',
  `is_deleted` tinyint(1) UNSIGNED DEFAULT '0' COMMENT 'Удаление'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_feature` smallint(6) NOT NULL DEFAULT '0' COMMENT '0 - discussion, 1 - question...',
  `post_type` varchar(32) NOT NULL DEFAULT 'post' COMMENT 'Post, page...',
  `post_translation` smallint(1) NOT NULL DEFAULT '0',
  `post_draft` smallint(1) NOT NULL DEFAULT '0',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_published` tinyint(1) NOT NULL DEFAULT '1',
  `post_user_id` int(10) UNSIGNED NOT NULL,
  `post_ip` varbinary(16) DEFAULT NULL,
  `post_after` smallint(6) NOT NULL DEFAULT '0' COMMENT 'id первого ответа',
  `post_votes` smallint(6) NOT NULL DEFAULT '0',
  `post_karma` smallint(6) NOT NULL DEFAULT '0',
  `post_answers_count` int(11) DEFAULT '0',
  `post_comments_count` int(11) DEFAULT '0',
  `post_hits_count` int(11) DEFAULT '0',
  `post_content` text NOT NULL,
  `post_content_img` varchar(255) DEFAULT NULL,
  `post_thumb_img` varchar(255) DEFAULT NULL,
  `post_related` varchar(255) DEFAULT NULL,
  `post_merged_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id с чем объединен',
  `post_is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Рекомендованные посты',
  `post_closed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - пост закрыт',
  `post_tl` smallint(1) NOT NULL DEFAULT '0' COMMENT 'Видимость по уровню доверия',
  `post_lo` int(11) NOT NULL DEFAULT '0' COMMENT 'Id лучшего ответа',
  `post_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - пост поднят',
  `post_url` varchar(255) DEFAULT NULL,
  `post_url_domain` varchar(255) DEFAULT NULL,
  `post_focus_count` int(11) DEFAULT '0',
  `post_is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_slug`, `post_feature`, `post_type`, `post_translation`, `post_draft`, `post_date`, `post_modified`, `post_published`, `post_user_id`, `post_ip`, `post_after`, `post_votes`, `post_karma`, `post_answers_count`, `post_comments_count`, `post_hits_count`, `post_content`, `post_content_img`, `post_thumb_img`, `post_related`, `post_merged_id`, `post_is_recommend`, `post_closed`, `post_tl`, `post_lo`, `post_top`, `post_url`, `post_url_domain`, `post_focus_count`, `post_is_deleted`) VALUES
(1, 'Ответы на некоторые вопросы (FAQ)', 'answer-qa', 0, 'post', 0, 0, '2021-02-26 18:08:09', '2021-10-26 06:26:06', 1, 1, 0x3132372e302e302e31, 0, 0, 0, 1, 0, 7, 'Превью поста на главной странице сайта формируется из первого абзаца текста. Мы забираем первый абзац и делаем превью. Сайт испольлзует MVC модель, если кто знаком с ней, то не особо трудно будет разобраться.\r\n\r\n### Где находятся конфиг сайта?\r\n\r\nЕсть 3 основополагающих файла конфигурации (There are 3 configuration files):\r\n\r\n* *dbase.config.php* — подключение к базе данных (connecting to the database)\r\n\r\n* *config.ini* — основные настройки (basic settings)\r\n\r\n* *start.hleb.php* — константы (constants)\r\n\r\n### Где находятся шаблоны сайта?\r\n\r\n```\r\n/resources/views/default\r\n```\r\n\r\n### Как мне изменить страницы с документацией?\r\n\r\nСлужебные страницы на этом сайте находятся: [/info](/info)\r\n\r\nА сам текст в Markdown разметке:\r\n\r\n```txt\r\n/resources/views/default/info/md/index.md\r\n```\r\n\r\n### Как мне поменять язык сайта?\r\n\r\nПо умолчанию на сайте используется русский язык.\r\n\r\nПереводы находится в папке:  `/app/Language/`\r\n\r\nВы можете переключать языки, в файле: `general.php` \r\n\r\nНайти:\r\n```php\r\n\'lang\' => \'ru\',\r\n```\r\n\r\n---\r\n\r\nBy default, the site uses Russian.\r\n\r\nThe translations are located in the folder: `general.php` find:\r\n\r\n```php\r\n\'lang\' => \'ru\',\r\n```\r\n\r\nThe transfers themselves are stored: `/app/Language/`', '', NULL, '2', 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0),
(2, 'Где можно почитать документацию?', 'docs-post', 0, 'post', 0, 0, '2021-02-26 18:15:58', '2021-11-04 17:26:31', 1, 2, 0x3132372e302e302e31, 0, 1, 0, 0, 0, 8, 'Страница документации Agouti находится в стадии разработки... \r\n\r\n[https://agouti.info/](https://agouti.info/)\r\n\r\nКак она будет завершена, об этом будет сообщено дополнительно. Сам сайт создан на PHP Микрофреймворк HLEB. Все основные настройки,  можно найти на этом сайте:\r\n\r\n[https://phphleb.ru/ru/v1/](https://phphleb.ru/ru/v1/)\r\n\r\n', '', NULL, '1', 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0),
(3, 'Medium — платформа для создания контента', 'medium-where-good-ideas-find-you', 0, 'post', 0, 0, '2021-04-28 10:35:13', '2021-04-28 10:35:13', 1, 1, 0x3132372e302e302e31, 0, 0, 0, 1, 0, 1, 'Medium — это платформа для создания контента, основанная соучредителем Blogger и Twitter Эван Уильямсом. Многие компании используют Medium в качестве платформы для публикации...', '2021/c-1624954734.webp', NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0),
(4, 'Bee Network 🥳 — Криптовалюта Pi-Network', 'bee-network-e-mdash-kriptovalyuta-pi-network', 0, 'post', 0, 0, '2021-12-05 19:52:00', '2021-12-07 15:43:51', 1, 1, 0x3132372e302e302e31, 0, 2, 0, 0, 0, 3, 'Bee Network 🥳 &mdash; Криптовалюта Pi-Network', '2021/c-1638777119.webp', '', '', 0, 0, 0, 0, 0, 0, '', '', 1, 0),
(5, 'Скрытые возможности в настройках профиля', 'skrytye-vozmozhnosti-v-nastrojkah-profilya', 0, 'post', 0, 0, '2021-12-07 22:44:23', '2021-12-07 22:44:23', 1, 1, 0x3132372e302e302e31, 0, 2, 0, 0, 0, 1, 'Если мы посмотрим в базу данных, в таблицу пользователей (users) то можем увидеть два поля которые пока не используются...\r\n\r\nПервое поле предполагает выбор дизайна. В планах сделать ещё один дизайн, который будет кардинально отличаться от существующего.\r\n\r\nИ второе поле `user_scroll`, которое будет служить, чтобы включить бесконечную прокрутку в ленте. Это иногда имеет смысл, хотя разбивка на страницы останется по дефолту.\r\n\r\n*Вообще, просто тестовый пост., чтобы заполнить одну тему.*', '', '', '', 0, 0, 0, 0, 0, 0, '', '', 1, 0),
(6, 'Информация', 'information', 0, 'page', 0, 0, '2021-12-22 08:39:35', '2021-12-22 08:44:50', 1, 1, 0x3132372e302e302e31, 0, 0, 0, 0, 0, 0, 'Этот раздел содержит справочную информацию.  \r\n\r\n### Где мне можно скачать архив сайта?\r\n\r\nСкачайте архив *agouti с GitHub:* [github.com/agoutiDev/agouti](https://github.com/agoutiDev/agouti)\r\n\r\nКод сайта имеет лицензию [MIT](https://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_MIT).  \r\n\r\n### Какие технологии используются на сайте?\r\n\r\nВ разделе документация есть статья: [Какие технологии использует сайт?](https://agouti.info/ru/support/article/hleb)\r\n\r\n### Где можно подробней ознакомится с документацией?\r\n\r\nВ разделе документация: [agouti.info](https://agouti.info)\r\n\r\n### Как я могу помочь сайту?\r\n\r\n1. Порекомендовать друзьям наш сайт.\r\n2. Оставить ссылку на наш сайт в своем блоге, сайте, «Твиттере», на своей странице в социальной сети или на форуме, где Вас хорошо знают.\r\n3. Сделать денежный взнос удобным для Вас способом. \r\n\r\n\r\nСпособы оплаты: *ЮMoney — * 4100140143763\r\n\r\n### Как с вами связаться?\r\n\r\nПо e-mail: *admin@agouti.ru*\r\n\r\n*Мы в Discord:* [discord.gg/dw47aNx5nU](https://discord.gg/dw47aNx5nU)\r\n\r\n###  🙏  Спасибо\r\n\r\nСпасибо за спонсорство и поддержку!\r\n\r\n![Спасибо от Агути](/assets/images/agouti-page.jpg)', '', '', '', 0, 0, 0, 0, 0, 0, '', '', 0, 0),
(7, 'Политика конфиденциальности', 'privacy', 0, 'page', 0, 0, '2021-12-22 08:46:43', '2021-12-22 08:47:18', 1, 1, 0x3132372e302e302e31, 0, 0, 0, 0, 0, 0, 'Политика конфиденциальности\r\n\r\nТут пишем про конфиденциальность! \r\n\r\nОбе эти статьи жестко закреплены в настройках и должны быть обязательны. Имя их URL изменению не подлежит. ', '', '', '', 0, 0, 0, 0, 0, 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `posts_signed`
--

CREATE TABLE `posts_signed` (
  `signed_id` int(11) NOT NULL,
  `signed_post_id` int(11) NOT NULL,
  `signed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `posts_signed`
--

INSERT INTO `posts_signed` (`signed_id`, `signed_post_id`, `signed_user_id`) VALUES
(1, 4, 1),
(2, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `search_logs`
--

CREATE TABLE `search_logs` (
  `id` int(11) NOT NULL,
  `request` text NOT NULL,
  `action_type` varchar(32) NOT NULL COMMENT 'Catalog, site...',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_ip` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `count_results` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `stop_words`
--

CREATE TABLE `stop_words` (
  `stop_id` int(11) NOT NULL,
  `stop_word` varchar(50) DEFAULT NULL,
  `stop_add_uid` int(11) NOT NULL DEFAULT '0' COMMENT 'Кто добавил',
  `stop_space_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 - глобально',
  `stop_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activated` tinyint(1) DEFAULT '0',
  `limiting_mode` tinyint(1) DEFAULT '0',
  `reg_ip` varchar(45) DEFAULT NULL,
  `trust_level` int(11) NOT NULL COMMENT 'Уровень доверия. По умолчанию 0 (5 - админ)',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invitation_available` int(11) NOT NULL DEFAULT '0',
  `invitation_id` int(11) NOT NULL DEFAULT '0',
  `template` varchar(12) NOT NULL DEFAULT 'default',
  `lang` varchar(2) NOT NULL DEFAULT 'ru',
  `scroll` tinyint(1) NOT NULL DEFAULT '0',
  `whisper` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'noavatar.png',
  `cover_art` varchar(255) NOT NULL DEFAULT 'cover_art.jpeg',
  `color` varchar(12) NOT NULL DEFAULT '#f56400',
  `about` varchar(250) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `public_email` varchar(50) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `telegram` varchar(50) DEFAULT NULL,
  `vk` varchar(50) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `my_post` int(11) DEFAULT '0' COMMENT 'Пост выведенный в профиль',
  `ban_list` tinyint(1) DEFAULT '0',
  `hits_count` int(11) DEFAULT '0',
  `up_count` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `email`, `password`, `activated`, `limiting_mode`, `reg_ip`, `trust_level`, `created_at`, `updated_at`, `invitation_available`, `invitation_id`, `template`, `lang`, `scroll`, `whisper`, `avatar`, `cover_art`, `color`, `about`, `website`, `location`, `public_email`, `skype`, `twitter`, `telegram`, `vk`, `rating`, `my_post`, `ban_list`, `hits_count`, `up_count`, `is_deleted`) VALUES
(1, 'AdreS', 'Олег', 'ss@sdf.ru', '$2y$10$oR5VZ.zk7IN/og70gQq/f.0Sb.GQJ33VZHIES4pyIpU3W2vF6aiaW', 1, 0, '127.0.0.1', 10, '2021-03-08 21:37:04', '2021-03-08 21:37:04', 0, 0, 'default', 'ru', 0, '', 'img_1.jpg', 'cover_art.jpeg', '#f56400', 'Тестовый аккаунт', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0),
(2, 'test', NULL, 'test@test.ru', '$2y$10$Iahcsh3ima0kGqgk6S/SSui5/ETU5bQueYROFhOsjUU/z1.xynR7W', 1, 0, '127.0.0.1', 2, '2021-04-30 07:42:52', '2021-04-30 07:42:52', 0, 0, 'default', 'ru', 0, '', 'noavatar.png', 'cover_art.jpeg', '#339900', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_action_logs`
--

CREATE TABLE `users_action_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'User ID',
  `user_login` varchar(50) NOT NULL COMMENT 'User login',
  `id_content` int(11) NOT NULL COMMENT 'Content ID',
  `action_type` varchar(32) NOT NULL,
  `action_name` varchar(124) NOT NULL COMMENT 'Action name',
  `url_content` varchar(250) NOT NULL COMMENT 'URL content',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_activate`
--

CREATE TABLE `users_activate` (
  `activate_id` int(11) NOT NULL,
  `activate_date` datetime NOT NULL,
  `activate_user_id` int(11) NOT NULL,
  `activate_code` varchar(50) NOT NULL,
  `activate_flag` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_agent_logs`
--

CREATE TABLE `users_agent_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_browser` varchar(64) NOT NULL,
  `user_os` varchar(64) NOT NULL,
  `user_ip` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `users_agent_logs`
--

INSERT INTO `users_agent_logs` (`id`, `add_date`, `user_id`, `user_browser`, `user_os`, `user_ip`) VALUES
(1, '2021-09-20 07:09:38', 1, 'Firefox 92.0', 'Windows', '127.0.0.1'),
(2, '2021-09-20 07:57:57', 2, 'Chrome 93.0.4577.82', 'Windows', '127.0.0.1'),
(3, '2021-10-18 01:43:05', 1, 'Firefox 93.0', 'Windows', '127.0.0.1'),
(4, '2021-10-26 06:24:03', 1, 'Firefox 93.0', 'Windows', '127.0.0.1'),
(5, '2021-11-04 17:01:34', 1, 'Firefox 94.0', 'Windows', '127.0.0.1'),
(6, '2021-12-05 09:38:15', 1, 'Firefox 94.0', 'Windows', '127.0.0.1'),
(7, '2021-12-05 19:51:36', 1, 'Firefox 94.0', 'Windows', '127.0.0.1'),
(8, '2021-12-07 15:25:29', 1, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(9, '2021-12-07 16:15:41', 2, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(10, '2021-12-07 22:40:13', 1, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(11, '2021-12-07 22:49:18', 2, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(12, '2021-12-22 08:03:39', 1, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(13, '2021-12-22 08:08:44', 1, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(14, '2021-12-22 08:09:08', 1, 'Firefox 95.0', 'Windows', '127.0.0.1'),
(15, '2022-02-10 02:50:18', 1, 'Firefox 96.0', 'Windows', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `users_auth_tokens`
--

CREATE TABLE `users_auth_tokens` (
  `auth_id` int(11) NOT NULL,
  `auth_user_id` int(11) NOT NULL,
  `auth_selector` varchar(255) NOT NULL,
  `auth_hashedvalidator` varchar(255) NOT NULL,
  `auth_expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_banlist`
--

CREATE TABLE `users_banlist` (
  `banlist_id` int(11) NOT NULL,
  `banlist_user_id` int(11) NOT NULL,
  `banlist_ip` varchar(45) NOT NULL,
  `banlist_bandate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banlist_int_num` int(11) NOT NULL,
  `banlist_int_period` varchar(20) NOT NULL,
  `banlist_status` tinyint(1) NOT NULL DEFAULT '1',
  `banlist_autodelete` tinyint(1) NOT NULL DEFAULT '0',
  `banlist_cause` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_email_activate`
--

CREATE TABLE `users_email_activate` (
  `id` int(11) NOT NULL,
  `pubdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `email_code` varchar(50) NOT NULL,
  `email_activate_flag` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_setting`
--

CREATE TABLE `users_setting` (
  `setting_id` int(11) NOT NULL,
  `setting_user_id` int(11) UNSIGNED NOT NULL,
  `setting_email_pm` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'Написал ПМ',
  `setting_email_appealed` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'Обратился @',
  `setting_email_post` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'Написал пост',
  `setting_email_answer` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'Ответил',
  `setting_email_comment` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'Прокомментировал'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `votes_answer`
--

CREATE TABLE `votes_answer` (
  `votes_answer_id` int(11) NOT NULL,
  `votes_answer_item_id` int(11) NOT NULL,
  `votes_answer_points` int(11) NOT NULL,
  `votes_answer_ip` varchar(45) NOT NULL,
  `votes_answer_user_id` int(11) NOT NULL DEFAULT '1',
  `votes_answer_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `votes_comment`
--

CREATE TABLE `votes_comment` (
  `votes_comment_id` int(11) NOT NULL,
  `votes_comment_item_id` int(11) NOT NULL,
  `votes_comment_points` int(11) NOT NULL,
  `votes_comment_ip` varchar(45) NOT NULL,
  `votes_comment_user_id` int(11) NOT NULL DEFAULT '1',
  `votes_comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `votes_item`
--

CREATE TABLE `votes_item` (
  `votes_item_id` int(11) NOT NULL,
  `votes_item_item_id` int(11) NOT NULL,
  `votes_item_points` int(11) NOT NULL,
  `votes_item_ip` varchar(45) NOT NULL,
  `votes_item_user_id` int(11) NOT NULL DEFAULT '1',
  `votes_item_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `votes_post`
--

CREATE TABLE `votes_post` (
  `votes_post_id` int(11) NOT NULL,
  `votes_post_item_id` int(11) NOT NULL,
  `votes_post_points` int(11) NOT NULL,
  `votes_post_ip` varchar(45) NOT NULL,
  `votes_post_user_id` int(11) NOT NULL DEFAULT '1',
  `votes_post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `votes_post`
--

INSERT INTO `votes_post` (`votes_post_id`, `votes_post_item_id`, `votes_post_points`, `votes_post_ip`, `votes_post_user_id`, `votes_post_date`) VALUES
(1, 2, 1, '127.0.0.1', 1, '2021-08-16 16:29:32');

--
-- Дамп данных и индексы таблиц `folders` и `folders_relation`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `action_type` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_coun` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `folders_relation` (
  `id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL COMMENT 'ID папки (folders)',
  `action_type` varchar(32) NOT NULL  COMMENT 'Тип контента',
  `tid` int(11) NOT NULL COMMENT 'id контента',
  `user_id` int(11) NOT NULL COMMENT 'id кто добавил'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `folders_relation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `folders_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `folders_relation` ADD UNIQUE(`action_type`, `tid`, `user_id`);


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `answer_link_id_2` (`answer_post_id`,`answer_date`),
  ADD KEY `answer_date` (`answer_date`),
  ADD KEY `answer_user_id` (`answer_user_id`,`answer_date`),
  ADD KEY `answer_post_id` (`answer_post_id`,`answer_order`);

--
-- Индексы таблицы `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_type` (`action_type`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `content_id` (`content_id`);

--
-- Индексы таблицы `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`badge_id`);

--
-- Индексы таблицы `badges_user`
--
ALTER TABLE `badges_user`
  ADD PRIMARY KEY (`bu_id`),
  ADD KEY `bu_badge_id` (`bu_badge_id`),
  ADD KEY `bu_user_id` (`bu_user_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_link_id_2` (`comment_post_id`,`comment_date`),
  ADD KEY `comment_date` (`comment_date`),
  ADD KEY `comment_user_id` (`comment_user_id`,`comment_date`);

--
-- Индексы таблицы `facets`
--
ALTER TABLE `facets`
  ADD PRIMARY KEY (`facet_id`),
  ADD UNIQUE KEY `unique_index` (`facet_slug`,`facet_type`),
  ADD KEY `facet_slug` (`facet_slug`),
  ADD KEY `facet_merged_id` (`facet_merged_id`),
  ADD KEY `facet_type` (`facet_type`);

--
-- Индексы таблицы `facets_items_relation`
--
ALTER TABLE `facets_items_relation`
  ADD KEY `relation_facet_id` (`relation_facet_id`) USING BTREE,
  ADD KEY `relation_item_id` (`relation_item_id`) USING BTREE;

--
-- Индексы таблицы `facets_matching`
--
ALTER TABLE `facets_matching`
  ADD UNIQUE KEY `matching_parent_id` (`matching_parent_id`,`matching_chaid_id`);

--
-- Индексы таблицы `facets_merge`
--
ALTER TABLE `facets_merge`
  ADD PRIMARY KEY (`merge_id`),
  ADD KEY `merge_source_id` (`merge_source_id`),
  ADD KEY `merge_target_id` (`merge_target_id`),
  ADD KEY `merge_user_id` (`merge_user_id`);

--
-- Индексы таблицы `facets_posts_relation`
--
ALTER TABLE `facets_posts_relation`
  ADD KEY `relation_facet_id` (`relation_facet_id`),
  ADD KEY `relation_content_id` (`relation_post_id`);

--
-- Индексы таблицы `facets_relation`
--
ALTER TABLE `facets_relation`
  ADD UNIQUE KEY `facet_parent_id` (`facet_parent_id`,`facet_chaid_id`);

--
-- Индексы таблицы `facets_signed`
--
ALTER TABLE `facets_signed`
  ADD PRIMARY KEY (`signed_id`);

--
-- Индексы таблицы `facets_types`
--
ALTER TABLE `facets_types`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `title_UNIQUE` (`type_code`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorite_user_id` (`id`),
  ADD KEY `favorite_id` (`tid`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `file_path` (`file_path`),
  ADD KEY `file_user_id` (`file_user_id`);

--
-- Индексы таблицы `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`invitation_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `invitation_code` (`invitation_code`),
  ADD KEY `active_time` (`active_time`),
  ADD KEY `active_ip` (`active_ip`),
  ADD KEY `active_status` (`active_status`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);
ALTER TABLE `items` ADD FULLTEXT KEY `item_title_url` (`item_title_url`,`item_content_url`,`item_url_domain`);

--
-- Индексы таблицы `items_signed`
--
ALTER TABLE `items_signed`
  ADD PRIMARY KEY (`signed_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `message_dialog_id` (`message_dialog_id`),
  ADD KEY `message_sender_id` (`message_sender_id`),
  ADD KEY `message_add_time` (`message_add_time`),
  ADD KEY `message_sender_remove` (`message_sender_remove`),
  ADD KEY `message_recipient_remove` (`message_recipient_remove`),
  ADD KEY `message_sender_receipt` (`message_receipt`);

--
-- Индексы таблицы `messages_dialog`
--
ALTER TABLE `messages_dialog`
  ADD PRIMARY KEY (`dialog_id`),
  ADD KEY `dialog_recipient_id` (`dialog_recipient_id`),
  ADD KEY `dialog_sender_id` (`dialog_sender_id`),
  ADD KEY `dialog_update_time` (`dialog_update_time`),
  ADD KEY `dialog_add_time` (`dialog_add_time`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_read_flag` (`recipient_id`,`read_flag`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `action_type` (`action_type`),
  ADD KEY `add_time` (`add_time`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_user_id` (`post_user_id`,`post_date`);
ALTER TABLE `posts` ADD FULLTEXT KEY `post_title` (`post_title`,`post_content`);

--
-- Индексы таблицы `posts_signed`
--
ALTER TABLE `posts_signed`
  ADD PRIMARY KEY (`signed_id`);

--
-- Индексы таблицы `search_logs`
--
ALTER TABLE `search_logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stop_words`
--
ALTER TABLE `stop_words`
  ADD PRIMARY KEY (`stop_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_action_logs`
--
ALTER TABLE `users_action_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) COMMENT 'uid';

--
-- Индексы таблицы `users_activate`
--
ALTER TABLE `users_activate`
  ADD PRIMARY KEY (`activate_id`);

--
-- Индексы таблицы `users_agent_logs`
--
ALTER TABLE `users_agent_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ip` (`user_ip`);

--
-- Индексы таблицы `users_auth_tokens`
--
ALTER TABLE `users_auth_tokens`
  ADD PRIMARY KEY (`auth_id`);

--
-- Индексы таблицы `users_banlist`
--
ALTER TABLE `users_banlist`
  ADD PRIMARY KEY (`banlist_id`),
  ADD KEY `banlist_ip` (`banlist_ip`),
  ADD KEY `banlist_user_id` (`banlist_user_id`);

--
-- Индексы таблицы `users_email_activate`
--
ALTER TABLE `users_email_activate`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_setting`
--
ALTER TABLE `users_setting`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `setting_user_id` (`setting_user_id`);

--
-- Индексы таблицы `votes_answer`
--
ALTER TABLE `votes_answer`
  ADD PRIMARY KEY (`votes_answer_id`),
  ADD KEY `votes_answer_item_id` (`votes_answer_item_id`,`votes_answer_user_id`),
  ADD KEY `votes_answer_ip` (`votes_answer_item_id`,`votes_answer_ip`),
  ADD KEY `votes_answer_user_id` (`votes_answer_user_id`);

--
-- Индексы таблицы `votes_comment`
--
ALTER TABLE `votes_comment`
  ADD PRIMARY KEY (`votes_comment_id`),
  ADD KEY `votes_comment_item_id` (`votes_comment_item_id`,`votes_comment_user_id`),
  ADD KEY `votes_comment_ip` (`votes_comment_item_id`,`votes_comment_ip`),
  ADD KEY `votes_comment_user_id` (`votes_comment_user_id`);

--
-- Индексы таблицы `votes_item`
--
ALTER TABLE `votes_item`
  ADD PRIMARY KEY (`votes_item_id`),
  ADD KEY `votes_item_item_id` (`votes_item_item_id`,`votes_item_user_id`) USING BTREE,
  ADD KEY `votes_item_user_id` (`votes_item_user_id`) USING BTREE,
  ADD KEY `votes_item_ip` (`votes_item_item_id`,`votes_item_ip`) USING BTREE;

--
-- Индексы таблицы `votes_post`
--
ALTER TABLE `votes_post`
  ADD PRIMARY KEY (`votes_post_id`),
  ADD KEY `votes_post_item_id` (`votes_post_item_id`,`votes_post_user_id`),
  ADD KEY `votes_post_ip` (`votes_post_item_id`,`votes_post_ip`),
  ADD KEY `votes_post_user_id` (`votes_post_user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `audits`
--
ALTER TABLE `audits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `badges`
--
ALTER TABLE `badges`
  MODIFY `badge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `badges_user`
--
ALTER TABLE `badges_user`
  MODIFY `bu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `facets`
--
ALTER TABLE `facets`
  MODIFY `facet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `facets_merge`
--
ALTER TABLE `facets_merge`
  MODIFY `merge_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `facets_signed`
--
ALTER TABLE `facets_signed`
  MODIFY `signed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `facets_types`
--
ALTER TABLE `facets_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `invitations`
--
ALTER TABLE `invitations`
  MODIFY `invitation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `items_signed`
--
ALTER TABLE `items_signed`
  MODIFY `signed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages_dialog`
--
ALTER TABLE `messages_dialog`
  MODIFY `dialog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `posts_signed`
--
ALTER TABLE `posts_signed`
  MODIFY `signed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `search_logs`
--
ALTER TABLE `search_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stop_words`
--
ALTER TABLE `stop_words`
  MODIFY `stop_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users_action_logs`
--
ALTER TABLE `users_action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_activate`
--
ALTER TABLE `users_activate`
  MODIFY `activate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_agent_logs`
--
ALTER TABLE `users_agent_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users_auth_tokens`
--
ALTER TABLE `users_auth_tokens`
  MODIFY `auth_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_banlist`
--
ALTER TABLE `users_banlist`
  MODIFY `banlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_email_activate`
--
ALTER TABLE `users_email_activate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_setting`
--
ALTER TABLE `users_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `votes_answer`
--
ALTER TABLE `votes_answer`
  MODIFY `votes_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `votes_comment`
--
ALTER TABLE `votes_comment`
  MODIFY `votes_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `votes_item`
--
ALTER TABLE `votes_item`
  MODIFY `votes_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `votes_post`
--
ALTER TABLE `votes_post`
  MODIFY `votes_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;