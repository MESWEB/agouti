<?php

namespace Modules\Catalog\App\Models;

use DB;

class WebModel extends \Hleb\Scheme\App\Models\MainModel
{
    // All sites
    // Все сайты
    public static function getItemsAll($page, $limit, $user, $sheet)
    {
        $sort   = self::sorts($sheet);
        $start  = ($page - 1) * $limit;
        $sql = "SELECT
                    item_id, 
                    item_title_url,
                    item_content_url,
                    item_published,
                    item_user_id,
                    item_url,
                    item_url_domain,
                    item_votes,
                    item_count,
                    item_title_soft,
                    item_github_url,
                    item_following_link,
                    item_is_deleted,
                    rel.*,
                    votes_item_user_id, votes_item_item_id,
                    fav.tid, fav.user_id, fav.action_type 
                        FROM items
                        LEFT JOIN
                        (
                            SELECT 
                                relation_item_id,
                                GROUP_CONCAT(facet_type, '@', facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets  
                                LEFT JOIN facets_items_relation 
                                    on facet_id = relation_facet_id

                                        GROUP BY relation_item_id
                        ) AS rel
                            ON rel.relation_item_id = item_id 
                        LEFT JOIN favorites fav ON fav.tid = item_id 
                           AND fav.user_id = :uid AND fav.action_type = 'website'
                        LEFT JOIN votes_item ON votes_item_item_id = item_id AND  votes_item_user_id = :uid_two
                        $sort
                        LIMIT $start, $limit ";

        return DB::run($sql, ['uid' => $user['id'], 'uid_two' => $user['id']])->fetchAll();
    }

    public static function getItemsAllCount($sheet)
    {
        $sort = self::sorts($sheet);
        $sql = "SELECT item_id, item_is_deleted FROM items $sort";

        return DB::run($sql)->rowCount();
    }

    public static function sorts($sheet)
    {
        switch ($sheet) {
            case 'web':
                $sort     = "WHERE item_is_deleted = 0 AND item_published = 1 ORDER BY item_id DESC";
                break;
            case 'web.top':
                $sort     = "WHERE item_is_deleted = 0 ORDER BY item_votes DESC";
                break;
            case 'web.deleted':
                $sort     = "WHERE item_is_deleted = 1 ORDER BY item_id DESC";
                break;
            case 'web.audits':
                $sort     = "WHERE item_is_deleted = 0 AND item_published = 0 ORDER BY item_id DESC";
                break;
        }

        return $sort;
    }

    // Получаем сайты по условиям
    // https://systemrequest.net/index.php/123/
    public static function feedItem($page, $limit, $facets, $user, $topic_id, $sheet, $screening)
    {
        $result = [];
        foreach ($facets as $ind => $row) {
            $result['9999'] = $topic_id;
            $result[$ind] = $row['facet_id'];
        }

        $sort = "ORDER BY item_votes DESC";
        if ($sheet == 'web.all') $sort = "ORDER BY item_date DESC";

        $string = "relation_facet_id IN($topic_id)";
        if ($result) $string = "relation_facet_id IN(" . implode(',', $result ?? []) . ")";

        $go = '';
        if ($screening == 'github') {
            $go = 'item_is_github = 1 AND';
        }

        $start  = ($page - 1) * $limit;

        $sql = "SELECT DISTINCT
                    item_id,
                    item_title_url,
                    item_content_url,
                    item_published,
                    item_user_id,
                    item_url,
                    item_url_domain,
                    item_votes,
                    item_date,
                    item_count,
                    item_title_soft,
                    item_is_github,
                    item_github_url,
                    item_following_link,
                    item_is_deleted,
                    rel.*,
                    votes_item_user_id, votes_item_item_id,
                    fav.tid, fav.user_id, fav.action_type, 
                    u.id, u.login, u.avatar
  
                        FROM facets_items_relation 
                        LEFT JOIN items ON relation_item_id = item_id
                        LEFT JOIN (
                            SELECT 
                                relation_item_id,
                                GROUP_CONCAT(facet_type, '@', facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets
                                LEFT JOIN facets_items_relation 
                                    on facet_id = relation_facet_id

                                    GROUP BY relation_item_id
                        ) AS rel
                             ON rel.relation_item_id = item_id
                            LEFT JOIN users u ON u.id = item_user_id
                            LEFT JOIN favorites fav ON fav.tid = item_id 
                                AND fav.user_id = :uid AND fav.action_type = 'website'
                            LEFT JOIN votes_item 
                                ON votes_item_item_id = item_id AND votes_item_user_id = :uid_two

                                WHERE $go $string $sort LIMIT $start, $limit";

        return DB::run($sql, ['uid' => $user['id'], 'uid_two' => $user['id']])->fetchAll();
    }

    public static function feedItemCount($facets, $topic_id, $screening)
    {
        $result = [];
        foreach ($facets as $ind => $row) {
            $result['9999'] = $topic_id;
            $result[$ind] = $row['facet_id'];
        }

        $go = '';
        if ($screening == 'github') {
            $go = 'item_is_github = 1 AND';
        }

        $string = "relation_facet_id IN($topic_id)";
        if ($result) $string = "relation_facet_id IN(" . implode(',', $result ?? []) . ")";

        $sql = "SELECT DISTINCT
                    item_id,
                    item_published,
                    item_is_github,
                    item_url,
                    item_is_deleted,
                    rel.*
                        FROM facets_items_relation 
                        LEFT JOIN items ON relation_item_id = item_id
            
                        LEFT JOIN (
                            SELECT 
                                relation_item_id,
                                GROUP_CONCAT(facet_type, '@', facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets
                                LEFT JOIN facets_items_relation 
                                    on facet_id = relation_facet_id

                                    GROUP BY relation_item_id
                        ) AS rel
                             ON rel.relation_item_id = item_id
                             
                                WHERE $go $string";

        return DB::run($sql)->rowCount();
    }

    // Check if the domain exists 
    // Проверим наличие домена
    public static function getItemOne($domain, $uid)
    {
        $sql = "SELECT
                    item_id,
                    item_title_url,
                    item_content_url,
                    item_title_soft,
                    item_content_soft,
                    item_published,
                    item_user_id,
                    item_url,
                    item_url_domain,
                    item_votes,
                    item_count,
                    item_is_soft,
                    item_is_github,
                    item_github_url,
                    item_post_related,
                    item_following_link,
                    item_is_deleted,
                    votes_item_user_id, votes_item_item_id,
                    rel.*,
                    fav.tid, fav.user_id, fav.action_type 
                        FROM items
                        LEFT JOIN
                        (
                            SELECT 
                                relation_item_id,
                                GROUP_CONCAT(facet_type, '@', facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets  
                                LEFT JOIN facets_items_relation 
                                    on facet_id = relation_facet_id

                                        GROUP BY relation_item_id
                        ) AS rel
                            ON rel.relation_item_id = item_id 
                        LEFT JOIN votes_item ON votes_item_item_id = item_id AND votes_item_user_id = :uid
                        LEFT JOIN favorites fav ON fav.tid = item_id 
                                AND fav.user_id = :uid_two AND fav.action_type = 'website'
                        WHERE item_url_domain = :domain AND item_is_deleted = 0";


        return DB::run($sql, ['domain' => $domain, 'uid' => $uid, 'uid_two' => $uid])->fetch();
    }

    // Add a domain
    // Добавим домен
    public static function add($params)
    {
        $sql = "INSERT INTO items(item_url, 
                            item_url_domain, 
                            item_title_url, 
                            item_content_url, 
                            item_published,
                            item_user_id, 
                            item_type_url, 
                            item_status_url, 
                            item_is_soft,
                            item_is_github,
                            item_votes,
                            item_count) 
                            
                       VALUES(:item_url, 
                       :item_url_domain, 
                       :item_title_url, 
                       :item_content_url, 
                       :item_published,
                       :item_user_id, 
                       :item_type_url, 
                       :item_status_url, 
                       :item_is_soft,
                       :item_is_github,
                       :item_votes,
                       :item_count)";

        DB::run($sql, $params);

        $item_id =  DB::run("SELECT LAST_INSERT_ID() as item_id")->fetch();

        return $item_id;
    }

    public static function addItemCount($domain)
    {
        $sql = "UPDATE items SET item_count = (item_count + 1) WHERE item_url_domain = :domain";
        DB::run($sql, ['domain' => $domain]);
    }

    public static function edit($params)
    {
        $sql = "UPDATE items 
                    SET item_url        = :item_url,  
                    item_title_url      = :item_title_url, 
                    item_content_url    = :item_content_url,
                    item_title_soft     = :item_title_soft, 
                    item_content_soft   = :item_content_soft,
                    item_published      = :item_published,
                    item_user_id        = :item_user_id,
                    item_type_url       = :item_type_url,
                    item_status_url     = :item_status_url,
                    item_is_soft        = :item_is_soft,
                    item_is_github      = :item_is_github,
                    item_post_related   = :item_post_related,
                    item_github_url     = :item_github_url
                        WHERE item_id   = :item_id";

        return  DB::run($sql, $params);
    }

    // Get data by id
    // Получим данные по id
    public static function getItemId($item_id)
    {
        $sql = "SELECT
                    item_id,
                    item_title_url,
                    item_content_url,
                    item_title_soft,
                    item_content_soft,
                    item_published,
                    item_user_id,
                    item_url,
                    item_url_domain,
                    item_votes,
                    item_count,
                    item_status_url,
                    item_is_soft,
                    item_is_github,
                    item_github_url,
                    item_post_related,
                    item_following_link,
                    item_is_deleted
                        FROM items 
                        WHERE item_id = :item_id AND item_is_deleted = 0";


        return DB::run($sql, ['item_id' => $item_id])->fetch();
    }

    // Topics by reference 
    // Темы по ссылке
    public static function getItemTopic($item_id)
    {
        $sql = "SELECT
                    facet_id as value,
                    facet_title,
                    facet_type,
                    facet_slug
                        FROM facets  
                        INNER JOIN facets_items_relation ON relation_facet_id = facet_id
                            WHERE relation_item_id  = :item_id ";

        return DB::run($sql, ['item_id' => $item_id])->fetchAll();
    }

    // More... 
    // Еще...
    public static function itemSimilar($item_id, $limit)
    {
        $sql = "SELECT 
                    item_id,
                    item_title_url,
                    item_url_domain
                        FROM items 
                            WHERE item_id < :item_id 
                                AND item_published = 1 AND item_is_deleted = 0
                                    ORDER BY item_id DESC LIMIT $limit";

        return DB::run($sql, ['item_id' => $item_id])->fetchall();
    }

    public static function setCleek($id)
    {
        $sql = "UPDATE items SET item_following_link = (item_following_link + 1) WHERE item_id = :id";

        return DB::run($sql, ['id' => $id]);
    }
}
