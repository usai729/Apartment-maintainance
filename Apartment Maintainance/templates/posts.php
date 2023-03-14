<?php 
    include "../php/conn.php";

    session_start();

    $error = "";
    $error_loading = "";

    class Post {
        protected $content;

        function __construct($content)
        {
            $this->content = $content;
        }  

        private function getID($conn, $session_user)
        {
            $getIdSQL = "SELECT flatid FROM flats WHERE phone=$session_user";
            $queryGetId = mysqli_query($conn, $getIdSQL);

            return mysqli_fetch_assoc($queryGetId)['flatid'];
        }

        function addNewPost($conn) {
            $id = $this->getID($conn, $_SESSION['user']);
            $date = date('y/m/d');

            echo $date;

            $sqlAddNewPost = "INSERT INTO posts(postBy, post, addedOn) VALUES($id, '$this->content', '$date')";
            
            if (mysqli_query($conn, $sqlAddNewPost)) {
                return true;
            } else {
                return false;
            }
        }
    }

    if (isset($_POST['submit'])) {
        $postContent = $_POST['post'];

        if (strlen($postContent) == 0) 
        {
            $error = "Post cannot be empty";
        }   

        $newPost = new Post($postContent);

        if ($newPost->addNewPost($conn)) 
        {
            header("Location: ./posts.php");
        } else {
            $error = "Couldn't complete action";
        }
    }

    function getFlatNum($conn, $id) {
        $sqlGetFlat = "SELECT flat_num FROM flats WHERE flatid=$id";
        $queryGetFlat = mysqli_query($conn, $sqlGetFlat);

        return mysqli_fetch_assoc($queryGetFlat)['flat_num'];
    }

    $sqlFetch = "SELECT * FROM posts";
    $queryFetch = mysqli_query($conn, $sqlFetch);

    $sqlFetchReplies = "SELECT * FROM replies";
    $queryFetchReplies = mysqli_query($conn, $sqlFetchReplies);
?>

<html>
    <head>
        <title>Posts</title>
        <meta name="viewport" content="width=device-width" />

        <link rel="stylesheet" href="../styling/globals.css">

        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        />

        <script src="../javascript/toggle.js"></script>

        <style>
            body {
                margin: 10px;
                font-family: "Dancing Script", cursive;
                font-family: "Open Sans", sans-serif;
                font-family: "Source Sans Pro", sans-serif;
            }
            button {
                background-color: lightgray;
                padding: 10px;
            }
            .new_post_area {
                transition: 0.4s;
            }
            .main {
                margin-top: 8px;
                background-color: lightgray;
                padding: 5px;
            }
            textarea {
                width: 100%;
                font-family: "Dancing Script", cursive;
                font-family: "Open Sans", sans-serif;
                font-family: "Source Sans Pro", sans-serif;
                padding: 10px;
                border-radius: 4px;
            }
            #flat {
                font-weight: bold;
            }
            .reply {
                margin: 5px;
            }
        </style>
    </head>

    <body>
        <button id="show_poster" onclick="show_post_area()"><i class="fa fa-plus" aria-hidden="true"></i> Add New Post</button>
        <div class="new_post_area" id="new_area">
            <form action="" method="post">
                <textarea rows="10" placeholder="Write your post here..you can write any number of characters" id="post" name="post"></textarea>
                <button type="submit" name="submit">Submit Post</button>
            </form>
            <!---->
            <?php
                echo $error;
            ?>
        </div>
            <?php 
                while ($results = mysqli_fetch_assoc($queryFetch)) {
                    $post = $results['post']."<br>";
                    $postBy = getFlatNum($conn, $results['postBy'])."<br>";
                    $addedOn = $results['addedOn'];

                    echo "<div class='main'>";
                        echo "
                            <span id='flat'>".$postBy."</span><span style='font-size: 0.8rem'>".$addedOn."</span><br>
                            ".$post."
                        ";
                        while ($resReplies = mysqli_fetch_assoc($queryFetchReplies)) {
                            $replyBy = getFlatNum($conn, $resReplies['replyBy']);
                            $reply = $resReplies['reply'];

                            echo "
                                <div class='reply'>
                                    <span id='flat' style='font-size: 0.8rem'>".$replyBy."</span><br>
                                    <span style='font-size: 0.7rem; margin-left: 3px'>".$reply."</span>
                                </div>
                            ";
                        }
                    echo "</div>";
                }
            ?>
    </body>
</html>