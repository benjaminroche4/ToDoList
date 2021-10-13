<?php


namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Login page
     */
    public function testDisplayLogin(){
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Connectez-vous');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    /**
     * Login with bads credentials
     */
    public function testLoginWithBadCredentials(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form([
            'email' => 'fake@email.fr',
            'password' => 'fakepassword'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * Login with valids credentials
     */
    public function testSuccessfullLogin(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form([
            'email' => '2email@email.com',
            'password' => 'password'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects('/');
    }


}