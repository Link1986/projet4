<?php

require_once('model/PostManager.php');

require_once('model/CommentManager.php');

require_once('model/AdminManager.php');

function listPosts()
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();
    $posts = $postManager->getPosts();

    require('view/frontend/listPostsView.php');
    
}

function post()
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();
    $commentManager = new \OpenClassrooms\Blog\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
    
}

function addPost($title, $content)
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();
    $addedPost = $postManager->newPost($title, $content);

    if ($addedPost === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible d\'ajouter le billet !' . '</p>';
        
    }
    
    else {
        
        header('Location: index.php?action=admin');
        
    }
    
}

function changePost()
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();    

    $post = $postManager->getPost($_GET['id']);    

    require('view/frontend/changePostView.php');
    
}

function updatePost($postId, $title, $content)
    
{
    
   $postManager = new \OpenClassrooms\Blog\Model\PostManager();

    $modifiedPost = $postManager->changedPost($postId, $title, $content);

    if ($modifiedPost === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de modifier le billet !' . '</p>';
        
    }
    
    else {
        
        header('Location: index.php?action=changePost&id=' . $postId);        
        
    }
    
}

function delPost($postId)
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();

    $suppressPost = $postManager->deletePost($postId);

    if ($suppressPost === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de supprimer le billet !' . '</p>';
        
    }
    
    else {
        
        header('Location: index.php?action=admin');
        
    }
    
}

function addComment($postId, $author, $comment)
    
{
    
    $commentManager = new \OpenClassrooms\Blog\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible d\'ajouter le commentaire !' . '</p>';
        
    }
    
    else {
        
        header('Location: index.php?action=post&id=' . $postId);
        
    }
    
}

function reportComment($commentId)
    
{
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $comments = $adminManager->searchComments($commentId);    
  
    $comment = $comments->fetch();
    $report = intval($comment['report_comment']);
    $report++;
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();    
    $unsafeComment = $adminManager->checkComment($report, $comment['id']);
    
    if ($unsafeComment === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de signaler le commentaire !' . '</p>';
        
    }
    
    else {
        
        header('Location: index.php?action=post&id=' . $comment['post_id']);
        
    }    

}

function adminPannel()
    
{
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $listAll = $adminManager->adminSpace();
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $connection = $adminManager->adminConnection();

    require('view/frontend/adminView.php');
    
}

function adminConnect()
    
{
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $listAll = $adminManager->adminSpace();

    require('view/frontend/adminConnectView.php');
    
}

function adminLogout()
    
{
    
    session_start();
    $_SESSION = array();
    session_destroy();
    setcookie('username', '');
    setcookie('password', '');
    
    header ('location: index.php?action=adminConnect');
    
}

function commentPannel()
    
{
    
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();
    $post = $postManager->getPost($_GET['id']);
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $comments = $adminManager->selectComments($_GET['id']);

    require('view/frontend/commentView.php');
    
}

function changeComment()
    
{
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $comments = $adminManager->searchComments($_GET['id']);    

    require('view/frontend/changeCommentView.php');
    
}

function updateComment($commentId, $author, $comment)
    
{
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $modifiedComment = $adminManager->changedComment($commentId, $author, $comment);

    if ($modifiedComment === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de modifier le commentaire !' . '</p>';
        
    }
    
    else {
        
        $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
        $comments = $adminManager->searchComments($commentId);    
  
        $comment = $comments->fetch();
        
        header('Location: index.php?action=changeComment&id=' . $comment['id']);        
        
    }
    
}

function delComment($commentId)
    
{
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
    $comments = $adminManager->searchComments($commentId);
    
    $comment = $comments->fetch();
    
    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();    
    $suppressComment = $adminManager->deleteComment($commentId);

    if ($suppressComment === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de supprimer le commentaire !' . '</p>';
        
    }
    
    else {        
        
        header('Location: index.php?action=commentPannel&id=' . $comment['post_id']);
        
    }
    
}

function unreportComment($commentId)
    
{

    $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();    
    $safeComment = $adminManager->uncheckComment($commentId);

    if ($safeComment === false) {
        
        require('view/frontend/errorPageView.php');
        echo '<br><p class="text-center text-white my-5">' . 'Impossible de désignaler le commentaire !' . '</p>';
        
    }
    
    else {
        
        $adminManager = new \OpenClassrooms\Blog\Model\AdminManager();
        $comments = $adminManager->searchComments($commentId);    
  
        $comment = $comments->fetch();
        
        header('Location: index.php?action=commentPannel&id=' . $comment['post_id']);
        
    }
    
}
