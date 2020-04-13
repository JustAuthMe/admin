<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\ConsoleTeam;
use PitouFW\Entity\ConsoleTeamApp;
use PitouFW\Entity\ConsoleTeamUser;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('ConsoleTeam', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleTeam $team */
            $team = Persist::read('ConsoleTeam', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['name'] !== '') {
                    $team->setName($_POST['name']);
                    Alert::success('Changes saved successfully.');
                }

                Persist::update($team);
            }

            Data::get()->add('TITLE', $team->getName() . ' team');
            Data::get()->add('team', $team);
            Controller::renderView('console/teams/details');
        } else {
            header('location: ' . WEBROOT . 'console/teams');
            die;
        }
        break;

    case 'apps':
        if (Persist::exists('ConsoleTeam', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleTeam $team */
            $team = Persist::read('ConsoleTeam', Request::get()->getArg(3));

            $team_apps = Persist::fetchAll('ConsoleTeamApp', "WHERE team_id = ?", [$team->getId()]);
            $apps = [];
            foreach ($team_apps as $team_app) {
                $apps[] = clone $team_app->app;
            }

            Data::get()->add('TITLE', $team->getName() . ' team apps');
            Data::get()->add('apps', $apps);
            Controller::renderView('core/apps/list');
        } else {
            header('location: ' . WEBROOT . 'console/teams');
            die;
        }
        break;

    case 'users':
        if (Persist::exists('ConsoleTeam', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleTeam $team */
            $team = Persist::read('ConsoleTeam', Request::get()->getArg(3));

            $team_users = Persist::fetchAll('ConsoleTeamUser', "WHERE team_id = ?", [$team->getId()]);

            Data::get()->add('TITLE', $team->getName() . ' team members');
            Data::get()->add('team_users', $team_users);
            Controller::renderView('console/teams/users');
        } else {
            header('location: ' . WEBROOT . 'console/teams');
            die;
        }
        break;

    case 'delete_user':
        if (Persist::exists('ConsoleTeamUser', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleTeamUser $team_user */
            $team_user = Persist::read('ConsoleTeamUser', Request::get()->getArg(3));
            $team_id = $team_user->getTeamId();

            Persist::delete($team_user);
            Alert::success('Team member successfully removed.');
        }

        header('location: ' . WEBROOT . 'console/teams' . (isset($team_id) ? '/users/' . $team_id : ''));
        die;

    case 'delete':
        if (Persist::exists('ConsoleTeam', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('ConsoleTeam', Request::get()->getArg(3));
            Alert::success('Team deleted successfully');
        }

        header('location: ' . WEBROOT . 'console/teams');
        die;

    default:
        Data::get()->add('TITLE', 'Developers teams');
        Data::get()->add('teams', Persist::fetchAll('ConsoleTeam', "ORDER BY id DESC"));
        Controller::renderView('console/teams/list');
}