<?php
use PHPUnit\Framework\TestCase;

final class VehicleControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../../models/vehicleModel.php';
    }

    public function testGetAllVehicles()
    {

        // Mock PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        
        // Verify execute() is called once
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);
        
        // Verify fetchAll() is called once with PDO::FETCH_ASSOC
        $expectedData = [
            [
                'vehicle_id' => 1,
                'license_plate' => 'ABC123',
                'model' => 'Model X',
                'vehicle_type_id' => 1,
                'battery_level' => 80,
                'current_range' => 150,
                'total_km' => 1000,
                'status' => 'active',
                'deleted' => false,
                'latitude' => 12.34,
                'longitude' => 56.78,
                'location_datetime' => '2023-01-01 10:00:00'
            ]
        ];
        
        $stmtMock->expects($this->once())
                 ->method('fetchAll')
                 ->with(PDO::FETCH_ASSOC)
                 ->willReturn($expectedData);

        // Mock PDO
        $pdoMock = $this->createMock(PDO::class);
        
        // Verify prepare() is called with expected SQL (contains SELECT and vehicles)
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('SELECT'))
                ->willReturn($stmtMock);

        // Mock Database singleton
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

        $vehicleModel = new Vehicle();
        $result = $vehicleModel->getAllVehicles();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        $first = $result[0];
        $this->assertArrayHasKey('vehicle_id', $first);
        $this->assertArrayHasKey('license_plate', $first);
        $this->assertArrayHasKey('latitude', $first);
        $this->assertArrayHasKey('longitude', $first);
        $this->assertArrayHasKey('location_datetime', $first);
    }

    public function testGetVehicleById()
    {
        // Expected ID to be passed
        $expectedId = 1;
        
        // Mock PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        
        // Verify bindParam is called with :id parameter
        $stmtMock->expects($this->once())
                 ->method('bindParam')
                 ->with(
                     $this->equalTo(':id'),
                     $this->callback(function(&$value) use ($expectedId) {
                         return $value === $expectedId;
                     })
                 );
        
        // Verify execute() is called once
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);
        
        // Verify fetch() is called once with PDO::FETCH_ASSOC
        $expectedData = [
            'vehicle_id' => 1,
            'license_plate' => 'ABC123',
            'model' => 'Model X',
            'vehicle_type_id' => 1,
            'battery_level' => 80,
            'current_range' => 150,
            'total_km' => 1000,
            'status' => 'active',
            'deleted' => false,
        ];
        
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->with(PDO::FETCH_ASSOC)
                 ->willReturn($expectedData);

        // Mock PDO
        $pdoMock = $this->createMock(PDO::class);
        
        // Verify prepare() is called with SQL containing WHERE vehicle_id = :id
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('WHERE vehicle_id = :id'))
                ->willReturn($stmtMock);

        // Mock Database singleton
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

        $vehicleModel = new Vehicle();
        $result = $vehicleModel->getById($expectedId);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('vehicle_id', $result);
        $this->assertEquals(1, $result['vehicle_id']);
        $this->assertEquals('ABC123', $result['license_plate']);
    }

    public function testCreateVehicle()
    {
        // Expected data that should be bound to the statement
        $data = [
            'license_plate' => 'NEW123',
            'model' => 'Model Y',
            'vehicle_type_id' => 2,
            'total_km' => 0,
            'status' => 'active'
        ];

        // Track which parameters were bound
        $boundParams = [];

        // Mock PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        
        // Verify bindParam is called for all expected parameters
        $stmtMock->expects($this->atLeast(7))
                 ->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[] = $param;
                     return true;
                 });
        
        // Verify execute() is called once and returns true
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        // Mock PDO
        $pdoMock = $this->createMock(PDO::class);
        
        // Verify prepare() is called with INSERT query
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('INSERT INTO'))
                ->willReturn($stmtMock);
        
        // Verify lastInsertId() is called once after successful execute
        $pdoMock->expects($this->once())
                ->method('lastInsertId')
                ->willReturn('42');

        // Mock Database singleton
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

        $vehicleModel = new Vehicle();

        $result = $vehicleModel->create($data);

        $this->assertNotFalse($result);
        $this->assertEquals(42, $result);
        
        // Verify at least all expected parameters were bound
        $expectedParams = [':license_plate', ':model', ':vehicle_type_id', ':battery_level', ':current_range', ':total_km', ':status'];
        foreach ($expectedParams as $param) {
            $this->assertContains($param, $boundParams, "Parameter $param should be bound");
        }
    }

    public function testUpdateVehicle()
    {
        // Expected update data
        $data = [
            'license_plate' => 'UPD123',
            'model' => 'Model Z',
            'vehicle_type_id' => 3,
            'total_km' => 150,
            'status' => 'maintenance'
        ];
        $vehicleId = 1;

        // Track which parameters were bound
        $boundParams = [];

        // Mock PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        
        // Verify bindParam is called for all expected parameters (6: 5 fields + id)
        $stmtMock->expects($this->atLeast(6))
                 ->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[] = $param;
                     return true;
                 });
        
        // Verify execute() is called once and returns true
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        // Mock PDO
        $pdoMock = $this->createMock(PDO::class);
        
        // Verify prepare() is called with UPDATE query
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->stringContains('UPDATE'))
                ->willReturn($stmtMock);

        // Mock Database singleton
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

        $vehicleModel = new Vehicle();

        $result = $vehicleModel->update($vehicleId, $data);

        $this->assertTrue($result);
        
        // Verify at least all expected parameters were bound
        $expectedParams = [':license_plate', ':model', ':vehicle_type_id', ':total_km', ':status', ':id'];
        foreach ($expectedParams as $param) {
            $this->assertContains($param, $boundParams, "Parameter $param should be bound");
        }
    }

    public function testDeleteVehicle()
    {
        $vehicleId = 1;

        // Mock PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        
        // Verify bindParam is called with :id parameter
        $stmtMock->expects($this->once())
                 ->method('bindParam')
                 ->with(
                     $this->equalTo(':id'),
                     $this->callback(function(&$value) use ($vehicleId) {
                         return $value === $vehicleId;
                     })
                 );
        
        // Verify execute() is called once and returns true
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        // Mock PDO
        $pdoMock = $this->createMock(PDO::class);
        
        // Verify prepare() is called with UPDATE query and deleted = true
        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with($this->logicalAnd(
                    $this->stringContains('UPDATE'),
                    $this->stringContains('deleted = true')
                ))
                ->willReturn($stmtMock);

        // Mock Database singleton
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

        $vehicleModel = new Vehicle();

        $result = $vehicleModel->delete($vehicleId);

        $this->assertTrue($result);
    }
}
