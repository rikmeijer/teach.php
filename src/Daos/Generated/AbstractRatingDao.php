<?php
/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the RatingDao class instead!
 */

declare(strict_types=1);

namespace rikmeijer\Teach\Daos\Generated;

use TheCodingMachine\TDBM\TDBMService;
use TheCodingMachine\TDBM\ResultIterator;
use rikmeijer\Teach\Beans\Rating;

/**
 * The AbstractRatingDao class will maintain the persistence of Rating class into the rating table.
 *
 */
class AbstractRatingDao
{

    /**
     * @var TDBMService
     */
    protected $tdbmService;

    /**
     * The default sort column.
     *
     * @var string
     */
    private $defaultSort = null;

    /**
     * The default sort direction.
     *
     * @var string
     */
    private $defaultDirection = 'asc';

    /**
     * Sets the TDBM service used by this DAO.
     *
     * @param TDBMService $tdbmService
     */
    public function __construct(TDBMService $tdbmService)
    {
        $this->tdbmService = $tdbmService;
    }

    /**
     * Persist the Rating instance.
     *
     * @param Rating $obj The bean to save.
     */
    public function save(Rating $obj): void
    {
        $this->tdbmService->save($obj);
    }

    /**
     * Get all Rating records.
     *
     * @return Rating[]|ResultIterator
     */
    public function findAll() : ResultIterator
    {
        if ($this->defaultSort) {
            $orderBy = 'rating.'.$this->defaultSort.' '.$this->defaultDirection;
        } else {
            $orderBy = null;
        }
        return $this->tdbmService->findObjects('rating', null, [], $orderBy);
    }
    
    /**
     * Deletes the Rating passed in parameter.
     *
     * @param Rating $obj object to delete
     * @param bool $cascade if true, it will delete all object linked to $obj
     */
    public function delete(Rating $obj, bool $cascade = false) : void
    {
        if ($cascade === true) {
            $this->tdbmService->deleteCascade($obj);
        } else {
            $this->tdbmService->delete($obj);
        }
    }


    /**
     * Get a list of Rating specified by its filters.
     *
     * @param mixed $filter The filter bag (see TDBMService::findObjects for complete description)
     * @param mixed[] $parameters The parameters associated with the filter
     * @param mixed $orderBy The order string
     * @param string[] $additionalTablesFetch A list of additional tables to fetch (for performance improvement)
     * @param int|null $mode Either TDBMService::MODE_ARRAY or TDBMService::MODE_CURSOR (for large datasets). Defaults to TDBMService::MODE_ARRAY.
     * @return Rating[]|ResultIterator
     */
    protected function find($filter = null, array $parameters = [], $orderBy=null, array $additionalTablesFetch = [], ?int $mode = null) : ResultIterator
    {
        if ($this->defaultSort && $orderBy == null) {
            $orderBy = 'rating.'.$this->defaultSort.' '.$this->defaultDirection;
        }
        return $this->tdbmService->findObjects('rating', $filter, $parameters, $orderBy, $additionalTablesFetch, $mode);
    }

    /**
     * Get a list of Rating specified by its filters.
     * Unlike the `find` method that guesses the FROM part of the statement, here you can pass the $from part.
     *
     * You should not put an alias on the main table name. So your $from variable should look like:
     *
     *   "rating JOIN ... ON ..."
     *
     * @param string $from The sql from statement
     * @param mixed $filter The filter bag (see TDBMService::findObjects for complete description)
     * @param mixed[] $parameters The parameters associated with the filter
     * @param mixed $orderBy The order string
     * @param int|null $mode Either TDBMService::MODE_ARRAY or TDBMService::MODE_CURSOR (for large datasets). Defaults to TDBMService::MODE_ARRAY.
     * @return Rating[]|ResultIterator
     */
    protected function findFromSql(string $from, $filter = null, array $parameters = [], $orderBy = null, ?int $mode = null) : ResultIterator
    {
        if ($this->defaultSort && $orderBy == null) {
            $orderBy = 'rating.'.$this->defaultSort.' '.$this->defaultDirection;
        }
        return $this->tdbmService->findObjectsFromSql('rating', $from, $filter, $parameters, $orderBy, $mode);
    }

    /**
     * Get a list of Rating from a SQL query.
     * Unlike the `find` and `findFromSql` methods, here you can pass the whole $sql query.
     *
     * You should not put an alias on the main table name, and select its columns using `*`. So the SELECT part of you $sql should look like:
     *
     *   "SELECT rating.* FROM ..."
     *
     * @param string $sql The sql query
     * @param mixed[] $parameters The parameters associated with the filter
     * @param string|null $countSql The count sql query (automatically computed if not provided)
     * @param int|null $mode Either TDBMService::MODE_ARRAY or TDBMService::MODE_CURSOR (for large datasets). Defaults to TDBMService::MODE_ARRAY.
     * @return Rating[]|ResultIterator
     */
    protected function findFromRawSql(string $sql, array $parameters = [], ?string $countSql = null, ?int $mode = null) : ResultIterator
    {
        return $this->tdbmService->findObjectsFromRawSql('rating', $sql, $parameters, $mode, null, $countSql);
    }

    /**
     * Get a single Rating specified by its filters.
     *
     * @param mixed $filter The filter bag (see TDBMService::findObjects for complete description)
     * @param mixed[] $parameters The parameters associated with the filter
     * @param string[] $additionalTablesFetch A list of additional tables to fetch (for performance improvement)
     * @return Rating|null
     */
    protected function findOne($filter = null, array $parameters = [], array $additionalTablesFetch = []) : ?Rating
    {
        return $this->tdbmService->findObject('rating', $filter, $parameters, $additionalTablesFetch);
    }

    /**
     * Get a single Rating specified by its filters.
     * Unlike the `find` method that guesses the FROM part of the statement, here you can pass the $from part.
     *
     * You should not put an alias on the main table name. So your $from variable should look like:
     *
     *   "rating JOIN ... ON ..."
     *
     * @param string $from The sql from statement
     * @param mixed $filter The filter bag (see TDBMService::findObjects for complete description)
     * @param mixed[] $parameters The parameters associated with the filter
     * @return Rating|null
     */
    protected function findOneFromSql(string $from, $filter = null, array $parameters = []) : ?Rating
    {
        return $this->tdbmService->findObjectFromSql('rating', $from, $filter, $parameters);
    }

    /**
     * Sets the default column for default sorting.
     *
     * @param string $defaultSort
     */
    public function setDefaultSort(string $defaultSort) : void
    {
        $this->defaultSort = $defaultSort;
    }
}
