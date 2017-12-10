<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Admin\UserMangementControllerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dashboard/manageusers/index');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'dashboard/manageusers/edit');
    }

}
