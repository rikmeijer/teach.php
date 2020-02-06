<?php
declare(strict_types=1);

/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 */

namespace rikmeijer\Teach\Daos\Generated;

use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\Daos\DoctrineMigrationVersionDao;
use rikmeijer\Teach\Daos\LesDao;
use rikmeijer\Teach\Daos\LesweekDao;
use rikmeijer\Teach\Daos\ModuleDao;
use rikmeijer\Teach\Daos\RatingDao;
use rikmeijer\Teach\Daos\RatingwaardeDao;
use rikmeijer\Teach\Daos\UseremailaddressDao;
use rikmeijer\Teach\Daos\UserDao;

/**
 * The DaoFactory provides an easy access to all DAOs generated by TDBM.
 *
 */
class DaoFactory
{
    /**
     * @var ContactmomentDao
     */
    private $contactmomentDao;

    /**
     * Returns an instance of the ContactmomentDao class.
     *
     * @return ContactmomentDao
     */
    public function getContactmomentDao() : ContactmomentDao
    {
        return $this->contactmomentDao;
    }

    /**
     * Sets the instance of the ContactmomentDao class that will be returned by the factory getter.
     *
     * @param ContactmomentDao $contactmomentDao
     */
    public function setContactmomentDao(ContactmomentDao $contactmomentDao) : void
    {
        $this->contactmomentDao = $contactmomentDao;
    }    /**
     * @var DoctrineMigrationVersionDao
     */
    private $doctrineMigrationVersionDao;

    /**
     * Returns an instance of the DoctrineMigrationVersionDao class.
     *
     * @return DoctrineMigrationVersionDao
     */
    public function getDoctrineMigrationVersionDao() : DoctrineMigrationVersionDao
    {
        return $this->doctrineMigrationVersionDao;
    }

    /**
     * Sets the instance of the DoctrineMigrationVersionDao class that will be returned by the factory getter.
     *
     * @param DoctrineMigrationVersionDao $doctrineMigrationVersionDao
     */
    public function setDoctrineMigrationVersionDao(DoctrineMigrationVersionDao $doctrineMigrationVersionDao) : void
    {
        $this->doctrineMigrationVersionDao = $doctrineMigrationVersionDao;
    }    /**
     * @var LesDao
     */
    private $lesDao;

    /**
     * Returns an instance of the LesDao class.
     *
     * @return LesDao
     */
    public function getLesDao() : LesDao
    {
        return $this->lesDao;
    }

    /**
     * Sets the instance of the LesDao class that will be returned by the factory getter.
     *
     * @param LesDao $lesDao
     */
    public function setLesDao(LesDao $lesDao) : void
    {
        $this->lesDao = $lesDao;
    }    /**
     * @var LesweekDao
     */
    private $lesweekDao;

    /**
     * Returns an instance of the LesweekDao class.
     *
     * @return LesweekDao
     */
    public function getLesweekDao() : LesweekDao
    {
        return $this->lesweekDao;
    }

    /**
     * Sets the instance of the LesweekDao class that will be returned by the factory getter.
     *
     * @param LesweekDao $lesweekDao
     */
    public function setLesweekDao(LesweekDao $lesweekDao) : void
    {
        $this->lesweekDao = $lesweekDao;
    }    /**
     * @var ModuleDao
     */
    private $moduleDao;

    /**
     * Returns an instance of the ModuleDao class.
     *
     * @return ModuleDao
     */
    public function getModuleDao() : ModuleDao
    {
        return $this->moduleDao;
    }

    /**
     * Sets the instance of the ModuleDao class that will be returned by the factory getter.
     *
     * @param ModuleDao $moduleDao
     */
    public function setModuleDao(ModuleDao $moduleDao) : void
    {
        $this->moduleDao = $moduleDao;
    }    /**
     * @var RatingDao
     */
    private $ratingDao;

    /**
     * Returns an instance of the RatingDao class.
     *
     * @return RatingDao
     */
    public function getRatingDao() : RatingDao
    {
        return $this->ratingDao;
    }

    /**
     * Sets the instance of the RatingDao class that will be returned by the factory getter.
     *
     * @param RatingDao $ratingDao
     */
    public function setRatingDao(RatingDao $ratingDao) : void
    {
        $this->ratingDao = $ratingDao;
    }    /**
     * @var RatingwaardeDao
     */
    private $ratingwaardeDao;

    /**
     * Returns an instance of the RatingwaardeDao class.
     *
     * @return RatingwaardeDao
     */
    public function getRatingwaardeDao() : RatingwaardeDao
    {
        return $this->ratingwaardeDao;
    }

    /**
     * Sets the instance of the RatingwaardeDao class that will be returned by the factory getter.
     *
     * @param RatingwaardeDao $ratingwaardeDao
     */
    public function setRatingwaardeDao(RatingwaardeDao $ratingwaardeDao) : void
    {
        $this->ratingwaardeDao = $ratingwaardeDao;
    }    /**
     * @var UseremailaddressDao
     */
    private $useremailaddressDao;

    /**
     * Returns an instance of the UseremailaddressDao class.
     *
     * @return UseremailaddressDao
     */
    public function getUseremailaddressDao() : UseremailaddressDao
    {
        return $this->useremailaddressDao;
    }

    /**
     * Sets the instance of the UseremailaddressDao class that will be returned by the factory getter.
     *
     * @param UseremailaddressDao $useremailaddressDao
     */
    public function setUseremailaddressDao(UseremailaddressDao $useremailaddressDao) : void
    {
        $this->useremailaddressDao = $useremailaddressDao;
    }    /**
     * @var UserDao
     */
    private $userDao;

    /**
     * Returns an instance of the UserDao class.
     *
     * @return UserDao
     */
    public function getUserDao() : UserDao
    {
        return $this->userDao;
    }

    /**
     * Sets the instance of the UserDao class that will be returned by the factory getter.
     *
     * @param UserDao $userDao
     */
    public function setUserDao(UserDao $userDao) : void
    {
        $this->userDao = $userDao;
    }
}
