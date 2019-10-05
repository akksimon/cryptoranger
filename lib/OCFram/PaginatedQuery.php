<?php

namespace OCFram;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;
    private $count;

    public function __construct(string $query, string $queryCount, string $classMapping, int $perPage)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = PDOFactory::getMysqlConnexion();
        $this->perPage = $perPage;
    }

    public function getItems(): array
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPage();
      	if ($currentPage > $this->count) {
           $currentPage = 1;
        }
        $offset = ($currentPage - 1) * $this->perPage;
        $list = $this->pdo->query(
            $this->query . 
            ' LIMIT '.$this->perPage.' OFFSET '.$offset)
            ->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->classMapping);
        return $list;
    }

    public function getCurrentPage(): int
    {
        if (isset($_GET['page']) AND $_GET['page'] > 0){
            $currentPage = (int) $_GET['page'];
        }else {
          $currentPage = 1;
        }
        return $currentPage;
    }

    public function getPage()
    {
        if ($this->count === null) {
            $this->count = (int)$this->pdo
            ->query($this->queryCount)
            ->fetch(\PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage);
    }
}