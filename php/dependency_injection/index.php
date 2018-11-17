<?php
//dependency class
class Logger
{
    public function log($message)
    {
        echo $message;
    }
}

class Logger2
{
    public function log($message)
    {
        echo $message;
    }
}


//This class is dependent on Logger class (dependent class)
//Dependency Injection is also called DRY(Don't Repeat Yourself)
class UserProfile
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger=$logger;
    }

    function createUser()
    {
        $this->logger->log("User Created");
    }

    public function updateUser()
    {
        $this->logger->log("User Updated");
    }

    public function deleteUser()
    {
        $this->logger->log("User Deleted");
    }
}

$obj = new UserProfile(new Logger);

$obj->updateUser();







/*
//This class is dependent on Logger class (dependent class)
class UserProfile
{
	public function createUser()
	{
		$logger = new Logger();
		$logger->log("User Created");
	}
	
	public function updateUser()
	{
		$logger = new Logger();
		$logger->log("User Updated");
	}

	public function deleteUser()
	{
		$logger = new Logger();
		$logger->log("User Deleted");
	}
	
}

$userProfile = new UserProfile();
$userProfile->createUser();
*/

