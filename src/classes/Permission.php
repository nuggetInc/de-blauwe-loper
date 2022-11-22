<?php

declare(strict_types=1);

class Permission
{
    private function __construct(
        private int $id,
        private int $userId,
        private PermissionType $permission,
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

    public function getPermission(): PermissionType
    {
        return $this->permission;
    }

    public function getUser(): User
    {
        return User::get($this->userId);
    }

    public function register(int $userId, PermissionType $permission): Permission
    {
        $params = array(
            ":user_id" => $userId,
            ":permission" => $permission->value,
        );

        $sth = getPDO()->prepare("INSERT INTO `permission` (`user_id`, `permission`) VALUES (:user_id, :permission);");
        $sth->execute($params);

        return new Permission((int)getPDO()->lastInsertId(), $userId, $permission);
    }

    public function get(int $id): ?Permission
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `user_id`, `permission` FROM `permission` WHERE `id` = :id;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Permission($id, $row["user_id"], PermissionType::from($row["permission"]));

        return null;
    }

    public function update(int $id, int $userId, PermissionType $permission): Permission
    {
        $params = array(
            ":id" => $id,
            ":user_id" => $userId,
            ":permission" => $permission->value,
        );
        $sth = getPDO()->prepare("UPDATE `permission` SET `name` = :name, `password_hash` = :password_hash WHERE `id` = :id;");
        $sth->execute($params);

        return new Permission($id, $userId, $permission);
    }

    public function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `permission` WHERE `id` = :id;");
        $sth->execute($params);
    }
}

enum PermissionType: string
{
    case MEMBERS = "members";
    case GAMES = "games";
}
