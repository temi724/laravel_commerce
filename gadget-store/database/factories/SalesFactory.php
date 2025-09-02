<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random product IDs from existing products
        $productIds = Product::pluck('id')->toArray();
        $selectedProducts = $this->faker->randomElements($productIds, $this->faker->numberBetween(1, 4));

        // Nigerian states and cities
        $nigerianStates = [
            'Lagos' => ['Lagos', 'Ikeja', 'Victoria Island', 'Lekki', 'Surulere'],
            'Abuja' => ['Garki', 'Wuse', 'Maitama', 'Gwarinpa', 'Kubwa'],
            'Kano' => ['Kano', 'Nassarawa', 'Fagge', 'Dala', 'Gwale'],
            'Rivers' => ['Port Harcourt', 'Obio-Akpor', 'Eleme', 'Ikwerre', 'Emohua'],
            'Oyo' => ['Ibadan', 'Ogbomoso', 'Oyo', 'Iseyin', 'Saki'],
        ];

        $selectedState = $this->faker->randomKey($nigerianStates);
        $selectedCity = $this->faker->randomElement($nigerianStates[$selectedState]);

        return [
            'username' => $this->faker->name(),
            'email_address' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->randomElement([
                '+234' . $this->faker->numerify('8#########'),
                '+234' . $this->faker->numerify('9#########'),
                '+234' . $this->faker->numerify('7#########'),
            ]),
            'location' => $this->faker->streetAddress(),
            'state' => $selectedState,
            'city' => $selectedCity,
            'product_ids' => $selectedProducts,
        ];
    }
}
