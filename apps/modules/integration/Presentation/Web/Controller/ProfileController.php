<?php

namespace Module\Integration\Presentation\Web\Controller;
use Module\Integration\Core\Application\Request\UserEditRequest;
use Module\Integration\Core\Application\Service\UserEditService;
use Module\Integration\Core\Exception\NotFoundException;
use Module\Integration\Core\Exception\WrongPasswordException;
use stdClass;

class ProfileController extends AuthenticatedBaseController
{
    protected UserEditService $user_edit_service;

    //public function initialize()
    //{
        //$this->user_edit_service = $this->di->get('userEditService');
    //}
    public function indexAction()
    {
        $this->user_edit_service = $this->di->get('userEditService');
        $this->view->setVar('user_info', $this->user_info);
        if ($this->request->isPost()) {
            $request = new UserEditRequest();
            $request->user_id = $this->user_info->id;
            $request->username = $this->request->getPost('profile_username', 'string');
            $request->old_password = $this->request->getPost('profile_old_password', 'string');
            $request->new_password = $this->request->getPost('profile_new_password', 'string');
            $confirm_password = $this->request->getPost('profile_confirm_password', 'string');
            if ($request->new_password != $confirm_password) {
                $this->flashSession->error('Konfirmasi Password Tidak Cocok.');
                return $this->response->redirect('/profile');
            }
            if ($request->new_password == '') {
                unset($request->new_password);
            }
            try {
                if ($this->user_edit_service->execute($request)) {
                    $ui = new stdClass;
                    $ui->id = $this->user_info->id;
                    $ui->username = $request->username;
                    $this->session->set('user_info', $ui);
                    $this->flashSession->success('Profil berhasil diubah.');
                    $this->response->redirect('/profile');
                }
            } catch (NotFoundException $e) {
                $this->flashSession->error('Akun tidak ditemukan');
            } catch (WrongPasswordException $e) {
                $this->flashSession->error('Password salah');
            } catch (\Exception $e) {
                $this->flashSession->error('Username sudah ada');
            }
        }
        $this->view->pick('index/profile');
    }
}
