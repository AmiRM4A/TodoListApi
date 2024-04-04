<?php

namespace App\Core;

class Response {
	private ?string $message = null;
	private ?int $statusCode = 200;
	private mixed $data = null;
	
	private array $headers = [];
	
	public function data(mixed $data): self {
		$this->data = $data;
		return $this;
	}
	
	public function statusCode(int $status): self {
		if (array_key_exists($status, Respond::STATUS_TEXTS)) {
			$this->statusCode = $status;
		}
		return $this;
	}
	
	public function message(string $message = null): self {
		$this->message = $message;
		return $this;
	}
	
	public function header(string $name, string $val): self {
		$this->headers[$name] = $val;
		return $this;
	}
	
	public function json(): self {
		$this->header('Content-Type', 'application/json');
		return $this;
	}
	
	public function html(): self {
		$this->header('Content-Type', 'text/html');
		return $this;
	}
	
	public function plain(): self {
		$this->header('Content-Type', 'text/plain');
		return $this;
	}
	
	public function xml(): self {
		$this->header('Content-Type', 'application/xml');
		return $this;
	}
	
	public function noCache(): self {
		$this->header('Cache-Control', 'no-cache, no-store, must-revalidate');
		return $this;
	}
	
	public function maxAge(int $seconds): self {
		$this->header('Cache-Control', 'max-age=' . $seconds);
		return $this;
	}
	
	public function attachment(string $filename = ''): self {
		$disposition = 'attachment';
		if (!empty($filename)) {
			$disposition .= '; filename="' . $filename . '"';
		}
		$this->header('Content-Disposition', $disposition);
		return $this;
	}
	
	public function inline(): self {
		$this->header('Content-Disposition', 'inline');
		return $this;
	}
	
	public function allowOrigin(string $origin = '*'): self {
		$this->header('Access-Control-Allow-Origin', $origin);
		return $this;
	}
	
	public function allowMethods(string $methods): self {
		$this->header('Access-Control-Allow-Methods', $methods);
		return $this;
	}
	
	public function allowHeaders(string $headers): self {
		$this->header('Access-Control-Allow-Headers', $headers);
		return $this;
	}
	
	private function setHeaders(): void {
		header('HTTP/1.1 ' . $this->statusCode . ' ' . Respond::STATUS_TEXTS[$this->statusCode]);
		foreach ($this->headers as $name => $val) {
			header($name . ': ' . $val);
		}
	}
	
	public function send(bool $exit = true, bool $return = false) {
		$this->setHeaders();
		$response = json_encode([
			'message' => $this->message,
			'data' => $this->data
		]);
		
		if ($return) {
			return $response;
		}
		
		echo $response;
		
		if ($exit) {
			exit;
		}
	}
}