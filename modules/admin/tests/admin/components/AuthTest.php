<?php

namespace tests\admin\components;

use luya\admin\components\Auth;
use admintests\AdminTestCase;

class AuthTest extends AdminTestCase
{
    public $auth;

    public function setUp()
    {
        parent::setUp();

        $this->auth = new Auth();
    }
    
    public function testGetApiTable()
    {
        $perm = $this->auth->getApiTable(1, 'api-admin-user');
        
        $this->assertTrue(is_array($perm));
        $this->assertSame(1, count($perm));
        $this->assertSame("1", $perm[0]['user_id']);
        $this->assertSame("1", $perm[0]['group_id']);
    }
    
    /*
    public function testGetRouteTable()
    {
    	var_dump($this->auth->getRouteTable(1, 'admin/storage/index'));
    }
    */

    /*
    public function testAddRoute()
    {
        $beforeData = $this->auth->getDatabaseAuths();

        $response = $this->auth->addRoute('foo', 'routename', 'baz');

        $this->assertEquals(1, $response);

        $response = $this->auth->addRoute('foo2', 'routename', 'baz2');

        $this->assertEquals(1, $response);

        $addApi = $this->auth->addApi('foo', 'apiname', 'baz');
        $addApi = $this->auth->addApi('foo3', 'apiname', 'baz3');

        $response = $this->auth->prepareCleanup($beforeData);

        $this->assertEquals(2, count($response));

        $this->assertEquals('baz3', $response[0]['alias_name']);
        $this->assertEquals('baz2', $response[1]['alias_name']);

        $exec = $this->auth->executeCleanup($response);

        $this->assertEquals(true, $exec);
    }

    public function testMatches()
    {
        $this->assertEquals(false, $this->auth->matchApi(1, 'foo'));
        $this->assertEquals(false, $this->auth->matchRoute(1, 'foo'));
    }
    */
    public function testPermissionWeight()
    {
        $this->assertEquals(0, $this->auth->permissionWeight(false, false, false));
        $this->assertEquals(1, $this->auth->permissionWeight(true, false, false));
        $this->assertEquals(3, $this->auth->permissionWeight(false, true, false));
        $this->assertEquals(4, $this->auth->permissionWeight(true, true, false));
        $this->assertEquals(5, $this->auth->permissionWeight(false, false, true));
        $this->assertEquals(6, $this->auth->permissionWeight(true, false, true));
        $this->assertEquals(8, $this->auth->permissionWeight(false, true, true));
        $this->assertEquals(9, $this->auth->permissionWeight(true, true, true));
    }

    public function testPermissionVerify()
    {
        // CAN CREATE
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_CREATE, 0));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_CREATE, 1));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_CREATE, 3));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_CREATE, 4));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_CREATE, 5));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_CREATE, 6));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_CREATE, 8));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_CREATE, 9));

        // CAN UPDATE
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_UPDATE, 0));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_UPDATE, 1));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_UPDATE, 3));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_UPDATE, 4));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_UPDATE, 5));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_UPDATE, 6));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_UPDATE, 8));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_UPDATE, 9));

        // CAN DELETE
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_DELETE, 0));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_DELETE, 1));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_DELETE, 3));
        $this->assertEquals(false, $this->auth->permissionVerify(Auth::CAN_DELETE, 4));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_DELETE, 5));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_DELETE, 6));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_DELETE, 8));
        $this->assertEquals(true, $this->auth->permissionVerify(Auth::CAN_DELETE, 9));
    }
}
