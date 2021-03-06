<?php namespace Fedeisas\LaravelDolarBlue\Providers;

class DolarBlue extends Provider implements ProviderInterface
{
    /**
     * Provider's base URL
     * @var string
     */
    protected $baseUrl = 'https://docs.google.com/spreadsheet/pub';

    /**
     * Provider's endpoint URL
     * @var string
     */
    protected $endpointUrl;

    public function __construct()
    {
        $this->endpointUrl = '?hl=en_US' .
                             '&key=0AtVv0u3p3Ex7dDZaVno5Uno3bWJ0UERpa0hDeDB4eHc' .
                             '&output=csv' .
                             '&single=true' .
                             '&gid=0';
    }

    /**
     * Parse Provider's Response
     * @param GuzzleHttp\Message\Response $response
     * @return array $result
     */
    public function parse($body)
    {
        $body = (string) $body->getBody();
        $csv = str_getcsv($body);

        $buy = number_format(
            preg_replace('/,/', '.', $csv[5]),
            2
        );

        $sell = number_format(
            preg_replace('/,/', '.', $csv[6]),
            2
        );

        return array(
            'buy' => $buy,
            'sell' => $sell,
            'timestamp' => time(),
        );
    }
}
