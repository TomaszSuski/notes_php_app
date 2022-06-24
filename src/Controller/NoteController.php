<?php

declare(strict_types=1);

namespace App\Controller;

class NoteController extends AbstractController
{   

    public function createAction(): void
    {
        $title = $this->request->postParam('title');
        $description = $this->request->postParam('description');

        if ($this->request->hasPost()) {
            $this->noteModel->create([
                'title' => $title,
                'description' => $description
            ]);
            $this->redirect('/', ['before' => 'created']);
            exit;
        }
        $this->view->render('create');
    }

    public function showAction(): void
    {
        $this->view->render('show', $this->getNote());
    }

    public function listAction(): void
    {
        $pageSize = (int) $this->request->getParam('page_size', DEFAULT_PAGE_SIZE);
        $pageNumber = (int) $this->request->getParam('page_number', DEFAULT_PAGE_NUMBER);
        
        if(!in_array($pageSize, [5, 10, 25]))
        {
            $pageSize = DEFAULT_PAGE_SIZE;
        }

        $sort = [
                    'by' => $this->request->getParam('sortby'),
                    'order' => $this->request->getParam('sortorder')
        ];
        
        $searchPhrase = $this->request->getParam('phrase') ?? null;

        if ($searchPhrase)
        {
            $notes = $this->noteModel->search($sort, $pageSize, $pageNumber, $searchPhrase);
            $notesCount = $this->noteModel->searchCount($searchPhrase);
        } else {
            $notes = $this->noteModel->list($sort, $pageSize, $pageNumber);
            $notesCount = $this->noteModel->count();
        }

        $pages = (int) ceil($notesCount / $pageSize);

        $this->view->render('list',
            [
                'page' => ['number' => $pageNumber, 'size' => $pageSize, 'pages' => $pages],
                'phrase' => $searchPhrase,
                'sort' => $sort,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $notes
            ]);
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->edit($noteId, $noteData);
            $this->redirect('/', ['before' => 'updated']);
        }

        $this->view->render('edit', $this->getNote());        
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $this->noteModel->delete($noteId);
            $this->redirect('/', ['before' => 'deleted']);
        }

        $this->view->render('delete', $this->getNote());
    }

    private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }

        return $this->noteModel->get($noteId);

    }

}

