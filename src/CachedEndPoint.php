<?php
namespace rikmeijer\Teach;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointDecorator;

class CachedEndPoint extends RouteEndPointDecorator
{

    /**
     * @var RouteEndPoint
     */
    private $suspendedResponseBody;
    private $lastModified;
    private $eTag;

    public function __construct(RouteEndPoint $wrappedEndPoint, \DateTime $lastModified, string $eTag)
    {
        parent::__construct($wrappedEndPoint);
        $this->suspendedResponseBody = new class($wrappedEndPoint) implements StreamInterface {

            /**
             * @var RouteEndPoint
             */
            private $wrappedEndPoint;
            private $responseBody;

            public function __construct(RouteEndPoint $wrappedEndPoint)
            {
                $this->wrappedEndPoint = $wrappedEndPoint;
            }

            private function responseBody() : StreamInterface {
                return $this->responseBody = ($this->responseBody??$this->wrappedEndPoint->respond(new Response())->getBody());
            }

            /**
             * Reads all data from the stream into a string, from the beginning to end.
             *
             * This method MUST attempt to seek to the beginning of the stream before
             * reading data and read the stream until the end is reached.
             *
             * Warning: This could attempt to load a large amount of data into memory.
             *
             * This method MUST NOT raise an exception in order to conform with PHP's
             * string casting operations.
             *
             * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
             * @return string
             */
            public function __toString()
            {
                return $this->responseBody()->__toString();
            }

            /**
             * Closes the stream and any underlying resources.
             *
             * @return void
             */
            public function close()
            {
                return $this->responseBody()->close();
            }

            /**
             * Separates any underlying resources from the stream.
             *
             * After the stream has been detached, the stream is in an unusable state.
             *
             * @return resource|null Underlying PHP stream, if any
             */
            public function detach()
            {
                return $this->responseBody()->detach();
            }

            /**
             * Get the size of the stream if known.
             *
             * @return int|null Returns the size in bytes if known, or null if unknown.
             */
            public function getSize()
            {
                return $this->responseBody()->getSize();
            }

            /**
             * Returns the current position of the file read/write pointer
             *
             * @return int Position of the file pointer
             * @throws \RuntimeException on error.
             */
            public function tell()
            {
                return $this->responseBody()->tell();
            }

            /**
             * Returns true if the stream is at the end of the stream.
             *
             * @return bool
             */
            public function eof()
            {
                return $this->responseBody()->eof();
            }

            /**
             * Returns whether or not the stream is seekable.
             *
             * @return bool
             */
            public function isSeekable()
            {
                return $this->responseBody()->isSeekable();
            }

            /**
             * Seek to a position in the stream.
             *
             * @link http://www.php.net/manual/en/function.fseek.php
             * @param int $offset Stream offset
             * @param int $whence Specifies how the cursor position will be calculated
             *     based on the seek offset. Valid values are identical to the built-in
             *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
             *     offset bytes SEEK_CUR: Set position to current location plus offset
             *     SEEK_END: Set position to end-of-stream plus offset.
             * @throws \RuntimeException on failure.
             */
            public function seek($offset, $whence = SEEK_SET)
            {
                return $this->responseBody()->seek($offset, $whence);
            }

            /**
             * Seek to the beginning of the stream.
             *
             * If the stream is not seekable, this method will raise an exception;
             * otherwise, it will perform a seek(0).
             *
             * @see seek()
             * @link http://www.php.net/manual/en/function.fseek.php
             * @throws \RuntimeException on failure.
             */
            public function rewind()
            {
                return $this->responseBody()->rewind();
            }

            /**
             * Returns whether or not the stream is writable.
             *
             * @return bool
             */
            public function isWritable()
            {
                return $this->responseBody()->isWritable();
            }

            /**
             * Write data to the stream.
             *
             * @param string $string The string that is to be written.
             * @return int Returns the number of bytes written to the stream.
             * @throws \RuntimeException on failure.
             */
            public function write($string)
            {
                return $this->responseBody()->write($string);
            }

            /**
             * Returns whether or not the stream is readable.
             *
             * @return bool
             */
            public function isReadable()
            {
                return $this->responseBody()->isReadable();
            }

            /**
             * Read data from the stream.
             *
             * @param int $length Read up to $length bytes from the object and return
             *     them. Fewer than $length bytes may be returned if underlying stream
             *     call returns fewer bytes.
             * @return string Returns the data read from the stream, or an empty string
             *     if no bytes are available.
             * @throws \RuntimeException if an error occurs.
             */
            public function read($length)
            {
                return $this->responseBody()->read($length);
            }

            /**
             * Returns the remaining contents in a string
             *
             * @return string
             * @throws \RuntimeException if unable to read or an error occurs while
             *     reading.
             */
            public function getContents()
            {
                return $this->responseBody()->getContents();
            }

            /**
             * Get stream metadata as an associative array or retrieve a specific key.
             *
             * The keys returned are identical to the keys returned from PHP's
             * stream_get_meta_data() function.
             *
             * @link http://php.net/manual/en/function.stream-get-meta-data.php
             * @param string $key Specific metadata to retrieve.
             * @return array|mixed|null Returns an associative array if no key is
             *     provided. Returns a specific key value if a key is provided and the
             *     value is found, or null if the key is not found.
             */
            public function getMetadata($key = null)
            {
                return $this->responseBody()->getMetadata($key);
            }
        };
        $this->lastModified = $lastModified;
        $this->eTag = $eTag;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $psrResponse
            ->withHeader('Last-Modified', $this->lastModified->format(DATE_RFC7231))
            ->withHeader('Etag', $this->eTag)
            ->withHeader('Cache-Control', 'public')
            ->withBody($this->suspendedResponseBody);
    }
}