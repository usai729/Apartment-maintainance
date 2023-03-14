<?php 
    include "conn.php";

    class login {
        protected $phno = 0;
        protected $pwd = "";
        protected $response = false;

        function __construct($phno, $pwd)
        {
            $this->phno = $phno;
            $this->pwd = $pwd;
        }

        public function login($conn) {
            $sql = "SELECT * FROM flats WHERE phone=$this->phno AND pwd='$this->pwd'";
            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) == 1) {
                $this->response = true;
            } else {
                $this->response = false;
            }

            return $this->response;
        }
    }

    if (isset($_POST['submit'])) {
        $phno = $_POST['phno'];

        $login = new login($phno, $_POST['pwd']);

        if ($login->login($conn)) {
            echo "Returned true";

            ini_set('session.gc_maxlifetime', 604800);
            session_set_cookie_params(604800);

            session_start();
            $_SESSION['user'] = $phno;

            header("Location: ../templates/home.php");
        } else {
            header("Location: ../templates/login.html");
        }
    }
?>