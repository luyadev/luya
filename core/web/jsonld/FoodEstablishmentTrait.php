<?php

namespace luya\web\jsonld;

/**
 * Food Establishment Trait.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
trait FoodEstablishmentTrait
{
    private $_acceptsReservations;

    /**
     * Accepts Reservations
     *
     * @param string $acceptsReservations
     * @return static
     */
    public function setAcceptsReservations($acceptsReservations)
    {
        $this->_acceptsReservations = $acceptsReservations;
        return $this;
    }

    /**
     * Get Accepts Reserverations
     *
     * @return string
     */
    public function getAcceptsReservations()
    {
        return $this->_acceptsReservations;
    }

    private $_hasMenu;

    /**
     * Set has menu
     *
     * @param string $hasMenu
     * @return static
     */
    public function setHasMenu($hasMenu)
    {
        $this->_hasMenu = $hasMenu;
        return $this;
    }

    /**
     * Get Has menu
     *
     * @return string
     */
    public function getHasMenu()
    {
        return $this->_hasMenu;
    }

    private $_servesCuisine;

    /**
     * Set Serves Cuisine
     *
     * @param string $servesCuisine
     * @return static
     */
    public function setServesCuisine($servesCuisine)
    {
        $this->_servesCuisine = $servesCuisine;
        return $this;
    }

    /**
     * Get serves Cuisine
     *
     * @return string
     */
    public function getServesCuisine()
    {
        return $this->_servesCuisine;
    }

    private $_starRating;

    /**
     * Set Star Rating
     *
     * @param Rating $rating
     * @return static
     */
    public function setStarRating(Rating $rating)
    {
        $this->_starRating = $rating;
        return $this;
    }

    /**
     * Get Star Rating
     *
     * @return Rating
     */
    public function getStarRating()
    {
        return $this->_starRating;
    }
}