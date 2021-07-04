<?php
    require_once 'connect.php';
    require_once 'function.php';

    abstract class Event {
        const USER_PROFILE_EDIT = "แก้ไขข้อมูลผู้ใช้";
        const USER_PROBLEM_POST = "เพิ่มโจทย์";
        const USER_PROBLEM_EDIT = "แก้ไขโจทย์";
        const USER_SUBMISSION = "ส่ง Submission";
        const USER_ARTICLE_POST = "โพสต์";
        const USER_ARTICLE_EDIT = "แก้ไขโพสต์";
        const USER_ARTICLE_DELETE = "ลบโพสต์";

        const USER_FILE_FILE_CREATE = "เพิ่มไฟล์";
        const USER_FILE_FILE_DELETE = "ลบไฟล์";
        const USER_FILE_FOLDER_MKDIR = "สร้างโฟลเดอร์";
        const USER_FILE_FOLDER_RMDIR = "ลบโฟลเดอร์";

        const USER_REGISTER = "สร้างบัญชีใหม่";
        const USER_LOGIN = "ลงชื่อเข้าใช้";
    }

    abstract class ErrorMessage {
        const AUTH_WRONG = "ERROR 01 : Wrong username or password";
        const AUTH_INVALID_EMAIL_TOKEN = "ERROR 06 : That email confirmation token is invalid, is that expired?";
        const AUTH_INVALID_RESET_PASSWORD_TOKEN = "ERROR 07 : That reset password token is invalid, is that expired?";
        
        const USER_NOT_FOUND = "ERROR 10 : User not found";
        const USER_ERROR = "ERROR 19 : Found conflict user";

        const FILE_IO = "ERROR 20 : Cannot performing File IO";
        const FILE_UPLOAD_NOT_FOUND = "ERROR 21 : Cannot locate the uploaded file";

        const DATABASE_ESTABLISH = "ERROR 40 : Cannot established with the database";
        const DATABASE_QUERY = "ERROR 41 : Cannot query with the database";
        const DATABASE_ERROR = "ERROR 49 : Unexpected internal database error";

        const SESSION_INVALID = "ERROR 60 : Session is invalid";
        
        const PERMISSION_REQUIRE = "ERROR 90 : You do not have enough permission";
        const PERMISSION_ERROR = "ERROR 99 : Found conflict permission";
    }

    abstract class Role {
        const ADMIN = "admin";
        const ROLES = array(Role::ADMIN);
    }

    class Language {
        const JAVA = "Java";
        const PYTHON = "Python";
        const C = "C";
        const CPP = "C++";
        const LCA = "LCA (Custom Template)";
        const LANGUAGES = array(Language::JAVA, Language::PYTHON, Language::C, Language::CPP, Language::LCA);
    }

    class User {
        protected int $id;
        protected String $user, $email, $role, $name;
        public $profile, $properties;

        public function getID() {
            return $this->id;
        }
        public function setID(int $id) {
            $this->id = $id;
        }

        public function getUsername() {
            return $this->user;
        }
        public function setUsername(String $username) {
            $this->user = $username;
        }

        public function getName() {
            return $this->name;
        }
        public function getDisplayname() {
            $name = $this->name;
            if ($this->getProperties("rainbow")) $name = "<text class='rainbow'>$name</text>";
            if ($this->isAdmin()) $name .= " <span class='badge badge-coekku'>Admin</span>";
            return $name;
        }
        public function setName(String $name) {
            $this->name = $name;
        }

        public function getEmail() {
            return $this->email;
        }
        public function setEmail(String $email) {
            $this->email = $email;
        }

        public function getProfile() {
            if (empty($this->profile) || !file_exists($this->profile)) return "../static/elements/user.svg";
            return $this->profile;
        }
        public function setProfile(string $url) {
            $this->profile = $url;
        }

        public function properties() {
            return $this->properties;   
        }
        public function getProperties(String $key) {
            if (empty($this->properties)) return false;
            return array_key_exists($key, $this->properties()) ? $this->properties()[$key] : false;
        }
        public function setProperties(String $key, $val) {
            $this->properties[$key] = $val;
        }

        public function isAdmin() {
            return $this->getProperties("admin");
        }

        public function getInfo() {
            return array(
                "id" => $this->id,
                "username" => $this->getUsername(),
                "name" => $this->getName(),
                "email" => $this->getEmail(),
                "profile" => $this->getProfile(),
                
            );
        }

        public function __construct(int $id) {
            $this->id = $id;
            $data = getUserData($id);
            if (!empty($data)) {
                $this->name = $data['displayname'];
                $this->email = $data['email'];
                $this->user = $data['username'];
                $this->profile = $data['profile'];
                $this->properties = json_decode($data['properties'], true);
            } else {
                $this->id = -1;
            }
        }
    }

    class Post {
        const TYPE_NORMAL = 1;
        const TYPE_HOTLINK = 2;

        const VISIBLE_GUEST = "guest";
        const VISIBLE_STAFF = "staff";
        const VISIBLE_DEALER = "dealer";

        protected int $id;
        protected $title, $article, $properties;

        public function getID() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }
        public function setTitle(String $title) {
            $this->title = $title;
        }
        
        public function getArticle() {
            return $this->article;
        }
        public function setArticle(String $article) {
            $this->article = $article;
        }

        public function getProperties() {
            return $this->properties;
        }
        public function setProperties($key, $val) {
            $this->properties[$key] = $val;
        }

        public function __construct(int $id) {
            $this->id = $id;
            if ($id > 0) {
                $post = getPostData($id);
                $this->title = $post['title'];
                $this->article = $post['article'];
                $this->properties = json_decode($post['properties'], true);
            } else {
                $this->title = null;
                $this->article = null;
                $this->properties = array(
                    "author" => $_SESSION['user']->getID(),
                    "type" => Post::TYPE_NORMAL,
                    "visibility"=> array(
                        Post::VISIBLE_GUEST => true,
                        Post::VISIBLE_STAFF => true,
                        Post::VISIBLE_DEALER => true
                    ),
                    "category" => "",
                    "upload_time" => time(),
                    "hide" => false,
                    "pin" => false,
                    "hotlink" => null,
                    "cover" => null,
                    "tag" => null,
                    "attachment" => null
                );
            }
        }
    }

?>