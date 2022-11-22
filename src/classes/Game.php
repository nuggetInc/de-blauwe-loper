<?php

declare(strict_types=1);

class Game
{
    private function __construct(
        private int $id,
        private int $whiteUserId,
        private int $blackUserId,
        private int $winnerUserId,
        private int $startTime,
        private int $endTime,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWhiteUserId(): int
    {
        return $this->whiteUserId;
    }

    public function getBlackUserId(): int
    {
        return $this->blackUserId;
    }

    public function getWinnerUserId(): int
    {
        return $this->winnerUserId;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    public static function register(int $whiteUserId, int $blackUserId, int $winnerUserId, int $startTime, int $endTime): Game
    {
        $params = array(
            ":white_user_id" => $whiteUserId,
            ":black_user_id" => $blackUserId,
            ":winner_user_id" => $winnerUserId,
            ":start_time" => date("Y-m-d", $startTime),
            ":end_time" => date("Y-m-d", $endTime),
        );

        $sth = getPDO()->prepare("INSERT INTO `game` (`white_user_id`, `black_user_id`, `winner_user_id`, `start_time`, `end_time`) VALUES (:white_user_id ,:black_user_id ,:winner_user_id ,:start_time ,:end_time);");
        $sth->execute($params);

        return new Game((int)getPDO()->lastInsertId(), $whiteUserId, $blackUserId, $winnerUserId, $startTime, $endTime);
    }

    public static function get(int $id): ?Game
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `white_user_id`, `black_user_id`, `winner_user_id`, `start_time`, `end_time` FROM `game` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Permission($id, $row["white_user_id"], $row["black_user_id"], $row["winner_user_id"], strtotime($row["start_time"]), strtotime($row["end_time"]));

        return null;
    }

    public static function update(int $id, int $whiteUserId, int $blackUserId, int $winnerUserId, int $startTime, int $endTime): Game
    {
        $params = array(
            ":id" => $id,
            ":white_user_id" => $whiteUserId,
            ":black_user_id" => $blackUserId,
            ":winner_user_id" => $winnerUserId,
            ":start_time" => date("Y-m-d", $startTime),
            ":end_time" => date("Y-m-d", $endTime),
        );
        $sth = getPDO()->prepare("UPDATE `game` SET `white_user_id` = :whiteUserId, `black_user_id` = :blackUserId, `winner_user_id` = :winnerUserId, `start_time` = :startTime, `end_time` = :endTime WHERE `id` = :id;");
        $sth->execute($params);

        return new Game($id, $whiteUserId, $blackUserId, $winnerUserId, $startTime, $endTime);
    }

    public static function delete(int $id): void
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `game` WHERE `id` = :id;");
        $sth->execute($params);
    }
}
