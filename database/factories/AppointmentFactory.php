<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->firstNameFemale().' '.$this->faker->lastName(),
            'contact_no' => '639'.rand(100,200).rand(100,200).rand(100,200),
            'age' => rand(18,30),
            'email' => $this->faker->email(),
            'address' => str_replace(array('.',','),"",$this->faker->sentence($nbWords = 2, $variableNbWords = true)),
            'purpose' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'set_date' => date("m/") . "20" . date("/Y"),
            'appoint_no' => rand(99, 1000) . '-' . rand(99, 1000)
        ];
    }
}
