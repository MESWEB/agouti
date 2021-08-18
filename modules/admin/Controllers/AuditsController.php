<?php

namespace Modules\Admin\Controllers;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use Modules\Admin\Models\AuditModel;
use App\Models\{PostModel, AnswerModel, CommentModel};
use Lori\Base;

class AuditsController extends MainController
{
    public function index($sheet)
    {
        $uid    = Base::getUid();
        $page   = Request::getInt('page');
        $page   = $page == 0 ? 1 : $page;

        $limit  = 55;
        $pagesCount = AuditModel::getAuditsAllCount($sheet);
        $audits     = AuditModel::getAuditsAll($page, $limit, $sheet);

        $result = array();
        foreach ($audits  as $ind => $row) {

            if ($row['audit_type'] == 'post') {
                $row['content'] = PostModel::getPostId($row['audit_content_id']);
            } elseif ($row['audit_type'] == 'answer') {
                $row['content'] = AnswerModel::getAnswerId($row['audit_content_id']);

                $row['post'] = PostModel::getPostId($row['content']['answer_post_id']);
            } elseif ($row['audit_type'] == 'comment') {
                $row['content'] = CommentModel::getCommentsId($row['audit_content_id']);
            }

            $result[$ind]       = $row;
        }

        $data = [
            'meta_title'    => lang('Audit'),
            'sheet'         => $sheet == 'approved' ? 'audits' : 'approved',
            'pagesCount'    => ceil($pagesCount / $limit),
            'pNum'          => $page,
        ];

        return view('/templates/audits', ['data' => $data, 'uid' => $uid, 'audits' => $result]);
    }

    // Восстановление после аудита
    public function status()
    {
        $st     = Request::getPost('status');
        $status = preg_split('/(@)/', $st);
        // id, type
        AuditModel::recoveryAudit($status[0], $status[1]);

        return true;
    }
}
