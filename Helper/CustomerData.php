<?php 

namespace Chronopay\Payment\Helper;

class CustomerData
{

	/** @var string | null */
	private $country = null;

	/** @var string | null */
	private $city = null;

	/** @var string | null */
	private $street = null;

	/** @var string | null */
	private $state = null;

	/** @var string | null */
	private $zip = null;

	/** @var string | null */
	private $email = null;

	/** @var string | null */
	private $phone = null;

	/** @var string | null */
	private $firstName = null;

	/** @var string | null */
	private $lastName = null;


	/**
	 * Set country
	 *
	 * @param string $country
	 *
	 * @return $this
	 */
	public function setCountry($country) 
	{
		$this->country = $country;
		return $this;
	}


	/**
	 * Get country
	 *
	 * @return string | null $country
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * Set city
	 *
	 * @param string $city
	 *
	 * @return $this
	 */
	public function setCity($city) 
	{
		$this->city = $city;
		return $this;
	}


	/**
	 * Get city
	 *
	 * @return string | null $city
	 */
	public function getCity()
	{
		return $this->city;
	}


	/**
	 * Set street
	 *
	 * @param string $street
	 *
	 * @return $this
	 */
	public function setStreet($street) 
	{
		$this->street = $street;
		return $this;
	}


	/**
	 * Get street
	 *
	 * @return string | null $street
	 */
	public function getStreet()
	{
		return $this->street;
	}


	/**
	 * Set state
	 *
	 * @param string $state
	 *
	 * @return $this
	 */
	public function setState($state) 
	{
		$this->state = $state;
		return $this;
	}


	/**
	 * Get state
	 *
	 * @return string | null $state
	 */
	public function getState()
	{
		return $this->state;
	}


	/**
	 * Set zip
	 *
	 * @param string $zip
	 *
	 * @return $this
	 */
	public function setZip($zip) 
	{
		$this->zip = $zip;
		return $this;
	}


	/**
	 * Get zip
	 *
	 * @return string | null $zip
	 */
	public function getZip()
	{
		return $this->zip;
	}


	/**
	 * Set zip
	 *
	 * @param string $email
	 *
	 * @return $this
	 */
	public function setEmail($email) 
	{
		$this->email = $email;
		return $this;
	}


	/**
	 * Get email
	 *
	 * @return string | null $email
	 */
	public function getEmail()
	{
		return $this->email;
	}


	/**
	 * Set phone
	 *
	 * @param string $phone
	 *
	 * @return $this
	 */
	public function setPhone($phone) 
	{
		$this->phone = $phone;
		return $this;
	}


	/**
	 * Get phone
	 *
	 * @return string | null $phone
	 */
	public function getPhone()
	{
		return $this->phone;
	}


	/**
	 * Set firstName
	 *
	 * @param string $firstName
	 *
	 * @return $this
	 */
	public function setFirstName($firstName) 
	{
		$this->firstName = $firstName;
		return $this;
	}


	/**
	 * Get firstName
	 *
	 * @return string | null $firstName
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}


	/**
	 * Set lastName
	 *
	 * @param string $lastName
	 *
	 * @return $this
	 */
	public function setLastName($lastName) 
	{
		$this->lastName = $lastName;
		return $this;
	}


	/**
	 * Get lastName
	 *
	 * @return string | null $lastName
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

}
