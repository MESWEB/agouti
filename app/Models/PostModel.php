<?php

namespace App\Models;

use DB;

class PostModel extends \Hleb\Scheme\App\Models\MainModel
{
    // Добавляем пост
    public static function create($params)
    {
        $sql = "INSERT INTO posts(post_title, 
                                    post_content, 
                                    post_content_img,
                                    post_thumb_img,
                                    post_related,
                                    post_tl,
                                    post_slug,
                                    post_feature,
                                    post_type,
                                    post_translation,
                                    post_draft,
                                    post_ip,
                                    post_published,
                                    post_user_id,
                                    post_closed,
                                    post_top,
                                    post_url,
                                    post_url_domain)
                                    
                                VALUES(:post_title, 
                                    :post_content, 
                                    :post_content_img,
                                    :post_thumb_img,
                                    :post_related,
                                    :post_tl,
                                    :post_slug,
                                    :post_feature,
                                    :post_type,
                                    :post_translation,
                                    :post_draft,
                                    :post_ip,
                                    :post_published,
                                    :post_user_id,
                                    :post_closed,
                                    :post_top,
                                    :post_url,
                                    :post_url_domain)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function getSlug($slug)
    {
        $sql = "SELECT 
                    post_slug 
                        FROM posts WHERE post_slug = :slug";

        return DB::run($sql, ['slug' => $slug])->fetch();
    }

    // Полная версия поста  
    public static function getPost($params, $name, $user)
    {
        $uid = $user['id'];
        $sort = "post_id = :params";
        if ($name == 'slug') {
            $sort = "post_slug = :params";
        }

        $sql = "SELECT 
                    post_id,
                    post_title,
                    post_slug,
                    post_feature,
                    post_translation,
                    post_type,
                    post_draft,
                    post_date,
                    post_published,
                    post_user_id,
                    post_ip,
                    post_votes,
                    post_answers_count,
                    post_comments_count,
                    post_content,
                    post_content_img,
                    post_thumb_img,
                    post_closed, 
                    post_tl,
                    post_lo,
                    post_top,
                    post_url,
                    post_modified,
                    post_related,
                    post_merged_id,
                    post_is_recommend,
                    post_url_domain,
                    post_hits_count,
                    post_is_deleted,
                    u.id,
                    u.login,
                    u.avatar,
                    my_post,
                    votes_post_item_id,
                    votes_post_user_id,
                    fav.tid, 
                    fav.user_id, 
                    fav.action_type
                        FROM posts
                        LEFT JOIN users u ON u.id = post_user_id
                        LEFT JOIN favorites fav ON fav.tid = post_id AND fav.user_id = $uid AND fav.action_type = 'post' 
                        LEFT JOIN votes_post ON votes_post_item_id = post_id AND votes_post_user_id = $uid
                            WHERE $sort AND post_tl <= :trust_level";

        $data = ['params' => $params, 'trust_level' => $user['trust_level']];

        return DB::run($sql, $data)->fetch();
    }

    // Рекомендованные посты
    public static function postsSimilar($post_id, $user, $limit)
    {

        $tl = $user['trust_level'];
        if ($user['trust_level'] == null) {
            $tl = 0;
        }

        $sql = "SELECT 
                    post_id,
                    post_title,
                    post_slug,
                    post_feature,
                    post_tl,
                    post_answers_count,
                    post_type,
                    post_draft,
                    post_user_id,
                    post_is_deleted
                        FROM posts
                            WHERE post_id < :post_id 
                                AND post_is_deleted = 0
                                AND post_draft = 0
                                AND post_tl <= :tl 
                                AND post_user_id != :id
                                ORDER BY post_id DESC LIMIT $limit";

        return DB::run($sql, ['post_id' => $post_id, 'id' => $user['id'], 'tl' => $tl])->fetchall();
    }

    // Пересчитываем количество
    // $type (comments / answers / hits)
    public static function updateCount($post_id, $type)
    {
        $sql = "UPDATE posts SET post_" . $type . "_count = (post_" . $type . "_count + 1) WHERE post_id = :post_id";

        return DB::run($sql, ['post_id' => $post_id]);
    }

    // Редактирование поста
    public static function editPost($data)
    {
        $params = [
            'post_title'            => $data['post_title'],
            'post_slug'             => $data['post_slug'],
            'post_feature'          => $data['post_feature'],
            'post_type'             => $data['post_type'],
            'post_translation'      => $data['post_translation'],
            'post_date'             => $data['post_date'],
            'post_user_id'          => $data['post_user_id'],
            'post_draft'            => $data['post_draft'],
            'post_modified'         => date("Y-m-d H:i:s"),
            'post_content'          => $data['post_content'],
            'post_content_img'      => $data['post_content_img'],
            'post_related'          => $data['post_related'],
            'post_tl'               => $data['post_tl'],
            'post_closed'           => $data['post_closed'],
            'post_top'              => $data['post_top'],
            'post_id'               => $data['post_id'],
        ];

        $sql = "UPDATE posts SET 
                    post_title            = :post_title,
                    post_slug             = :post_slug,
                    post_feature          = :post_feature,
                    post_type             = :post_type,
                    post_translation      = :post_translation,
                    post_date             = :post_date,
                    post_user_id          = :post_user_id,
                    post_draft            = :post_draft,
                    post_modified         = :post_modified,
                    post_content          = :post_content,
                    post_content_img      = :post_content_img,
                    post_related          = :post_related,
                    post_tl               = :post_tl,
                    post_closed           = :post_closed,
                    post_top              = :post_top
                         WHERE post_id = :post_id";

        return DB::run($sql, $params);
    }

    // Связанные посты
    public static function postRelated($post_related)
    {
        $in = "post_id IN(0) AND";
        if ($post_related) {
            $in = "post_id IN(0, " . $post_related . ") AND";
        }

        $sql = "SELECT 
                    post_id as id, 
                    post_title as value,
                    post_slug,
                    post_content_img
                        FROM posts 
                           WHERE $in post_is_deleted = 0 AND post_tl = 0";

        return DB::run($sql)->fetchAll();
    }


    // Связанные посты All
    public static function postRelatedAll()
    {
        $sql = "SELECT 
                    post_id, 
                    post_title, 
                    post_slug as slug
                        FROM posts 
                            WHERE post_is_deleted = 0 AND post_tl = 0";

        return DB::run($sql)->fetchAll();
    }

    // Удаление обложки
    public static function setPostImgRemove($post_id)
    {
        $sql_two = "UPDATE posts SET post_content_img = '' WHERE post_id = :post_id";

        return DB::run($sql_two, ['post_id' => $post_id]);
    }


    // Добавить пост в профиль
    public static function setPostProfile($post_id, $user_id)
    {
        $result = self::getPostProfile($post_id, $user_id);
        
        if (is_array($result)) {

            $sql = "UPDATE users SET my_post = :my_post_id WHERE id = :id AND my_post = :post_id";

            DB::run($sql, ['post_id' => $post_id, 'id' => $user_id, 'my_post_id' => 0]);

            return 'del';
        }

        $sql = "UPDATE users SET my_post = :post_id WHERE id = :id";

        DB::run($sql, ['post_id' => $post_id, 'id' => $user_id]);
        
        return 'add';
    }
    
    public static function getPostProfile($post_id, $user_id)
    {
        $sql = "SELECT my_post FROM users WHERE my_post = :post_id AND id = :id";

        return  DB::run($sql, ['post_id' => $post_id, 'id' => $user_id])->fetch();
    }    

    // Удален пост или нет
    public static function isThePostDeleted($post_id)
    {
        $sql = "SELECT post_id, post_is_deleted
                    FROM posts
                        WHERE post_id = :post_id";

        $result = DB::run($sql, ['post_id' => $post_id])->fetch();

        return $result['post_is_deleted'];
    }

    public static function getPostTopic($post_id, $user_id, $type)
    {
        $condition  = "topic";
        if ($type == 'blog') {
            $condition  = "blog";
        }

        $sql = "SELECT
                    facet_id,
                    facet_title,
                    facet_slug,
                    facet_img,
                    facet_type,
                    facet_short_description,
                    relation_facet_id,
                    relation_post_id,
                    signed_facet_id, 
                    signed_user_id
                        FROM facets  
                        INNER JOIN facets_posts_relation ON relation_facet_id = facet_id
                        LEFT JOIN facets_signed ON signed_facet_id = facet_id AND signed_user_id = :id
                            WHERE relation_post_id  = :post_id AND facet_type = '$condition'";

        return DB::run($sql, ['post_id' => $post_id, 'id' => $user_id])->fetchAll();
    }



    public static function getPostFacet($post_id, $type)
    {
        $sql = "SELECT
                    facet_id as value,
                    facet_title 
                        FROM facets  
                        INNER JOIN facets_posts_relation ON relation_facet_id = facet_id
                            WHERE relation_post_id  = :post_id AND facet_type = :type";

        return DB::run($sql, ['post_id' => $post_id, 'type' => $type])->fetchAll();
    }

    public static function getPostLastUser($post_id)
    {
        $sql = "SELECT
                    answer_id,
                    answer_post_id,
                    answer_user_id,
                    answer_date,
                    answer_id,
                    id,
                    login,
                    avatar
                        FROM answers 
                        LEFT JOIN users ON id = answer_user_id                        
                            WHERE answer_post_id = :post_id
                            ORDER BY answer_date DESC";

        return DB::run($sql, ['post_id' => $post_id])->fetch();
    }
    
    // Check if the domain exists 
    // Проверим наличие домена
    public static function getDomain($domain, $uid)
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
                    item_is_deleted,
                    votes_item_user_id, 
                    votes_item_item_id
                        FROM items 
                        LEFT JOIN votes_item ON votes_item_item_id = item_id AND  votes_item_user_id = :uid
                        WHERE item_url_domain = :domain AND item_is_deleted = 0";


        return DB::run($sql, ['domain' => $domain, 'uid' => $uid])->fetch();
    }
    
    // 5 popular domains
    // 5 популярных доменов
    public static function getDomainTop($domain)
    {
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
                    item_is_deleted
                        FROM items 
                        WHERE item_url_domain != :domain AND item_published = 1 AND item_is_deleted = 0
                        ORDER BY item_count DESC LIMIT 10";

        return DB::run($sql, ['domain' => $domain])->fetchAll();
    }
    
    // Кто подписан на данный вопрос / пост
    public static function getFocusUsersPost($post_id)
    {
        $sql = "SELECT
                    signed_post_id,
                    signed_user_id
                        FROM posts_signed
                        WHERE signed_post_id = :post_id";

        return DB::run($sql, ['post_id' => $post_id])->fetchAll();
    }
    
    // Список читаемых постов
    public static function getFocusPostUser($uid)
    {
        $sql = "SELECT
                    signed_post_id,
                    signed_user_id 
                        FROM posts_signed
                        WHERE signed_user_id = :uid";

        return DB::run($sql, ['uid' => $uid])->fetchAll();
    }

    public static function getFocusPostsListUser($uid)
    {
        $focus_posts = self::getFocusPostUser($uid);

        $result = [];
        foreach ($focus_posts as $ind => $row) {
            $result[$ind] = $row['signed_post_id'];
        }

        if ($result) {
            $string = "WHERE post_id IN(" . implode(',', $result) . ") AND post_draft = 0";
        } else {
            $string = "WHERE post_id IN(0) AND post_draft = 0";
        }

        $sql = "SELECT 
                    post_id,
                    post_title,
                    post_slug,
                    post_feature,
                    post_translation,
                    post_draft,
                    post_date,
                    post_published,
                    post_user_id,
                    post_votes,
                    post_hits_count,
                    post_answers_count,
                    post_comments_count,
                    post_content,
                    post_content_img,
                    post_thumb_img,
                    post_merged_id,
                    post_closed,
                    post_tl,
                    post_lo,
                    post_top,
                    post_url_domain,
                    post_is_deleted,
                    rel.*,
                    votes_post_item_id, votes_post_user_id,
                    u.id, u.login, u.avatar, 
                    fav.tid, fav.user_id, fav.action_type
                    
                        FROM posts
                        LEFT JOIN
                        (
                            SELECT 
                                relation_post_id,

                                GROUP_CONCAT(facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets  
                                LEFT JOIN facets_posts_relation 
                                    on facet_id = relation_facet_id
                                GROUP BY relation_post_id
                        ) AS rel
                            ON rel.relation_post_id = post_id 

            INNER JOIN users u ON u.id = post_user_id
            LEFT JOIN votes_post ON votes_post_item_id = post_id AND votes_post_user_id = $uid
            LEFT JOIN favorites fav ON fav.tid = post_id AND fav.user_id = $uid AND fav.action_type = 'post'
            $string  LIMIT 100";

        return DB::run($sql)->fetchAll();
    }
}
