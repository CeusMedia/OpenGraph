<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;

use CeusMedia\Common\ADT\Collection\Dictionary;
use OutOfRangeException;

class Profile
{
	protected ?string $url			= NULL;
	protected ?string $firstName	= NULL;
	protected ?string $lastName		= NULL;
	protected ?string $username		= NULL;
	protected ?string $gender		= NULL;

	protected array $genders		= ['male', 'female'];

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function getGender(): ?string
	{
		return $this->gender;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setFirstName( string $firstName ): static
	{
		$this->firstName	= $firstName;
		return $this;
	}

	public function setGender( string $gender ): static
	{
		if( !in_array( $gender, $this->genders, TRUE ) )
			throw new OutOfRangeException( 'Invalid gender' );
		$this->gender	= $gender;
		return $this;
	}

	public function setLastName( string $lastName ): static
	{
		$this->lastName	= $lastName;
		return $this;
	}

	public function setUsername( string $username ): static
	{
		$this->username	= $username;
		return $this;
	}

	public function toArray(): array
	{
		$prefix	= 'profile';
		$map	= new Dictionary();
		if( NULL !== $this->firstName )
			$map->set( $prefix.':first_name', $this->firstName );
		if( NULL !== $this->lastName )
			$map->set( $prefix.':last_name', $this->lastName );
		if( NULL !== $this->username )
			$map->set( $prefix.':username', $this->username );
		if( NULL !== $this->gender )
			$map->set( $prefix.':gender', $this->gender );
		return $map->getAll();
	}
}
