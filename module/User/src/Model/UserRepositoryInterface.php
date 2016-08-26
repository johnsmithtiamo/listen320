<?php

namespace User\Model;

interface UserRepositoryInterface {

    public function findAllUsers();

    public function findUser($user_id);
}
