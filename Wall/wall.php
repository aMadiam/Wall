<?php
    require('Sql.php');
    session_start();
    if (isset($_SESSION['logged-in'])) {
        session_destroy();
        header('location: index.php');
        die();
    }
    echo "howdy, {$_SESSION['first_name']}!<br>";
    echo "<a href='process.php'>LOG-OFF! </a>";
?>
<style>
    textarea {
        width: 300px;
        height: 150px;
}
    form input[type='submit'] {
        display: block;
        background-color: blue;
        border-radius: 5px;
        color: white;
        padding: 5px;
        margin-top: 5px;
    }
    h3 {
        margin-left: 15px;
    }
    p {
        margin-left: 15px;
    }
    .comment_form {
        margin-left: 20px;
    }
</style>

<h1>This is my wall!</h1>
<h2>Post a message</h2>

<form action='process.php' method='post'>
    <input type='hidden' name='action' value='create_message' />
    <textarea name='context' placeholder='Post a message' class="comment"></textarea>
    <input type='submit' value='Create a message'>
</form>

<?php
    $reviews = fetch_all("SELECT reviews.*, users.first_name, users.last_name FROM reviews LEFT JOIN
                users ON users.id = reviews.user_id ORDER BY id DESC");
?>
<?php
foreach ($reviews as $review){ 
?>    
<h2>Message from <?= $review['first_name']; ?> 
<?= $review['last_name']; ?> 
(<?= $review['created_at'];?>)</h2>
<p> <?= $review['context']; ?></p>

<?php
    $replies = fetch_all("SELECT replies.*, users.first_name, users.last_name FROM replies
                        LEFT JOIN users ON users.id = replies.user_id
                        WHERE replies.review_id = ".$review['id']);
?>

<?php
    foreach ($replies as $reply) {
?>

<h3>Message from <?= $reply['first_name']; ?> <?= $reply['last_name']; ?> (<?= $reply['created_at']; ?>)</h3>
<p><?= $reply['content']; ?></p>
<?php 
    }
?>
<h3>Post a comment</h3>
<form action='comment_form' action='process.php' method='post' class="comment_form">
    <input type='hidden' name='action' value='create_comment' />
    <input type='hidden' name='reviews_id' value='<?= $review['id']?>' />
    <textarea name='comment' placeholder='Post a comment' class="comment"></textarea>
    <input type='submit' value='Create a comment'>
</form>
<?php
}
?>