<?php

namespace Tests\Unit;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ListCountriesTest extends TestCase
{

    public function testListCountries()
    {
        if (!\App::runningInConsole()){
            $url = '/listCountries';

            print_r("ListCountriesTest");

            $formAttributes = [
                'username' => getenv('BACKOFFICE_USERNAME'),
                'password' => getenv('BACKOFFICE_PASSWORD'),
            ];

            $response = $this->json('post', $url, $formAttributes);

            //print_r($response->getContent());

            $response->assertStatus(200);
            $response->dump();

            /*$response->assertJsonFragment(
                [
                    "status" => "OK"
                ]
            );*/

            /*}catch(NotFoundHttpException $ex){
                print_r($ex->getMessage());
            }*/
        }
    }
}
