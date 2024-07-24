<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD APP USING CI4 & Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Add New Post Modal Start -->
    <div class="modal fade" id="add_postModal" tabindex="-1" aria-labelledby="addPostLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addPostLabel">Add New Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="add_form_post" novalidate>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="add_title" class="mb-2">Post Title</label>
                            <input type="text" id="add_title" name="title" class="form-control" placeholder="Title"
                                required>
                            <div class="invalid-feedback">Post Title Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="add_category" class="mb-2">Post Category</label>
                            <input type="text" id="add_category" name="category" class="form-control"
                                placeholder="Category" required>
                            <div class="invalid-feedback">Post Category Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="add_body" class="mb-2">Post Body</label>
                            <textarea name="body" class="form-control" id="add_body" rows="4" required></textarea>
                            <div class="invalid-feedback">Post Body Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="add_image" class="mb-2">Post Image</label>
                            <input type="file" id="add_image" name="image" class="form-control" required>
                            <div class="invalid-feedback">Post Image Is Required..!!!</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="add_post_btn">Add New Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add New Post Modal End -->

    <!-- Edit Post Modal Start -->
    <div class="modal fade" id="edit_post_modal" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPostLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="edit_form_post" novalidate>
                    <input type="hidden" name="id" id="edit_pid">
                    <input type="hidden" name="old_image" id="edit_old_image">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="edit_title" class="mb-2">Post Title</label>
                            <input type="text" id="edit_title" name="title" class="form-control" placeholder="Title"
                                required>
                            <div class="invalid-feedback">Post Title Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category" class="mb-2">Post Category</label>
                            <input type="text" id="edit_category" name="category" class="form-control"
                                placeholder="Category" required>
                            <div class="invalid-feedback">Post Category Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_body" class="mb-2">Post Body</label>
                            <textarea name="body" class="form-control" id="edit_body" rows="4" required></textarea>
                            <div class="invalid-feedback">Post Body Is Required..!!!</div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="mb-2">Post Image</label>
                            <input type="file" id="edit_image" name="image" class="form-control">
                            <div class="invalid-feedback">Post Image Is Required..!!!</div>
                            <div id="current_image"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="edit_post_btn">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Post Modal End -->

    <div class="container">
        <div class="row my-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="text-secondary fs-3 fw-bold">All Posts</div>
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add_postModal">Add New
                            Post</button>
                    </div>
                    <div class="card-body">
                        <div class="row" id="show-post">
                            <h1 class="text-center text-secondary my-5">Post is Loading....!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script>
        $(function () {
            // Add Post Form Submission
            $("#add_form_post").submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                if (!this.checkValidity()) {
                    e.preventDefault();
                    $(this).addClass('was-validated');
                } else {
                    $('#add_post_btn').text("Adding...");
                    $.ajax({
                        url: '<?= base_url('/post/add') ?>',
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            if (response.error) {
                                $("#add_image").addClass('is-invalid');
                                $("#add_image").next().text(response.message.image);
                            } else {
                                $("#add_postModal").modal('hide');
                                $("#add_form_post")[0].reset();
                                $("#add_image").removeClass('is-invalid');
                                $("#add_image").next().text('');
                                $("#add_form_post").removeClass('was-validated');
                                Swal.fire('Added', response.message, 'success');
                                fetchAllPosts();
                            }
                            $("#add_post_btn").text("Add New Post");
                        }
                    });
                }
            });

            // Update Post Form Submission
            $("#edit_form_post").submit(function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                if (!this.checkValidity()) {
                    e.preventDefault();
                    $(this).addClass('was-validated');
                } else {
                    $('#edit_post_btn').text("Updating...");
                    $.ajax({
                        url: '<?= base_url('/post/update') ?>',
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            $("#edit_post_modal").modal('hide');
                            $("#edit_form_post").removeClass('was-validated');
                            Swal.fire('Updated', response.message, 'success');
                            fetchAllPosts();
                            $("#edit_post_btn").text("Update Post");
                        }
                    });
                }
            });

            // Edit Post Button Click
            $(document).on('click', '.post_edit_btn', function (e) {
                e.preventDefault();
                const id = $(this).attr('id');
                $.ajax({
                    url: '<?= base_url('post/edit') ?>/' + id,
                    method: 'get',
                    success: function (response) {
                        $("#edit_pid").val(response.message.id);
                        $("#edit_old_image").val(response.message.image);
                        $("#edit_title").val(response.message.title);
                        $("#edit_category").val(response.message.category);
                        $("#edit_body").val(response.message.body);
                        $("#current_image").html('<img src="<?= base_url('uploads/avatar/') ?>/' + response.message.image + '" class="img-fluid mt-2 img-thumbnail" width="150px">');
                    }
                });
            });


            // delete post ajax request
            $(document).delegate('.post_delete_btn', 'click', function (e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                       $.ajax({
                        url: '<?= base_url('post/delete') ?>/' + id,
                        method: 'get',
                        success: function (response) {
                            Swal.fire('Deleted', response.message, 'success');
                            fetchAllPosts();
                        }
                        }) }
                });
            });










            // Fetch All Posts
            fetchAllPosts();
            function fetchAllPosts() {
                $.ajax({
                    url: '<?= base_url('post/fetch') ?>',
                    method: 'get',
                    success: function (response) {
                        $("#show-post").html(response.message);
                    }
                });
            }
        });
    </script>

</body>

</html>