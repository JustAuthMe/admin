<?php
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Utils;
use PitouFW\Entity\AdminUser;
use PitouFW\Model\AdminUser as UserModel;

if (UserModel::isLogged()) {
    header('location: ' . WEBROOT);
    die;
}

if (POST) {
    if (isset($_POST['access_token'])) {
        $response = json_decode(file_get_contents(JAM_API . 'data?token=' . $_POST['access_token'] . '&secret=' . JAM_SECRET), true);
        if ($response['status'] === 'success') {
            if (Persist::exists('AdminUser', 'jam_id', $response['jam_id'])) {
                /** @var AdminUser $user */
                $user = Persist::readBy('AdminUser', 'jam_id', $response['jam_id']);
                $_SESSION['uid'] = $user->getId();
            } else if (REGISTRATION_ALLOWED) {
                $user = new AdminUser(
                    0,
                    $response['jam_id'],
                    $response['email'],
                    $response['firstname'],
                    $response['lastname'],
                    '',
                    Utils::time()
                );
                $uid = Persist::create($user);
                $user->setId($uid);

                file_put_contents(ROOT . 'public/upload/avatar_' . $user->getId() . '.jpg', file_get_contents($response['avatar']));
                $user->setAvatar(WEBROOT . 'upload/avatar_' . $user->getId() . '.jpg');
                Persist::update($user);
                $_SESSION['uid'] = $user->getId();
            }

            header('location: ' . WEBROOT);
            die;
        }
    }
}

$response = json_decode(file_get_contents(JAM_API . 'token?secret=' . JAM_SECRET));

Data::get()->add('token', $response->token);
Data::get()->add('qr', $response->qr);
Controller::renderView('login', false);