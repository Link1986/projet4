<?php $title = htmlspecialchars($post['title']); ?>

    <?php ob_start(); ?>    
    
    <!-- Menu de navigation -->
       
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top mb-5">
    
        <div class="container">
    
            <a class="navbar-brand order-1 mr-0" href="index.php" >Billet simple pour l'Alaska</a>
        
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        
                <span class="navbar-toggler-icon"></span>
            
            </button>
        
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        
                <div class="navbar-nav">
        
                    <a class="nav-item nav-link text-white" href="index.php#blog">Retour à la liste des billets</a>                
                
                </div>
            
            </div>
        
        </div>
        
    </nav>
    
    <!-- Chapitre du blog -->
    
    <div class="container">
    
        <div class="row">
        
            <div class="col-sm-12 my-5">
            
                <h3 class="my-5 pl-5 text-center">Billet simple pour l'Alaska</h3>
                
                <div class="bg-success rounded">
    
                    <h3 class="text-center text-white chapitre py-2">
                    
                        <?= htmlspecialchars($post['title']) ?>            
            
                    </h3>
    
                    <p class="text-white text-center py-2 border">
        
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
            
                    </p>
        
                    <p class="text-white text-center py-2">
                    
                        <em>le <?= $post['creation_date_fr'] ?></em>
                        
                    </p>
        
                </div>
                
            </div>
            
        </div>
        
    </div>
       

    <!-- Affichage des commentaires -->
    <?php
    
        while ($comment = $comments->fetch())
            
        {
            
    ?>
    
    <div class="container">
    
        <div class="row">
        
            <div class="col-sm-12">        
        
                <div class="bg-info rounded my-4 text-white">
        
                    <h3 class="text-center text-white chapitre py-2"><?= htmlspecialchars($comment['author']) ?></h3>
            
                    <p class="text-white text-center py-2 border"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
            
                    <p class="text-white text-center py-2"><em>le <?= $comment['comment_date_fr'] ?></em></p>
                    
                    <p class="text-white text-center py-2"><em>
                    
                    <?php 
        
                    if ($comment['report_comment'] > 0 ) {
                    
                        echo 'Nombre de signalements : ' . $comment['report_comment'];
                        
                    }
            
                    else {
                    
                    }
            
                    ?>
                    
                    </em></p>
                    
                    <a href="index.php?action=reportComment&amp;id=<?= $comment['id'] ?>" class="btn btn-light mx-auto d-flex justify-content-center font-weight-bold font-italic my-3" style="width: 200px;">Signaler le commentaire</a>
                    
                    <br/>       
        
                </div>
            
            </div>
            
        </div>
        
    </div>
        
    <?php
        
        }

        $comments->closeCursor();

    ?>
    
    <!-- Module de messagerie -->
            
    <div class="container">
    
        <div class="row">
        
            <div class="col-sm-12">
            
                <h3 class="my-5 pl-5 text-center">Ajouter un commentaire</h3>
                
                <div class="bg-primary rounded font-weight-bold border border-light mb-3">
       
                    <form class="col-sm-6 mx-auto" action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
                    
                        <div class="form-group">
                        
                            <label for="author" class="text-white">Pseudo :</label>
                            
                            <input type="text" class="form-control border border-dark" id="author" name="author" aria-describedby="emailHelp">
                            
                        </div>
                        
                        <div class="form-group">
                        
                            <label for="comment" class="text-white">Message :</label>
                            
                            <textarea class="form-control border border-dark" id="comment" name="comment" rows="3"></textarea>
                            
                        </div>
  
                        <button type="submit" class="btn btn-light font-weight-bold d-flex justify-content-center mb-3">Envoyer</button>
                        
                    </form>
        
                </div>
                
            </div>
            
        </div>
        
    </div>

    <?php $content = ob_get_clean(); ?>

    <?php require('template.php'); ?>
