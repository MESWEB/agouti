<?php

namespace App\Controllers;
use Hleb\Constructor\Handlers\Request;
use App\Models\SearchModel;
use App\Models\ExploreModel;
use Lori\Config;
use Lori\Base;

class SearchController extends \MainController
{
    // Форма поиска
    public function index()
    {

        if (Request::getPost())
        {    
            $qa =  \Request::getPost('q');
          
            $query = preg_replace('/[^a-zA-Zа-яА-Я0-9 ]/ui', '',$qa);

            if (!empty($query)) 
            { 
                if (Base::getStrlen($query) < 3) {
                    Base::addMsg(lang('Too short'), 'error');
                    redirect('/search');
                } else if (Base::getStrlen($query) > 128) {
                    Base::addMsg(lang('Too long'), 'error');
                    redirect('/search');
                } else {
                    // введем подключение словарной библиотеки для подсказок
                } 

                // Успех и определим, что будем использовать
                // Далее индивидуально расширим (+ лайки, просмотры и т.д.)
                if(Config::get(Config::PARAM_SEARCH) == 0) {
                    $qa =  SearchModel::getSearch($query);
                    $result = Array();
                    foreach($qa as $ind => $row){
                        $row['post_content']  = Base::text(Base::cutWords($row['post_content'], 220, '...'), 'md');
                        $result[$ind]         = $row; 
                    }  
                } else {
                    $qa =  SearchModel::getSearchServer($query);
                    $result = Array();
                    foreach($qa as $ind => $row){
                        $result[$ind]         = $row; 
                    } 
                }
            } else {
                Base::addMsg(lang('Empty request'), 'error');
                redirect('/search');
            }  
        } else {
            $query  = '';
            $result = '';
        }
        
        Request::getResources()->addBottomStyles('/assets/css/info.css'); 
        Request::getHead()->addScript('/assets/js/Chart.js');
        
        $flow_num = ExploreModel::getGraf();
        $uid  = Base::getUid();
        $data = [
            'h1'            => lang('Search'),
            'sheet'         => 'search',
            'meta_title'    => lang('Search'),
            'flow_num'      => $flow_num,
        ];

        return view(PR_VIEW_DIR . '/search/index', ['data' => $data, 'uid' => $uid, 'result' => $result, 'query' => $query]);
    }
    
    // Поиск по домену
    public function domain() 
    {
        $domain     = \Request::get('domain');
        $uid        = Base::getUid();
        
        $post       = SearchModel::getDomain($domain, $uid['id']); 
        Base::PageError404($post);
        
        $result = Array();
        foreach($post as $ind => $row){
            $row['post_content_preview']    = Base::cutWords($row['post_content'], 68);
            $row['post_date']               = lang_date($row['post_date']);
            $row['lang_num_answers']        = word_form($row['post_answers_num'], lang('Answer'), lang('Answers-m'), lang('Answers'));
            $result[$ind]                   = $row;
         
        }
        
        $domains = SearchModel::getDomainsTop($domain); 
        
        $meta_title = lang('Domain') . ': ' . $domain .' | '. Config::get(Config::PARAM_NAME);
        $meta_desc = lang('domain-desc') . ': ' . $domain .' '. Config::get(Config::PARAM_HOME_TITLE);
        
        $data = [
            'h1'            => lang('Domain') . ': ' . $domain,  
            'canonical'     => '/' . $domain,
            'sheet'         => 'domain',
            'meta_title'    => $meta_title,
            'meta_desc'     => $meta_desc, 
        ];
        
        return view(PR_VIEW_DIR . '/search/domain', ['data' => $data, 'uid' => $uid, 'posts' => $result, 'domains' => $domains]);
    }

}
