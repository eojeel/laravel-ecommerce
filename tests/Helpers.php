<?php

use Tests\TestCase;
use App\Models\User;

function createValidUser(): User
{
    return User::factory()->hasCustomer(
        [
            'first_name' => 'joe',
            'last_name' => 'lee'
        ])
        ->create();
}
