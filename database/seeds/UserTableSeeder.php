<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UserTableSeeder extends Seeder{
	public function run()
	{

        \DB::table('plans')->insert(array(
            'nombre' => 'PERAST',
            'capacidad' => '0',
            'cantidadTablets' => '0',
            'sistemas' => '0',
            'duracion' => '2016-06-06',
            'precio' => '0',
            'periodicidad' => 'anual'
        ));
        $id_user = \DB::table('users')->insertGetId(array(
            'name' => 'Julian Castillo',
            'email' => 'jcastillo@perast.cl',
            'password' => \Hash::make('123456'),
            'pagina' => 'perast.cl'
        ));


        \DB::table('plan_user')->insert(array(
            'activo' => '1',
            'user_id' => $id_user,
            'plan_id' => '1',
            'duracion' => '2016-06-06'
        ));


     /*$faker = Faker::create();

        for($i = 0; $i<3 ; $i++) {

            \DB::table('plans')->insert(array(
                'nombre' => $faker->safeColorName,
                'usuariosAdmins' => $faker->randomDigit,
                'usuariosReportes' => $faker->randomDigit,
                'cantidadTablets' => $faker->randomDigit,
                'sistemas' => $faker->randomDigit,
                'precio' => $faker->randomNumber(2),
                'periodicidad' => 'anual',
                'planCol' => $faker->word
            ));
        }

        for($i = 0; $i < 30; $i++){
            $id_user = \DB::table('users')->insertGetId(array(
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => \Hash::make('123456'),
                'pagina' => $faker->domainName,
                'imagenFondo' => $faker->url,
                //'plan' => $faker->safeColorName,
                'logo' => $faker->url
            ));
            for($j=0;$j<2;$j++) {
                \DB::table('plan_user')->insert(array(
                    'activo' => $faker->boolean(100),
                    'user_id' => $id_user,
                    'plan_id' => $faker->randomElement(array('1', '2', '3')),
                    'duracion' => $faker->dateTimeBetween('now', '1 years')->format('Y-m-d')
                ));
            }
        }*/


	}
}
