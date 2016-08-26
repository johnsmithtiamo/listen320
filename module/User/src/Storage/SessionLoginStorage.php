<?php

namespace User\Storage;

use Zend\Authentication\Storage\Session;

class SessionLoginStorage extends Session {

    public function setRememberMe($rememberMe = 0, $time = 1209600) {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }

    public function setUserRole($role) {
        $this->session->offsetSet('user.role', $role);
        return $this;
    }

    public function getUserRole() {
        return $this->session->offsetGet('user.role');
    }

    public function setUserId($id) {
        $this->session->offsetSet('user.id', $id);
        return $this;
    }

    public function getUserId() {
        return $this->session->offsetGet('user.id');
    }

}
