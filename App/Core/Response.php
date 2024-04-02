<?php

namespace App\Core;

class Response {
	private ?string $message = null;
	private int $statusCode = 200;
	private array $data = [];
	
	private array $headers = [];
	
	public function data(array $data = []): self {
		$this->data = $data;
		return $this;
	}
	
	public function statusCode(int $status = 200): self {
		if (in_array($status, Respond::STATUS_TEXTS, true)) {
			$this->statusCode = $status;
		}
		return $this;
	}
	
	public function message(string $message = null): self {
		$this->message = $message ?: Respond::STATUS_TEXTS[$this->statusCode];
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
		foreach ($this->headers as $name => $val) {
			header($name . ': ' . $val);
		}
	}
	
	public function send(bool $exit = false, bool $return = false) {
		$this->setHeaders();
		$response = json_encode([
			'status_code' => $this->statusCode,
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