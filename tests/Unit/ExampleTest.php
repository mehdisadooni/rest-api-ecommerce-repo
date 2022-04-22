<?php

namespace Tests\Unit;


use Tests\TestCase;

class ExampleTest extends TestCase
{

    /**
     * @test
     */
    public function register_should_be_validate()
    {
        $response = $this->postJson('api/v1/register');
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function new_user_can_be_register()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson('api/v1/register', [
            'name' => 'mehdi',
            'email' => 'mehdi@gmail.com',
            'password' => '11',
            'c_password' => '11',
            'address' => 'test address',
            'cellphone' => '09374802160',
            'postal_code' => '234521',
            'province_id' => '1',
            'city_id' => '2',
        ]);
        $response->assertStatus(201);
    }



}
