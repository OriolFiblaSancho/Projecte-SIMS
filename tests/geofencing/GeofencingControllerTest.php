<?php
use PHPUnit\Framework\TestCase;

final class GeofencingControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../../models/geofencingModel.php';
    }

    public function testGetAllZones()
    {
        $stmtMock = $this->createMock(PDOStatement::class);

        $expectedData = [
            [
                'zone_id' => 1,
                'zone_name' => 'Zona Centro',
                'center_latitude' => 41.3851,
                'center_longitude' => 2.1734,
                'radius_meters' => 1000,
                'max_speed_allowed' => 60,
                'type' => 'urban',
                'deleted' => false
            ]
        ];

        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);
        $stmtMock->expects($this->once())
                 ->method('fetchAll')
                 ->with(PDO::FETCH_ASSOC)
                 ->willReturn($expectedData);

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('SELECT'))
                ->willReturn($stmtMock);

        // Mock singleton Database
        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($conn) { $this->conn = $conn; }
            public function getConnection() { return $this->conn; }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $geo = new GeofencingConfig();
        $result = $geo->getAllZones();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('zone_name', $result[0]);
        $this->assertEquals('Zona Centro', $result[0]['zone_name']);
    }

    public function testGetById()
    {
        $expectedId = 1;
        $expectedData = [
            'zone_id' => 1,
            'zone_name' => 'Zona Norte',
            'center_latitude' => 41.4,
            'center_longitude' => 2.2,
            'radius_meters' => 500,
            'max_speed_allowed' => 50,
            'type' => 'residential',
            'deleted' => false
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('bindParam')
                 ->with(':id', $this->callback(fn(&$value) => $value === $expectedId));
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->with(PDO::FETCH_ASSOC)
                 ->willReturn($expectedData);

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('WHERE zone_id = :id'))
                ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($conn) { $this->conn = $conn; }
            public function getConnection() { return $this->conn; }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $geo = new GeofencingConfig();
        $result = $geo->getById($expectedId);

        $this->assertIsArray($result);
        $this->assertEquals('Zona Norte', $geo->zone_name);
        $this->assertEquals(500, $geo->radius_meters);
        $this->assertArrayHasKey('type', $result);
    }

    public function testCreate()
    {
        $data = [
            'zone_name' => 'Zona Este',
            'center_latitude' => 41.3,
            'center_longitude' => 2.15,
            'radius_meters' => 800,
            'max_speed_allowed' => 70,
            'type' => 'highway'
        ];

        $boundParams = [];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->atLeast(6))
                 ->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[] = $param;
                     return true;
                 });
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('INSERT INTO geofencing_config'))
                ->willReturn($stmtMock);
        $pdoMock->expects($this->once())
                ->method('lastInsertId')
                ->willReturn('10');

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($conn) { $this->conn = $conn; }
            public function getConnection() { return $this->conn; }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $geo = new GeofencingConfig();
        $result = $geo->create($data);

        $this->assertEquals(10, $result);
        $this->assertEquals('Zona Este', $geo->zone_name);

        $expectedParams = [
            ':zone_name', ':center_latitude', ':center_longitude',
            ':radius_meters', ':max_speed_allowed', ':type'
        ];
        foreach ($expectedParams as $param) {
            $this->assertContains($param, $boundParams, "Falta el parámetro $param");
        }
    }

    public function testUpdate()
    {
        $id = 1;
        $data = [
            'zone_name' => 'Zona Actualizada',
            'center_latitude' => 41.2,
            'center_longitude' => 2.1,
            'radius_meters' => 900,
            'max_speed_allowed' => 80,
            'type' => 'industrial'
        ];

        $boundParams = [];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->atLeast(7))
                 ->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[] = $param;
                     return true;
                 });
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('UPDATE geofencing_config'))
                ->willReturn($stmtMock);

        $dbStub = new class($pdoMock) {
            private $conn;
            public function __construct($conn) { $this->conn = $conn; }
            public function getConnection() { return $this->conn; }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $geo = new GeofencingConfig();
        $result = $geo->update($id, $data);

        $this->assertTrue($result);
        $expectedParams = [
            ':zone_name', ':center_latitude', ':center_longitude',
            ':radius_meters', ':max_speed_allowed', ':type', ':id'
        ];
        foreach ($expectedParams as $param) {
            $this->assertContains($param, $boundParams, "Falta el parámetro $param");
        }
    }

    public function testSoftDelete()
    {
        $id = 5;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('bindParam')
                 ->with(':id', $this->callback(fn(&$v) => $v === $id));
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
            public function __construct($conn) { $this->conn = $conn; }
            public function getConnection() { return $this->conn; }
        };

        $ref = new ReflectionClass('Database');
        $prop = $ref->getProperty('instance');
        $prop->setAccessible(true);
        $prop->setValue(null, $dbStub);

        $geo = new GeofencingConfig();
        $result = $geo->softDelete($id);

        $this->assertTrue($result);
    }
}
