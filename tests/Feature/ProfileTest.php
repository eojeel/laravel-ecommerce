<?php

namespace Tests\Feature;

use Database\Seeders\CountrySeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->seed(CountrySeeder::class);

    $this->user = createValidUser();
});

test('profile page is displayed', function () {

    $this->actingAs($this->user)
        ->get(route('profile.view'))
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Profile/profile')
            ->where('user.name', $this->user->name)
            ->where('user.email', $this->user->email)
        );
});

test('can update the profile information', function () {

    $this->actingAs($this->user)
        ->post(route('profile.update'), createFakeUserData())
        ->assertRedirect(route('profile.view'));

    $this->actingAs($this->user)
        ->get(route('profile.view'))
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Profile/profile')
            ->where('user.name', $this->user->name)
            ->where('user.email', $this->user->email)
        );
});

test('email verification status is unchanged when the email address is unchanged', function () {

    $this->actingAs($this->user)
        ->post(route('profile.update'), createFakeUserData())
        ->assertRedirect(route('profile.view'));

    expect($this->user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {

    $response = $this->actingAs($this->user)
        ->delete(route('profile.delete'), ['password' => 'password']);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('index'));

    expect($this->user->fresh())->toBeNull();

});

test('correct password must be provided to delete an accoubnt', function () {

    $response = $this->actingAs($this->user)
        ->delete(route('profile.delete'), ['password' => 'wrong-password']);

    $response
        ->assertSessionHasErrors('password');

    expect($this->user->fresh())->not->toBeNull();

});
