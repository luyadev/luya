<?php

namespace luya\web\jsonld;

interface ContactPointInterface extends ThingInterface
{
    public function setEmail($email);
    
    public function getEmail();
    
    public function setTelephone($telephone);
    
    public function getTelephone();
}