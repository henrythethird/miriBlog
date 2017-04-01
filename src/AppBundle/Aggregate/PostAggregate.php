<?php

namespace AppBundle\Aggregate;

use AppBundle\Entity\Post;

class PostAggregate {
	/**
	 * @var int
	 */
	private $count;

	/**
	 * @var Post[]
	 */
	private $data;

	/**
	 * ArchiveAggregate constructor.
	 *
	 * @param int $count
	 * @param Post[] $data
	 */
	public function __construct($count, $data) {
		$this->count = $count;
		$this->data = $data;
	}

	/**
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @return Post[]
	 */
	public function getData() {
		return $this->data;
	}
}