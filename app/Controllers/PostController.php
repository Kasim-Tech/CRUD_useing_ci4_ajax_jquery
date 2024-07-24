<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PostController extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function add()
    {
        $file = $this->request->getFile('image');
        $fileName = $file->getRandomName();

        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'body' => $this->request->getPost('body'),
            'image' => $fileName,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'image' => [
                'label' => 'Image',
                'rules' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png]'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'error' => true,
                'message' => $validation->getErrors()
            ]);
        } else {
            $file->move('uploads/avatar', $fileName);
            $postModel = new \App\Models\PoseModel();
            $postModel->save($data);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Post created successfully'
            ]);
        }
    }

    // handle fetch all post ajax request
    public function fetch()
    {
        $postModel = new \App\Models\PoseModel();
        $posts = $postModel->findAll();
        $data = '';

        if ($posts) {
            foreach ($posts as $post) {
                $data .= '  <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <a href="#" id="' . $post['id'] . '" class="post_detail_btn"><img
                                            src="uploads/avatar/' . $post['image'] . '"class="img-fluid card-img-top">
                                            </a>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="card-title fs-5 fw-bold">' . $post['title'] . '</div>
                                            <div class="badge bg-dark">' . $post['category'] . '</div>
                                        </div>
                                        <p>
                                        ' . substr($post['body'], 0, 80) . '...
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <div class="fst-italic">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                                        <div>
                                            <a href="#" id="' . $post['id'] . '"class="btn btn-success btn-sm post_edit_btn"data-bs-toggle="modal" data-bs-target="#edit_post_modal">Edit</a>
                                            <a href="#" id="' . $post['id'] . '" class="btn btn-danger btn-sm post_delete_btn">Delete</a>
                                        </div>
                                    </div>
                                </div>

                            </div>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $data
            ]);
        }else{
            return $this->response->setJSON([
                'error' => true,
               'message' => '<div class="tet-center text-secondry fw-bold my-5"> No Post Found IN The Database..!!</div>'
            ]);
        }
    }

    // handel edit post ajax request
    public function edit($id = null){
        $postModal = new \App\Models\PoseModel();
        $post = $postModal->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post
        ]);
        
    }
    // handel update
    public function update(){
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('image');
        $fileName = $file ? $file->getName() : '';
    
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/avatar', $fileName);
    
            if ($this->request->getPost('old_image') && file_exists('uploads/avatar/' . $this->request->getPost('old_image'))) {
                unlink('uploads/avatar/' . $this->request->getPost('old_image'));
            }
        } else {
            $fileName = $this->request->getPost('old_image');
        }
    
        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'body' => $this->request->getPost('body'),
            'image' => $fileName,
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $postModel = new \App\Models\PoseModel();
        try {
            $postModel->update($id, $data);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Post Updated Successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Failed to update post: ' . $e->getMessage()
            ]);
        }
    }

    // handle delete post ajax request
    public function delete($id = null){
        $postModel = new \App\Models\PoseModel();
        $post = $postModel->find($id);
       $postModel->delete($id);
       unlink('uploads/avatar/' . $post['image']);
       return $this->response->setJSON([
           'error' => false,
          'message' => 'Post deleted successfully'
       ]);
    }
}    