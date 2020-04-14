<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\WebsitePage;

switch (Request::get()->getArg(2)) {
    case 'new':
        if (POST) {
            if ($_POST['title'] !== '' && $_POST['route'] !== '' && $_POST['content'] !== '') {
                if (preg_match("#^[a-z0-9-]+$#", $_POST['route'])) {
                    if (!Persist::exists('WebsitePage', 'route', $_POST['route'])) {
                        $page = new WebsitePage(
                            0,
                            $_POST['title'],
                            $_POST['route'],
                            $_POST['content'],
                            0,
                            Utils::time(),
                            Utils::time(),
                            isset($_GET['publish']) ? 1 : 0
                        );
                        Persist::create($page);
                        Alert::success('Website page successfully ' . (isset($_GET['publish']) ? 'published' : 'created') . '!');
                        header('location: ' . WEBROOT . 'website/pages');
                        die;
                    } else {
                        Alert::error('A page with this URL already exists.');
                    }
                } else {
                    Alert::error('Invalid URL.');
                }
            } else {
                Alert::error('All fields must be filled.');
            }
        }

        Data::get()->add('TITLE', 'Add a new website page');
        Controller::renderView('website/pages/new');
        break;

    case 'details':
        if (Persist::exists('WebsitePage', 'id', Request::get()->getArg(3))) {
            /** @var WebsitePage $page */
            $page = Persist::read('WebsitePage', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['title'] !== '' && $_POST['route'] !== '' && $_POST['content'] !== '') {
                    $page->setTitle($_POST['title']);
                    $page->setContent($_POST['content']);
                    $page->setUpdatedAt(Utils::time());
                    Alert::success('Changes saved successfully.');
                    if ($_POST['route'] !== $page->getRoute()) {
                        if (preg_match("#^[a-z0-9-]+$#", $_POST['route'])) {
                            if (!Persist::exists('WebsitePage', 'route', $_POST['route'])) {
                                $page->setRoute($_POST['route']);
                            } else {
                                Alert::error('A page with this URL already exists.');
                            }
                        } else {
                            Alert::error('Invalid URL.');
                        }
                    }

                    Persist::update($page);
                } else {
                    Alert::error('All fields must be filled.');
                }
            }

            Data::get()->add('TITLE', 'Details of page #' . $page->getId() .': ' . $page->getTitle());
            Data::get()->add('page', $page);
            Controller::renderView('website/pages/details');
        } else {
            header('location: ' . WEBROOT . 'webiste/pages');
            die;
        }
        break;

    case 'publish':
        if (Persist::exists('WebsitePage', 'id', Request::get()->getArg(3))) {
            /** @var WebsitePage $page */
            $page = Persist::read('WebsitePage', Request::get()->getArg(3));
            $page->setPublished(1);
            $page->setUpdatedAt(Utils::time());

            Persist::update($page);
            Alert::success('Website page successfully published.');

            header('location: ' . WEBROOT . 'website/pages/details/' . Request::get()->getArg(3));
            die;
        }

        header('location: ' . WEBROOT . 'website/pages');
        die;

    case 'unpublish':
        if (Persist::exists('WebsitePage', 'id', Request::get()->getArg(3))) {
            /** @var WebsitePage $page */
            $page = Persist::read('WebsitePage', Request::get()->getArg(3));
            $page->setPublished(0);
            $page->setUpdatedAt(Utils::time());

            Persist::update($page);
            Alert::success('Website page successfully unpublished.');

            header('location: ' . WEBROOT . 'website/pages/details/' . Request::get()->getArg(3));
            die;
        }

        header('location: ' . WEBROOT . 'website/pages');
        die;

    case 'delete':
        if (Persist::exists('WebsitePage', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('WebsitePage', Request::get()->getArg(3));
            Alert::success('Website page deleted successfully.');
        }

        header('location: ' . WEBROOT . 'website/pages');
        die;

    default:
        Data::get()->add('TITLE', 'Website pages');
        Data::get()->add('pages', Persist::fetchAll('WebsitePage', "ORDER BY updated_at DESC"));
        Controller::renderView('website/pages/list');
        break;
}