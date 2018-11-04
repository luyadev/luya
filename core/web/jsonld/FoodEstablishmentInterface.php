<?php

namespace luya\web\jsonld;

/**
 * Food Establishment Interface
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
interface FoodEstablishmentInterface
{
    /**
     * Accepts Reservations
     *
     * @param string $acceptsReservations
     * @return static
     */
    public function setAcceptsReservations($acceptsReservations);

    /**
     * Get Accepts Reserverations
     *
     * @return string
     */
    public function getAcceptsReservations();

    /**
     * Set has menu
     *
     * @param string $hasMenu
     * @return static
     */
    public function setHasMenu($hasMenu);

    /**
     * Get Has menu
     *
     * @return string
     */
    public function getHasMenu();

    /**
     * Set Serves Cuisine
     *
     * @param string $servesCuisine
     * @return static
     */
    public function setServesCuisine($servesCuisine);

    /**
     * Get serves Cuisine
     *
     * @return string
     */
    public function getServesCuisine();

    /**
     * Set Star Rating
     *
     * @param Rating $rating
     * @return static
     */
    public function setStarRating(Rating $rating);

    /**
     * Get Star Rating
     *
     * @return Rating
     */
    public function getStarRating();
}