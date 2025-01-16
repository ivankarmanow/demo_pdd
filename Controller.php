<?php

require_once "model/Request.php";
require_once "model/User.php";
require_once "Model.php";


class Controller {

    public static Model $db;
    public static array $config;

    public static function view(string $template, string $title, array $data = []) {
        extract($data);
        include __DIR__ . "/html/" . "header.php";
        include __DIR__ . "/html/" . $template . ".php";
        include __DIR__ . "/html/" . "footer.php";
    }

    public static function index() {
        if ($_SESSION['is_admin'] ?? false) {
            header("Location: /admin");
            return;
        }
        if (!isset($_SESSION['user_id'])) {
            self::view("index", "Главная", []);
        } else {
            $requests = self::$db->fetchAll("SELECT 'Request', id, ts_number, description, status FROM request WHERE created_by = :user_id", ["user_id" => $_SESSION['user_id']]);
            self::view("index", "Главная", ["requests" => $requests]);
        }
    }

    public static function new_form() {
        self::view("new", "Новая заявка");
    }

    public static function reg_form() {
        self::view("reg", "Регистрация");
    }

    public static function login_form() {
        self::view("login", "Вход");
    }

    public static function admin() {
        if (!isset($_SESSION['is_admin']) or !$_SESSION['is_admin']) {
            header("Location: /");
            return;
        }
        $requests = self::$db->fetchAll("SELECT 'Request', r.id, r.ts_number, r.description, r.status, u.name FROM request as r LEFT JOIN user as u ON r.created_by = u.id");
        self::view("admin", "Админ-панель", ["requests" => $requests]);
    }

    public static function change_status() {
        $rid = $_POST['rid'];
        $status = $_POST['status'];
        try {
            if ($status != "confirmed" and $status != "rejected") {
                throw new Exception();
            }
            $req = self::$db->fetchOne("SELECT 'Request', id, status FROM request WHERE id = :id", ['id' => $rid]);
            if (!$req or $req->status != "new") {
                throw new Exception();
            }
            self::$db->execute("UPDATE request SET status = :status WHERE id = :id", ["status" => $status, "id" => $rid]);
            header("Location: /admin");
        } catch (Exception $e) {
            header("Location: /admin");
            return;
        }

    }

    public static function new() {
        $req = self::$db->execute(
            "INSERT INTO request (ts_number, description, created_by, status) VALUES (?, ?, ?, ?)",
            [$_POST['ts_number'], $_POST['description'], $_SESSION['user_id'], "new"]
        );
        if ($req) {
            header("Location: /");
        } else {
            echo "<script>window.history.back()</script>";
            die();
        }
    }

    public static function login() {
        if ($_POST['login'] == self::$config['admin_login'] && $_POST['password'] == self::$config['admin_password']) {
            $_SESSION['is_admin'] = true;
            header("Location: /admin");
            return;
        }
        $user = self::$db->fetchOne("SELECT 'User', id, name, password FROM user WHERE login = :login", ["login" => $_POST['login']]);
//        var_dump($user);
        if ($user) {
            if (password_verify($_POST['password'], $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['name'] = $user->name;
                header("Location: /");
            } else {
                self::view("login", "Вход", [
                    "authFail" => true,
                    "oldLogin" => $_POST['login'],
                    "oldPass" => $_POST['password']
                ]);
            }
        } else {
            self::view("login", "Вход", [
                "authFail" => true,
                "oldLogin" => $_POST['login'],
                "oldPass" => $_POST['password']
            ]);
        }
    }

    public static function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['login']);
        unset($_SESSION['is_admin']);
        echo "<script>window.history.go(-1);</script>";
    }

    public static function reg() {
        $patterns = [
            "login" => "/^[-a-z0-9_]{3,16}$/",
            "name" => "/^([ЁёА-я]+)\s+([ЁёА-я]+)\s*([ЁёА-я]+\s*)?$/u",
            "email" => "/^[-a-zA-ZЁёА-я_0-9]+@[-a-zA-Z_ЁёА-я0-9]+\.[a-zёа-я]{2,5}$/u",
            "phone" => "/^\(\d{3}\)-\d{3}-\d{2}-\d{2}$/",
            "password" => "/^(?=.*?[A-ZА-Я])(?=.*?[a-zа-я])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/u"
        ];
        $errors = [];
        foreach ($patterns as $name => $pattern) {
            if (!preg_match($pattern, $_POST[$name])) {
                $errors[$name] = "pattern";
            }
        }
        if ($errors) {
            echo json_encode(["status" => false, "errors" => $errors]);
            return;
        }
        if ($_POST['login'] == self::$config['admin_login'] or self::$db->count("SELECT COUNT(id) FROM user WHERE login = :login", ["login" => $_POST['login']])) {
            $errors["login"] = "exists";
            echo json_encode(["status" => false, "errors" => $errors]);
            return;
        }
        $res = self::$db->execute(
            "INSERT INTO user (login, name, email, phone, password) VALUES (?, ?, ?, ?, ?)",
            [$_POST['login'], $_POST['name'], $_POST['email'], "+7 " . $_POST['phone'], password_hash($_POST['password'], PASSWORD_DEFAULT)]
        );
        if ($res) {
            $_SESSION['user_id'] = self::$db->lastRowId();
            $_SESSION['name'] = $_POST['name'];
//            header("Location: /");
            echo json_encode(["status" => true]);
        } else {
//            header("Location: /reg_form");
            echo json_encode(["status" => false, "errors" => ["db" => "query"]]);
        }
    }
}
