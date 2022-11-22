<?php

declare(strict_types=1);

require_once("classes/User.php");

class Member
{
    private function __construct(
        private int $id,
        private int $userId,
        private string $birthdate,
        private string $phone,
        private string $email,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBirthdate(): int
    {
        return $this->birthdate;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUser(): User
    {
        return User::get($this->userId);
    }

    public static function register(int $userId, string $birthdate, string $phone, string $email): Member
    {
        $params = array(
            ":user_id" => $userId,
            ":birthdate" => $birthdate,
            ":phone" => $phone,
            ":email" => $email,
        );
        $sth = getPDO()->prepare("INSERT INTO `member` (`user_id`, `birthdate`, `phone`, `email`) VALUES (:user_id, :birthdate, :phone, :email);");
        $sth->execute($params);

        return new Member((int)getPDO()->lastInsertId(), $userId, $birthdate, $phone, $email);
    }

    public static function get(int $id): ?Member
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `user_id`, `birthdate`, `phone`, `email` FROM `member` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Member($id, $row["user_id"], $row["birthdate"], $row["phone"], $row["email"]);

        return null;
    }

    public static function getByUser(User $user): ?Member
    {
        return self::getByUserId($user->getId());
    }

    public static function getByUserId(int $userId): ?Member
    {
        $params = array(":user_id" => $userId);
        $sth = getPDO()->prepare("SELECT `id`, `birthdate`, `phone`, `email` FROM `member` WHERE `user_id` = :user_id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Member($row["id"], $userId, $row["birthdate"], $row["phone"], $row["email"]);

        return null;
    }

    public static function update(int $id, int $userId, string $birthdate, string $phone, string $email): Member
    {
        $params = array(
            ":id" => $id,
            ":user_id" => $userId,
            ":birthdate" => $birthdate,
            ":phone" => $phone,
            ":email" => $email,
        );
        $sth = getPDO()->prepare("UPDATE `user` SET `name` = :name, `password_hash` = :password_hash WHERE `id` = :id;");
        $sth->execute($params);

        return new Member($id, $userId, $birthdate, $phone, $email);
    }

    public static function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `member` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
