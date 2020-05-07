<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\AdminPitchMail;
use PitouFW\Entity\AdminProspect;
use PitouFW\Model\AdminProspect as AdminProspectModel;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'details';
        if (Persist::exists('AdminProspect', 'id', Request::get()->getArg(3))) {
            /** @var AdminProspect $prospect */
            $prospect = Persist::read('AdminProspect', Request::get()->getArg(3));

            if (POST) {
                if ($prospect->getAssignedId() === null || $prospect->getAssignedId() === AdminUser::get()->getId()) {
                    if ($_POST['name'] !== '' && $_POST['lang'] !== '' && $_POST['status'] !== '') {
                        $prospect->setName($_POST['name']);
                        Alert::success('Prospect updated successfully!');

                        if (Persist::exists('AdminPitchMail', 'lang', $_POST['lang'])) {
                            $prospect->setLang($_POST['lang']);
                        } else {
                            Alert::warning('Unknown lang.');
                        }

                        $status_manual_override = false;
                        if ($_POST['status'] !== $prospect->getStatus() && in_array($_POST['status'], array_keys(AdminProspectModel::STATUS_LABEL))) {
                            $prospect->setStatus($_POST['status']);
                            $status_manual_override = true;
                        }

                        if ($_POST['contact_email'] !== '') {
                            if (filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
                                $prospect->setContactEmail($_POST['contact_email']);
                                if ($prospect->getStatus() === AdminProspectModel::STATUS_INCOMPLETE && !$status_manual_override) {
                                    $prospect->setStatus(AdminProspectModel::STATUS_PENDING);
                                }
                            } else {
                                Alert::warning('Please provide a valid e-mail address.');
                            }
                        }

                        if ($_POST['contact_name'] !== '') {
                            $prospect->setContactName($_POST['contact_name']);
                        }

                        if ($_POST['url'] !== '') {
                            if (filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
                                $prospect->setUrl($_POST['url']);
                            } else {
                                Alert::warning('Please provide a valid website URL.');
                            }
                        }

                        if ($_POST['assigned_id'] !== '' && Persist::exists('AdminUser', 'id', $_POST['assigned_id'])) {
                            $prospect->setAssignedId($_POST['assigned_id']);
                        }

                        Persist::update($prospect);
                    } else {
                        Alert::error('Name, lang and status cannot be left empty.');
                    }
                } else {
                    Alert::error('Only ' . $prospect->assigned->getFirstname() . ' ' . $prospect->assigned->getLastname() . ' can update this prospect.');
                }
            }

            switch ($prospect->getStatus()) {
                case AdminProspectModel::STATUS_INCOMPLETE:
                    $statuses = [AdminProspectModel::STATUS_INCOMPLETE];
                    break;

                case AdminProspectModel::STATUS_PENDING:
                    $statuses = [AdminProspectModel::STATUS_PENDING];
                    break;

                case AdminProspectModel::STATUS_NEGOTIATING:
                case AdminProspectModel::STATUS_TO_REMIND:
                case AdminProspectModel::STATUS_DECLINED:
                    $statuses = [
                        AdminProspectModel::STATUS_NEGOTIATING,
                        AdminProspectModel::STATUS_TO_REMIND,
                        AdminProspectModel::STATUS_ACCEPTED,
                        AdminProspectModel::STATUS_DECLINED
                    ];
                    break;

                case AdminProspectModel::STATUS_ACCEPTED:
                    $statuses = [AdminProspectModel::STATUS_ACCEPTED];
                    break;

                default:
                    $statuses = array_keys(AdminProspectModel::STATUS_LABEL);
            }

            Data::get()->add('TITLE', 'Details of prospect ' . $prospect->getName());
            Data::get()->add('prospect', $prospect);
            Data::get()->add('admins', Persist::fetchAll('AdminUser'));
            Data::get()->add('statuses', $statuses);
            Data::get()->add('pitch_mails', Persist::fetchAll('AdminPitchMail', "ORDER BY id DESC"));
            Data::get()->add('parser', new Parsedown());
            Controller::renderView('prospects/manager/details');
        } else {
            header('location: ' . WEBROOT . 'prospects/manage');
            die;
        }
        break;

    case 'pitch':
        if (POST && Persist::exists('AdminProspect', 'id', Request::get()->getArg(3))) {
            /** @var AdminProspect $prospect */
            $prospect = Persist::read('AdminProspect', Request::get()->getArg(3));
            /** @var AdminPitchMail $pitch */
            $pitch = Persist::readBy('AdminPitchMail', 'lang', $prospect->getLang());
            $parser = new Parsedown();

            if ($prospect->getAssignedId() === null || $prospect->getAssignedId() === AdminUser::get()->getId()) {
                if ($_POST['subject'] !== '' && $_POST['content'] !== '') {
                    $prospect->setMailSubject($_POST['subject']);
                    $prospect->setMailContent($_POST['content']);
                    Alert::success('Pitch e-mail successfully updated!');

                    $postdata = [
                        'to' => '',
                        'subject' => $prospect->getMailSubject(),
                        'body' => str_replace("\n", '',
                            str_replace('{{name}}', $prospect->getName(),
                                str_replace('{{fullname}}', AdminUser::get()->getFirstname() . ' ' . AdminUser::get()->getLastname(),
                                    str_replace('{{firstname}}', AdminUser::get()->getFirstname(), $parser->text($prospect->getMailContent()))
                                )
                            )
                        ),
                        'call_to_action[title]' => $pitch->getButton(),
                        'call_to_action[link]' => 'mailto:partnership@justauth.me?subject=Re: ' . $prospect->getMailSubject()
                    ];

                    switch (Request::get()->getArg(4)) {
                        case 'test':
                            $postdata['to'] = AdminUser::get()->getEmail();
                            Utils::httpRequestInternal(
                                JAM_API . 'mailer/default',
                                'POST',
                                $postdata
                            );
                            Alert::success('Pitch e-mail successfully tested at ' . AdminUser::get()->getEmail() . '!');
                            break;

                        case 'send':
                            if ($prospect->getStatus() !== AdminProspectModel::STATUS_INCOMPLETE) {
                                $prospect->setStatus(AdminProspectModel::STATUS_NEGOTIATING);
                                if ($prospect->getAssignedId() === null) {
                                    $prospect->setAssignedId(AdminUser::get()->getId());
                                }
                                $postdata['to'] = $prospect->getContactEmail();
                                Utils::httpRequestInternal(
                                    JAM_API . 'mailer/default',
                                    'POST',
                                    $postdata
                                );
                                Alert::success('Pitch e-mail successfully sent at ' . $prospect->getContactEmail() . '!');
                            } else {
                                Alert::error('You can\'t approach a prospect without knowing its e-mail address.');
                            }
                            break;
                    }

                    Persist::update($prospect);
                } else {
                    Alert::error('The pitch e-mail content connat be left empty.');
                }
            } else {
                Alert::error('Only ' . $prospect->assigned->getFirstname() . ' ' . $prospect->assigned->getLastname() . ' can update or sent this prospect pitch e-mail.');
            }

            header('location: ' . WEBROOT . 'prospects/manager/details/' . $prospect->getId());
            die;
        } else {
            header('location: ' . WEBROOT . 'prospects/manager');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('AdminProspect', 'id', Request::get()->getArg(3))) {
            /** @var AdminProspect $prospect */
            $prospect = Persist::read('AdminProspect', Request::get()->getArg(3));
            if ($prospect->getStatus() === AdminProspectModel::STATUS_INCOMPLETE || $prospect->getStatus() === AdminProspectModel::STATUS_PENDING) {
                Persist::delete($prospect);
                Alert::success('Prospect deleted successfully!');
            } else {
                Alert::error('You can\'t delete an already approached prospect.');
            }
        }

        header('location: ' . WEBROOT . 'prospects/manager');
        die;

    default:
        if (POST) {
            if ($_POST['name'] !== '' && $_POST['lang'] !== '') {
                if (Persist::exists('AdminPitchMail' ,'lang', $_POST['lang'])) {
                    /** @var AdminPitchMail $pitch_mail */
                    $pitch_mail = Persist::readBy('AdminPitchMail', 'lang', $_POST['lang']);

                    $prospect = new AdminProspect(
                        0,
                        $_POST['name'],
                        $_POST['lang'],
                        '',
                        '',
                        '',
                        $pitch_mail->getSubject(),
                        $pitch_mail->getContent(),
                        AdminUser::get()->getId()
                    );
                    Alert::success('Prospect successfully created!');

                    if ($_POST['url'] !== '') {
                        if (filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
                            $prospect->setUrl($_POST['url']);
                        } else {
                            Alert::warning('Website must be an valid URL.');
                        }
                    }

                    if ($_POST['contact_email'] !== '') {
                        if (filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
                            $prospect->setContactEmail($_POST['contact_email']);
                            $prospect->setStatus(AdminProspectModel::STATUS_PENDING);
                        } else {
                            Alert::warning('Contact E-Mail must be valid.');
                        }
                    }

                    if ($_POST['contact_name'] !== '') {
                        $prospect->setContactName($_POST['contact_name']);
                    }

                    Persist::create($prospect);
                } else {
                    Alert::error('Unknown lang.');
                }
            } else {
                Alert::error('A new prospect must at least have a name and a lang.');
            }
        }

        Data::get()->add('TITLE', 'Prospects manager');
        Data::get()->add('prospects', Persist::fetchAll('AdminProspect', "ORDER BY updated_at DESC"));
        Data::get()->add('pitch_mails', Persist::fetchAll('AdminPitchMail', "ORDER BY id DESC"));
        Controller::renderView('prospects/manager/list');
}