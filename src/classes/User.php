<?php

declare(strict_types=1);

/** Database class for the `user` table */
class User
{
    /**
     * @param int $id The UID of the user. Automatically increments.
     * @param string $name The name of the user. Max length is 45.
     * @param string $passwordHash The hashed password of the user. Hashed using `password_hash` with `PASSWORD_DEFAULT`.
     * @param bool $member If this user has a `Member` associated with it.
     */
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

    /** Gets the user by name. And validate password.
     * @param string $name The name to search for.
     * @param string $password The password that was entered.
     * @return ?User The user `null` if `$name` or `$password` are incorrect.
     */
    public static function login(string $name, string $password): ?User
    {
        $params = array(":name" => $name);
        $sth = getPDO()->prepare("SELECT `id`, `password_hash`, `member` FROM `user` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            if (password_verify($password, $row["password_hash"]))
                return new User($row["id"], $name, $row["password_hash"], $row["member"] != 0);

        return null;
    }

    /** Registers a new user.
     * Doesn't register a member if `$member` is true.
     * @param string $name The name of the user. Max length is 45.
     * @param string $passwordHash The hashed password of the user. Hashed using `password_hash` with `PASSWORD_DEFAULT`.
     * @param bool $member If this user has a `Member` associated with it.
     * @return User The user that was registered.
     */
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

    /** Gets a user by UID.
     * @param int $id The UID of the user to get.
     * @return ?User The user, `null` if the UID doesn't exist.
     */
    public static function get(int $id): ?User
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `name`, `password_hash`, `member` FROM `user` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new User($id, $row["name"], $row["password_hash"], $row["member"] != 0);

        return null;
    }

    public static function check(string $name): ?User
    {
        $params = array(":name" => $name);
        $sth = getPDO()->prepare("SELECT `id`, `name`, `password_hash`, `member` FROM `user` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch()) {
            return new User($row["id"], $name, $row["password_hash"], $row["member"] != 0);
        } else {
            return null;
        }
    }
    public static function getAllMembers(): array
    {
        $sth = getPDO()->prepare("SELECT user.name, DATE_FORMAT(member.birthdate,'%d/%m/%Y') AS birthdate, member.phone, member.email, user.id 
        FROM `user` LEFT JOIN `member` ON member.user_id = user.id WHERE user.member != 0 AND user.id != 0");
        $sth->execute();
        return $sth->fetchAll();
    }
    public static function getMemberById($id): ?User
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT User.name, User.password_hash, User.member, member.birthdate, member.phone, member.email
        FROM `user` LEFT JOIN `member` ON member.user_id = user.id WHERE user.member != 0 AND user.id = :id");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new User($id, $row["name"], $row["password_hash"], $row["member"] != 0);
        return null;
    }

    /** Updates the user's information by UID.
     * @param int $id The UID of the user to update.
     * @param string $name The new name of the user. Max length is 45.
     * @param bool $member If this user has a `Member` associated with it.
     * @return User The user with updated information.
     */
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

    /** Updates the user's password by UID.
     * @param int $id The UID of the user to update.
     * @param string $password The new password of the user. Will be hashed using `password_hash` with `PASSWORD_DEFAULT`.
     * @return User The user with updated password.
     */
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

    /** Deletes the user and associated data by UID.
     * @param int $id The UID of the user to delete.
     */
    public static function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `user` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
