<?php

declare(strict_types=1);

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

    public function getBirthdate(): string
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

    public function register(int $userId, string $birthdate, string $phone, string $email): Member
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

    public function get(int $id): ?Member
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `user_id`, `birthdate`, `phone`, `email` FROM `member` WHERE `id` = :id;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Member($id, $row["user_id"], $row["birthdate"], $row["phone"], $row["email"]);

        return null;
    }

    public function update(int $id, int $userId, string $birthdate, string $phone, string $email): Member
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

    public function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `member` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
