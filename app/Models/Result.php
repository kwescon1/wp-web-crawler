<?php

namespace App\Models;

class Result {
	private int $id;
	private string $url;

	public const TABLE = 'crawl_results';

	public function getId(): int {
		return $this->id;
	}

	public function getUrl(): string {
		return $this->url;
	}
}
