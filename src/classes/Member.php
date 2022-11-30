<?php

declare(strict_types=1);

require_once("classes/User.php");

class Member
{
    /**
     * @param int $id The UID of the member. Automatically increments.
     * @param int $userId The UID of the user this member is associated with.
     * @param string $birthdate The birthdate of the user. Format is in `YYYY-MM-DD`.
     * @param string $phone The phonenumber of the user. Can contain spaces.
     * @param string $email The email of the user.
     */
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

    /** Gets the associated user */
    public function getUser(): User
    {
        return User::get($this->userId);
    }

    /** Registers a new member.
     * @param int $userId The UID of the user this member is associated with.
     * @param string $birthdate The birthdate of the user. Format is in `YYYY-MM-DD`.
     * @param string $phone The phonenumber of the user. Can contain spaces.
     * @param string $email The email of the user.
     * @return Member The member that was registered.
     */
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

    /** Gets a member by UID.
     * @param int $id The UID of the member to get.
     * @return ?User The member, `null` if the UID doesn't exist.
     */
    public static function get(int $id): ?Member
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `user_id`, `birthdate`, `phone`, `email` FROM `member` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Member($id, $row["user_id"], $row["birthdate"], $row["phone"], $row["email"]);

        return null;
    }

    /** Gets member by associated user's UID
     * @param User $user The associated user.
     * @return ?Member The member, `null` if the associated user doesn't exist or doesn't have a member associated with it.
     */
    public static function getByUser(User $user): ?Member
    {
        return self::getByUserId($user->getId());
    }

    /** Gets member by associated user's UID
     * @param int $userId The UID of the associated user.
     * @return ?Member The member, `null` if the associated user doesn't exist or doesn't have a member associated with it.
     */
    public static function getByUserId(int $userId): ?Member
    {
        $params = array(":user_id" => $userId);
        $sth = getPDO()->prepare("SELECT `id`, `birthdate`, `phone`, `email` FROM `member` WHERE `user_id` = :user_id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Member($row["id"], $userId, $row["birthdate"], $row["phone"], $row["email"]);

        return null;
    }

    /** Updates the member by UID.
     * @param int $id The UID of the member to update.
     * @param int $userId The UID of the user this member is associated with.
     * @param string $birthdate The birthdate of the user. Format is in `YYYY-MM-DD`.
     * @param string $phone The phonenumber of the user. Can contain spaces.
     * @param string $email The email of the user.
     * @return Member The member with updated data.
     */
    public static function update(int $id, int $userId, string $birthdate, string $phone, string $email): Member
    {
        $params = array(
            ":id" => $id,
            ":user_id" => $userId,
            ":birthdate" => $birthdate,
            ":phone" => $phone,
            ":email" => $email,
        );
        $sth = getPDO()->prepare("UPDATE `member` SET `user_id` = :user_id, `birthdate` = :birthdate, `phone` = :phone, `email` = :email WHERE `id` = :id;");
        $sth->execute($params);

        return new Member($id, $userId, $birthdate, $phone, $email);
    }
    /** Deletes User from user;
     *  Deletes Member with associated user_id;
     *  Set every created game wit associated user_id to 0;
     */
    public function delete(): void
    {
        $params = array(":user_id" => $this->userId);
        $sth = getPDO()->prepare("UPDATE `game` 
        SET `game`.white_user_id = 0 WHERE `game`.white_user_id = :user_id;
        UPDATE `game`
        SET `game`.black_user_id = 0 WHERE `game`.black_user_id = :user_id;
        UPDATE `game`
        SET `game`.winner_user_id = 0 WHERE `game`.winner_user_id = :user_id;");
        $sth->execute($params);


        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `member` WHERE `id` = :id;");
        $sth->execute($params);

        $params = array(":user_id" => $this->userId);
        $sth = getPDO()->prepare("DELETE FROM `user` WHERE `id` = :user_id;");
        $sth->execute($params);

    }
}
