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

    $this->withoutExceptionHandling();

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
        ])->assertRedirect('/profile');

    $this->actingAs($user)
        ->get('/profile')
        ->assertInertia(fn (Assert $assert) => $assert
            ->component('Profile/profile')
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
        );
});

/*
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

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
