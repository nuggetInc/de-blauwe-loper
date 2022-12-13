<?php

declare(strict_types=1);

require_once("classes/User.php");

class Game
{
    private function __construct(
        private int $id,
        private ?int $whiteUserId,
        private ?int $blackUserId,
        private ?int $winnerUserId,
        private string $startTime,
        private string $endTime,
    ) {
    }

    /** Gets the user that played white
     * @return ?User The user that played white. Null if user doesn't exist.
     */
    public function getGetWhiteUser(): ?User
    {
        if ($this->whiteUserId === null) return null;
        return User::get($this->whiteUserId);
    }

    /** Gets the user that played black
     * @return ?User The user that played black. Null if user doesn't exist.
     */
    public function getGetBlackUser(): ?User
    {
        if ($this->blackUserId === null) return null;
        return User::get($this->blackUserId);
    }

    /** Gets the user that won
     * @return ?User The user that won. Null if user doesn't exist or the game was a draw.
     */
    public function getGetWinnerUser(): ?User
    {
        if ($this->winnerUserId === null) return null;
        return User::get($this->winnerUserId);
    }

    /** Registers a new game.
     * @param ?int $whiteUserId The UID of the user that played white.
     * @param ?int $blackUserId The UID of the user that played black.
     * @param ?int $winnerUserId The UID of the user that won the game.
     * @param string $startTime The time that the game started.
     * @param string $endTime The time that the game ended.
     * @return User The game that was registered.
     */
    public static function register(?int $whiteUserId, ?int $blackUserId, ?string $winnerUserId, string $startTime, string $endTime): Game
    {
        $params = array(
            ":white_user_id" => $whiteUserId,
            ":black_user_id" => $blackUserId,
            ":winner_user_id" => $winnerUserId,
            ":start_time" => $startTime,
            ":end_time" => $endTime,
        );

        $sth = getPDO()->prepare("INSERT INTO `game` (`white_user_id`, `black_user_id`, `winner_user_id`, `start_time`, `end_time`) VALUES (:white_user_id ,:black_user_id ,:winner_user_id ,:start_time ,:end_time);");
        $sth->execute($params);

        return new Game((int)getPDO()->lastInsertId(), $whiteUserId, $blackUserId, $winnerUserId, $startTime, $endTime);
    }

    /** Gets a game by UID.
     * @param int $id The UID of the game to get.
     * @return ?Game The game, `null` if the UID doesn't exist.
     */
    public static function get(int $id): ?Game
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `white_user_id`, `black_user_id`, `winner_user_id`, `start_time`, `end_time` FROM `game` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Game($id, $row["white_user_id"], $row["black_user_id"], $row["winner_user_id"], $row["start_time"], $row["end_time"]);

        return null;
    }
    /** Gets all the games out of the games table
     * Left joins the user and game table
     */
    public static function getAllGames(): ?array
    {
        $sth = getPDO()->prepare("SELECT `white_user_id`, `black_user_id`, `winner_user_id`, `start_time`, `end_time`, `id` FROM `game`");
        $sth->execute();
        return $sth->fetchAll();
    }

    /** Updates the game by UID.
     * @param int $id The UID of the game to update.
     * @param ?int $whiteUserId The UID of the user that played white.
     * @param ?int $blackUserId The UID of the user that played black.
     * @param ?int $winnerUserId The UID of the user that won the game.
     * @param string $startTime The time that the game started.
     * @param string $endTime The time that the game ended.
     * @return Game The game with updated information.
     */
    public static function update(int $id, ?int $whiteUserId, ?int $blackUserId, ?int $winnerUserId, string $startTime, string $endTime): Game
    {
        $params = array(
            ":id" => $id,
            ":white_user_id" => $whiteUserId,
            ":black_user_id" => $blackUserId,
            ":winner_user_id" => $winnerUserId,
            ":start_time" => $startTime,
            ":end_time" => $endTime,
        );
        $sth = getPDO()->prepare("UPDATE `game` SET `white_user_id` = :white_user_id, `black_user_id` = :black_user_id, `winner_user_id` = :winner_user_id, `start_time` = :start_time, `end_time` = :end_time WHERE `id` = :id;");
        $sth->execute($params);

        return new Game($id, $whiteUserId, $blackUserId, $winnerUserId, $startTime, $endTime);
    }

    /** Deletes the game and associated member by UID.
     * @param int $id The UID of the game to delete.
     */
    public function delete(): void
    {
        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `game` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
