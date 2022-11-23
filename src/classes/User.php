<?php

declare(strict_types=1);

class User
{
    private function __construct(
        private int $id,
        private string $name,
        private string $passwordHash,
        private bool $member,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getMember(): bool
    {
        return $this->member;
    }

    public static function login(string $username, string $password): ?User
    {
        $params = array(":username" => $username);
        $sth = getPDO()->prepare("SELECT `id`, `password_hash`, `member` FROM `user` WHERE `username` = :username LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            if (password_verify($password, $row["password_hash"]))
                return new User($row["id"], $username, $row["password_hash"], $row["member"] != 0);

        return null;
    }

    public static function register(string $username, string $password, bool $member): User
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(
            ":username" => $username,
            ":password_hash" => $passwordHash,
            ":member" => $member ? 1 : 0
        );
        $sth = getPDO()->prepare("INSERT INTO `user` (`name`, `password_hash`, `member`) VALUES (:username, :password_hash, :member);");
        $sth->execute($params);

        return new User((int)getPDO()->lastInsertId(), $username, $password, $member);
    }

    public static function get(int $id): ?User
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `name`, `password_hash`, `member` FROM `user` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new User($id, $row["name"], $row["password_hash"], $row["member"] != 0);

        return null;
    }
    public static function getAllMembers() : array
    {
        $sth = getPDO()->prepare("SELECT user.name, member.birthdate, member.phone, member.email, user.id 
        FROM `user` LEFT JOIN `member` ON member.user_id = user.id WHERE user.member != 0");
        $sth->execute();
        return $sth->fetchAll();
    }
    public static function getMemberById($id) : ?User
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT User.name, User.password_hash, User.member, member.birthdate, member.phone, member.email
        FROM `user` LEFT JOIN `member` ON member.user_id = user.id WHERE user.member != 0 AND user.id = :id");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new User($id, $row["name"], $row["password_hash"], $row["member"] != 0);
        return null;
    }

    public static function update(int $id, string $name, bool $member): User
    {
        $params = array(
            ":id" => $id,
            ":name" => $name,
            ":member" => ($member ? 1 : 0)
        );
        $sth = getPDO()->prepare("UPDATE `user` SET `name` = :name, `member` = :member WHERE `id` = :id;");
        $sth->execute($params);

        return Self::get($id);
    }

    public static function updatePassword(int $id, string $password): User
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(
            ":id" => $id,
            ":password_hash" => $passwordHash,
        );
        $sth = getPDO()->prepare("UPDATE `user` SET `password_hash` = :password_hash WHERE `id` = :id;");
        $sth->execute($params);

        return Self::get($id);
    }

    public static function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `user` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
