<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 14.36
 */

class WordsController extends Controller
{
    public function process($params)
    {
        if ($params[0] == 'AddWord') {

            $this->head = array(
                'title' => 'Add new word',
                'description' => 'Add new word data.'
            );
            $addWord = new AddNewWord();
            $addWord->addWord();

            $this->view = 'addword';
        } else {
            $this->head = array(
                'title' => 'Words Table',
                'description' => 'Words table data.'
            );

            $wordModel = new PaginationWordsTable();
            $this->data['arr'] = $wordModel->paginationForWordsTable();
            $this->data['total_pages'] = $wordModel->totalPages();
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $this->data['pageno'] = $pageno;
            $this->view = 'wordtable';
        }

        $deleteWord = new DeleteWordsByIdFromDb();
        $deleteWord->deleteWordsById();

        if (isset($_GET['id'])) {
            $updateWord = new EditWord();
            $this->data['selectAllArray'] = $updateWord->selectData();
            $this->view = 'editword';
            $updateWord->updateWord();
        }


    }
}