<?php
declare(strict_types=1);

namespace DoctrineStandalone\Tests;

use PHPUnit\Framework\TestCase;
use DoctrineQueryBuilder\Query\StandaloneQueryBuilder;
use DoctrineQueryBuilder\Query\Exception\QueryException;

class GenericBuilderTest extends TestCase
{
    private $qb;

    public function setUp(): void
    {
        $this->qb = new StandaloneQueryBuilder();
    }

    public function testSelectFromTableWithLimit()
    {
        $this->qb->select('*')
            ->from("test_table")
            ->setMaxResults(100);
        $expected = "SELECT * FROM test_table LIMIT 100";
        $this->assertSame($expected, $this->qb->getSQL());
    }

    public function testJoins()
    {
        $this->qb->select('*')
            ->from("test_table", 'tt')
            ->innerJoin('tt', "test_table2", 'tt2', "tt.id = tt2.id")
            ->leftJoin('tt', "test_table3", 'tt3', "tt.id = tt3.id")
            ->rightJoin('tt', "test_table4", 'tt4', "tt.id = tt4.id")
            ->setMaxResults(100);

        $expected = "SELECT * FROM test_table tt INNER JOIN test_table2 tt2 ON tt.id = tt2.id LEFT JOIN test_table3 tt3 ON tt.id = tt3.id RIGHT JOIN test_table4 tt4 ON tt.id = tt4.id LIMIT 100";
        $this->assertSame($expected, $this->qb->getSQL());

    }

    public function testUnknownAliasException()
    {
        $alias = 'test_alias';
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage("The given alias '$alias' is not part of any FROM or JOIN clause table.");
        $this->qb->select('*')
            ->from("test_table", 'tt')
            ->innerJoin($alias, "test_table2", 'tt2', "tt.id = tt2.id")
            ->leftJoin('tt', "test_table3", 'tt3', "tt.id = tt3.id")
            ->rightJoin('tt', "test_table4", 'tt4', "tt.id = tt4.id")
            ->setMaxResults(100);
        $this->qb->getSQL();
    }
}