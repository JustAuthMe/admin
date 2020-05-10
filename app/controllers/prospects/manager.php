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
                    if ($_POST['name'] !== '' && $_POST['status'] !== '') {
                        $prospect->setName($_POST['name']);
                        $prospect->setContactName($_POST['contact_name']);
                        Alert::success('Prospect updated successfully!');

                        if ($_POST['model_id'] !== $prospect->getModelid()) {
                            if (Persist::exists('AdminPitchMail', 'id', $_POST['model_id'])) {
                                $prospect->setModelid($_POST['model_id']);
                                /** @var AdminPitchMail $pitch */
                                $pitch = Persist::readBy('AdminPitchMail', 'id', $_POST['model_id']);
                                $prospect->setMailSubject($pitch->getSubject());
                                $prospect->setMailContent($pitch->getContent());
                            } elseif ($_POST['model_id'] === '') {
                                $prospect->setModelId(null);
                            } else {
                                Alert::warning('Unknown model.');
                            }
                        }

                        $status_manual_override = false;
                        if ($_POST['status'] !== $prospect->getStatus() && in_array($_POST['status'], array_keys(AdminProspectModel::STATUS_LABEL))) {
                            $prospect->setStatus($_POST['status']);
                            $status_manual_override = true;
                        }

                        if ($_POST['contact_email'] === '' || filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
                            $prospect->setContactEmail($_POST['contact_email']);
                            if ($_POST['contact_email'] !== '' && $prospect->getStatus() === AdminProspectModel::STATUS_INCOMPLETE && !$status_manual_override) {
                                $prospect->setStatus(AdminProspectModel::STATUS_PENDING);
                            }
                        } else {
                            Alert::warning('Please provide a valid e-mail address.');
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
                        Alert::error('Name, model and status cannot be left empty.');
                    }
                } else {
                    Alert::error('Only ' . $prospect->assigned->getFirstname() . ' ' . $prospect->assigned->getLastname() . ' can update this prospect.');
                }
            }

            switch ($prospect->getStatus()) {
                case AdminProspectModel::STATUS_PENDING:
                    $statuses = [AdminProspectModel::STATUS_PENDING];
                    break;

                case AdminProspectModel::STATUS_INCOMPLETE:
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
            Data::get()->add('pitch_mails', Persist::fetchAll('AdminPitchMail', "ORDER BY lang, label"));
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
            $pitch = Persist::readBy('AdminPitchMail', 'id', $prospect->getModelid());
            $parser = new Parsedown();

            if ($prospect->getAssignedId() === null || $prospect->getAssignedId() === AdminUser::get()->getId()) {
                if ($_POST['subject'] !== '' && $_POST['content'] !== '') {
                    $prospect->setMailSubject($_POST['subject']);
                    $prospect->setMailContent($_POST['content']);
                    Alert::success('Pitch e-mail successfully updated!');

                    $postdata = [
                        'from' => AdminUser::get()->getFirstname() . ' • JustAuthMe <' . AdminUser::get()->getEmail() . '>',
                        'subject' => $prospect->getMailSubject(),
                        'body' => str_replace("\n", '',
                            str_replace('{{name}}', $prospect->getName(),
                                str_replace('{{fullname}}', AdminUser::get()->getFirstname() . ' ' . AdminUser::get()->getLastname(),
                                    str_replace('{{firstname}}', AdminUser::get()->getFirstname(), $parser->text($prospect->getMailContent()))
                                )
                            )
                        )
                    ];

                    if ($pitch->getButtonText() !== '' && $pitch->getButtonLink() !== '') {
                        $postdata['call_to_action[title]'] = $pitch->getButtonText();
                        $postdata['call_to_action[link]'] = $pitch->getButtonLink();
                    }

                    switch (Request::get()->getArg(4)) {
                        case 'test':
                            $postdata['to'] = AdminUser::get()->getEmail();
                            Utils::httpRequestInternal(
                                JAM_API . 'mailer/default',
                                'POST',
                                $postdata
                            );
                            Alert::success($prospect->getName() . ' pitch e-mail successfully tested at ' . AdminUser::get()->getEmail() . '!');
                            break;

                        case 'send':
                            if ($prospect->getStatus() !== AdminProspectModel::STATUS_INCOMPLETE) {
                                if (!Persist::exists('CoreEmailBlacklist', 'email', Utils::hashEmail($prospect->getContactEmail()))) {
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
                                    Alert::success($prospect->getName() . ' pitch e-mail successfully sent at ' . $prospect->getContactEmail() . '!');
                                } else {
                                    $prospect->setStatus(AdminProspectModel::STATUS_DECLINED);
                                    Alert::error('This prospect unsubscribed from our mailing lists. We cannot contact them anymore.');
                                }
                            } else {
                                Alert::error('You can\'t approach a prospect without knowing its e-mail address.');
                            }
                            break;
                    }

                    $prospect->setUpdatedAt(date('Y-m-d H:i:s'));
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
            if ($prospect->getAssignedId() === null || $prospect->getAssignedId() == AdminUser::get()->getId()) {
                Persist::delete($prospect);
                Alert::success('Prospect deleted successfully!');
            } else {
                Alert::error('Only ' . $prospect->assigned->getFirstname() . ' ' . $prospect->assigned->getLastname() . ' can delete this prospect.');
            }
        }

        header('location: ' . WEBROOT . 'prospects/manager');
        die;

    default:
        if (POST) {
            if ($_POST['name'] !== '') {
                if (!Persist::exists('AdminProspect', 'name', $_POST['name'])) {
                    $prospect = new AdminProspect(
                        0,
                        $_POST['name'],
                        null,
                        '',
                        '',
                        '',
                        '',
                        '',
                        AdminUser::get()->getId()
                    );
                    Alert::success('Prospect successfully created!');

                    if ($_POST['model_id'] !== '') {
                        if (Persist::exists('AdminPitchMail', 'id', $_POST['model_id'])) {
                            /** @var AdminPitchMail $pitch */
                            $pitch = Persist::readBy('AdminPitchMail', 'id', $_POST['model_id']);

                            $prospect->setModelId($pitch->getId());
                            $prospect->setMailSubject($pitch->getSubject());
                            $prospect->setMailContent($pitch->getContent());
                        } else {
                            Alert::warning('Unknown model.');
                        }
                    }

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
                    Alert::error('A prospect with the name "' . htmlentities($_POST['name']) . '" already exists.');
                }
            } else {
                Alert::error('A new prospect must at least have a name and a model.');
            }
        }

        Data::get()->add('TITLE', 'Prospects manager');
        Data::get()->add('prospects', Persist::fetchAll('AdminProspect', "ORDER BY updated_at DESC"));
        Data::get()->add('pitch_mails', Persist::fetchAll('AdminPitchMail', "ORDER BY lang, label"));
        Controller::renderView('prospects/manager/list');
}