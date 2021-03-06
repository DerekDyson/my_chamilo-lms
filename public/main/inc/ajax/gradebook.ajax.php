<?php
/* For licensing terms, see /license.txt */
/**
 * Responses to AJAX calls.
 */
require_once __DIR__.'/../global.inc.php';

api_protect_course_script(true);

$action = $_REQUEST['a'];

switch ($action) {
    case 'add_gradebook_comment':
        if (true !== api_get_configuration_value('allow_gradebook_comments')) {
            exit;
        }
        if (api_is_allowed_to_edit(null, true)) {
            $userId = $_REQUEST['user_id'] ?? 0;
            $gradeBookId = $_REQUEST['gradebook_id'] ?? 0;
            $comment = $_REQUEST['comment'] ?? '';
            GradebookUtils::saveComment($gradeBookId, $userId, $comment);
            echo 1;
            exit;
        }
        echo 0;
        break;
    case 'get_gradebook_weight':
        if (api_is_allowed_to_edit(null, true)) {
            $cat_id = $_GET['cat_id'];
            $cat = Category :: load($cat_id);
            if ($cat && isset($cat[0])) {
                echo $cat[0]->get_weight();
            } else {
                echo 0;
            }
        }
        break; /*
    case 'generate_custom_report':
        if (api_is_allowed_to_edit(null, true)) {
            $allow = api_get_configuration_value('gradebook_custom_student_report');
            if (!$allow) {
                exit;
            }
            $form = new FormValidator(
                'search',
                'get',
                api_get_path(WEB_CODE_PATH).'gradebook/index.php?'.api_get_cidreq().'&action=generate_custom_report'
            );
            $form->addText('custom_course_id', get_lang('Course ID'));
            $form->addDateRangePicker('range', get_lang('Date range'));
            $form->addHidden('action', 'generate_custom_report');
            $form->addButtonSearch();
            $form->display();
        }
        break;*/
    default:
        echo '';
        break;
}
exit;
