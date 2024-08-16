<?php

use App\Models\User;

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('api.login.user'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);

    // $this->assertAuthenticatedAs($user);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('api.login.user'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('api.logout.user'));
    
    $response->assertStatus(200);

});
