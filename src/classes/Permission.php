<?php

declare(strict_types=1);

require_once("classes/User.php");

/** Database class for the `permission` table */
class Permission
{
    /**
     * @param int $id The UID of the permission. Automatically increments.
     * @param int $userId The UID of the user the permission is granted to.
     * @param PermissionType $permission The permission granted to the user.
     */
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

    /** Gets the associated user */
    public function getUser(): User
    {
        return User::get($this->userId);
    }

    /** Registers a new permission.
     * @param int $userId The UID of the user to grant the permission to.
     * @param PermissionType $permission The permission to be granted.
     * @return Permission The permission that was registered.
     */
    public static function register(int $userId, PermissionType $permission): Permission
    {
        $params = array(
            ":user_id" => $userId,
            ":permission" => $permission->value,
        );

        $sth = getPDO()->prepare("INSERT INTO `permission` (`user_id`, `permission`) VALUES (:user_id, :permission);");
        $sth->execute($params);

        return new Permission((int)getPDO()->lastInsertId(), $userId, $permission);
    }

    /** Gets a permission by UID.
     * @param int $id The UID of the permission to get.
     * @return ?Permission The permission, `null` if the UID doesn't exist.
     */
    public static function get(int $id): ?Permission
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `user_id`, `permission` FROM `permission` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Permission($id, $row["user_id"], PermissionType::from($row["permission"]));

        return null;
    }
    public static function getByUserId(int $user_id): ?Permission
    {
        $params = array(":user_id" => $user_id);
        $sth = getPDO()->prepare("SELECT `id`, `user_id`, `permission` FROM `permission` WHERE `user_id` = :user_id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Permission($row["id"], $row["user_id"], PermissionType::from($row["permission"]));

        return null;
    }

    /** Updates the permissions by UID.
     * @param int $id The UID of the permission to update.
     * @param int $userId The UID of the user the permission should be granted to.
     * @param PermissionType $permission The permission to grant.
     * @return Permission The permission with updated information.
     */
    public static function update(int $id, int $userId, PermissionType $permission): Permission
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

    /** Deletes the permission by UID.
     * @param int $id The UID of the permission to delete.
     */
    public static function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `permission` WHERE `id` = :id;");
        $sth->execute($params);
    }
}

/** Database enum for the `permission`.`permission` column */
enum PermissionType: string
{
    case MEMBERS = "members";
    case GAMES = "games";
}
