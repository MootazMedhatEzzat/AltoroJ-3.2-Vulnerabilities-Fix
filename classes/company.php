<?php

class company extends users
{
    private $bio;
    private $address;
    private $location;
    private $logo_img;

    // Additional methods specific to companies

    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setLogoImg($logo_img)
    {
        $this->logo_img = $logo_img;
    }

    // ... Other company-specific methods ...
}

?>