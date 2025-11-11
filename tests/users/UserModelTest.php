<?php

use PHPUnit\Framework\TestCase;

final class UserModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../../models/userModel.php';
    }

    public function testGetAllUsers()
    {
        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $expectedData = [
            [
                'user_id' => 1,
                'username' => 'jdoe',
                'name' => 'John',
                'last_name' => 'Doe',
                'email' => 'jdoe@example.com',
                'phone' => '123456789',
                'user_type' => 'customer',
                'balance' => 0.0,
                'driver_license' => null,
                'status' => 'non-verified',
                'deleted' => false
            ]
        ];

        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedData);

        $pdoMock = $this->createMock(PDO::class);

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT'))
            ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();
        $result = $userModel->getAllUsers();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('user_id', $result[0]);
        $this->assertArrayHasKey('username', $result[0]);
    }

    public function testGetById()
    {
        $expectedId = 1;

        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->expects($this->once())
            ->method('bindParam')
            ->with(
                $this->equalTo(':id'),
                $this->callback(function (&$value) use ($expectedId) {
                    return $value === $expectedId;
                })
            );

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $expectedData = [
            'user_id' => 1,
            'username' => 'jdoe',
            'email' => 'jdoe@example.com'
        ];

        $stmtMock->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedData);

        $pdoMock = $this->createMock(PDO::class);

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('WHERE user_id = :id'))
            ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();
        $result = $userModel->getById($expectedId);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('user_id', $result);
        $this->assertEquals(1, $result['user_id']);
        $this->assertEquals('jdoe', $result['username']);
    }

    public function testCreateUser()
    {
        $data = [
            'username' => 'joelr',
            'name' => 'Joel',
            'last_name' => 'Rubio',
            'email' => 'joel@example.com',
            'password' => 'password',
            'phone' => '123456789',
            'user_type' => 'admin',
            'balance' => '1000',
            'driver_license' => '',
            'status' => 'verified'
        ];

        $boundParams = [];

        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->expects($this->atLeast(9))
            ->method('bindParam')
            ->willReturnCallback(function ($param, &$value) use (&$boundParams) {
                $boundParams[] = $param;
                return true;
            });

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $pdoMock = $this->createMock(PDO::class);

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('INSERT INTO'))
            ->willReturn($stmtMock);

        $pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn('99');

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();
        $result = $userModel->create($data);

        $this->assertNotFalse($result);
        $this->assertEquals(99, $result);

        $expectedParams = [':username', ':name', ':last_name', ':email', ':password', ':phone', ':user_type', ':balance', ':driver_license', ':status'];
        foreach ($expectedParams as $param) {
            $this->assertContains($param, $boundParams, "Parameter $param should be bound");
        }
    }

    public function testUpdateUser()
    {
        $data = [
            'username' => 'oriol777',
            'name' => 'oriol',
            'last_name' => 'fibla',
            'email' => 'oriol@xample.com',
            'password' => 'password',
            'phone' => '123456789',
            'user_type' => 'costumer',
            'balance' => '1000',
            'driver_license' => 'DL',
            'status' => 'active'
        ];
        $userId = 1;

        $boundParams = [];

        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->expects($this->atLeast(9))
            ->method('bindParam')
            ->willReturnCallback(function ($param, &$value) use (&$boundParams) {
                $boundParams[] = $param;
                return true;
            });

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $pdoMock = $this->createMock(PDO::class);

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('UPDATE'))
            ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();

        $result = $userModel->update($userId, $data);

        $this->assertTrue($result);

        $this->assertContains(':id', $boundParams);
    }

    public function testDeleteUser()
    {
        $userId = 1;

        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->expects($this->once())
            ->method('bindParam')
            ->with(
                $this->equalTo(':id'),
                $this->callback(function (&$value) use ($userId) {
                    return $value === $userId;
                })
            );

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $pdoMock = $this->createMock(PDO::class);

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->logicalAnd(
                $this->stringContains('UPDATE'),
                $this->stringContains('deleted = true')
            ))
            ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();

        $result = $userModel->delete($userId);

        $this->assertTrue($result);
    }

    public function testCreateUserInvalidEmail()
    {
        $data = [
            'username' => 'bademail',
            'name' => 'Bad',
            'last_name' => 'Email',
            'email' => 'bad@@example..com',
            'password' => 'password',
            'phone' => '000',
            'user_type' => 'customer',
            'balance' => '0',
            'driver_license' => '',
            'status' => 'non-verified'
        ];

        // Prepare a statement mock but assert execute is never called because validation fails
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->never())
            ->method('execute');

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($c)
            {
                $this->conn = $c;
            }
            public function getConnection()
            {
                return $this->conn;
            }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $userModel = new UserModel();
        $result = $userModel->create($data);

        $this->assertFalse($result);
    }
}
