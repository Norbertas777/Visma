<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 14.36
 */

class PatternController extends Controller
{
    public function process($params)
    {
        if ($params[0] == 'AddPatterns') {
            $this->head = array(
                'title' => 'Add new pattern',
                'description' => 'Add new pattern data.'
            );

            $addPattern = new AddNewPattern();
            $addPattern->addPattern();


            $this->view = 'addpatterns';
        } else {
            $this->head = array(
                'title' => 'Pattern Table',
                'description' => 'Pattern table data.'
            );

            $patternModel = new PaginationPatternTable();
            $this->data['arr'] = $patternModel->paginationForPatternTable();
            $this->data['total_pages'] = $patternModel->totalPages();
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $this->data['pageno'] = $pageno;
            $this->view = 'patterntable';
        }

        $deletePattern = new DeletePatternsByIdFromDb();
        $deletePattern->deletePatternsById();

        if(isset($_GET['id'])) {
            $updatePattern = new EditPattern();
            $this->data['selectAllArray'] = $updatePattern->selectData();
            $this->view = 'editpattern';
            $updatePattern->updatePattern();
            }

    }
}