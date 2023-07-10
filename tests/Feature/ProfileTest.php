<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CountrySeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->seed(CountrySeeder::class);
});

test('profile page is displayed', function () {

    $this->withoutExceptionHandling();
    $user = createValidUser();

    $this->actingAs($user)
        ->get(route('profile.view'))
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Profile/profile')
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
        );
});

test('can update the profile information', function () {

    $user = createValidUser();

    $this->actingAs($user)
        ->post(route('profile.update'), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'shipping_address1' => fake()->streetAddress(),
            'shipping_address2' => fake()->secondaryAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->state(),
            'shipping_postcode' => fake()->postcode(),
            'shipping_county' => fake()->country(),
            'billing_country_code' => 'usa',

            'billing_address1' => fake()->streetAddress(),
            'billing_address2' => fake()->secondaryAddress(),
            'billing_city' => fake()->city(),
            'billing_state' => fake()->state(),
            'billing_postcode' => fake()->postcode(),
            'billing_county' => fake()->country(),
            'shipping_country_code' => 'usa',
        ])->assertRedirect(route('profile.view'));

    $this->actingAs($user)
        ->get(route('profile.view'))
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Profile/profile')
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
        );
});

test('email verification status is unchanged when the email address is unchanged', function() {

    $this->withoutExceptionHandling();
    $user = createValidUser();

    $this->actingAs($user)
    ->post(route('profile.update'), [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => $user->email,
    ])
    ->assertRedirect(route('profile.view'));

    dd(($user->refresh()->email_verified_at));
    //expect($user->refresh()->email_verified_at)->not->toBeNull();
});
/*


    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
*/
