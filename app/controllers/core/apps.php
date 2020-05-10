<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\ConsoleTeam;
use PitouFW\Entity\CoreClientApp;
use PitouFW\Model\CoreClientApp as CoreClientAppModel;

function fromDataStringToArray(string $data) {
    return explode(',', strtolower(str_replace(' ', '', $data)));
}

function checkDataString(array $data) {
    $is_data_ok = true;
    foreach ($data as $d) {
        $d = strpos($d, '!') === strlen($d) - 1 ? substr($d, 0, -1) : $d;
        if (!in_array($d, DATA_LIST)) {
            $is_data_ok = $d;
            break;
        }
    }

    return $is_data_ok;
}

switch (Request::get()->getArg(2)) {
    case 'new':
        if (POST) {
            if ($_POST['name'] !== '' && $_FILES['logo']['size'] > 0 && $_POST['domain'] !== '' && $_POST['redirect_url'] !== '' && $_POST['data'] !== '') {
                $data = fromDataStringToArray($_POST['data']);
                $is_data_ok = checkDataString($data);
                if ($is_data_ok === true) {
                    $dataurl = 'data:image/' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
                    $static_call = Utils::httpRequestInternal(JAM_STATIC_API, 'POST', [
                        'file[name]' => $_FILES['logo']['name'],
                        'file[url]' => $dataurl
                    ], 'VtMgEK2C0fI+63pnhdLldkTQBLmpxWxQ6ikRzR9jkwSXf8ESheKmkia4bPjeGO8E');

                    if ($static_call->status === 'success') {
                        $response = Utils::httpRequestInternal(JAM_API . 'client_app', 'POST', [
                            'domain' => $_POST['domain'],
                            'name' => $_POST['name'],
                            'logo' => $static_call->url,
                            'redirect_url' => $_POST['redirect_url'],
                            'data' => json_encode($data),
                            'dev' => isset($_POST['dev']) ? '1' : '0'
                        ]);

                        if ($response->status === 'success') {
                            Alert::success('Client app created successfully');
                            header('location: ' . WEBROOT . 'core/apps');
                            die;
                        } else {
                            Alert::error('Core API returned "' . $response->message . '".');
                        }
                    } else {
                        Alert::error('Static API returned "' . $static_call->message . '"');
                    }
                } else {
                    unset($_POST['data']);
                    Alert::error('Data "' . $is_data_ok . '" does not exists. Allowed data: ' . implode(', ', DATA_LIST));
                }
            }
        }

        Data::get()->add('TITLE', 'New client app');
        Data::get()->add('posted', $_POST);
        Controller::renderView('core/apps/new');
        break;

    case 'details':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            /** @var CoreClientApp $app */
            $app = Persist::read('CoreClientApp', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['name'] !== '' && $_POST['domain'] !== '' && $_POST['redirect_url'] !== '' && $_POST['data'] !== '') {
                    $app->setName($_POST['name']);
                    $app->setDomain($_POST['domain']);
                    $app->setRedirectUrl($_POST['redirect_url']);
                    $app->setDev(isset($_POST['dev']) ? 1 : 0);

                    $data = fromDataStringToArray($_POST['data']);
                    $is_data_ok = checkDataString($data);
                    if ($is_data_ok === true) {
                        $app->setData(json_encode($data));
                        Alert::success('Changes saved successfully.');
                    } else {
                        unset($_POST['data']);
                        Alert::error('Data "' . $is_data_ok . '" does not exists. Allowed data: ' . implode(', ', DATA_LIST));
                    }
                    Persist::update($app);
                } else {
                    Alert::error('All fields must be filled.');
                }
            }

            Data::get()->add('TITLE', 'Details of ' . $app->getName() . ' app');
            Data::get()->add('app', $app);
            Controller::renderView('core/apps/details');
        } else {
            header('location: ' . WEBROOT . 'core/apps');
            die;
        }
        break;

    case 'secret':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            /** @var CoreClientApp $app */
            $app = Persist::read('CoreClientApp', Request::get()->getArg(3));

            $new_secret = CoreClientAppModel::generateSecret();
            $app->setSecret($new_secret);
            Persist::update($app);
            Alert::success('Secret successfully reset.');

            header('location: ' . WEBROOT . 'core/apps/details/' . $app->getId());
            die;
        }

        header('location: ' . WEBROOT . 'core/apps');
        die;

    case 'delete':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('CoreClientApp', Request::get()->getArg(3));
            Alert::success('Client app deleted successfully.');
        }

        header('location: ' . WEBROOT . 'core/apps');
        die;

    default:
        Data::get()->add('TITLE', 'Client apps');
        Data::get()->add('apps', Persist::fetchAll('CoreClientApp', "ORDER BY id DESC"));
        Controller::renderView('core/apps/list');
}
