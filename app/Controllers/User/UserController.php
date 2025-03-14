<?php

namespace App\Controllers\User;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use App\Models\User\{UserModel, BadgeModel};
use App\Models\{PostModel, FolderModel};
use Content, Translate, Tpl, UserData;

class UserController extends MainController
{
    private $user;

    protected $limit = 42;

    public function __construct()
    {
        $this->user  = UserData::get();
    }

    // All users
    // Все пользователи
    function index($sheet, $type)
    {
        $page   = Request::getInt('page');
        $page   = $page == 0 ? 1 : $page;

        $usersCount = UserModel::getUsersAllCount();
        $users      = UserModel::getUsersAll($page, $this->limit, $this->user['id'], $sheet);
        pageError404($users);

        $m = [
            'og'         => false,
            'twitter'    => false,
            'imgurl'     => false,
            'url'        => getUrlByName($sheet),
        ];

        return Tpl::agRender(
            '/user/all',
            [
                'meta'  => meta($m, Translate::get($type . 's'), Translate::get($sheet . '.desc')),
                'data'  => [
                    'sheet'         => $sheet,
                    'type'          => $type,
                    'pagesCount'    => ceil($usersCount / $this->limit),
                    'pNum'          => $page,
                    'users'         => $users
                ]
            ]
        );
    }

    // Member bookmarks page
    // Страница закладок участника
    function favorites()
    {
        $favorites = UserModel::userFavorite($this->user['id']);

        $result = [];
        foreach ($favorites as $ind => $row) {

            if ($row['action_type'] == 'post') {
                $row['answer_post_id'] = $row['post_id'];
            }

            $row['answer_content']  = Content::text($row['answer_content'], 'text');
            $row['post']            = PostModel::getPost($row['answer_post_id'], 'id', $this->user);
            $result[$ind]           = $row;
        }

        return Tpl::agRender(
            '/user/favorite/all',
            [
                'meta'  => meta($m = [], Translate::get('favorites')),
                'data'  => [
                    'sheet'     => 'favorites',
                    'type'      => 'favorites',
                    'favorites' => $result,
                    'tags'      => FolderModel::get('favorite', $this->user['id']),
                ]
            ]
        );
    }


    // Participant's folder page (for bookmarks)
    // Страница папок участника (для закладок)
    function folders()
    {
        Request::getResources()->addBottomStyles('/assets/js/tag/tagify.css');
        Request::getResources()->addBottomScript('/assets/js/tag/tagify.min.js');
        
        $folders = FolderModel::get('favorite', $this->user['id']);
        
        return Tpl::agRender(
            '/user/favorite/folders',
            [
                'meta'  => meta($m = [], Translate::get('folders')),
                'data'  => [
                    'sheet'     => 'folders',
                    'type'      => 'folders',
                    'folders'   => $folders,
                    'count'     => count($folders),
                ]
            ]
        );
    }
    
    public function foldersFavorite()
    {
        $tag_id = Request::getInt('id');
        $favorites = UserModel::userFavorite($this->user['id'], $tag_id);
        
        return Tpl::agRender(
            '/user/favorite/all',
            [
                'meta'  => meta($m = [], Translate::get('favorites')),
                'data'  => [
                    'sheet'     => 'favorites',
                    'type'      => 'favorites',
                    'favorites' => $favorites
                ]
            ]
        );
 
    }

    // Member Draft Page
    // Страница черновиков участника
    function drafts()
    {
        return Tpl::agRender(
            '/user/draft',
            [
                'meta'  => meta($m = [], Translate::get('drafts')),
                'data'  => [
                    'drafts'    => UserModel::userDraftPosts($this->user['id']),
                    'sheet'     => 'drafts',
                    'type'      => 'drafts',
                ]
            ]
        );
    }

    // User preferences page
    // Страница предпочтений пользователя
    public function subscribed()
    {
        $focus_posts = PostModel::getFocusPostsListUser($this->user['id']);

        $result = [];
        foreach ($focus_posts as $ind => $row) {
            $text                           = explode("\n", $row['post_content']);
            $row['post_content_preview']    = Content::text($text[0], 'line');
            $row['post_date']               = lang_date($row['post_date']);
            $result[$ind]                   = $row;
        }

        return Tpl::agRender(
            '/user/favorite/subscribed',
            [
                'meta'  => meta($m = [], Translate::get('subscribed')),
                'data'  => [
                    'h1'    => Translate::get('subscribed') . ' ' . $this->user['login'],
                    'sheet' => 'subscribed',
                    'type'  => 'favorites',
                    'posts' => $result
                ]
            ]
        );
    }

    public function card()
    {
        $user_id    = Request::getPostInt('user_id');
        $user       = UserModel::getUser($user_id, 'id');
        $post       = PostModel::getPost($user['my_post'], 'id', $this->user);
        $badges     = BadgeModel::getBadgeUserAll($user_id);

        Tpl::agIncludeTemplate(
            '/content/user/card',
            [
                'user'      => $user,
                'post'      => $post,
                'badges'    => $badges
            ]
        );
    }
}
