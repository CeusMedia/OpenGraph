<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;
class Profile{

	protected $url;
	protected $firstName;
	protected $lastName;
	protected $username;
	protected $gender;

	protected $genders	= array( 'male', 'female' );

	public function getFirstName(){
		return $this->firstName;
	}

	public function getGender(){
		return $this->gender;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setFirstName( $firstName ){
		$this->firstName	= $firstName;
	}

	public function setGender( $gender ){
		if( !in_array( $gender, $this->genders, TRUE ) )
			throw new \OutOfRangeException( 'Invalid gender' );
		return $this->gender;
	}

	public function setLastName( $lastName ){
		$this->lastName	= $lastName;
	}

	public function setUsername( $username ){
		$this->username	= $username;
	}

	public function toArray(){
		$prefix	= 'profile';
		$map	= new \ADT_List_Dictionary();
		if( $this->firstName )
			$map->set( $prefix.':first_name', $this->firstName );
		if( $this->lastName )
			$map->set( $prefix.':last_name', $this->lastName );
		if( $this->username )
			$map->set( $prefix.':username', $this->username );
		if( $this->gender )
			$map->set( $prefix.':gender', $this->gender );
		return $map;
	}
}
