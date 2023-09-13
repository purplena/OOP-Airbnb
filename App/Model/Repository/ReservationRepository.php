<?php

namespace App\Model\Repository;

use App\Model\Reservation;
use App\Model\User;
use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class ReservationRepository extends Repository
{
    public function getTableName(): string
    {
        return 'reservation';
    }

    public function addNewReservation(array $data): bool
    {
        $query = sprintf(
            '
            INSERT INTO `%s` 
            (`user_id`, `estate_id`, `date_start`, `date_finish`, `num_guests`, `are_animals`) 
            VALUES 
            (:user_id, :estate_id, :date_start, :date_finish, :num_guests, :are_animals)',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return false;
        $stmt->execute($data);

        return true;
    }

    public function reservationsByUser(int $id): ?array
    {
        $query = sprintf(
            '
            SELECT `%1$s`.*
            FROM `%s`
            WHERE `%1$s`.user_id = :id',
            $this->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['id' => $id]);
        $result_array = [];
        $hostArray = [];
        while ($row_data = $stmt->fetch()) {
            $reservation = new Reservation($row_data);
            $reservation->user = AppRepoManager::getRm()->getUserRepo()->findUserById($id);
            $reservation->estate = AppRepoManager::getRm()->getEstateRepo()->findEstateById($row_data['estate_id']);
            $host = AppRepoManager::getRm()->getUserRepo()->findUserById($reservation->estate->user_id);
            $hostArray['id'] = $host->id;
            $hostArray['first_name'] = $host->first_name;
            $hostArray['second_name'] = $host->second_name;
            $hostArray['email'] = $host->email;
            $hostArray['photo_host'] = $host->photo_user;
            $reservation->host = $hostArray;
            $result_array[] = $reservation;
        }
        return $result_array;
    }

    public function findReservationByEstateId(int $id): ?array
    {
        $query = sprintf(
            '
            SELECT `%1$s`.*, `%2$s`.id AS user_id_id, `%2$s`.first_name, `%2$s`.second_name, `%2$s`.email
            FROM `%1$s`
            INNER JOIN `%2$s` 
            ON `%1$s`.user_id = `%2$s`.id
            WHERE `%1$s`.estate_id = :id',
            $this->getTableName(),
            AppRepoManager::getRm()->getUserRepo()->getTableName()
        );
        $stmt = $this->pdo->prepare($query);
        if (!$stmt) return null;
        $stmt->execute(['id' => $id]);
        $result_array = [];

        while ($row_data = $stmt->fetch()) {
            $reservation = new Reservation($row_data);
            $user_data = [
                'id' => $row_data['user_id'],
                'first_name' => $row_data['first_name'],
                'second_name' => $row_data['second_name'],
                'email' => $row_data['email'],
            ];
            $user = new User($user_data);
            $reservation->user = $user;
            $result_array[] = $reservation;
        }

        return $result_array;
    }
}
