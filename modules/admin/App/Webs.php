<?php

namespace Modules\Admin\App;

use Hleb\Constructor\Handlers\Request;
use Modules\Catalog\App\Models\WebModel;

class Webs
{
    public function favicon()
    {
        $item_id    = Request::getPostInt('id');
        $item       = WebModel::getItemId($item_id);
        pageError404($item);

        $puth = HLEB_PUBLIC_DIR . AG_PATH_FAVICONS . $item["item_url_domain"] . '.png';
        $dirF = HLEB_PUBLIC_DIR . AG_PATH_FAVICONS;

        if (!file_exists($puth)) {
            $urls = self::getFavicon($item['item_url_domain']);
            copy($urls, $puth);
        }

        return true;
    }

    public static function getFavicon($url)
    {
        $url = str_replace("https://", '', $url);
        //return "https://www.google.com/s2/favicons?domain=" . $url;
        return "https://favicon.yandex.net/favicon/" . $url;
    }
}
