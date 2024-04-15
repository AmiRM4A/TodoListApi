<?php

namespace App\Core;

/**
 * Class Response
 *
 * Represents an HTTP response.
 */
class Response {
	/**
	 * @var mixed The response message.
	 */
	private mixed $message = null;
	
	/**
	 * @var int|null The HTTP status code.
	 */
	private ?int $statusCode = 200;
	
	/**
	 * @var mixed|null The response data.
	 */
	private mixed $data = null;
	
	/**
	 * @var array The response headers.
	 */
	private array $headers = [];
	
	/**
	 * Set the response data.
	 *
	 * @param mixed $data The response data.
	 *
	 * @return self
	 */
	public function data(mixed $data): self {
		$this->data = $data;
		return $this;
	}
	
	/**
	 * Set the HTTP status code.
	 *
	 * @param int|null $status The HTTP status code.
	 *
	 * @return self
	 */
	public function statusCode(?int $status = 200): self {
		if (!is_null($status) && array_key_exists($status, Respond::STATUS_TEXTS)) {
			$this->statusCode = $status;
		}
		return $this;
	}
	
	/**
	 * Set the response message.
	 *
	 * @param string|null $message The response message.
	 *
	 * @return self
	 */
	public function message(?string $message = null): self {
		if (!is_null($message)) {
			$this->message = $message;
		}
		return $this;
	}
	
	/**
	 * Add a header to the response.
	 *
	 * @param string $name The name of the header.
	 * @param string $val The value of the header.
	 *
	 * @return self
	 */
	public function header(string $name, string $val): self {
		$this->headers[$name] = $val;
		return $this;
	}
	
	/**
	 * Set the response content type to JSON.
	 *
	 * @return self
	 */
	public function json(): self {
		$this->header('Content-Type', 'application/json');
		return $this;
	}
	
	/**
	 * Set the response content type to HTML.
	 *
	 * @return self
	 */
	public function html(): self {
		$this->header('Content-Type', 'text/html');
		return $this;
	}
	
	/**
	 * Set the response content type to plain text.
	 *
	 * @return self
	 */
	public function plain(): self {
		$this->header('Content-Type', 'text/plain');
		return $this;
	}
	
	/**
	 * Set the response content type to XML.
	 *
	 * @return self
	 */
	public function xml(): self {
		$this->header('Content-Type', 'application/xml');
		return $this;
	}
	
	/**
	 * Set the response headers to prevent caching.
	 *
	 * @return self
	 */
	public function noCache(): self {
		$this->header('Cache-Control', 'no-cache, no-store, must-revalidate');
		return $this;
	}
	
	/**
	 * Set the maximum age for caching the response.
	 *
	 * @param int $seconds The number of seconds to cache the response.
	 *
	 * @return self
	 */
	public function maxAge(int $seconds): self {
		$this->header('Cache-Control', 'max-age=' . $seconds);
		return $this;
	}
	
	/**
	 * Set the response as an attachment.
	 *
	 * @param string $filename The filename of the attachment.
	 *
	 * @return self
	 */
	public function attachment(string $filename = ''): self {
		$disposition = 'attachment';
		if (!empty($filename)) {
			$disposition .= '; filename="' . $filename . '"';
		}
		$this->header('Content-Disposition', $disposition);
		return $this;
	}
	
	/**
	 * Set the response as inline content.
	 *
	 * @return self
	 */
	public function inline(): self {
		$this->header('Content-Disposition', 'inline');
		return $this;
	}
	
	/**
	 * Allow cross-origin resource sharing from specified origin.
	 *
	 * @param string $origin The allowed origin. Defaults to '*'.
	 *
	 * @return self
	 */
	public function allowOrigin(string $origin = '*'): self {
		$this->header('Access-Control-Allow-Origin', $origin);
		return $this;
	}
	
	/**
	 * Allow specified HTTP methods for cross-origin requests.
	 *
	 * @param string $methods The allowed HTTP methods.
	 *
	 * @return self
	 */
	public function allowMethods(string $methods): self {
		$this->header('Access-Control-Allow-Methods', $methods);
		return $this;
	}
	
	/**
	 * Allow specified headers for cross-origin requests.
	 *
	 * @param string $headers The allowed headers.
	 *
	 * @return self
	 */
	public function allowHeaders(string $headers): self {
		$this->header('Access-Control-Allow-Headers', $headers);
		return $this;
	}
	
	/**
	 * Set the HTTP headers for the response.
	 *
	 * @return void
	 */
	private function setHeaders(): void {
		header('HTTP/1.1 ' . $this->statusCode . ' ' . Respond::STATUS_TEXTS[$this->statusCode]);
		foreach ($this->headers as $name => $val) {
			header($name . ': ' . $val);
		}
	}
	
	/**
	 * Send the HTTP response.
	 *
	 * @param bool $return Whether to return the response instead of outputting it. Defaults to false.
	 *
	 * @return void|string The response if $return is true.
	 */
	public function send(bool $return = false) {
		$this->setHeaders();
		$response = json_encode([
			'message' => $this->message,
			'data' => $this->data
		]);
		
		if ($return) {
			return $response;
		}
		
		echo $response;
		exit;
	}
}