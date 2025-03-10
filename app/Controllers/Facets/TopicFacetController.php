<?php

namespace App\Controllers\Facets;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use App\Models\User\UserModel;
use App\Models\{FeedModel, SubscriptionModel, FacetModel, PostModel};
use Content, Translate, Tpl, UserData;

class TopicFacetController extends MainController
{
    protected $limit = 25;

    private $user;

    public function __construct()
    {
        $this->user = UserData::get();
    }

    // Posts in the topic 
    // Посты по теме
    public function index($sheet, $type)
    {
        $page   = Request::getInt('page');
        $page   = $page == 0 ? 1 : $page;

        $slug   = Request::get('slug');
        $facet  = FacetModel::getFacet($slug, 'slug', 'topic');
        pageError404($facet);

        if ($facet['facet_type'] == 'blog' || $facet['facet_type'] == 'section') {
            include HLEB_GLOBAL_DIRECTORY . '/app/Optional/404.php';
            hl_preliminary_exit();
        }

        $facet['facet_add_date']    = lang_date($facet['facet_add_date']);

        $posts      = FeedModel::feed($page, $this->limit, $this->user, $sheet, $facet['facet_slug']);
        $pagesCount = FeedModel::feedCount($this->user, $sheet, $facet['facet_slug']);

        $result = [];
        foreach ($posts as $ind => $row) {
            $text = fragment($row['post_content']);
            $row['post_content_preview']    = Content::text($text, 'line');
            $row['post_date']               = lang_date($row['post_date']);
            $result[$ind]                   = $row;
        }

        $url    = getUrlByName('topic', ['slug' => $facet['facet_slug']]);
        $title  = $facet['facet_seo_title'] . ' — ' .  Translate::get('topic');
        $desc   = $facet['facet_description'];
        if ($sheet == 'facet.recommend') {
            $url    =  getUrlByName('recommend', ['slug' => $facet['facet_slug']]);
            $title  = $facet['facet_seo_title'] . ' — ' .  Translate::get('recommended posts');
            $desc   = sprintf(Translate::get('recommended.posts.desc'), $facet['facet_seo_title']) . $facet['facet_description'];
        }

        $m = [
            'og'         => true,
            'twitter'    => true,
            'imgurl'     => AG_PATH_FACETS_LOGOS . $facet['facet_img'],
            'url'        => $url,
        ];

        return Tpl::agRender(
            '/facets/topic',
            [
                'meta'  => meta($m, $title, $desc),
                'data'  => [
                    'pagesCount'    => ceil($pagesCount / $this->limit),
                    'pNum'          => $page,
                    'sheet'         => $sheet,
                    'type'          => $type,
                    'facet'         => $facet,
                    'posts'         => $result,
                    'focus_users'   => FacetModel::getFocusUsers($facet['facet_id'], 5),
                    'facet_signed'  => SubscriptionModel::getFocus($facet['facet_id'], $this->user['id'], 'topic'),
                    'user'          => UserModel::getUser($facet['facet_user_id'], 'id'),
                    'high_topics'   => FacetModel::getHighLevelList($facet['facet_id']),
                    'low_topics'    => FacetModel::getLowLevelList($facet['facet_id']),
                    'low_matching'  => FacetModel::getLowMatching($facet['facet_id']),
                    'writers'       => FacetModel::getWriters($facet['facet_id'], 5),
                ],
                'facet'   => ['facet_id' => $facet['facet_id'], 'facet_type' => $facet['facet_type'], 'facet_user_id' => $facet['facet_user_id']],
            ]
        );
    }

    // Information on the topic 
    // Информация по теме
    public function info()
    {
        $slug   = Request::get('slug');
        $facet  = FacetModel::getFacet($slug, 'slug', 'topic');
        pageError404($facet);

        $facet['facet_add_date']    = lang_date($facet['facet_add_date']);

        $facet['facet_info']   = Content::text($facet['facet_info'], 'text');

        $facet_related = $facet['facet_post_related'] ?? null;

        $m = [
            'og'         => true,
            'twitter'    => true,
            'imgurl'     => AG_PATH_FACETS_LOGOS . $facet['facet_img'],
            'url'        => getUrlByName('topic.info', ['slug' => $facet['facet_slug']]),
        ];

        return Tpl::agRender(
            '/facets/info',
            [
                'meta'  => meta($m, $facet['facet_seo_title'] . ' — ' .  Translate::get('info'), $facet['facet_description']),
                'data'  => [
                    'sheet'         => 'info',
                    'type'          => 'info',
                    'facet'         => $facet,
                    'facet_signed'  => SubscriptionModel::getFocus($facet['facet_id'], $this->user['id'], 'topic'),
                    'focus_users'   => FacetModel::getFocusUsers($facet['facet_id'], 5),
                    'related_posts' => PostModel::postRelated($facet_related),
                    'high_topics'   => FacetModel::getHighLevelList($facet['facet_id']),
                    'low_topics'    => FacetModel::getLowLevelList($facet['facet_id']),
                    'user'          => UserModel::getUser($facet['facet_user_id'], 'id'),
                ]
            ]
        );
    }

    // Information on the topic 
    // Информация по теме
    public function writers()
    {
        $slug   = Request::get('slug');
        $facet  = FacetModel::getFacet($slug, 'slug', 'topic');
        pageError404($facet);

        $facet['facet_add_date']    = lang_date($facet['facet_add_date']);

        $facet['facet_info']   = Content::text($facet['facet_info'], 'text');

        $facet_related = $facet['facet_post_related'] ?? null;

        $m = [
            'og'         => true,
            'twitter'    => true,
            'imgurl'     => AG_PATH_FACETS_LOGOS . $facet['facet_img'],
            'url'        => getUrlByName('topic.info', ['slug' => $facet['facet_slug']]),
        ];
 
        return Tpl::agRender(
            '/facets/writers',
            [
                'meta'  => meta($m, $facet['facet_seo_title'] . ' — ' .  Translate::get('info'), $facet['facet_description']),
                'data'  => [
                    'sheet'         => 'writers',
                    'type'          => 'writers',
                    'facet'         => $facet,
                    'facet_signed'  => SubscriptionModel::getFocus($facet['facet_id'], $this->user['id'], 'topic'),
                    'focus_users'   => FacetModel::getFocusUsers($facet['facet_id'], 5),
                    'related_posts' => PostModel::postRelated($facet_related),
                    'high_topics'   => FacetModel::getHighLevelList($facet['facet_id']),
                    'writers'       => FacetModel::getWriters($facet['facet_id'], 15),
                    'low_topics'    => FacetModel::getLowLevelList($facet['facet_id']),
                    'user'          => UserModel::getUser($facet['facet_user_id'], 'id'),
                ]
            ]
        );
    }

    // Subscribed (25) 
    // Подписаны (25)
    public function followers()
    {
        $topic_id   = Request::getInt('id');

        $users      = FacetModel::getFocusUsers($topic_id, 15);

        return Tpl::agIncludeTemplate('/content/facets/followers', ['users' => $users]);
    }
}
