<?php

namespace User\Model;

interface UserCommandInterface {

    public function insertUser(User $user);

    public function updateUser(User $user);

    public function deleteUser(User $user);
}
