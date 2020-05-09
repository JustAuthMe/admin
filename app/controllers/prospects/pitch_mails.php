<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\AdminPitchMail;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'new':
        if (POST) {
            if ($_POST['lang'] !== '' && $_POST['label'] !== '' && $_POST['subject'] !== '' && $_POST['content'] !== '') {
                $pitch = new AdminPitchMail(
                    0,
                    $_POST['lang'],
                    $_POST['label'],
                    $_POST['subject'],
                    $_POST['content'],
                    '',
                    '',
                    null,
                    AdminUser::get()->getId()
                );
                Alert::success('Pitch e-mail created successfully!');

                if ($_POST['button_text'] !== '' || $_POST['button_link'] !== '') {
                    if ($_POST['button_text'] !== '' && $_POST['button_link'] !== '') {
                        $pitch->setButtonText($_POST['button_text']);
                        $pitch->setButtonLink($_POST['button_link']);
                    } else {
                        Alert::warning('You need to fill Call to action text AND link or left them both empty.');
                    }
                }

                Persist::create($pitch);
                header('location: ' . WEBROOT . 'prospects/pitch-mails');
                die;
            } else {
                Alert::error('All required fields must be filled.');
            }
        }

        Data::get()->add('TITLE', 'New pitch e-mail');
        Data::get()->add('parser', new Parsedown());
        Data::get()->add('posted', $_POST);
        Controller::renderView('prospects/pitch_mails/new');
        break;

    case 'details':
        if (Persist::exists('AdminPitchMail', 'id', Request::get()->getArg(3))) {
            /** @var AdminPitchMail $pitch */
            $pitch = Persist::read('AdminPitchMail', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['label'] !== '' && $_POST['subject'] !== '' && $_POST['content'] !== '') {
                    $pitch->setLabel($_POST['label']);
                    $pitch->setSubject($_POST['subject']);
                    $pitch->setContent($_POST['content']);
                    $pitch->setUpdatedAt(date('Y-m-d H:i:s'));
                    $pitch->setUpdaterId(AdminUser::get()->getId());
                    Alert::success('Pitch e-mail updated successfully!');

                    if (
                        ($_POST['button_text'] !== '' && $_POST['button_link'] !== '') ||
                        ($_POST['button_text'] === '' && $_POST['button_link'] === '')
                    ) {
                        $pitch->setButtonText($_POST['button_text']);
                        $pitch->setButtonLink($_POST['button_link']);
                    } else {
                        Alert::warning('You need to fill Call to action text AND link or left them both empty.');
                    }

                    Persist::update($pitch);

                    if (Request::get()->getArg(4) === 'test') {
                        $parser = new Parsedown();
                        $postdata = [
                            'to' => AdminUser::get()->getEmail(),
                            'subject' => $pitch->getSubject(),
                            'body' => str_replace("\n", '',
                                str_replace('{{fullname}}', AdminUser::get()->getFirstname() . ' ' . AdminUser::get()->getLastname(),
                                    str_replace('{{firstname}}', AdminUser::get()->getFirstname(), $parser->text($pitch->getContent()))
                                )
                            )
                        ];

                        if ($pitch->getButtonText() !== '' && $pitch->getButtonLink() !== '') {
                            $postdata['call_to_action[title]'] = $pitch->getButtonText();
                            $postdata['call_to_action[link]'] = $pitch->getButtonLink();
                        }

                        Utils::httpRequestInternal(
                            JAM_API . 'mailer/default',
                            'POST',
                            $postdata
                        );
                        Alert::success('Pitch e-mail successfully tested at ' . AdminUser::get()->getEmail() . '!');
                    }
                } else {
                    Alert::error('All required fields must be filled.');
                }
            }

            Data::get()->add('TITLE', 'Details of ' . strtoupper($pitch->getLang()) . ' pitch e-mail');
            Data::get()->add('pitch', $pitch);
            Data::get()->add('parser', new Parsedown());
            Controller::renderView('prospects/pitch_mails/details');
        } else {
            header('location: ' . WEBROOT . 'prospects/pitch-mails');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('AdminPitchMail', 'id', Request::get()->getArg(3))) {
            /** @var AdminPitchMail $pitch $pitch */
            $pitch = Persist::read('AdminPitchMail', Request::get()->getArg(3));

            if (Persist::count('AdminProspect', "WHERE lang = ?", [$pitch->getLang()]) === 0) {
                Persist::delete($pitch);
                Alert::success('Pitch e-mail removed successfully!');
            } else {
                Alert::error('This pitch e-mail is associated to one or many prospects.');
            }
        }

        header('location: ' . WEBROOT . 'prospects/pitch-mails');
        die;

    default:
        Data::get()->add('TITLE', 'Pitch e-mails');
        Data::get()->add('pitchs', Persist::fetchAll('AdminPitchMail', "ORDER BY updated_at DESC"));
        Controller::renderView('prospects/pitch_mails/list');
}